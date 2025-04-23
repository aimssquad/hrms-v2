@extends('employeer.include.app')

@section('title', 'Settings Dashboard')

@section('content')

    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Settings Dashboard</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('organization/employerdashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Settings Dashboard</li>
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
                            <!-- Buttons -->
                             <div class="col-xl-4">
                                <a href="{{ url('org-settings/vw-cmp-bank') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-bank modern-icon" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                            </div>
                                            <h4 class="modern-card-title">Add Organisation Bank</h4>
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
                            <div class="col-xl-4">
                                <a href="{{ url('org-settings/vw-emp-bank') }}" class="modern-card-link">
                                    <div class="modern-card border-0">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-bank modern-icon" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                            </div>
                                            <h4 class="modern-card-title">Add Employee Bank</h4>
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
                            <div class="col-xl-4">
                                <a href="{{ url('org-settings/add-new-department') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-sitemap modern-icon" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                            </div>
                                            <h4 class="modern-card-title">Add New Department</h4>
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
                            <div class="col-xl-4">
                                <a href="{{ url('org-settings/designation') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-id-badge modern-icon" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                            </div>
                                            <h4 class="modern-card-title">Add New Designation</h4>
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
                            <div class="col-xl-4">
                                <a href="{{ url('org-settings/employee-type') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-users modern-icon" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                            </div>
                                            <h4 class="modern-card-title">Add New Employee Type</h4>
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
                            <div class="col-xl-4">
                                <a href="{{ url('org-settings/add-mode-emp') }}" class="modern-card-link">
                                    <div class="modern-card border-0">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="la la-user modern-icon" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                            </div>
                                            <h4 class="modern-card-title">Add Employee Mode Type</h4>
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
                            <div class="col-xl-4">
                                <a href="{{ url('org-settings/add-new-type') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="fa fa-braille modern-icon" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                            </div>
                                            <h4 class="modern-card-title">Add Employee Master Type</h4>
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
                            <div class="col-xl-4">
                                <a href="{{ url('org-settings/add-new-education') }}" class="modern-card-link">
                                    <div class="modern-card border-0">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="fa fa-braille modern-icon" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                            </div>
                                            <h4 class="modern-card-title">Add Education Master Type</h4>
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
                            
                            <!--<div class="col-md-4 col-6 mb-4">-->
                            <!--    <div class="alert alert-outline-info alert-dismissible fade show h-100 w-100">-->
                            <!--        Add New Department-->
                            <!--        <a href="{{url('org-settings/add-new-department')}}">-->
                            <!--            <button type="button" class="btn-close" aria-label="add">-->
                            <!--                <i class="fas fa-add"></i>-->
                            <!--            </button>-->
                            <!--        </a>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<div class="col-md-4 col-6 mb-4">-->
                            <!--    <div class="alert alert-outline-info alert-dismissible fade show h-100 w-100">-->
                            <!--        Add New Dsignation-->
                            <!--        <a href="{{url('org-settings/designation')}}">-->
                            <!--            <button type="button" class="btn-close" aria-label="add">-->
                            <!--                <i class="fas fa-add"></i>-->
                            <!--            </button>-->
                            <!--        </a>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<div class="col-md-4 col-6 mb-4">-->
                            <!--    <div class="alert alert-outline-info alert-dismissible fade show h-100 w-100">-->
                            <!--        Add New Employee Type-->
                            <!--        <a href="{{url('org-settings/employee-type')}}">-->
                            <!--            <button type="button" class="btn-close" aria-label="add">-->
                            <!--                <i class="fas fa-add"></i>-->
                            <!--            </button>-->
                            <!--        </a>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<div class="col-md-4 col-6 mb-4">-->
                            <!--    <div class="alert alert-outline-info alert-dismissible fade show h-100 w-100">-->
                            <!--       Add Employee Mode Type-->
                            <!--        <a href="{{url('org-settings/add-mode-emp')}}">-->
                            <!--            <button type="button" class="btn-close" aria-label="add">-->
                            <!--                <i class="fas fa-add"></i>-->
                            <!--            </button>-->
                            <!--        </a>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<div class="col-md-4 col-6 mb-4">-->
                            <!--    <div class="alert alert-outline-info alert-dismissible fade show h-100 w-100">-->
                            <!--       Add Employee Master Type-->
                            <!--        <a href="{{url('org-settings/add-new-type')}}">-->
                            <!--            <button type="button" class="btn-close" aria-label="add">-->
                            <!--                <i class="fas fa-add"></i>-->
                            <!--            </button>-->
                            <!--        </a>-->
                            <!--    </div>-->
                            <!--</div>-->
                            <!--<div class="col-md-4 col-6 mb-4">-->
                            <!--    <div class="alert alert-outline-info alert-dismissible fade show h-100 w-100">-->
                            <!--       Add Education Master Type-->
                            <!--        <a href="{{url('org-settings/add-new-education')}}">-->
                            <!--            <button type="button" class="btn-close" aria-label="add">-->
                            <!--                <i class="fas fa-add"></i>-->
                            <!--            </button>-->
                            <!--        </a>-->
                            <!--    </div>-->
                            <!--</div>-->
                            
                        </div>

                        <hr class="my-4">

                        <div class="row g-4 ">

                            <div class="col-xl-4">
                                <a href="{{ url('org-settings/vw-department') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="fa fa-braille modern-icon" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                            </div>
                                            <h4 class="modern-card-title">Total Department</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <span></span>
                                            <div class="modern-arrow">
                                                <div class="employee-count">{{ $department_count }}</div>
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>

                            <div class="col-xl-4">
                                <a href="{{ url('org-settings/vw-designation') }}" class="modern-card-link">
                                    <div class="modern-card border-0">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="fa fa-braille modern-icon" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                            </div>
                                            <h4 class="modern-card-title">Total Designation</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <span></span>
                                            <div class="modern-arrow">
                                                <div class="employee-count">{{ $designation_count }}</div>
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>

                            <div class="col-xl-4">
                                <a href="{{ url('org-settings/vw-type') }}" class="modern-card-link">
                                    <div class="modern-card border-0">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="fa fa-braille modern-icon" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                            </div>
                                            <h4 class="modern-card-title">Total Employee Type</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <span></span>
                                            <div class="modern-arrow">
                                                <div class="employee-count">{{ $employee_type_count }}</div>
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>

                            <div class="col-xl-4">
                                <a href="{{ url('org-settings/vw-mode-type') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="fa fa-braille modern-icon" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                            </div>
                                            <h4 class="modern-card-title">Total Employee Mode</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <span></span>
                                            <div class="modern-arrow">
                                                <div class="employee-count">{{ $employee_mode_count }}</div>
                                                <i class="fa fa-arrow-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>


                            </div>

                            <div class="col-xl-4">
                            <a href="{{ url('org-settings/vw-type') }}" class="modern-card-link">
                            <div class="modern-card border-0">
                                <div class="modern-card-header">
                                    <div class="modern_icon_wrapper">
                                        <i class="fa fa-braille modern-icon" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                    </div>
                                    <h4 class="modern-card-title">Total Employee Master</h4>
                                </div>
                                <div class="modern-card-body">
                                    <span></span>
                                    <div class="modern-arrow">
                                        <div class="employee-count">{{ $employee_master_count }}</div>
                                        <i class="fa fa-arrow-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>

                            </div>

                            <div class="col-xl-4">
                                <a href="{{ url('org-settings/vw-education') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="fa fa-braille modern-icon" data-bs-toggle="tooltip" aria-label="fa fa-braille" data-bs-original-title="fa fa-braille"></i>
                                            </div>
                                            <h4 class="modern-card-title">Total Education Master</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <span></span>
                                            <div class="modern-arrow">
                                                <div class="employee-count">{{ $employee_master_count }}</div>
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
