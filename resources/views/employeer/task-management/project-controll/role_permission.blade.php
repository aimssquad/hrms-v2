@extends('employeer.task-management.project-controll.app')

@section('title', \App\Helpers\Helper::cachedTrans('Project Permission Master'))
@section('css')
<style>
    .form-check-input:checked {
        background-color: #ff8c00;   /* your button color */
        border-color: #ff8c00;
    }
</style>
   
@endsection

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
                
            </div>
        </div>
        <!-- /Page Header -->
        @include('employeer.layout.message')
        <div class="container mt-4">
            <div class="card">
                <div class="card-header">
                    <h4>Assign Permissions to Role</h4>
                </div>

                <div class="card-body">
                    <form action="{{ url('org-project-control/'.request()->route('id').'/assign-permission-to-role') }}" method="POST">
                        @csrf

                        <!-- Role Dropdown -->
                        <div class="mb-3">
                            <label>Select Role</label>
                           <select name="role_id" id="role_id" class="select" required>
                                <option value="">-- Select Role --</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">
                                        {{ $role->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Permissions List -->
                        <div class="row">
                            @foreach($permissions as $permission)
                            <div class="col-md-3">
                                <div class="form-check">
                                    <input type="checkbox"
                                        name="permissions[]"
                                        value="{{ $permission->id }}"
                                        class="form-check-input permission-checkbox">

                                    <label class="form-check-label">
                                        {{ ucwords(str_replace('_',' ',$permission->name)) }}
                                    </label>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Submit -->
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">
                                Save Permissions
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>


<!-------- End add member modal--------->
@endsection

