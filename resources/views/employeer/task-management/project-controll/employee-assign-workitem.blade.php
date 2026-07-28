@extends('employeer.task-management.project-controll.app')

@section('title', \App\Helpers\Helper::cachedTrans('Employee Addigned'))

@section('content')
<!-- Page Content -->
    <div class="content container-fluid pb-0">
        
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Assigned</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{url('org-task-management/dashboard')}}">{{\App\Helpers\Helper::cachedTrans('All project List')}}</a></li>
                        <li class="breadcrumb-item active"><a href="#">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
                        <!--<li class="breadcrumb-item active"><a href="#">Project {{ ucfirst($workItem) }} List</a></li>-->
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                       
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        @include('employeer.layout.message')
        <div class="row">
            <form action="{{ route('employee.work-item.assign.store') }}"
                  method="POST">
            
                @csrf
            
                <input type="hidden"
                       name="project_id"
                       value="{{ $project_id }}">
            
                <input type="hidden"
                       name="work_item_id"
                       value="{{ $workItem->id }}">
            
                <div class="row">
                    
                    {{-- <div class="col-md-6">
                        <label>Role</label>
            
                        <select name="project_role_id"
                                class="form-control"
                                required>
            
                            <option value="">
                                Select Role
                            </option>
            
                            @foreach($roles as $role)
            
                                <option value="{{ $role->id }}">
                                    {{ $role->name }}
                                </option>
            
                            @endforeach
            
                        </select>
                    </div> --}}
                    
            
                    <div class="col-md-4">
                        <label>Employee</label>
            
                        <select name="employee_id"
                                class="form-control"
                                required>
            
                            <option value="">
                                Select Employee
                            </option>
            
                            @foreach($employees as $employee)
            
                                <option value="{{ $employee->employee_id }}">
                                    {{ $employee->name }}
                                </option>
            
                            @endforeach
            
                        </select>
                    </div>
            
                   
            
                </div>
            
                <div class="mt-3">
                    <button class="btn btn-primary">
                        Assign
                    </button>
                </div>
            
            </form>
        </div>
    </div>
    <!-- /Page Content -->
   
@endsection
@section('script')
    @include('taskmanagement.partials.scripts')
    <script src="{{asset('assets/taskmanagement/taskmanagement.js')}}"></script>
@endsection
