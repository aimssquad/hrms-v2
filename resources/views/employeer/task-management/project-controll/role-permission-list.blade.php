@extends('employeer.task-management.project-controll.app')

@section('title', \App\Helpers\Helper::cachedTrans('Project Permission Master'))

@section('content')
<!-- Page Content -->
    <div class="content container-fluid pb-0">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Project Permission Master</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{url('org-task-management/dashboard')}}">{{\App\Helpers\Helper::cachedTrans('All project List')}}</a></li>
                        <li class="breadcrumb-item active"><a href="#">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
                        <li class="breadcrumb-item active"><a href="#">{{\App\Helpers\Helper::cachedTrans('Project Permission Master')}}</a></li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    <a href="{{ url('org-project-control/'.request()->route('id').'/project-permission') }}" class="btn add-btn" >
                        <i class="fa-solid fa-plus"></i> Add Project Permission
                    </a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        @include('employeer.layout.message')
        <div class="container mt-4">
            <div class="card">
                <div class="card-header">
                    <h4>Role Permission List</h4>
                </div>

                <div class="card-body">
                    <table class="table table-bordered" id="basic-datatables">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Role Name</th>
                                <th>Permissions</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($roles as $role)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>

                                    <!-- Role Name -->
                                    <td>{{ $role->name }}</td>

                                    <!-- Permissions -->
                                    <td>
                                        @if(isset($rolePermissions[$role->id]))
                                            @foreach($rolePermissions[$role->id] as $perm)
                                                <span class="badge bg-success m-1">
                                                    {{ ucwords(str_replace('_',' ', $perm->name)) }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">No Permissions</span>
                                        @endif
                                    </td>

                                    <td>
                                        <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle"
                                        data-bs-toggle="dropdown">
                                        <i class="material-icons">more_vert</i>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right">

                                        <a href="{{ url('org-project-control/'.request()->route('id').'/project-permission-edit/'.$role->id) }}"
                                        class="dropdown-item editRole">
                                        <i class="fa fa-pencil m-r-5"></i> Edit
                                        </a>

                                        <a href="{{ url('org-project-control/'.request()->route('id').'/project-permission-delete/'.$role->id) }}"
                                        class="dropdown-item deleteRole">
                                        <i class="fa fa-trash m-r-5"></i> Delete
                                        </a>

                                        </div>
                                        </div>
                                        </td>
                                    </tr>
                            @endforeach
                        </tbody>

                    </table>
                </div>
            </div>
        </div>


        <!-- Edit Permission Modal -->
        <div class="modal fade" id="editPermissionModal">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
{{-- 
                <form method="POST" id="updatePermissionForm">
                    @csrf
                    @method('PUT')

                    <div class="modal-header">
                        <h5 class="modal-title">Update Role Permissions</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <input type="hidden" id="edit_role_id" name="role_id">

                        <div class="row">
                            @foreach($permissions as $permission)
                            <div class="col-md-4 mb-2">
                                <div class="form-check">
                                    <input type="checkbox"
                                        class="form-check-input edit-permission"
                                        name="permissions[]"
                                        value="{{ $permission->id }}"
                                        id="perm{{ $permission->id }}">

                                    <label class="form-check-label">
                                        {{ ucwords(str_replace('_',' ', $permission->name)) }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button class="btn btn-primary">
                            Update Permissions
                        </button>
                    </div>

                </form> --}}

                </div>
            </div>
        </div>
    </div>

<!-------- End add member modal--------->
@endsection
