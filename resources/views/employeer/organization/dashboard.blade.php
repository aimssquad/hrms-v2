@extends('employeer.include.app')

@section('title', 'Home - Organization Dashboard')
@php
    $sidebarItems = \App\Helpers\Helper::getSidebarItems();
    $user_type = Session::get("user_type");
    //dd($sidebarItems);
@endphp
@section('css')
    <style>
        /* Post Container */
        .post-container {
            max-width: 740px;
            margin: 0 auto;
            padding: 20px;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }

        /* Post Card */
        .post-card {
            margin-bottom: 20px;
            border-radius: 8px;
            border: 1px solid #ddd;
            box-shadow: 0 1px 2px rgba(0,0,0,0.1);
            background-color: white;
        }

        /* Post Header */
        .post-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
            border-bottom: 1px solid #ddd;
            padding: 12px 15px;
        }

        .post-avatar {
            width: 40px;
            height: 40px;
            object-fit: cover;
            border: 2px solid rgb(89, 86, 86);
            border-radius: 50%;
        }

        .post-username {
            font-weight: 600;
            font-size: 15px;
            margin: 0;
        }

        .post-timestamp {
            font-size: 12px;
            color: #65676B;
        }

        .post-options {
            border: none;
            background: none;
            padding: 5px;
            color: #65676B;
            cursor: pointer;
        }

        /* Post Content */
        .post-content {
            font-size: 15px;
            line-height: 1.4;
            margin-bottom: 15px;
            padding: 0 15px;
        }

        .post-image {
            margin-bottom: 10px;
            max-height: 500px;
            width: 100%;
            object-fit: cover;
            border-radius: 10px;
        }

        /* Post Stats */
        .post-stats {
            background-color: white;
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
            padding: 8px 15px;
            font-size: 14px;
            color: #65676B;
        }

        .like-count-badge {
            background-color: #1877f2;
            color: white;
            width: 20px;
            height: 20px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            margin-right: 5px;
        }

        /* Post Actions */
        .post-actions {
            background-color: white;
            border-top: none;
            padding: 5px 15px;
        }

        .btn-action {
            text-align: center;
            background: none;
            border: none;
            padding: 8px 0;
            font-size: 14px;
            color: #65676B;
            cursor: pointer;
            flex: 1;
        }

        .btn-action:hover {
            background-color: #f5f5f5;
            border-radius: 5px;
        }

        .btn-action i {
            margin-right: 8px;
        }

        .action-buttons {
            display: flex;
            justify-content: space-between;
        }

        /* Comments Section */
        .post-comments {
            max-height: 180px;
            overflow-y: auto;
            background-color: #f9f9f9;
            border-top: 1px solid #ddd;
            padding: 15px;
        }

        .comment-avatar {
            width: 32px;
            height: 32px;
            object-fit: cover;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .comment-bubble {
            background-color: #f0f2f5;
            padding: 8px 12px;
            border-radius: 18px;
            max-width: 80%;
            margin-left: 10px;
        }

        .comment-username {
            font-size: 13px;
            font-weight: 600;
            margin: 0;
        }

        .comment-text {
            font-size: 14px;
            margin: 0;
        }

        .comment-input {
            border-radius: 18px;
            background-color: #f0f2f5;
            border: none;
            padding: 8px 12px;
            font-size: 14px;
            flex-grow: 1;
        }

        .comment-input:focus {
            box-shadow: none;
            background-color: #e4e6e9;
            outline: none;
        }

        .comment-post-btn {
            border-radius: 18px;
            padding: 0 15px;
            font-size: 14px;
            font-weight: 600;
            background-color: #1877f2;
            color: white;
            border: none;
            cursor: pointer;
            margin-left: 10px;
        }

        .comment-post-btn:hover {
            background-color: #166fe5;
        }

        .comment-section {
            display: flex;
            padding: 15px;
            background-color: white;
            border-top: 1px solid #ddd;
        }

        .comment-form {
            display: flex;
            flex-grow: 1;
            margin-left: 10px;
        }

        .comment-item {
            display: flex;
            margin-bottom: 15px;
        }

        .post-stats-content {
            display: flex;
            justify-content: space-between;
        }

        .likes-count {
            display: flex;
            align-items: center;
        }

        .card-body {
            padding: 15px 10px;
        }
    </style>
@endsection


@section('content')


    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">
                        {{\App\Helpers\Helper::cachedTrans('Welcome')}}
                        
                        {{ \App\Helpers\Helper::cachedTrans(ucwords($Roledata->com_name ?? "NA") )}}!
                    </h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item active">
                            {{\App\Helpers\Helper::cachedTrans('Dashboard')}}
                            
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
                                
                                <span>{{\App\Helpers\Helper::cachedTrans('Total Departments')}}</span>
                                <h3>{{\App\Helpers\Helper::cachedTrans($department_count ?? 0 )}}</h3>
                            </div>
                            <span class="dash-widget-icon"><i class="fa-solid fa-cubes"></i></span>
                            <div class="arrow-icon pt-2" style="text-align: center; margin-top: -10px;">
                                <span><span>{{\App\Helpers\Helper::cachedTrans('View')}}</span></span><i class="fa-solid fa-arrow-right"></i>
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
                                <span>{{\App\Helpers\Helper::cachedTrans('Migrants Employees')}}</span>
                                <h3>{{\App\Helpers\Helper::cachedTrans($migrant_emp_count ?? 0)}}</h3>
                            </div>
                            <span class="dash-widget-icon"><i class="fa-solid fa-dollar-sign"></i></span>
                            <div class="arrow-icon pt-2" style="text-align: center; margin-top: -10px;">
                                <span>{{\App\Helpers\Helper::cachedTrans('View')}}</span><i class="fa-solid fa-arrow-right"></i>
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
                                <span>{{\App\Helpers\Helper::cachedTrans('Total Job Types')}}</span>
                                <h3>{{\App\Helpers\Helper::cachedTrans($job_type_count ?? 0)}}</h3>
                            </div>
                            <span class="dash-widget-icon"><i class="fa-regular fa-gem"></i></span>
                            <div class="arrow-icon pt-2" style="text-align: center; margin-top: -10px;">
                                <span>{{\App\Helpers\Helper::cachedTrans('View')}}</span><i class="fa-solid fa-arrow-right"></i>
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
                                <span>{{\App\Helpers\Helper::cachedTrans('Billing')}}</span>
                                <h3>{{\App\Helpers\Helper::cachedTrans('750')}}</h3>
                            </div>
                            <span class="dash-widget-icon"><i class="fa-regular fa-gem"></i></span>
                            <div class="arrow-icon pt-2" style="text-align: center; margin-top: -10px;">
                                <span>{{\App\Helpers\Helper::cachedTrans('View')}}</span><i class="fa-solid fa-arrow-right"></i>
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
                                        <div class="fw-semibold d-flex text-card-size-fixed mb-1">{{\App\Helpers\Helper::cachedTrans('Profile')}}</div>
                                        <div class="d-flex align-items-center">
                                            <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                            <div class="fs-12 edit_profile">
                                                {{\App\Helpers\Helper::cachedTrans('Edit')}} <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i>
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
                                        <div class="fw-semibold d-flex text-card-size-fixed mb-1">{{\App\Helpers\Helper::cachedTrans('Employees (RTI)')}}</div>
                                        <div class="d-flex align-items-center">
                                            <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                            <div class="fs-12 edit_profile">
                                                <span>{{\App\Helpers\Helper::cachedTrans('View all')}}</span>
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
                                        <div class="fw-semibold d-flex text-card-size-fixed mb-1">{{\App\Helpers\Helper::cachedTrans('Authorizing Officer')}}</div>
                                        <div class="d-flex align-items-center">
                                            <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                            <div class="fs-12 edit_profile">
                                                <span>{{\App\Helpers\Helper::cachedTrans('View all')}}</span>
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
                                        <div class="fw-semibold d-flex text-card-size-fixed mb-1">{{\App\Helpers\Helper::cachedTrans('Key Contact')}}</div>
                                        <div class="d-flex align-items-center">
                                            <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                            <div class="fs-12 edit_profile">
                                                <span>{{\App\Helpers\Helper::cachedTrans('View all')}}</span>
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
                                        <div class="fw-semibold d-flex text-card-size-fixed mb-1"> {{\App\Helpers\Helper::cachedTrans('Level 1 User')}}</div>
                                        <div class="d-flex align-items-center">
                                            <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                            <div class="fs-12 edit_profile">
                                                <span>{{\App\Helpers\Helper::cachedTrans('View all')}}</span>
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
                                        <div class="fw-semibold d-flex text-card-size-fixed mb-1"> {{\App\Helpers\Helper::cachedTrans('Level 2 User')}}</div>
                                        <div class="d-flex align-items-center">
                                            <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                            <div class="fs-12 edit_profile">
                                                <span>{{\App\Helpers\Helper::cachedTrans('View all')}}</span>
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
                                        <div class="fw-semibold d-flex text-card-size-fixed mb-1"> {{\App\Helpers\Helper::cachedTrans('Sponsor Compliance')}}</div>
                                        <div class="d-flex align-items-center">
                                            <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                            <div class="fs-12 edit_profile">
                                                <span> {{\App\Helpers\Helper::cachedTrans('View all')}}</span>
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
                    <div class="col-lg-12 col-md-12 col-12 d-flex">
                        <div class="card flex-fill">
                            <div class="card-body">
                                <div class="statistic-header">
                                    <h4>{{\App\Helpers\Helper::cachedTrans('Important')}}</h4>
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
                                                <i class="la la-bell"></i> {{\App\Helpers\Helper::cachedTrans('Notifications')}}
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="tab-content">

                                        <div class="tab-pane active" id="notification_tab">
                                            <div class="employee-noti-content" style="max-height: 380px; overflow-y: auto;">
                                                <ul class="employee-notification-list">
                                                    @foreach($notices as $notice)
                                                        <li class="employee-notification-grid">
                                                            <div class="employee-notification-icon">
                                                                {{-- <a href="#">
                                                                    <span class="badge-soft-danger rounded-circle">{{ $notice->title }}</span>
                                                                </a> --}}
                                                                <a href="{{ asset('storage/' . $notice->image) }}" target="_blank">
                                                                    <span class="badge-soft-danger rounded-circle">{{ \App\Helpers\Helper::cachedTrans($notice->title) }}</span>
                                                                </a>
                                                            </div>
                                                            <div class="employee-notification-content">
                                                                <h6>
                                                                    <a href="#">{{ \App\Helpers\Helper::cachedTrans(strip_tags($notice->description) )}}</a>
                                                                </h6>
                                                                <ul class="nav">
                                                                    <li>{{ \Carbon\Carbon::parse($notice->start_date)->format('d-m-Y') }}</li>
                                                                    <li>{{ \Carbon\Carbon::parse($notice->end_date)->format('d-m-Y') }}</li>
                                                                </ul>
                                                            </div>
                                                        </li>
                                                    @endforeach
                                                
                                                </ul>
                                            </div>
                                        </div>

                                    

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- @if(!$employee_birth->isEmpty())
                        <div class="col-xl-12 col-md-12 d-flex">
                            <div class="card employee-month-card flex-fill" style="height: 200px;">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-lg-9 col-md-12">
                                            <div class="employee-month-details">
                                                
                                                <h4> {{\App\Helpers\Helper::cachedTrans('Birthday Employee')}}</h4>
                                                <p> {{\App\Helpers\Helper::cachedTrans('We are proud to celebrate your birthday today!')}}</p>
                                            </div>
                                            <div class="employee-month-content">
                                                <h6> {{\App\Helpers\Helper::cachedTrans('Happy Birthday,')}} 
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
                                                <h4>{{ \App\Helpers\Helper::cachedTrans('Birthday Employee') }}</h4>
                                                <p>{{ \App\Helpers\Helper::cachedTrans('No birthdays today.') }}</p>
                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif --}}
                </div>
            </div>
            </div>
            <div class="col-lg-4 col-md-12 col-12 d-flex">

                <div class="col-xl-12 col-md-12 d-flex">
                    {{-- <div class="card  flex-fill" style="height: 250px;"> --}}
                        {{-- <div class="card-body"> --}}
                            {{-- <div class="post-container"> --}}
                                    <!-- Post 1 -->
                                    {{-- <div class="post-card col-xl-12 col-md-12" style="border-radius: 12px; overflow: hidden; border: 1px solid #e0e0e0;">
                                        <!-- Post Header -->
                                        <div class="post-header">
                                            <div style="display: flex; align-items: center;">
                                                <img src="https://randomuser.me/api/portraits/men/1.jpg" alt="John Doe" class="post-avatar">
                                                <div style="margin-left: 12px;">
                                                    <h5 class="post-username">John Doe</h5>
                                                    <small class="post-timestamp">3 days ago</small>
                                                </div>
                                            </div>
                                            <button class="post-options">
                                                <i class="fas fa-ellipsis-h"></i>
                                            </button>
                                        </div>

                                        <!-- Post Content -->
                                        <div class="card-body">
                                            <p class="post-content">Just enjoyed a beautiful hike in the mountains today! The views were absolutely breathtaking. 🏔️ #nature #adventure</p>

                                            <!-- Post Image -->
                                            <img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" alt="Post content" class="post-image">
                                        </div>

                                        <!-- Likes and Comments Count -->
                                        <div class="post-stats">
                                            <div class="post-stats-content">
                                                <div class="likes-count">
                                                    <span class="like-count-badge">
                                                        <i class="fas fa-thumbs-up" style="font-size: 12px;"></i>
                                                    </span>
                                                    <span>24</span>
                                                </div>
                                                <div>
                                                    <span>5 comments</span>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Action Buttons -->
                                        <div class="post-actions">
                                            <div class="action-buttons">
                                                <button class="btn-action">
                                                    <i class="far fa-thumbs-up"></i>
                                                    Like
                                                </button>
                                                <button class="btn-action" id="hide">
                                                    <i class="fas fa-comment"></i>
                                                    Comment
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Comments Section -->
                                        <div class="post-comments comment" id="comment">
                                            <!-- Existing Comments -->
                                            <div class="comment-item">
                                                <img src="https://randomuser.me/api/portraits/women/1.jpg" alt="Jane Smith" class="comment-avatar">
                                                <div class="comment-bubble">
                                                    <h6 class="comment-username">Jane Smith</h6>
                                                    <p class="comment-text">Looks amazing! Which trail did you take?</p>
                                                </div>
                                            </div>
                                            
                                            <div class="comment-item">
                                                <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="Mike Johnson" class="comment-avatar">
                                                <div class="comment-bubble">
                                                    <h6 class="comment-username">Mike Johnson</h6>
                                                    <p class="comment-text">I was there last weekend! The sunset is incredible from that viewpoint.</p>
                                                </div>
                                            </div>
                                            <div class="comment-item">
                                                <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="Mike Johnson" class="comment-avatar">
                                                <div class="comment-bubble">
                                                    <h6 class="comment-username">Mike Johnson</h6>
                                                    <p class="comment-text">I was there last weekend! The sunset is incredible from that viewpoint.</p>
                                                </div>
                                            </div>
                                            <div class="comment-item">
                                                <img src="https://randomuser.me/api/portraits/men/2.jpg" alt="Mike Johnson" class="comment-avatar">
                                                <div class="comment-bubble">
                                                    <h6 class="comment-username">Mike Johnson</h6>
                                                    <p class="comment-text">I was there last weekend! The sunset is incredible from that viewpoint.</p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Add Comment -->
                                        <div class="comment-section ">
                                            <img src="https://randomuser.me/api/portraits/men/4.jpg" alt="You" class="comment-avatar">
                                            <div class="comment-form">
                                                <input type="text" placeholder="Write a comment..." class="comment-input">
                                                <button class="comment-post-btn">Post</button>
                                            </div>
                                        </div>
                                    </div> --}}
                                {{-- </div> --}}


                        {{-- </div> --}}
                    {{-- </div> --}}
                </div>   

                    {{-- @if(!$employee_birth->isEmpty())
                        <div class="col-xl-12 col-md-12 d-flex">
                            <div class="card employee-month-card flex-fill" style="height: 200px;">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="col-lg-9 col-md-12">
                                            <div class="employee-month-details">
                                                
                                                <h4> {{\App\Helpers\Helper::cachedTrans('Birthday Employee')}}</h4>
                                                <p> {{\App\Helpers\Helper::cachedTrans('We are proud to celebrate your birthday today!')}}</p>
                                            </div>
                                            <div class="employee-month-content">
                                                <h6> {{\App\Helpers\Helper::cachedTrans('Happy Birthday,')}} 
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
                                                <h4>{{ \App\Helpers\Helper::cachedTrans('Birthday Employee') }}</h4>
                                                <p>{{ \App\Helpers\Helper::cachedTrans('No birthdays today.') }}</p>
                                             
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif --}}
            </div>
        </div>

        
       

    </div>
    <!-- /Page Content -->


@endsection
