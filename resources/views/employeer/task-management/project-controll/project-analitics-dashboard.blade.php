@extends('employeer.task-management.project-controll.app')

@section('title', \App\Helpers\Helper::cachedTrans('Project Analytics Dashboard'))

@section('css')
<style>
    #projectChart {
        max-width: 250px;
        max-height: 250px;
        margin: auto;
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
                <h3 class="page-title">{{\App\Helpers\Helper::cachedTrans($projects->title. ' Dashboard')}} Testing</h3>
                {{-- <h3 class="page-title">{{$projects->title .'Dashboard'}}</h3> --}}
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('org-task-management/dashboard')}}">{{\App\Helpers\Helper::cachedTrans('All project List')}}</a></li>
                    <li class="breadcrumb-item active"><a href="#">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
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

                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card dash-widget overflow-visible">
                                <a href="#">
                                    <div class="card-body modern-card">
                                        <div class="dash-widget-info">
                                            <span>{{\App\Helpers\Helper::cachedTrans('Members')}}</span>
                                            <h3>{{ $totalMembers }}</h3>
                                        </div>
                                        <div class="modern_icon_wrapper">
                                            <i class="fa-solid fa-users fa-2x modern-icon"></i>
                                        </div>
                                        <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                            <span style="font-size: 13px;">{{\App\Helpers\Helper::cachedTrans('View')}}</span>
                                            <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card dash-widget overflow-visible">
                                <a href="#">
                                    <div class="card-body modern-card">
                                        <div class="dash-widget-info">
                                            <span>{{\App\Helpers\Helper::cachedTrans('Module')}}</span>
                                            <h3>{{ $totalModule }}</h3>
                                        </div>
                                        <div class="modern_icon_wrapper">
                                            <i class="fa-solid fa fa-folder fa-2x modern-icon"></i>
                                        </div>
                                        <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                            <span style="font-size: 13px;">{{\App\Helpers\Helper::cachedTrans('View')}}</span>
                                            <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card dash-widget overflow-visible">
                                <a href="#">
                                    <div class="card-body modern-card">
                                        <div class="dash-widget-info">
                                            <span>{{\App\Helpers\Helper::cachedTrans('Sub Module')}}</span>
                                            <h3>{{ $totalSubmodule }}</h3>
                                        </div>
                                        <div class="modern_icon_wrapper">
                                            <i class="fa-solid fa fa-folder-open fa-2x modern-icon"></i>
                                        </div>
                                        <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                            <span style="font-size: 13px;">{{\App\Helpers\Helper::cachedTrans('View')}}</span>
                                            <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card dash-widget overflow-visible">
                                <a href="#">
                                    <div class="card-body modern-card">
                                        <div class="dash-widget-info">
                                            <span>{{\App\Helpers\Helper::cachedTrans('Task')}}</span>
                                            <h3>{{ $totalTasks }}</h3>
                                        </div>
                                        <div class="modern_icon_wrapper">
                                            <i class="fa-solid fa fa-tasks fa-2x modern-icon"></i>
                                        </div>
                                        <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                            <span style="font-size: 13px;">{{\App\Helpers\Helper::cachedTrans('View')}}</span>
                                            <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card dash-widget overflow-visible">
                                <a href="#">
                                    <div class="card-body modern-card">
                                        <div class="dash-widget-info">
                                            <span>{{\App\Helpers\Helper::cachedTrans('Sub Task')}}</span>
                                            <h3>{{ $totalSubtask }}</h3>
                                        </div>
                                        <div class="modern_icon_wrapper">
                                            <i class="fa-solid fa fa-check-square fa-2x modern-icon"></i>
                                        </div>
                                        <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                            <span style="font-size: 13px;">{{\App\Helpers\Helper::cachedTrans('View')}}</span>
                                            <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card dash-widget overflow-visible">
                                <a href="#">
                                    <div class="card-body modern-card">
                                        <div class="dash-widget-info">
                                            <span>{{\App\Helpers\Helper::cachedTrans('Member Label')}}</span>
                                            <h3>{{ $memberLabels->sum('total') }}</h3>
                                        </div>
                                        <div class="modern_icon_wrapper">
                                            <i class="fa-solid fa-tags fa-2x modern-icon"></i>
                                        </div>
                                        <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                            <span style="font-size: 13px;">{{\App\Helpers\Helper::cachedTrans('View')}}</span>
                                            <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card dash-widget overflow-visible">
                                <a href="#">
                                    <div class="card-body modern-card">
                                        <div class="dash-widget-info">
                                            <span>{{\App\Helpers\Helper::cachedTrans('Member Roles')}}</span>
                                            <h3>{{ $memberRoles }}</h3>
                                        </div>
                                        <div class="modern_icon_wrapper">
                                            <i class="fa-solid fa-user-tie fa-2x modern-icon"></i>
                                        </div>
                                        <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                            <span style="font-size: 13px;">{{\App\Helpers\Helper::cachedTrans('View')}}</span>
                                            <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        {{-- <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card dash-widget overflow-visible">
                                <a href="#">
                                    <div class="card-body modern-card">
                                        <div class="dash-widget-info">
                                            <span>{{\App\Helpers\Helper::cachedTrans('Active Projects')}}</span>
                                            <h3>{{$activeProject}}</h3>
                                        </div>
                                        <div class="modern_icon_wrapper">
                                            <i class="fa-solid fa-bars-progress fa-2x modern-icon"></i>
                                        </div>
                                        <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                            <span style="font-size: 13px;">{{\App\Helpers\Helper::cachedTrans('View')}}</span>
                                            <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>

                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card dash-widget overflow-visible">
                                <a href="#">
                                    <div class="card-body modern-card">
                                        <div class="dash-widget-info">
                                            <span>{{\App\Helpers\Helper::cachedTrans('Completed Projects')}}</span>
                                            <h3>{{$closedProject}}</h3>
                                        </div>
                                        <div class="modern_icon_wrapper">
                                            <i class="fa-solid fa-circle-check fa-2x modern-icon"></i>
                                        </div>
                                        <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                            <span style="font-size: 13px;">{{\App\Helpers\Helper::cachedTrans('View')}}</span>
                                            <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div> --}}

                        <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
                            <div class="card dash-widget overflow-visible">
                                <a href="{{url('/org-task-management/'.encrypt($id).'/chat')}}">
                                    <div class="card-body modern-card">
                                        <div class="dash-widget-info">
                                            <span>{{\App\Helpers\Helper::cachedTrans('Chat')}}</span>
                                            {{-- <h3>25</h3> --}}
                                        </div>
                                        <div class="modern_icon_wrapper">
                                            <i class="fa-solid fa-comments fa-2x modern-icon"></i>
                                        </div>
                                        <div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
                                            <span style="font-size: 13px;">{{\App\Helpers\Helper::cachedTrans('View')}}</span>
                                            <i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
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
                
        
    

</div>



@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>



@endsection