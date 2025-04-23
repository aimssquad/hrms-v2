@extends('employeer.include.app')

@section('title', 'User Permissions Dashboard')

@section('content')


    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">User Permissions Dashboard</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('organization/employerdashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">User Permissions Dashboard</li>
                    </ul>
                </div>
                {{-- <div class="col-auto float-end ms-auto">
                    <a href="#" class="btn add-btn" data-bs-toggle="modal" data-bs-target="#add_employee"><i class="fa-solid fa-plus"></i> Add Job Applied</a>
                </div> --}}
            </div>
        </div>
        <!-- /Page Header -->


        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                       

                        <div class="row">

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <a href="{{ url('user-access-role/vw-users') }}" class="modern-card-link">
                                    <div class="modern-card border-0">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-dashboard modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title">User Settings</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <span></span>
                                            <div class="modern-arrow">
                                                <div class="employee-count">{{ $user_config_count ?? 0 }}</div>
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <a href="{{ url('user-access-role/view-users-role') }}" class="modern-card-link">
                                    <div class="modern-card border-0">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-dashboard modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title">Access Roles</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <span></span>
                                            <div class="modern-arrow">
                                                <div class="employee-count">{{ $roles_management_count ?? 0 }}</div>
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    <!-- /Page Content -->


@endsection
