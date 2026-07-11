@extends('employeer.include.app')
@section('title')
    Add Client To Project Member
@endsection
@section('content')
<div class="main-panel">
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-md-12">
               <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                  <li class="breadcrumb-item"><a href="{{url('organization/settings-dashboard')}}">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
                  {{-- @if(isset($_GET['id']))
                  <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Edit Client To Project Member')}}</li>
                  @else --}}
                  <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Add Client To Project Member')}}</li>
                  {{-- @endif --}}
               </ul>
               <div class="card custom-card">
                  <div class="card-header">
                    <h4 class="card-title">
                        {{ \App\Helpers\Helper::cachedTrans('Add Client To Project Member') }}
                    </h4>
                     
                  </div>
                  @if(Session::has('message'))										
                  <div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
                  @endif
                  @if(Session::has('error'))										
                  <div class="alert alert-success" style="text-align:center;">{{ Session::get('error') }}</div>
                  @endif
                  <div class="card-body">
                     <div class="multisteps-form">
                        <!--form panels-->
                        <div class="row">
                           <div class="col-12 col-lg-12 m-auto">
                                <form action="{{ route('organization.guest.project.save') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $guest->id ?? '' }}">

                                    <div class="row form-group">
                                         <div class="col-md-6">
                                            <label class="col-form-label">
                                                {{ \App\Helpers\Helper::cachedTrans('All Project Name *') }}
                                            </label>

                                            <select name="project_id" class="select">
                                                <option value="">-- Select Project --</option>
                                                @foreach($projects as $project)
                                                    <option value="{{$project->id}}">{{$project->title}} - {{$project->description}}</option>
                                                @endforeach
                                            </select>

                                            @error('status')
                                                <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-6">
                                            <label class="col-form-label">{{ \App\Helpers\Helper::cachedTrans('Name *') }}</label>
                                            <input type="text" class="form-control" name="name" readonly
                                                value="{{ old('name', $guest->name ?? '') }}">
                                                
                                            @error('name')
                                                <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="col-form-label">{{ \App\Helpers\Helper::cachedTrans('Company Name *') }}</label>
                                            <input type="text" class="form-control" name="company_name" readonly
                                                value="{{ old('company_name', $guest->company_name ?? '') }}">
                                                
                                            @error('company_name')
                                                <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <div class="col-md-4">
                                            <label class="col-form-label">{{ \App\Helpers\Helper::cachedTrans('Designation') }}</label>
                                            <input type="text" class="form-control" name="designation" readonly
                                                value="{{ old('designation', $guest->designation ?? '') }}">
                                                
                                            @error('designation')
                                                <div style="color:red">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    </br>
                                    <button type="submit" class="btn btn-primary">
                                        Add Client as Project Member
                                    </button>
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