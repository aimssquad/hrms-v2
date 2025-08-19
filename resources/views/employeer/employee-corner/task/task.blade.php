@extends('employeer.employee-corner.main')
@section('title', 'Project Assigned')
@section('css')
     <style>
        .assigned-card {
            border-radius: 12px;
        }
        .avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }
        .cursor-pointer {
            cursor: pointer;
        }
        .team-avatars {
            display: flex;
            align-items: center;
        }
        .team-avatars .avatar {
            margin-left: -10px;
            border: 2px solid #fff;
        }
        .progress {
            height: 6px;
        }
    </style>
@endsection
@section('content')
    <div class="content container-fluid pb-0">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title" style="color:#ff902f">Project Assigned</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('organization/employerdashboard') }}" style="color:#ff902f">Dashboard</a></li>
                        <li class="breadcrumb-item active" style="color:#ff902f">Project Assigned</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        
        <div class="card mb-0">
            
                <div class="row">  
                    @foreach($projects as $project)
                        <div class="col-md-6 col-lg-3 my-2">
                            <div class="card assigned-card h-100 shadow-sm">
                                <div class="card-body position-relative">
                                    <i class="fas fa-ellipsis position-absolute top-0 end-0 m-3 text-muted cursor-pointer"></i>
                                    <h5 class="card-title">{{ $project['project_title'] }}</h5>
                                    <small class="text-muted">{{ $project['project_status'] }}, {{ count($project['tasks']) }} tasks</small>
                                    <p class="card-text mt-2">
                                        {{ $project['project_description'] }}
                                    </p>
                                    
                                    @if(count($project['tasks']) > 0)
                                        @php
                                            $taskDates = collect($project['tasks']);
                                            $startDate = $taskDates->min('start_date');
                                            $endDate = $taskDates->max('expected_end_date');
                                            $isPastDue = \Carbon\Carbon::parse($endDate)->isPast();
                                            $completedTasks = $taskDates->where('task_status', 'Completed')->count();
                                            $progress = count($project['tasks']) > 0 ? round(($completedTasks / count($project['tasks'])) * 100) : 0;
                                        @endphp
                                        
                                        <p class="fw-bold mb-1">Timeline:</p>
                                        <div class="d-flex justify-content-between">
                                            <div>
                                                <small>Start</small>
                                                <p>{{ \Carbon\Carbon::parse($startDate)->format('d M Y') }}</p>
                                            </div>
                                            <div>
                                                <small>End</small>
                                                <p class="{{ $isPastDue ? 'text-danger' : '' }}">
                                                    {{ \Carbon\Carbon::parse($endDate)->format('d M Y') }}
                                                    @if($isPastDue)
                                                        <i class="fas fa-exclamation-circle ms-1"></i>
                                                    @endif
                                                </p>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <p class="fw-bold mb-1">Project Role:</p>
                                    <p>{{ $project['project_role'] }}</p>
                                    
                                    <h4>
                                        <a href="{{ route('projects.members', $project['project_id']) }}" class="text-decoration-none">
                                            <i class="fas fa-comments me-2"></i>Chat with Team
                                        </a>
                                    </h4>
                                    {{-- <p class="fw-bold mb-1">Team Members:</p>
                                    <div class="team-members mb-3">
                                        @php 
                                            $memberIds = DB::table('project_members')
                                                ->where('project_id', $project['project_id'])
                                                ->pluck('user_id')
                                                ->toArray();
                                            
                                            $teamMembers = DB::table('employee')
                                                ->whereIn('id', $memberIds)
                                                ->select('emp_fname', 'emp_lname')
                                                ->get();
                                        @endphp

                                        @if($teamMembers->count() > 0)
                                            @foreach($teamMembers as $member)
                                                <span class="badge bg-light text-dark me-1 mb-1">
                                                    {{ $member->emp_fname }} {{ $member->emp_lname }}
                                                </span>
                                            @endforeach
                                        @else
                                            <span class="text-muted">No team members assigned</span>
                                        @endif
                                    </div> --}}
                                    
                                    {{-- @if(count($project['tasks']) > 0)
                                        <p class="fw-bold mb-1">Progress</p>
                                        <div class="progress">
                                            <div class="progress-bar bg-success" role="progressbar" style="width: {{ $progress }}%"></div>
                                        </div>
                                        <small class="text-success fw-bold">{{ $progress }}%</small>
                                    @endif --}}
                                </div>
                            </div>
                        </div>
                    @endforeach

                    {{-- <div class="col-md-6 col-lg-3 my-2">
                        <div class="card assigned-card h-100 shadow-sm">
                            <div class="card-body position-relative">
                                <i class="fas fa-ellipsis position-absolute top-0 end-0 m-3 text-muted cursor-pointer"></i>
                                <h5 class="card-title">Office Management</h5>
                                <small class="text-muted">1 open tasks, 9 tasks completed</small>
                                <p class="card-text mt-2">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                                    When an unknown printer took a galley of type and scrambled it...
                                </p>
                                <p class="fw-bold mb-1">Deadline:</p>
                                <p>17 Apr 2019</p>
                                <p class="fw-bold mb-1">Project Leader :</p>
                                <div class="mb-2">
                                    <img src="{{ asset('assets/img/sponicHr-logo.png') }}" alt="leader" class="avatar">
                                </div>
                                <p class="fw-bold mb-1">Team :</p>
                                <div class="team-avatars mb-3">
                                    <img src="{{ asset('assets/img/holiday.jpg') }}" alt="team-1" class="avatar" style="z-index: 0">
                                    <img src="{{ asset('assets/img/holiday.jpg') }}" alt="team-2" class="avatar" style="z-index: 1">
                                    <img src="{{ asset('assets/img/holiday.jpg') }}" alt="team-3" class="avatar" style="z-index: 2">
                                    <img src="{{ asset('assets/img/holiday.jpg') }}" alt="team-4" class="avatar" style="z-index: 3">
                                </div>
                                <p class="fw-bold mb-1">Progress</p>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 40%"></div>
                                </div>
                                <small class="text-success fw-bold">40%</small>
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-6 col-lg-3 my-2">
                        <div class="card assigned-card h-100 shadow-sm">
                            <div class="card-body position-relative">
                                <i class="fas fa-ellipsis position-absolute top-0 end-0 m-3 text-muted cursor-pointer"></i>
                                <h5 class="card-title">Office Management</h5>
                                <small class="text-muted">1 open tasks, 9 tasks completed</small>
                                <p class="card-text mt-2">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                                    When an unknown printer took a galley of type and scrambled it...
                                </p>
                                <p class="fw-bold mb-1">Deadline:</p>
                                <p>17 Apr 2019</p>
                                <p class="fw-bold mb-1">Project Leader :</p>
                                <div class="mb-2">
                                    <img src="{{ asset('assets/img/sponicHr-logo.png') }}" alt="leader" class="avatar">
                                </div>
                                <p class="fw-bold mb-1">Team :</p>
                                <div class="team-avatars mb-3">
                                    <img src="{{ asset('assets/img/holiday.jpg') }}" alt="team-1" class="avatar" style="z-index: 0">
                                    <img src="{{ asset('assets/img/holiday.jpg') }}" alt="team-2" class="avatar" style="z-index: 1">
                                    <img src="{{ asset('assets/img/holiday.jpg') }}" alt="team-3" class="avatar" style="z-index: 2">
                                    <img src="{{ asset('assets/img/holiday.jpg') }}" alt="team-4" class="avatar" style="z-index: 3">
                                </div>
                                <p class="fw-bold mb-1">Progress</p>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 40%"></div>
                                </div>
                                <small class="text-success fw-bold">40%</small>
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-6 col-lg-3 my-2">
                        <div class="card assigned-card h-100 shadow-sm">
                            <div class="card-body position-relative">
                                <i class="fas fa-ellipsis position-absolute top-0 end-0 m-3 text-muted cursor-pointer"></i>
                                <h5 class="card-title">Office Management</h5>
                                <small class="text-muted">1 open tasks, 9 tasks completed</small>
                                <p class="card-text mt-2">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                                    When an unknown printer took a galley of type and scrambled it...
                                </p>
                                <p class="fw-bold mb-1">Deadline:</p>
                                <p>17 Apr 2019</p>
                                <p class="fw-bold mb-1">Project Leader :</p>
                                <div class="mb-2">
                                    <img src="{{ asset('assets/img/sponicHr-logo.png') }}" alt="leader" class="avatar">
                                </div>
                                <p class="fw-bold mb-1">Team :</p>
                                <div class="team-avatars mb-3">
                                    <img src="{{ asset('assets/img/holiday.jpg') }}" alt="team-1" class="avatar" style="z-index: 0">
                                    <img src="{{ asset('assets/img/holiday.jpg') }}" alt="team-2" class="avatar" style="z-index: 1">
                                    <img src="{{ asset('assets/img/holiday.jpg') }}" alt="team-3" class="avatar" style="z-index: 2">
                                    <img src="{{ asset('assets/img/holiday.jpg') }}" alt="team-4" class="avatar" style="z-index: 3">
                                </div>
                                <p class="fw-bold mb-1">Progress</p>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 40%"></div>
                                </div>
                                <small class="text-success fw-bold">40%</small>
                            </div>
                        </div>
                    </div> 

                    <div class="col-md-6 col-lg-3 my-2">
                        <div class="card assigned-card h-100 shadow-sm">
                            <div class="card-body position-relative">
                                <i class="fas fa-ellipsis position-absolute top-0 end-0 m-3 text-muted cursor-pointer"></i>
                                <h5 class="card-title">Office Management</h5>
                                <small class="text-muted">1 open tasks, 9 tasks completed</small>
                                <p class="card-text mt-2">
                                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. 
                                    When an unknown printer took a galley of type and scrambled it...
                                </p>
                                <p class="fw-bold mb-1">Deadline:</p>
                                <p>17 Apr 2019</p>
                                <p class="fw-bold mb-1">Project Leader :</p>
                                <div class="mb-2">
                                    <img src="{{ asset('assets/img/sponicHr-logo.png') }}" alt="leader" class="avatar">
                                </div>
                                <p class="fw-bold mb-1">Team :</p>
                                <div class="team-avatars mb-3">
                                    <img src="{{ asset('assets/img/holiday.jpg') }}" alt="team-1" class="avatar" style="z-index: 0">
                                    <img src="{{ asset('assets/img/holiday.jpg') }}" alt="team-2" class="avatar" style="z-index: 1">
                                    <img src="{{ asset('assets/img/holiday.jpg') }}" alt="team-3" class="avatar" style="z-index: 2">
                                    <img src="{{ asset('assets/img/holiday.jpg') }}" alt="team-4" class="avatar" style="z-index: 3">
                                </div>
                                <p class="fw-bold mb-1">Progress</p>
                                <div class="progress">
                                    <div class="progress-bar bg-success" role="progressbar" style="width: 40%"></div>
                                </div>
                                <small class="text-success fw-bold">40%</small>
                            </div>
                        </div>
                    </div>  --}}
                </div>
           
        </div>
    </div>    
@endsection

