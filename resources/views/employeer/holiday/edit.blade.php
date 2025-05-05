@extends('employeer.include.app')
@section('title', 'Add Holiday Type')
@section('content')
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('orgaization/holiday-dashboard')}}">Holiday Dashboard</a></li>
               <li class="breadcrumb-item active">Add Holiday Type</li>
            </ul>
            <div class="card custom-card">
               <div class="card-header">
                  <h4 class="card-title"><i class="far fa-user"></i>  Add Holiday Type</h4>
               </div>
               <div class="card-body">
                  <div class="multisteps-form">
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                           <form action="{{ route('holiday.types.update', $holidayType->id) }}" method="post" enctype="multipart/form-data" class="form-horizontal">
                              {{csrf_field()}}
                              @method('PUT')
                              <div class="row">
                                 <div class="col-md-5">
                                    <div class="form-group">
                                       <label for="inputFloatingLabel" class="col-form-label">Holiday Type Name</label>
                                       <input id="inputFloatingLabel" type="text" class="form-control input-border-bottom" required="" name="holiday_type_name" value="<?php if(isset($holidayType->id)){  echo $holidayType->holiday_type_name;  }?>{{ old('name') }}"> 
                                       @if ($errors->has('holiday_type_name'))
                                       <div class="error" style="color:red;">{{ $errors->first('holiday_type_name') }}</div>
                                       @endif
                                    </div>
                                 </div>
                                 <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="inputFloatingLabel" class="col-form-label">Status</label>
                                        <select name="status" id="" class="select">
                                            <option value="">Select</option>
                                            <option value="1"{{ $holidayType->status == 1 ? 'selected' : '' }}>Active</option>
                                            <option value="0"{{ $holidayType->status == 0 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                    </div>
                                 </div>
                              </div>
                              <div class="row form-group">
                                 <div class="col-md-12"><button type="submit" class="btn btn-primary" style="margin-top:10px;">Update</button></div>
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
@endsection