@extends('employeer.include.app')

@section('title', \App\Helpers\Helper::cachedTrans('Visitor Dashboard'))

@section('content')


    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Visitor Dashboard')}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('organization/employerdashboard') }}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                        <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Visitor Dashboard')}}</li>
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
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <a href="{{ url('rota-org/visitor-regis') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="fa fa-users modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans('Total No Of Visitors')}}</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status">
                                                </div>
                                                <div class="modern-arrow">
                                                <span class="employee-count">{{ $visitor_count }}</span>
                                                <i class="fa fa-arrow-circle-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </a>

                            </div>
                            <div class="col-xl-4 col-md-6 col-sm-12">
                                <a href="{{ url('rota-org/visitor-link') }}" class="modern-card-link">
                                    <div class="modern-card">
                                        <div class="modern-card-header">
                                            <div class="modern_icon_wrapper">
                                                <i class="fa fa-sign-in modern-icon"></i>
                                            </div>
                                            <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans('Sign Up Link')}}</h4>
                                        </div>
                                        <div class="modern-card-body">
                                            <div class="modern-status">
                                                </div>
                                                <div class="modern-arrow">
                                                <span class="employee-count">{{ $visitor_count }}</span>
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
