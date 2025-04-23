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
                                <a href="{{ url('org-employee/change-of-circumstances-add') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-bell modern-icon" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                            </div>
                                            <h4 class="modern-card-title">Change Notification List</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status"></div>
                                            <div class="modern-arrow">
                                                <i class="fa fa-arrow-circle-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>
                            <div class="col-xl-4">
                                <a href="{{ url('org-dashboard/change-of-circumstances') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-list modern-icon" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                            </div>
                                            <h4 class="modern-card-title">COC- Report</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status"></div>
                                            <div class="modern-arrow">
                                                <i class="fa fa-arrow-circle-right"></i>
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
