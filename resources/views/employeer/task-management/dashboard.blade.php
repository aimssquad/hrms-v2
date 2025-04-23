@extends('employeer.include.app')

@section('title', 'Task Control Dashboard')

@section('content')


    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Welcome Task Control Dashboard</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        <div class="card">
            <div class="card-body">
                <div class="row mb-4">
                    <div class="col-xl-6 col-md-6 col-sm-12">
                    <a href="{{ url('org-task-management/projects') }}" class="modern-card-link">
                            <div class="modern-card border-0">
                                <div class="modern-card-header">
                                    <div class="modern_icon_wrapper">
                                        <i class="la la-list modern-icon"></i>
                                    </div>
                                    <h4 class="modern-card-title">Project Directory</h4>
                                </div>
                                <div class="modern-card-body">
                                    <div class="modern-status"></div>
                                    <div class="modern-arrow">
                                        <span class="employee-count opacity-0">0</span>
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <a href="{{ url('org-task-management/create-project') }}" class="modern-card-link">
                            <div class="modern-card border-0">
                                <div class="modern-card-header">
                                    <div class="modern_icon_wrapper">
                                        <i class="la la-plus modern-icon"></i>
                                    </div>
                                    <h4 class="modern-card-title">New Project</h4>
                                </div>
                                <div class="modern-card-body">
                                    <div class="modern-status"></div>
                                    <div class="modern-arrow">
                                        <span class="employee-count opacity-0">0</span>
                                        <i class="fa fa-arrow-circle-right"></i>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>            
                <div class="row">
                @foreach($projects as $k=>$p)
                <!-- <?php
                        // echo "<pre>";
                        // 		print_r($p);
                        // 		echo "</pre>"; 
                        ?> -->
                <div class="col-sm-4">
                    <div class="mt-2">
                        <h6 class="bg-primary m-0 p-2 text-white"><a class="for_hover_white" href={{url('/org-task-management/'.encrypt($p->id).'/tasks')}}>{{ucfirst($p->title)}} <i class="fa-solid fa-arrow-right"></i></a></h6>
                        <table class="table table-hover border m-0 p-0">
                            <tr>
                                <th>Owner:</th>
                                <td>{{ucfirst($p->owner)}}</td>
                            </tr>
                            <tr>
                                <th>Satrt Date:</th>
                                <td><span class="badge text-bg-primary">{{date("d-m-Y",strtotime($p->created_at))}}</span></td>
                            </tr>
                        </table>
    
                    </div>
                    <div class="mb-5 d-block mt-2">
                        @foreach($p->labels as $l)
                        <span class="border border-1 rounded pt-1 pb-1 ps-2 pe-2 d-inline-block text-center" style="background-color:#f5f5b7;">
                            <h4 class="m-0 p-0 text-primary">{{$l['count']}}</h4>
                            <p class="m-0 p-0">{{$l['title']}}</p>
                        </span>
                        @endforeach
                    </div>
                </div>
                @endforeach
               
            </div>
            </div>    
        </div>            
         
     

    </div>
    <!-- /Page Content -->


@endsection
