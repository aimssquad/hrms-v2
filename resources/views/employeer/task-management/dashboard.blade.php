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
                <div class="row">
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="card border-0">
                            <div class="alert alert-primary border border-primary mb-0 p-3">
                                <div class="d-flex align-items-start">
                                    <div class="text-primary w-100">
                                        <i class="la la-list rota-icon-size-fixed"></i>
                                        <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">Project Directory</div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                            <div class="fs-12">
                                                <a href="{{ url('org-task-management/projects') }}" class="text-primary fw-semibold">
                                                    <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i> View all
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-md-6 col-sm-12">
                        <div class="card border-0">
                            <div class="alert alert-primary border border-primary mb-0 p-3">
                                <div class="d-flex align-items-start">
                                    <div class="text-primary w-100">
                                        <i class="la la-plus rota-icon-size-fixed"></i>
                                        <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">New Project</div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                            <div class="fs-12">
                                                <a href="{{ url('org-task-management/create-project') }}" class="text-primary fw-semibold">
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
                <div class="row">
                @foreach($projects as $k=>$p)
                <!-- <?php
                        // echo "<pre>";
                        // 		print_r($p);
                        // 		echo "</pre>"; 
                        ?> -->
                <div class="col-sm-4">
                    <div class="mt-2">
                        <h6 class="bg-primary m-0 p-2 text-white"><a style="color:#f7f7cb;" href={{url('/org-task-management/'.encrypt($p->id).'/tasks')}}>{{ucfirst($p->title)}}</a></h6>
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
