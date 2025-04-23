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
                                   
                                    <h4 class="card-title"><i class="far fa-user"></i> Add Notice  </h4>
                                   
                                    @include('layout/message')
                                </div>
                                <div class="card-body">

                                    <form action="{{ route('notices.update', $notice->id) }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="row form-group">

                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>Title</label>
                                                    <input type="text" class="form-control" name="title" value="{{ $notice->title }}" required>
                                                </div>
                                            </div>
                                           
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>Start Date</label>
                                                    <input type="date" name="start_date" class="form-control" 
                                                           value="{{ $notice->start_date ? \Carbon\Carbon::parse($notice->start_date)->format('Y-m-d') : '' }}" 
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label>End Date</label>
                                                    <input type="date" name="end_date" class="form-control" 
                                                           value="{{ $notice->end_date ? \Carbon\Carbon::parse($notice->end_date)->format('Y-m-d') : '' }}" 
                                                           required>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label>Description</label>
                                                    <textarea name="description" class="form-control" required>{{ $notice->description }}</textarea>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Image (optional)</label>
                                                    <input type="file" class="form-control" name="image">
                                                    @if ($notice->image)
                                                        <img src="{{ asset('storage/' . $notice->image) }}" alt="Notice Image" width="100">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="form-group">
                                                    <label>Notice For</label>
                                                    <select name="notice_for" id="" class="form-control" required>
                                                        <option value="">Select Notice For</option>
                                                        <option value="employees" {{ (old('notice_for', $notice->notice_for) == 'employees') ? 'selected' : '' }}>Only For Employees</option>
                                                        <option value="organization" {{ (old('notice_for', $notice->notice_for) == 'organization') ? 'selected' : '' }}>Only For Organization</option>
                                                        <option value="all" {{ (old('notice_for', $notice->notice_for) == 'all') ? 'selected' : '' }}>For Both</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                           
                                            <div class="row form-group">
                                                <div class="col-md-12">
                                                    <input type="hidden" name="created_by" value="admin"> 
                                                    <button type="submit" class="btn btn-default">Update Notice</button>
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
  
</body>
</html>
