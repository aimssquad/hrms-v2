@extends('employeer.task-management.project-controll.app')

@section('title', \App\Helpers\Helper::cachedTrans('Project Each Label List'))

@section('content')
<!-- Page Content -->
    <div class="content container-fluid pb-0">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Project {{ ucfirst($workItem) }} List</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{url('org-task-management/dashboard')}}">{{\App\Helpers\Helper::cachedTrans('All project List')}}</a></li>
                        <li class="breadcrumb-item active"><a href="#">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
                        <li class="breadcrumb-item active"><a href="#">Project {{ ucfirst($workItem) }} List</a></li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                        <a href="{{ route('work-item.create', [
                                'id' => request()->route('id'),
                                'workItem' => $workItem
                            ]) }}"
                           class="btn add-btn">
                            <i class="fa-solid fa-plus"></i>
                            Add {{ ucfirst($workItem) }}
                        </a>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        @include('employeer.layout.message')
        <div class="row">
            <div class="col-md-12">
    
                <div class="card">
    
                    <div class="card-header">
                        <h4 class="card-title">
                            Add {{ ucfirst($workItem) }}
                        </h4>
                    </div>
    
                    <div class="card-body">
    
                        <form action="{{ route('work-item.store') }}"
                              method="POST"
                              enctype="multipart/form-data">
                        
                            @csrf
                        
                            <input type="hidden" name="project_id" value="{{ $project_id }}">
                            <input type="hidden" name="type" value="{{ $workItem }}">
                        
                            <div class="row">
                        
                                @if(in_array($workItem,['submodule','task','subtask']))
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Parent Item</label>
                                    <select name="parent_id" class="form-control">
                                        <option value="">Select Parent</option>
                                        @foreach($parents as $parent)
                                            <option value="{{ $parent->id }}">
                                                {{ $parent->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                                @endif
                        
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Title</label>
                                    <input type="text"
                                           name="title"
                                           class="form-control"
                                           required>
                                </div>
                        
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Priority</label>
                                    <select name="priority" class="form-control">
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                </div>
                        
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">Start Date</label>
                                    <input type="date"
                                           name="start_date"
                                           class="form-control">
                                </div>
                        
                                <div class="col-md-3 mb-3">
                                    <label class="form-label">End Date</label>
                                    <input type="date"
                                           name="end_date"
                                           class="form-control">
                                </div>
                        
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">File</label>
                                    <input type="file"
                                           name="image"
                                           class="form-control">
                                </div>
                        
                                <!--<div class="col-md-6 mb-3">-->
                                <!--    <label class="form-label">Attachment</label>-->
                                <!--    <input type="file"-->
                                <!--           name="file"-->
                                <!--           class="form-control">-->
                                <!--</div>-->
                        
                                <div class="col-md-12 mb-3">
                                    <label class="form-label">Description</label>
                                    <textarea name="description"
                                              rows="4"
                                              class="form-control"></textarea>
                                </div>
                        
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">
                                        Save {{ ucfirst($workItem) }}
                                    </button>
                                </div>
                        
                            </div>
                        </form>
    
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
