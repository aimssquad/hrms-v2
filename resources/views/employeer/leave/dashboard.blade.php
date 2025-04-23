@extends('employeer.include.app')

@section('title', 'Leave Handling Dashboard')

@section('content')


    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Leave Handling Dashboard</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('organization/employerdashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Leave Handling Dashboard</li>
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
                       

                        <div class="row g-4">

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <a href="{{ url('leave/leave-type-listing') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-dashboard modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title">Category</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status"></div>
                                            <div class="modern-arrow">
                                                <span class="employee-count">{{ $leave_type_count ?? 0 }}</span>
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <a href="{{ url('leave/leave-rule-listing') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-dashboard modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title">Policy</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status">
                                                </div>
                                                <div class="modern-arrow">
                                                <span class="employee-count">{{ $late_rule_count ?? 0 }}</span>
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <a href="{{ url('leave/leave-allocation-listing') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-dashboard modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title">Allocation</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status">
                                                </div>
                                                <div class="modern-arrow">
                                                <span class="employee-count">{{ $leave_allocation_count ?? 0 }}</span>
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <a href="{{ url('leave/leave-balance') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-dashboard modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title">Leave Accrued</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status">
                                                </div>
                                                <div class="modern-arrow">
                                                <span class="employee-count">{{ $leave_balance_count ?? 0 }}</span>
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <a href="{{ url('leave/leave-report') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-dashboard modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title">Leave Record</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status">
                                                </div>
                                                <div class="modern-arrow">
                                                <span class="employee-count opacity-0"></span>
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>
                            
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <a href="{{ url('leave/leave-report-employee') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-dashboard modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title">Record EE Wise</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status">
                                                </div>
                                                <div class="modern-arrow">
                                                <span class="employee-count opacity-0"></span>
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
