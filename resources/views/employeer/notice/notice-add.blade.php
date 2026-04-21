@extends('employeer.include.app')
@section('title', \App\Helpers\Helper::cachedTrans('Add Notice'))
@section('content')
<div class="content container-fluid pb-0">
<div class="page-header">
    <div class="row">
        <div class="col-sm-12">
            <h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Add Notice')}}</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('organization.home')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{url('notification-dashboard')}}">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
                <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Notice')}} </li>
            </ul>
        </div>
    </div>
</div>
@include('employeer.layout.message')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <div class="card custom-card">
               <div class="card-header">
                  <h4 class="card-title"><i class="las la-bullhorn" style="color:rgb(253, 124, 3)"></i>  {{\App\Helpers\Helper::cachedTrans('Add New Notice')}}</h4>
               </div>
               <div class="card-body">
                  <div class="multisteps-form">
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                            <form action="{{ url('notice/add-notice') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="row form-group">

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Title')}}</label>
                                            <input type="text" class="form-control" name="title" value="{{ old('title') }}" required>
                                        </div>
                                    </div>
                                   
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Start Date')}}</label>
                                            <input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}" required>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('End Date')}}</label>
                                            <input type="date" name="end_date" class="form-control" value="{{ old('end_date') }}" required>
                                         </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group">
                                            <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Description')}}</label>
                                            <textarea name="description" class="form-control" required>{{ old('description') }}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Image')}}</label>
                                            <input type="file" class="form-control" name="image">
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="form-group">
                                            <label class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Notice Send To')}}</label>
                                            {{-- <input type="text" class="form-control" name="notice_for"> --}}
                                            <select name="notice_for" id="" class="select">
                                                <option value="all">All</option>
                                                @foreach($employees as $employee)
                                                <option value="{{$employee->emp_code}}">{{$employee->emp_fname}} {{$employee->emp_mname}} {{$employee->emp_lname}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>


                                </div>
                                <br>   
                                    <div class="row form-group">
                                        <div class="col-md-12">
                                            {{-- <input type="hidden" name="notice_for" value="employees">  --}}
                                            <input type="hidden" name="created_by_type" value="Organization"> 
                                            <button type="submit" class="btn btn-primary">{{\App\Helpers\Helper::cachedTrans('Create Notice')}}</button>
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
@endsection
