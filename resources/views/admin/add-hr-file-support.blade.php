@include('admin.include.head')
<body>
    <div class="wrapper">
        @include('admin.include.header')
        <!-- Sidebar -->
        @include('admin.include.sidebar')
        <!-- End Sidebar -->
        <div class="main-panel">
            <div class="page-header">
                <!-- <h4 class="page-title">Employee Management</h4> -->
            </div>
            <div class="content">
                <div class="page-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card custom-card">
                                <div class="card-header">
                                    @if(isset($user) && !empty($user->id))
                                    <h4 class="card-title"><i class="far fa-user"></i> Edit Hr Support File </h4>
                                    @else
                                    <h4 class="card-title"><i class="far fa-user"></i> Add Hr Support File </h4>
                                    @endif
                                    @include('layout/message')
                                </div>
                                <div class="card-body">
                                    <form action="{{ url('superadmin/add-hr-support-file') }}" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        @if(isset($user) && !empty($user->id))
                                        <input type="hidden" name="id" value="{{ $user->id }}">
                                        @endif
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="selectFloatingLabel" class="placeholder">Type</label>
                                                    <select name="type_id" class="form-control" id="type_id" required>
                                                        <option value="">Choose..</option>
                                                        @foreach ($type as $types)
                                                            <option value="{{ $types->id }}" @if(isset($user) && $user->type_id == $types->id) selected @endif>{{$types->type}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="selectFloatingLabel" class="placeholder">Sub Type</label>
                                                    @if(isset($user) && !empty($user->id))
                                                    <select name="sub_type_id" class="form-control" id="sub_type_id" required>
                                                        <option value="">Select</option>
                                                        @foreach($subTypes as $subType)
                                                            <option value="{{ $subType->id }}" 
                                                                    @if(isset($user) && $user->sub_type_id == $subType->id) selected @endif>
                                                                {{ $subType->sub_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @else
                                                    <select name="sub_type_id" class="form-control" id="sub_type_id" required>
                                                        <option value="">Select</option>
                                                    </select>
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="selectFloatingLabel" class="placeholder">Title</label>
                                                    <input type="text" name="title" class="form-control input-border-bottom" id="selectFloatingLabel" required value="{{ isset($user) ? $user->title : '' }}">
                                                </div>
                                            </div>

                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="description" class="placeholder">Short Description</label>
                                                    <textarea id="smalldescription" name="smalldescription" class="form-control input-border-bottom" required >{{ isset($user) ? $user->small_description : '' }}</textarea>
                                                </div> 
                                            </div>
                                            <div class="col-md-9">
                                                <div class="form-group">
                                                    <label for="description" class="placeholder">Long Description</label>
                                                    <textarea id="description" name="description" rows="30" class="form-control input-border-bottom" required >{{ isset($user) ? $user->description : '' }}</textarea>
                                                </div>
                                            </div>
                                           
                                        <div id="file-container">
                                            <div class="row file-section">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>File Name</label>
                                                        <input type="text" class="form-control" name="file_names[]" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>Document Description</label>
                                                        <input type="text" class="form-control" name="document_desc[]" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Upload Pdf</label>
                                                        <input type="file" class="form-control" name="pdf_files[]" accept=".pdf" required>
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label>Upload Doc</label>
                                                        <input type="file" class="form-control" name="doc_files[]" accept=".doc,.docx">
                                                    </div>
                                                </div>
                                                <div class="col-md-12 text-right">
                                                    <button type="button" class="btn btn-success btn-sm add-file-section " style="margin-bottom:0px; margin-right:5px;"><i class="fa fa-plus"></i></button>
                                                    <button type="button" class="btn btn-danger btn-sm remove-file-section"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row form-group">
                                            <div class="col-md-12">
                                                <button type="submit" class="btn btn-default">Submit</button>
                                            </div>
                                        </div>
                                    
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @include('admin.include.footer')
        </div>
    </div>
    <!--   Core JS Files   -->
    @include('admin.include.script')
    <script>
        CKEDITOR.replace('description');
        CKEDITOR.replace('smalldescription');
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function () {
            // Trigger AJAX call on Type dropdown change
            $('#type_id').change(function () {
                let typeId = $(this).val(); // Get selected Type ID
    
                // Reset Sub Type dropdown
                $('#sub_type_id').empty().append('<option value="">Select</option>');
    
                if (typeId) {
                    $.ajax({
                        url: "{{ route('getSubTypes') }}", // The route for fetching sub types
                        type: "POST",
                        data: {
                            _token: "{{ csrf_token() }}",
                            type_id: typeId,
                        },
                        success: function (response) {
                            if (response.success) {
                                // Populate Sub Type dropdown with data
                                $.each(response.subTypes, function (index, subType) {
                                    $('#sub_type_id').append(
                                        `<option value="${subType.id}">${subType.sub_name}</option>`
                                    );
                                });
                            } else {
                                alert(response.message); // Display error message if no subtypes found
                            }
                        },
                        error: function () {
                            alert('An error occurred. Please try again.');
                        },
                    });
                }
            });
        });
    </script>
    <script>
                         $(document).ready(function () {
                // Add new file upload section
                $(document).on('click', '.add-file-section', function () {
                    const newSection = $(this)
                        .closest('.file-section') // Find the closest file-section div
                        .clone(true) // Clone the entire section
                        .find('input')
                        .val('') // Clear input values
                        .end();
                    $('#file-container').append(newSection); // Append the cloned section
                });

                // Remove a file upload section
                $(document).on('click', '.remove-file-section', function () {
                    if ($('.file-section').length > 1) {
                        $(this).closest('.file-section').remove(); // Remove the specific section
                    } else {
                        alert('At least one file section must remain.');
                    }
                });
            });

    </script>
</body>
</html>
