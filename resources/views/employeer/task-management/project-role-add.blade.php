@extends('employeer.include.app')

@section('title', \App\Helpers\Helper::cachedTrans(isset($role) ? 'Update Role' : 'Add New Role'))

@section('content')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="row">
                <div class="col-md-12">

                    <ul class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="{{ url('organization/employerdashboard') }}">
                                {{ \App\Helpers\Helper::cachedTrans('Home') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item">
                            <a href="{{ url('org-task-management/dashboard') }}">
                                {{ \App\Helpers\Helper::cachedTrans('Project Control Dashboard') }}
                            </a>
                        </li>
                        <li class="breadcrumb-item active">
                            {{ \App\Helpers\Helper::cachedTrans(isset($role) ? 'Update Role' : 'Add New Role') }}
                        </li>
                    </ul>

                    <div class="card custom-card">
                        <div class="card-header">
                            <h4 class="card-title">
                                <i class="far fa-user"></i>
                                {{ \App\Helpers\Helper::cachedTrans(isset($role) ? 'Update Role' : 'Add New Role') }}
                            </h4>
                        </div>

                        @include('employeer.layout.message')

                        <div class="card-body">
                            <div class="multisteps-form">
                                <div class="row">
                                    <div class="col-12 col-lg-12 m-auto">

                                        <form id="frm_project_create"
                                              method="POST"
                                              action="{{ isset($role) ? url('project-controll/rolles/'.$role->id) : url('project-controll/rolles') }}">

                                            @csrf

                                            @if(isset($role))
                                                @method('PUT')
                                            @endif

                                            <div class="clearfix"></div>

                                            <div class="lv-due" style="border:none;">
                                                <div class="row form-group lv-due-body">
                                                    <div class="col-md-6">
                                                        <label class="col-fprm-label">
                                                            {{ \App\Helpers\Helper::cachedTrans('Project Role') }}
                                                            <span>(*)</span>
                                                        </label>

                                                        <input type="text"
                                                               class="form-control @error('name') is-invalid @enderror"
                                                               name="name"
                                                               value="{{ old('name', isset($role) ? $role->name : '') }}"
                                                               placeholder="Enter Project Role">

                                                        @error('name')
                                                            <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>

                                                <br>

                                                <div class="row">
                                                    <div class="col-md-4 btn-up">
                                                        <button class="btn btn-primary"
                                                                type="submit"
                                                                id="btn_project_create">
                                                            {{ isset($role) ? \App\Helpers\Helper::cachedTrans('Update') : \App\Helpers\Helper::cachedTrans('Submit') }}
                                                        </button>

                                                        <a href="{{ url('project-controll/roles') }}" class="btn btn-secondary">
                                                            {{ \App\Helpers\Helper::cachedTrans('Cancel') }}
                                                        </a>
                                                    </div>

                                                    <div class="clearfix"></div>
                                                </div>

                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection