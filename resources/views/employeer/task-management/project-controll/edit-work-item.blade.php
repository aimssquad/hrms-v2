@extends('employeer.task-management.project-controll.app')

@section('title', \App\Helpers\Helper::cachedTrans('Edit Project Work Item'))

@section('content')
<div class="content container-fluid pb-0">

    <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">
                    Edit {{ ucfirst($workItem->type) }}
                </h3>

                <ul class="breadcrumb">
                    <li class="breadcrumb-item">
                        <a href="{{ url('organization/employerdashboard') }}">
                            {{ \App\Helpers\Helper::cachedTrans('Home') }}
                        </a>
                    </li>

                    <li class="breadcrumb-item">
                        <a href="{{ url('org-task-management/dashboard') }}">
                            {{ \App\Helpers\Helper::cachedTrans('All project List') }}
                        </a>
                    </li>

                    <li class="breadcrumb-item active">
                        <a href="{{url('org-task-management/project-analitic-dashboard/'.request()->route('id'))}}">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a>
                    </li>

                    <li class="breadcrumb-item active">
                        Edit {{ ucfirst($workItem->type) }}
                    </li>
                </ul>
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
                        Edit {{ ucfirst($workItem->type) }}
                    </h4>
                </div>

                <div class="card-body">

                    <form action="{{ route('work-item.update', encrypt($workItem->id)) }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf
                       

                        <input type="hidden"
                               name="project_id"
                               value="{{ $project_id }}">

                        <input type="hidden"
                               name="type"
                               value="{{ $workItem->type }}">

                        @if(in_array($workItem->type,['submodule','task','subtask']))
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">Parent Item</label>

                                    <select name="parent_id" class="form-control">
                                        <option value="">Select Parent</option>

                                        @foreach($parents as $parent)
                                            <option value="{{ $parent->id }}"
                                                {{ $workItem->parent_id == $parent->id ? 'selected' : '' }}>
                                                {{ $parent->title }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif

                        <div class="row">

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Title</label>

                                <input type="text"
                                       name="title"
                                       class="form-control"
                                       value="{{ old('title', $workItem->title) }}"
                                       required>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Priority</label>

                                <select name="priority" class="form-control">
                                    <option value="low"
                                        {{ $workItem->priority=='low' ? 'selected' : '' }}>
                                        Low
                                    </option>

                                    <option value="medium"
                                        {{ $workItem->priority=='medium' ? 'selected' : '' }}>
                                        Medium
                                    </option>

                                    <option value="high"
                                        {{ $workItem->priority=='high' ? 'selected' : '' }}>
                                        High
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">Start Date</label>

                                <input type="date"
                                       name="start_date"
                                       class="form-control"
                                       value="{{ old('start_date', $workItem->start_date) }}">
                            </div>

                            <div class="col-md-3 mb-3">
                                <label class="form-label">End Date</label>

                                <input type="date"
                                       name="end_date"
                                       class="form-control"
                                       value="{{ old('end_date', $workItem->end_date) }}">
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">File</label>

                                <input type="file"
                                       name="image"
                                       class="form-control">

                                @if($workItem->image)
                                    <div class="mt-2">
                                        <img src="{{ asset($workItem->image) }}"
                                             width="120"
                                             class="img-thumbnail">
                                    </div>
                                @endif
                            </div>

                            <div class="col-md-12 mb-3">
                                <label class="form-label">Description</label>

                                <textarea name="description"
                                          rows="4"
                                          class="form-control">{{ old('description', $workItem->description) }}</textarea>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Status</label>

                                <select name="status" class="form-control">
                                    <option value="open"
                                        {{ $workItem->status=='open' ? 'selected' : '' }}>
                                        Open
                                    </option>

                                    <option value="close"
                                        {{ $workItem->status=='close' ? 'selected' : '' }}>            
                                        Closed
                                    </option>
                                </select>
                            </div>

                            <div class="col-md-12">
                                <button type="submit" class="btn btn-primary">
                                    Update {{ ucfirst($workItem->type) }}
                                </button>
                            </div>

                        </div>

                    </form>

                </div>

            </div>

        </div>
    </div>

</div>
@endsection

@section('script')
    @include('taskmanagement.partials.scripts')
    <script src="{{ asset('assets/taskmanagement/taskmanagement.js') }}"></script>
@endsection