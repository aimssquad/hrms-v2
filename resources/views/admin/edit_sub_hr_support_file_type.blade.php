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
                                        <h4 class="card-title"><i class="far fa-user"></i> Edit Sub Hr Support File System</h4>
                                    @else
                                        <h4 class="card-title"><i class="far fa-user"></i> Add Sub Hr Support File System</h4>
                                    @endif
                                    @include('layout.message')
                                </div>
                                <div class="card-body">
                                    <form action="{{ url('superadmin/sub/edit-hr-support-file-type') }}" method="post" enctype="multipart/form-data">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        @if(isset($user) && !empty($user->id))
                                            <input type="hidden" name="id" value="{{ $user->id }}">
                                        @endif
                                        <div class="row form-group">
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="selectFloatingLabel" class="placeholder">Type</label>
                                                    <select id="status" name="type_id" class="form-control input-border-bottom" required>
                                                        @foreach($type as $types) <!-- Loop through $type to display the options -->
                                                            <option value="{{ $types->id }}" 
                                                                {{ (isset($user) && $user->type_id == $types->id) ? 'selected' : '' }}>
                                                                {{ $types->type }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="selectFloatingLabel" class="placeholder">Sub Type</label>
                                                    <input type="text" name="sub_name" class="form-control input-border-bottom" id="selectFloatingLabel" required value="{{ isset($user) ? $user->sub_name : '' }}">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="status" class="placeholder">Status</label>
                                                    <select id="status" name="status" class="form-control input-border-bottom" required>
                                                        <option value="1" {{ (isset($user) && $user->status == 1) ? 'selected' : '' }}>Active</option>
                                                        <option value="0" {{ (isset($user) && $user->status == 0) ? 'selected' : '' }}>Inactive</option>
                                                    </select>
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
    </script>
</body>
</html>