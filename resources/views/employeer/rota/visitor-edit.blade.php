@extends('employeer.include.app')
@section('title', \App\Helpers\Helper::cachedTrans('Edit Visitor'))
@section('content')
<div class="content container-fluid pb-0">
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Edit Visitor')}}</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
               <li class="breadcrumb-item"><a href="{{url('rota-org/visitor-dashboard')}}">{{\App\Helpers\Helper::cachedTrans('Dashboard')}} </a></li>
               <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Edit Visitor')}}</li>
            </ul>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-body">
               @include('employeer.layout.message')
               <form action="{{url('rota-org/visitor-edit')}}" method="post" enctype="multipart/form-data">
                  {{csrf_field()}}
                  <div class="row form-group">
                     <div class="col-md-4">
                        <div class=" form-group">
                           <input type="hidden" name="visitor_id" value="<?php print_r($visitor->id) ?>">		
                           <label for="inputFloatingLabel-grade" class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Name')}}</label>
                           <input type="text" class="form-control" name="name" value="<?php print_r($visitor->name) ?>">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="designation" class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Designation')}} </label>
                           <input type="text" class="form-control" name="desig" value="<?php print_r($visitor->desig) ?>">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="designation" class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Number')}} </label>
                           <input type="number"  name="phone_number" class="form-control" value="<?php print_r($visitor->phone_number) ?>">
                        </div>
                     </div>
                  </div>
                  <div class="row form-group">
                     <div class="col-md-4">
                        <div class=" form-group">	
                           <label for="inputFloatingLabel-shift-in-time" class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Email')}}</label>
                           <input id="inputFloatingLabel-shift-in-time" type="email" class="form-control input-border-bottom"  name="email" value="<?php print_r($visitor->email) ?>"  style="">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class=" form-group">	
                           <label for="inputFloatingLabel-shift-in-time" class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Address')}}</label>
                           <input id="inputFloatingLabel-shift-in-time" type="text" class="form-control input-border-bottom"   name="address" value="<?php print_r($visitor->address) ?>"  style="">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class=" form-group">	
                           <label for="inputFloatingLabel-shift-in-time" class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Description')}}</label>
                           <input id="inputFloatingLabel-shift-in-time" type="text" class="form-control input-border-bottom"  name="purpose" value="<?php print_r($visitor->purpose) ?>"  style="">
                        </div>
                     </div>
                  </div>
                  <div class="row form-group">
                     <div class="col-md-4">
                        <div class=" form-group">	
                           <label for="inputFloatingLabel-shift-in-time" class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Date')}}</label>
                           <input id="inputFloatingLabel-shift-in-time" type="date" class="form-control input-border-bottom"   name="date" value="<?php print_r($visitor->date) ?>"  style="">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class=" form-group">	
                           <label for="inputFloatingLabel-shift-in-time" class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Time')}}</label>
                           <input id="inputFloatingLabel-shift-in-time" type="time" class="form-control input-border-bottom"   name="time" value="<?php print_r($visitor->time) ?>"  style="">
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class=" form-group">	
                           <label for="inputFloatingLabel-shift-in-time" class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Refarence')}}</label>
                           <input id="inputFloatingLabel-shift-in-time" type="text" class="form-control input-border-bottom"  name="reff" value="<?php print_r($visitor->reff) ?>"  style="">
                        </div>
                     </div>
                  </div>
                  <br>
                  <div class="row form-group">
                     <div class="col-md-4">
                        <div class="sub-reset-btn">
                           <a href="#">	
                           <button class="btn btn-primary" type="submit">{{\App\Helpers\Helper::cachedTrans('Submit')}}</button></a>
                           <!-- <i class="fas fa-ban reset-ban-icon"></i> -->
                           {{-- <a href="#">	
                           <button class="btn btn-default" type="submit" style="background-color: #1572E8!important; color: #fff!important;">Reset</button></a> --}}
                        </div>
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
<script >
   function chngdepartment(empid){
        $.ajax({
            type:'GET',
            url:'{{url('pis/getEmployeedesigByshiftId')}}/'+empid,
            cache: false,
            success: function(response){
                document.getElementById("designation").innerHTML = response;
            }
        });
    }

    function employeeList(){
        var degId= $('#designation option:selected').text();
        console.log(degId);
        $.ajax({
            url:"{{url('rota/add-shift-management-desi')}}"+'/'+degId,
            type: "GET",
            success: function(response) {
                console.log(response);
            document.getElementById("empId").innerHTML = response;
            }
        });
    }
   
</script>
@endsection