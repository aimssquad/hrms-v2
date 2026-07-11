@extends('employeer.task-management.project-controll.app')

@section('title', \App\Helpers\Helper::cachedTrans('Project Permission Master'))

@section('css')
<style>
    .form-check-input:checked{
        background-color:#ff8c00;
        border-color:#ff8c00;
    }
</style>
@endsection


@section('content')

<div class="content container-fluid pb-0">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Edit Project Permission Master</h3>

                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{url('organization/employerdashboard')}}">Home</a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{url('org-task-management/dashboard')}}">
                            All Project List
                        </a>
                    </li>

                    <li class="breadcrumb-item active">
                        Project Permission Master
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    @include('employeer.layout.message')


    <div class="container mt-4">
        <div class="card">

            <div class="card-header">
                <h4>Edit Role Permissions</h4>
            </div>


            <div class="card-body">

                <form action="{{ url('org-project-control/'.request()->route('id').'/update-permissions/'.$roleId) }}" method="POST">
                    @csrf

                    <input type="hidden" name="role_id" value="{{ $roleId }}">

                    <div class="mb-4">
                        <label class="fw-bold">Role Name</label>

                        <input type="text"
                            class="form-control"
                            value="{{ $role->name }}"
                            readonly>
                    </div>


                    <h5 class="mb-3">Assigned Permissions</h5>

                    <div class="row">
                        @foreach($allPermissions as $permission)
                        <div class="col-md-3 mb-3">
                            <div class="form-check">

                                <input
                                    type="checkbox"
                                    name="permissions[]"
                                    value="{{ $permission->id }}"
                                    class="form-check-input"
                                    {{ in_array($permission->id,$permissions) ? 'checked' : '' }}
                                >

                                <label class="form-check-label">
                                    {{ ucwords(str_replace('_',' ',$permission->name)) }}
                                </label>

                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-4">
                        <button class="btn btn-primary">
                            Update Permissions
                        </button>
                    </div>

                    </form>
            </div>
        </div>
    </div>

</div>

@endsection