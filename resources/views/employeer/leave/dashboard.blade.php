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
                       

                        <div class="row">

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="card border-0">
                                    <div class="alert alert-primary border border-primary mb-0 p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary w-100">
                                                <i class="la la-dashboard rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">Category</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12">{{$leave_type_count ?? 0}}</div>
                                                    <div class="fs-12">
                                                        <a href="{{ url('leave/leave-type-listing') }}" class="text-primary fw-semibold">
                                                            <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="card border-0">
                                    <div class="alert alert-primary border border-primary mb-0 p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary w-100">
                                                <i class="la la-dashboard rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">Policy</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12">{{$late_rule_count ?? 0}}</div>
                                                    <div class="fs-12">
                                                        <a href="{{ url('leave/leave-rule-listing') }}" class="text-primary fw-semibold">
                                                            <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="card border-0">
                                    <div class="alert alert-primary border border-primary mb-0 p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary w-100">
                                                <i class="la la-dashboard rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">Allocation</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12">{{$leave_allocation_count ?? 0 }}</div>
                                                    <div class="fs-12">
                                                        <a href="{{ url('leave/leave-allocation-listing') }}" class="text-primary fw-semibold">
                                                            <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="card border-0">
                                    <div class="alert alert-primary border border-primary mb-0 p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary w-100">
                                                <i class="la la-dashboard rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">Leave Accrued</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12">{{$leave_balance_count ?? 0 }}</div>
                                                    <div class="fs-12">
                                                        <a href="{{ url('leave/leave-balance') }}" class="text-primary fw-semibold">
                                                            <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="card border-0">
                                    <div class="alert alert-primary border border-primary mb-0 p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary w-100">
                                                <i class="la la-dashboard rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">Leave Record</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                                    <div class="fs-12">
                                                        <a href="{{ url('leave/leave-report') }}" class="text-primary fw-semibold">
                                                            <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <div class="card border-0">
                                    <div class="alert alert-primary border border-primary mb-0 p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary w-100">
                                                <i class="la la-dashboard rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">Record EE Wise</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                                    <div class="fs-12">
                                                        <a href="{{ url('leave/leave-report-employee') }}" class="text-primary fw-semibold">
                                                            <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
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
