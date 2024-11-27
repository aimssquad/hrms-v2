@extends('employeer.include.app')

@section('title', 'Circumstances Dashboard')

@section('content')


    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Change Of Circumstances Dashboard</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('organization/employerdashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Change Of Circumstances Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!-- card -->
                            <div class="col-xl-4">
                                <div class="card border-0">
                                    <div class="alert alert-primary border border-primary mb-0 p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary w-100">
                                                <i class="la la-bell" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">Change Notification List</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                                    <div class="fs-12">
                                                        <a href="{{url('org-employee/change-of-circumstances-add')}}" class="text-primary fw-semibold">
                                                            <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4">
                                <div class="card border-0">
                                    <div class="alert alert-primary border border-primary mb-0 p-3">
                                        <div class="d-flex align-items-start">
                                            <div class="text-primary w-100">
                                                <i class="la la-list" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">COC- Report</div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                                    <div class="fs-12">
                                                        <a href="{{url('org-dashboard/change-of-circumstances')}}" class="text-primary fw-semibold">
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
