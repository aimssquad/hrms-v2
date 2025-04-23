@extends('employeer.include.app')

@section('title', 'Rota Dashboard')

@section('content')


    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Rota Dashboard</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('organization/employerdashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Rota Dashboard</li>
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
                                <a href="{{ url('rota-org/shift-management') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="fa fa-dashboard modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title">Shift Planning</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status"></div>
                                            <div class="modern-arrow">
                                                <span class="employee-count">{{ $shift_management }}</span>
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <a href="{{ url('rota-org/shift-management') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="fa fa-dashboard modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title">Late Policy</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status"></div>
                                            <div class="modern-arrow">
                                                <span class="employee-count">{{ $late_policy_count }}</span>
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <a href="{{ url('rota-org/offday') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-dashboard modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title">Leave Day</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status"></div>
                                            <div class="modern-arrow">
                                                <span class="employee-count">{{ $day_off_count }}</span>
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <a href="{{ url('rota-org/grace-period') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-dashboard modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title">Allowance Period</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status"></div>
                                            <div class="modern-arrow">
                                                <span class="employee-count">{{ $grac_count }}</span>
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <a href="{{ url('rota-org/duty-roster') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-dashboard modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title">Employee Roster</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status"></div>
                                            <div class="modern-arrow">
                                                <span class="employee-count">{{ $roast_count }}</span>
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
