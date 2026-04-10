@extends('employeer.task-management.project-management.app')

@section('title', \App\Helpers\Helper::cachedTrans('Task Details List'))
@php use Illuminate\Support\Str; @endphp
@section('content')

<div class="main-panel">
    <div class="page-header">
    </div>
    <div class="content">
        <div class="page-inner">
            <div class="page-header">
               
                {{-- <h1 class="page-title"> {{$project->title}}</h1> --}}
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('org-task-management/dashboard')}}">{{\App\Helpers\Helper::cachedTrans('All project List')}}</a></li>
                    {{-- <li class="breadcrumb-item"><a href="{{url('/org-task-management/project-analitic-dashboard/'.encrypt($project->id))}}">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li> --}}
                    <li class="breadcrumb-item"><a href="#">{{\App\Helpers\Helper::cachedTrans('Task Details')}}</a></li>  
                </ul>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card custom-card">
                        <div class="card-header">
                            <h4 class="card-title"><i class="fas fa-briefcase"></i> {{\App\Helpers\Helper::cachedTrans($project_name)}} 
                            </h4>
                        </div>
                        {{-- @include('employeer.layout.message')
                        <div class="card-header">
                        </div> --}}
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped custom-table" id="basic-datatables">
                                    <thead>
                                        <tr>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Sl No.')}}</th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Task Name')}}</th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Assigned To')}}</th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Task Description')}}</th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Task File')}}</th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Priority')}}</th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('By Assigner')}}</th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Start Date')}}</th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('End Date')}}</th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Emp File')}}</th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Status')}}</th>
                                            <th>{{\App\Helpers\Helper::cachedTrans('Action')}}</th>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        @foreach($tasks as $key => $task)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $task->task_name }}</td>
                                            <td>{{ $task->assignedTo }}</td>
                                            <td>
                                                <a href="javascript:void(0);" 
                                                data-toggle="modal" 
                                                data-target="#descModal{{ $task->id }}">
                                                
                                                    {{ \Illuminate\Support\Str::limit(strip_tags($task->task_desc), 50) }}
                                                </a>
                                            </td>
                                            <td>
                                                @if(!empty($task->task_file))
                                                    <a href="{{ \Illuminate\Support\Facades\Storage::url($task->task_file) }}" target="_blank" class="btn btn-sm btn-primary">
                                                        View
                                                    </a>
                                                @else
                                                    <span class="text-muted">No File</span>
                                                @endif
                                            </td>
                                            <td>{{ $task->priority }}</td>
                                            <td></td>
                                            <td>{{ $task->start_date }}</td>
                                            <td>{{ $task->expected_end_date }}</td>
                                            <td>
                                                @if(!empty($task->task_file))
                                                    <a href="{{ \Illuminate\Support\Facades\Storage::url($task->task_file) }}" target="_blank" class="btn btn-sm btn-primary">
                                                        View
                                                    </a>
                                                @else
                                                    <span class="text-muted">No File</span>
                                                @endif
                                            </td>
                                            {{-- <td> 
                                                <span class="@if($task->status == 'Todo') badge badge-danger
                                                @elseif($task->status == 'Pending') badge badge-warning
                                                @elseif($task->status == 'Resolved') badge badge-success
                                                @endif">
                                                    {{ $task->status }}
                                                </span>
                                            </td> --}}
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-sm dropdown-toggle 
                                                        @if($task->status == 'Todo') btn-danger
                                                        @elseif($task->status == 'Pending') btn-warning
                                                        @elseif($task->status == 'Resolved') btn-primary
                                                        @elseif($task->status == 'Complete') btn-success
                                                        @endif"
                                                        type="button" data-toggle="dropdown">

                                                        {{ ucfirst($task->status) }}
                                                    </button>

                                                    <div class="dropdown-menu">
                                                        <a class="dropdown-item change-status" 
                                                        data-id="{{ $task->id }}" 
                                                        data-status="Todo" href="#">Todo</a>

                                                        <a class="dropdown-item change-status" 
                                                        data-id="{{ $task->id }}" 
                                                        data-status="Pending" href="#">Pending</a>

                                                        <a class="dropdown-item change-status" 
                                                        data-id="{{ $task->id }}" 
                                                        data-status="Resolved" href="#">Resolved</a>

                                                        <a class="dropdown-item change-status" 
                                                        data-id="{{ $task->id }}" 
                                                        data-status="Complete" href="{{url('org-task-management/'.$task->id.'/task-status')}}">Complete</a>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-end">
                                                <div class="dropdown dropdown-action">
                                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="">
                                                            <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                        </a>
                                                        <a class="dropdown-item" href="" onclick="return confirm('Are you sure?')">
                                                            <i class="fa-solid fa-trash m-r-5"></i> Delete
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>

                                        <div class="modal fade" id="descModal{{ $task->id }}" tabindex="-1" role="dialog">
                                            <div class="modal-dialog modal-lg" role="document">
                                                <div class="modal-content">

                                                    <div class="modal-header d-flex justify-content-between">
                                                        <h5 class="modal-title">Task Description</h5>

                                                        <button type="button" class="btn btn-danger btn-sm" data-dismiss="modal">
                                                            ✕
                                                        </button>
                                                    </div>

                                                    <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                                                        {!! $task->task_desc !!}
                                                    </div>

                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

                                    </tbody>
                                </table>
                            </div>

                        </div>
                    </div>
                </div>




            </div>
        </div>
    </div>
    
</div>
<!-- /.content -->
@endsection

@include('taskmanagement.partials.scripts')
@section('scripts')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"></script>
@endsection


