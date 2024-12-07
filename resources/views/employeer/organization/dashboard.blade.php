@extends('employeer.include.app')

@section('title', 'Home - Organization Dashboard')
@php
    $sidebarItems = \App\Helpers\Helper::getSidebarItems();
    $user_type = Session::get("user_type");
    //dd($sidebarItems);
@endphp
@section('content')


    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Welcome {{ ucwords($Roledata->com_name ?? "NA")}}!</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">
                            Dashboard
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->

        <div class="row">
            <!--<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">-->
            <!--    <div class="card dash-widget">-->
            <!--        <div class="card-body">-->
            <!--            <span class="dash-widget-icon"><i class="fa-solid fa-user"></i></span>-->
            <!--            <div class="dash-widget-info">-->
            <!--                <h3>{{$employee_count ?? 0}}</h3>-->
            <!--                <span>Active Employees</span>-->
            <!--            </div>-->
            <!--            <div class="arrow-icon pt-2" style="text-align: center; margin-top: -10px;">-->
            <!--                <a href="{{url('organization/employeeee')}}">-->
            <!--                    <span class="p-2"style=" color: #fd9330;">View</span><i class="fa-solid fa-arrow-right" style=" color: #fd9330;"></i>-->
            <!--                </a>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <!-- <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">-->
            <!--    <div class="card dash-widget">-->
            <!--        <div class="card-body">-->
            <!--            <span class="dash-widget-icon">-->
            <!--                <i class="fa-solid fa-user"></i>-->
            <!--            </span>-->
            <!--            <div class="dash-widget-info">-->
            <!--                <h3>{{$inactive_employee ?? 0}}</h3>-->
            <!--                <span>Inactive Employees</span>-->
            <!--            </div>-->
            <!--            <div class="arrow-icon pt-2" style="text-align: center; margin-top: -10px;">-->
            <!--                <a href="{{url('organization/inactiveEmployee')}}">-->
            <!--                    <span class="p-2"style=" color: #fd9330;">View</span><i class="fa-solid fa-arrow-right" style=" color: #fd9330;"></i>-->
            <!--                </a>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <a href="{{url('org-settings/vw-department')}}">
                        <div class="card-body">
                            <div class="dash-widget-info">
                                <span>Total Departments</span>
                                <h3>{{$department_count ?? 0 }}</h3>
                            </div>
                            <span class="dash-widget-icon"><i class="fa-solid fa-cubes"></i></span>
                            <div class="arrow-icon pt-2" style="text-align: center; margin-top: -10px;">
                                <span>View</span><i class="fa-solid fa-arrow-right"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <a href="{{url('org-dashboard-migrant-employees')}}">
                        <div class="card-body">
                            <div class="dash-widget-info">
                                <span>Migrants Employees</span>
                                <h3>{{$migrant_emp_count ?? 0}}</h3>
                            </div>
                            <span class="dash-widget-icon"><i class="fa-solid fa-dollar-sign"></i></span>
                            <div class="arrow-icon pt-2" style="text-align: center; margin-top: -10px;">
                                <span>View</span><i class="fa-solid fa-arrow-right"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <a href="{{url('recruitment/job_list')}}">
                        <div class="card-body">
                            <div class="dash-widget-info">
                                <span>Total Job Types</span>
                                <h3>{{$job_type_count ?? 0 }}</h3>
                            </div>
                            <span class="dash-widget-icon"><i class="fa-regular fa-gem"></i></span>
                            <div class="arrow-icon pt-2" style="text-align: center; margin-top: -10px;">
                                <span>View</span><i class="fa-solid fa-arrow-right"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
            
              <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                <div class="card dash-widget">
                    <a href="{{url('billing/list')}}">
                        <div class="card-body">
                            <div class="dash-widget-info">
                                <span>Billing</span>
                                <h3>750</h3>
                            </div>
                            <span class="dash-widget-icon"><i class="fa-regular fa-gem"></i></span>
                            <div class="arrow-icon pt-2" style="text-align: center; margin-top: -10px;">
                                <span>View</span><i class="fa-solid fa-arrow-right"></i>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

       

      <div class="row staff-grid-row">
            <!--<div class="col-xl-4 col-md-6 col-sm-12">-->
            <!--    <div class="card border-0">-->
            <!--        <div class="alert alert-primary border border-primary mb-0 p-3">-->
            <!--            <div class="d-flex align-items-start">-->
            <!--                <div class="text-primary w-100">-->
            <!--                    <i class="fa fa-chart-pie rota-icon-size-fixed"></i>-->
            <!--                    <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">Organization Statistics</div>-->
            <!--                    <div class="d-flex justify-content-between align-items-center">-->
            <!--                        <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>-->
            <!--                        <div class="fs-12">-->
            <!--                            <a href="#" class="text-primary fw-semibold">-->
            <!--                                <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all-->
            <!--                            </a>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="col-lg-8 col-md-12 col-12">
            <div class="row">
            <div class="col-xl-4 col-md-6 col-sm-12">
                <a href="{{ url('organization/profile') }}" class="text-primary fw-semibold editProfile_tab">
                    <div class="card border-0">
                        <div class="alert mb-0 dashboard-card">
                            <div class="position-absolute abstract" style="z-index: 0;">
                                <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                    <style>
                                        .s0 {
                                            opacity: .05;
                                            fill: var(--vz-success)
                                        }
                                    </style>
                                    <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                                </svg>
                            </div>
                            <div class="d-flex align-items-start">
                                <div class="text-primary w-100 db-box">
                                    <div class="img-box">
                                        <i class="fa fa-user-edit "></i>
                                    </div>
                                    <div class="img-box-text">
                                        <div class="fw-semibold d-flex text-card-size-fixed mb-1">Profile</div>
                                        <div class="d-flex align-items-center">
                                            <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                            <div class="fs-12 edit_profile">
                                                Edit <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <a href="{{ url('employees-according-to-rti') }}" class="text-primary fw-semibold editProfile_tab">
                    <div class="card border-0">
                        <div class="alert mb-0 dashboard-card">
                            <div class="position-absolute abstract" style="z-index: 0;">
                                <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                    <style>
                                        .s0 {
                                            opacity: .05;
                                            fill: var(--vz-success);
                                        }
                                    </style>
                                    <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                                </svg>
                            </div>
                            <div class="d-flex align-items-start">
                                <div class="text-primary w-100 db-box">
                                    <div class="img-box">
                                        <i class="fa fa-users"></i>
                                    </div>
                                    <div class="img-box-text">
                                        <div class="fw-semibold d-flex text-card-size-fixed mb-1">Employees (RTI)</div>
                                        <div class="d-flex align-items-center">
                                            <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                            <div class="fs-12 edit_profile">
                                                <span>View all</span>
                                                <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="View all" data-bs-original-title="View all"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <a href="{{ url('authorizing-officer') }}" class="text-primary fw-semibold editProfile_tab">
                    <div class="card border-0">
                        <div class="alert mb-0 dashboard-card">
                            <div class="position-absolute abstract" style="z-index: 0;">
                                <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                    <style>
                                        .s0 {
                                            opacity: .05;
                                            fill: var(--vz-success);
                                        }
                                    </style>
                                    <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                                </svg>
                            </div>
                            <div class="d-flex align-items-start">
                                <div class="text-primary w-100 db-box">
                                    <div class="img-box">
                                        <i class="fa fa-user-tie"></i>
                                    </div>
                                    <div class="img-box-text">
                                        <div class="fw-semibold d-flex text-card-size-fixed mb-1">Authorizing Officer</div>
                                        <div class="d-flex align-items-center">
                                            <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                            <div class="fs-12 edit_profile">
                                                <span>View all</span>
                                                <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="View all" data-bs-original-title="View all"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <a href="{{ url('key-contact') }}" class="text-primary fw-semibold editProfile_tab">
                    <div class="card border-0">
                        <div class="alert mb-0 dashboard-card">
                            <div class="position-absolute abstract" style="z-index: 0;">
                                <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                    <style>
                                        .s0 {
                                            opacity: .05;
                                            fill: var(--vz-success);
                                        }
                                    </style>
                                    <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                                </svg>
                            </div>
                            <div class="d-flex align-items-start">
                                <div class="text-primary w-100 db-box">
                                    <div class="img-box">
                                        <i class="fa fa-id-badge"></i>
                                    </div>
                                    <div class="img-box-text">
                                        <div class="fw-semibold d-flex text-card-size-fixed mb-1">Key Contact</div>
                                        <div class="d-flex align-items-center">
                                            <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                            <div class="fs-12 edit_profile">
                                                <span>View all</span>
                                                <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="View all" data-bs-original-title="View all"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <a href="{{ url('level-1-user') }}" class="text-primary fw-semibold editProfile_tab">
                    <div class="card border-0">
                        <div class="alert mb-0 dashboard-card">
                            <div class="position-absolute abstract" style="z-index: 0;">
                                <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                    <style>
                                        .s0 {
                                            opacity: .05;
                                            fill: var(--vz-success);
                                        }
                                    </style>
                                    <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                                </svg>
                            </div>
                            <div class="d-flex align-items-start">
                                <div class="text-primary w-100 db-box">
                                    <div class="img-box">
                                        <i class="fa fa-user-shield"></i>
                                    </div>
                                    <div class="img-box-text">
                                        <div class="fw-semibold d-flex text-card-size-fixed mb-1">Level 1 User</div>
                                        <div class="d-flex align-items-center">
                                            <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                            <div class="fs-12 edit_profile">
                                                <span>View all</span>
                                                <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="View all" data-bs-original-title="View all"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <a href="{{ url('level-2-user') }}" class="text-primary fw-semibold editProfile_tab">
                    <div class="card border-0">
                        <div class="alert mb-0 dashboard-card">
                            <div class="position-absolute abstract" style="z-index: 0;">
                                <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                    <style>
                                        .s0 {
                                            opacity: .05;
                                            fill: var(--vz-success);
                                        }
                                    </style>
                                    <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                                </svg>
                            </div>
                            <div class="d-flex align-items-start">
                                <div class="text-primary w-100 db-box">
                                    <div class="img-box">
                                        <i class="fa fa-user-cog"></i>
                                    </div>
                                    <div class="img-box-text">
                                        <div class="fw-semibold d-flex text-card-size-fixed mb-1">Level 2 User</div>
                                        <div class="d-flex align-items-center">
                                            <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                            <div class="fs-12 edit_profile">
                                                <span>View all</span>
                                                <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="View all" data-bs-original-title="View all"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
                <a href="{{ url('org-dashboarddetails') }}" class="text-primary fw-semibold editProfile_tab">
                    <div class="card border-0">
                        <div class="alert mb-0 dashboard-card">
                            <div class="position-absolute abstract" style="z-index: 0;">
                                <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                                    <style>
                                        .s0 {
                                            opacity: .05;
                                            fill: var(--vz-success);
                                        }
                                    </style>
                                    <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                                </svg>
                            </div>
                            <div class="d-flex align-items-start">
                                <div class="text-primary w-100 db-box">
                                    <div class="img-box">
                                        <i class="fa fa-check-circle"></i>
                                    </div>
                                    <div class="img-box-text">
                                        <div class="fw-semibold d-flex text-card-size-fixed mb-1">Sponsor Compliance</div>
                                        <div class="d-flex align-items-center">
                                            <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                            <div class="fs-12 edit_profile">
                                                <span>View all</span>
                                                <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="View all" data-bs-original-title="View all"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
                <div class="col-12">
                    @if(!$employee_birth->isEmpty())
                <div class="col-xl-12 col-md-12 d-flex">
                    <div class="card employee-month-card flex-fill" style="height: 200px;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-lg-9 col-md-12">
                                    <div class="employee-month-details">
                                        <h4>Birthday Employee</h4>
                                        <p>We are proud to celebrate your birthday today!</p>
                                    </div>
                                    <div class="employee-month-content">
                                        <h6>Happy Birthday, 
                                            @foreach($employee_birth as $emp)
                                                {{ $emp->emp_fname }} {{ $emp->emp_lname }}@if(!$loop->last), @endif
                                            @endforeach
                                        </h6>
                                        <!-- Assuming the first employee's designation will be shown, or you can adjust this -->
                                        <p>{{ $employee_birth->first()->emp_designation ?? 'Employee' }}</p>
                                    </div>
                                </div>
                                @if($employee_birth->count() == 1)
                                    <div class="col-lg-3 col-md-12">
                                        <div class="employee-month-img">
                                            <a href="{{ asset('storage/app/public/' . $employee_birth->first()->emp_image) }}" class="avatar" target="_blank">
                                                <img src="{{ asset('storage/app/public/' . $employee_birth->first()->emp_image) }}" alt="Employee Image">
                                            </a>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <div class="col-xl-12 col-md-12 d-flex">
                    <div class="card employee-month-card flex-fill" style="height: 200px;">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="col-lg-9 col-md-12">
                                    <div class="employee-month-details">
                                        <h4>Birthday Employee</h4>
                                        <p>No birthdays today.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
                </div>
            </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12 d-flex">
                <div class="card flex-fill">
                    <div class="card-body">
                        <div class="statistic-header">
                            <h4>Important</h4>
                            {{-- <div class="important-notification">
                                <a href="#">
                                    View All <i class="fe fe-arrow-right-circle"></i>
                                </a>
                            </div> --}}
                        </div>
                        <div class="notification-tab">
                            <ul class="nav nav-tabs">
                                <li>
                                    <a href="#" class="active" data-bs-toggle="tab" data-bs-target="#notification_tab">
                                        <i class="la la-bell"></i> Notifications
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">

                                <div class="tab-pane active" id="notification_tab">
                                    <div class="employee-noti-content" style="max-height: 380px; overflow-y: auto;">
                                        <ul class="employee-notification-list">
                                            <li class="employee-notification-grid">
                                                <div class="employee-notification-icon">
                                                    <a href="#">
                                                        <span class="badge-soft-danger rounded-circle">HR</span>
                                                    </a>
                                                </div>
                                                <div class="employee-notification-content">
                                                    <h6>
                                                        <a href="#">Your leave request has been</a>
                                                    </h6>
                                                    <ul class="nav">
                                                        <li>02:10 PM</li>
                                                        <li>21 Apr 2024</li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="employee-notification-grid">
                                                <div class="employee-notification-icon">
                                                    <a href="#">
                                                        <span class="badge-soft-info rounded-circle">ER</span>
                                                    </a>
                                                </div>
                                                <div class="employee-notification-content">
                                                    <h6>
                                                        <a href="#">You’re enrolled in upcoming training...</a>
                                                    </h6>
                                                    <ul class="nav">
                                                        <li>12:40 PM</li>
                                                        <li>21 Apr 2024</li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="employee-notification-grid">
                                                <div class="employee-notification-icon">
                                                    <a href="#">
                                                        <span class="badge-soft-warning rounded-circle">SM</span>
                                                    </a>
                                                </div>
                                                <div class="employee-notification-content">
                                                    <h6>
                                                        <a href="#">Your annual compliance training...</a>
                                                    </h6>
                                                    <ul class="nav">
                                                        <li>11:00 AM</li>
                                                        <li>21 Apr 2024</li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="employee-notification-grid">
                                                <div class="employee-notification-icon">
                                                    <a href="#">
                                                        <span class="badge-soft-warning rounded-circle">SH</span>
                                                    </a>
                                                </div>
                                                <div class="employee-notification-content">
                                                    <h6>
                                                        <a href="#">Jessica has requested feedback...</a>
                                                    </h6>
                                                    <ul class="nav">
                                                        <li>10:30 AM</li>
                                                        <li>21 Apr 2024</li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="employee-notification-grid">
                                                <div class="employee-notification-icon">
                                                    <a href="#">
                                                        <span class="badge-soft-warning rounded-circle">DT</span>
                                                    </a>
                                                </div>
                                                <div class="employee-notification-content">
                                                    <h6>
                                                        <a href="#">Gentle reminder about training...</a>
                                                    </h6>
                                                    <ul class="nav">
                                                        <li>09:00 AM</li>
                                                        <li>21 Apr 2024</li>
                                                    </ul>
                                                </div>
                                            </li>
                                            <li class="employee-notification-grid">
                                                <div class="employee-notification-icon">
                                                    <a href="#">
                                                        <span class="badge-soft-danger rounded-circle">AU</span>
                                                    </a>
                                                </div>
                                                <div class="employee-notification-content">
                                                    <h6>
                                                        <a href="#">Our HR system will be down for maintenance...</a>
                                                    </h6>
                                                    <ul class="nav">
                                                        <li>11:50 AM</li>
                                                        <li>21 Apr 2024</li>
                                                    </ul>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                             

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--<div class="col-xl-4 col-md-6 col-sm-12">-->
            <!--    <div class="card border-0">-->
            <!--        <div class="alert alert-primary border border-primary mb-0 p-3">-->
            <!--            <div class="d-flex align-items-start">-->
            <!--                <div class="text-primary w-100">-->
            <!--                    <i class="fa fa-gavel rota-icon-size-fixed"></i>-->
            <!--                    <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">Governance</div>-->
            <!--                    <div class="d-flex justify-content-between align-items-center">-->
            <!--                        <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>-->
            <!--                        <div class="fs-12">-->
            <!--                            <a href="#" class="text-primary fw-semibold">-->
            <!--                                <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all-->
            <!--                            </a>-->
            <!--                        </div>-->
            <!--                    </div>-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>         -->
        </div>

        
       

    </div>
    <!-- /Page Content -->


@endsection
