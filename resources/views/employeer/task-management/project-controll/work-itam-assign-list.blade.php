@extends('employeer.task-management.project-controll.app')

@section('title', \App\Helpers\Helper::cachedTrans('Assignment List'))

@section('content')
<!-- Page Content -->
    <div class="content container-fluid pb-0">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Assignment List</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{url('org-task-management/dashboard')}}">{{\App\Helpers\Helper::cachedTrans('All project List')}}</a></li>
                        {{-- <li class="breadcrumb-item active"><a href="#">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li> --}}
                        <li class="breadcrumb-item active"><a href="#">Assignment List</a></li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                        <a href="{{ route('work-item.assign-create', [
                                'id' => request()->route('id'),
                                'workItem' => $workItem
                            ]) }}"
                           class="btn add-btn">
                            <i class="fa-solid fa-plus"></i>
                            Assigne 
                        </a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        @include('employeer.layout.message')
        <div class="row">
            <div class="col-md-12">
                <div class="card custom-card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4 class="card-title">
                            <i class="far fa-user" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Assignment List
                        </h4>
                        <div class="row">
                            <div class="col-auto">
                                <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                                    @csrf
                                    <input type="hidden" name="data" id="data">
                                    <input type="hidden" name="headings" id="headings">
                                    <input type="hidden" name="filename" id="filename">
                                    {{-- put the value - that is your file name --}}
                                    <input type="hidden" id="filenameInput" value="Hired">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-file-excel"></i> Export to Excel
                                    </button>
                                </form>
                            </div>
                            <div class="col-auto">
                                <form action="{{ route('exportPDF') }}" method="POST" id="exportPDFForm">
                                    @csrf
                                    <input type="hidden" name="data" id="pdfData">
                                    <input type="hidden" name="headings" id="pdfHeadings">
                                    <input type="hidden" name="filename" id="pdfFilename">
                                    <button type="submit" class="btn btn-info btn-sm">
                                        <i class="fas fa-file-pdf"></i> Export to PDF
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                           <table class="table">
                                <thead>
                                    <tr>
                                        <th>Employee</th>
                                        <th>Assigned</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                            
                                @foreach($assignments as $assignment)
                            
                                    <tr>
                            
                                        <td>{{ $assignment->employee_name }}</td>
                            
                                        <td><span><button class="btn btn-success"><i class="fa fa-check"></i></button></span></td>
                                        
                                        <td>{{strtoUpper($assignment->status)}}</td>
                            
                                        <td>
                            
                                            <a href="#">
                                                Remove
                                            </a>
                            
                                        </td>
                            
                                    </tr>
                            
                                @endforeach
                            
                                </tbody>
                            </table> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Content -->
   
@endsection
@section('script')
    @include('taskmanagement.partials.scripts')
    <script src="{{asset('assets/taskmanagement/taskmanagement.js')}}"></script>
@endsection
