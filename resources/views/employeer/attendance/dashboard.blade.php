@extends('employeer.include.app')

@section('title', 'Attendance Dashboard')

@section('content')


    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Attendance Dashboard</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('organization/employerdashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Attendance Dashboard</li>
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
                       

                        <div class="row g-3">

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-dashboard modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title">Total No of Employee Present</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status"></div>
                                            <div class="modern-arrow">
                                                <span class="employee-count">{{ $employee_rs_count }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-dashboard modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title">Total No of Employee Absent</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status"></div>
                                            <div class="modern-arrow">
                                                <span class="employee-count">{{ $ab_count }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-dashboard modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title">Total No of Employee On Leave</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status"></div>
                                            <div class="modern-arrow">
                                                <span class="employee-count">{{ $co_count }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                           <div class="col-12">
                            <hr class="mt-3" >
                           </div>
                            
                           
                            <!--<div class="col-3 mb-3">-->
                            <!--    <div class="alert alert-outline-info alert-dismissible fade show">-->
                            <!--        Daily Attendance-->
                            <!--        <a href="{{ url('attendance-management/daily-attendance') }}">-->
                            <!--            <button type="button" class="btn-close" aria-label="add">-->
                            <!--                <i class="fa fa-arrow-circle-right"></i>-->
                            <!--            </button>-->
                            <!--        </a>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<div class="col-3 mb-3">-->
                            <!--    <div class="alert alert-outline-info alert-dismissible fade show">-->
                            <!--        Attendance History-->
                            <!--        <a href="{{ url('attendance-management/attendance-report') }}">-->
                            <!--            <button type="button" class="btn-close" aria-label="add">-->
                            <!--                <i class="fa fa-arrow-circle-right"></i>-->
                            <!--            </button>-->
                            <!--        </a>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<div class="col-3 mb-3">-->
                            <!--    <div class="alert alert-outline-info alert-dismissible fade show">-->
                            <!--        Process Attendance-->
                            <!--        <a href="{{ url('attendance-management/process-attendance') }}">-->
                            <!--            <button type="button" class="btn-close" aria-label="add">-->
                            <!--                <i class="fa fa-arrow-circle-right"></i>-->
                            <!--            </button>-->
                            <!--        </a>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<div class="col-3 mb-3">-->
                            <!--    <div class="alert alert-outline-info alert-dismissible fade show">-->
                            <!--        Absent Report-->
                            <!--        <a href="{{ url('attendance-management/absent-report') }}">-->
                            <!--            <button type="button" class="btn-close" aria-label="add">-->
                            <!--                <i class="fa fa-arrow-circle-right"></i>-->
                            <!--            </button>-->
                            <!--        </a>-->
                            <!--    </div>-->
                            <!--</div>-->


                          

                            

                           

                        </div>

                        <div class="row g-3 mt-1">
                        <div class="col-xl-4 col-md-6 col-sm-12">
                                <a href="{{ url('attendance-management/generate-data') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="fa fa-calendar-check modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title mt-1">Generate Attendance</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status"></div>
                                            <div class="modern-arrow">
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <a href="{{ url('attendance-management/daily-attendance') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="fa fa-calendar-check modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title mt-1">Daily Log</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status"></div>
                                            <div class="modern-arrow">
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <a href="{{ url('attendance-management/attendance-report') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="fa fa-history modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title mt-1">Attendance Record</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status"></div>
                                            <div class="modern-arrow">
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <a href="{{ url('attendance-management/process-attendance') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="fa fa-cogs modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title mt-1">Execute Attendance</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status"></div>
                                            <div class="modern-arrow">
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <a href="{{ url('attendance-management/absent-report') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="fa fa-user-times modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title mt-1">Absentee Record</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status"></div>
                                            <div class="modern-arrow">
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
