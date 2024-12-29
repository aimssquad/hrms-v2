@extends('employeer.include.app')

@section('title', 'Employee Dashboard')

@section('content')


    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Employee Dashboard</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('organization/employerdashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Employee Dashboard</li>
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

                            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                                <div class="card dash-widget overflow-visible">
                                    <a href="{{ url('organization/employeeee') }}">
                                        <div class="card-body modern-card">
                                            <div class="dash-widget-info">
                                                <span>Employees</span>
                                                <h3>{{$employee_count ?? 0}}</h3>
                                            </div>
                                            <div class="modern_icon_wrapper">
                                                <i class="fa-solid fa-users fa-2x modern-icon"></i>
                                            </div>
                                            <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                                <span style="font-size: 13px;">View</span>
                                                <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                                <div class="card dash-widget overflow-visible">
                                    <a href="{{ url('org-settings/vw-department') }}">
                                        <div class="card-body modern-card">
                                            <div class="dash-widget-info">
                                                <span>Department</span>
                                                <h3>{{$department_count ?? 0}}</h3>
                                            </div>
                                            <div class="modern_icon_wrapper">
                                                <i class="fa-solid fa-building fa-2x modern-icon"></i>
                                            </div>
                                            <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                                <span style="font-size: 13px;">View</span>
                                                <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                                <div class="card dash-widget overflow-visible">
                                    <a href="{{ url('org-settings/vw-designation') }}">
                                        <div class="card-body modern-card">
                                            <div class="dash-widget-info">
                                                <span>Designation</span>
                                                <h3>{{$designation_count ?? 0}}</h3>
                                            </div>
                                            <div class="modern_icon_wrapper">
                                                <i class="fa-solid fa-id-badge fa-2x modern-icon"></i>
                                            </div>
                                            <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                                <span style="font-size: 13px;">View</span>
                                                <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                                <div class="card dash-widget overflow-visible">
                                    <a href="{{ url('org-settings/vw-employee-type') }}">
                                        <div class="card-body modern-card">
                                            <div class="dash-widget-info">
                                                <span>Type of Employees</span>
                                                <h3>{{$employee_type_count ?? 0 }}</h3>
                                            </div>
                                            <div class="modern_icon_wrapper">
                                                <i class="fa-solid fa-user-tie fa-2x modern-icon"></i>
                                            </div>
                                            <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                                <span style="font-size: 13px;">View</span>
                                                <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                                <div class="card dash-widget overflow-visible">
                                    <a href="{{ url('organization/allShifts') }}">
                                        <div class="card-body modern-card">
                                            <div class="dash-widget-info">
                                                <span>All Shifts</span>
                                                <h3>{{$shift_count ?? 0 }}</h3>
                                            </div>
                                            <div class="modern_icon_wrapper">
                                                <i class="fa-solid fa-clock fa-2x modern-icon"></i>
                                            </div>
                                            <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                                <span style="font-size: 13px;">View</span>
                                                <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
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

    </div>
    <!-- /Page Content -->


@endsection
