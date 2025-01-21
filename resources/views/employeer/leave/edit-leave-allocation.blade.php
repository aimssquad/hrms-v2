@extends('employeer.include.app')
@section('title', 'Edit Leave Allocation')
@section('content')
<div class="content container-fluid pb-0">
<div class="page-header">
   <div class="row">
      <div class="col-sm-12">
         <h3 class="page-title">Edit Leave Allocation</h3>
         <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{route('organization.home')}}">Dashboard</a></li>
            <li class="breadcrumb-item active">Edit Leave Allocation</li>
         </ul>
      </div>
   </div>
</div>
<div class="main-panel">
<div class="content">
   <div class="page-inner">
      <div class="row">
         <div class="col-md-12">
            <div class="card custom-card">
               <div class="card-header">
                  <h4 class="card-title"><i class="far fa-user"></i>Edit Leave Allocation</h4>
               </div>
               <div class="card-body">
                  <div class="multisteps-form">
                     <!--form panels-->
                     <div class="row">
                        <div class="col-12 col-lg-12 m-auto">
                           <form action="{{ url('attendance/save-edit-leave-allocation') }}" method="post" enctype="multipart/form-data">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <input type="hidden" name="id" value="<?php echo $leave_allocation->id;  ?>">
                              <input type="hidden" name="leave_type_id" value="<?php echo $leave_allocation->leave_type_id; ?>">
                              <input type="hidden" name="leave_rule_id" value="<?php echo $leave_allocation->leave_rule_id; ?>">
                              <div class="row form-group">
                                 <div class="col-md-4">
                                    <div class="form-group">		
                                       <label for="leave_type_name" class="col-form-label">Leave Type.</label>
                                       <input   type="text" class="form-control input-border-bottom" required="" id="leave_type_name" name="leave_type_name" value="<?php  if(!empty($leave_type->leave_type_name)){echo $leave_type->leave_type_name;} ?>" readonly>
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">	
                                       <label for="employee_code" class="col-form-label">Employee Code</label>
                                       <input   type="text" class="form-control input-border-bottom" required="" id="employee_code" name="employee_code" value="<?php  if(!empty($leave_allocation->employee_code)){echo $leave_allocation->employee_code;} ?>" readonly>
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">	
                                       <label for="max_no" class="col-form-label">Max No. Of Leave </label>
                                       <input   type="text" class="form-control input-border-bottom" required="" name="max_no" id="max_no" value="<?php  if(!empty($leave_allocation->max_no)){echo $leave_allocation->max_no;} ?>" readonly>
                                    </div>
                                 </div>
                              </div>
                              <div class="row form-group">
                                 <?php
                                    $leaveemdata = DB::table('employee_type')      
                                    ->where('id','=', $leave_allocation->employee_type)
                                    
                                    ->first(); 
                                     
                                     
                                     ?>
                                 <div class="col-md-4">
                                    <div class="form-group">	
                                       <label for="employee_type" class="col-form-label">Employee Type</label>
                                       <input   type="text" class="form-control input-border-bottom" required="" name="employee_type" id="employee_type" value="<?php  if(!empty($leave_allocation->employee_type)){echo $leave_allocation->employee_type;} ?>" readonly>
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">	
                                       <label for="leave_in_hand" class="col-form-label">Leave in Hand. </label>
                                       <input   type="text" class="form-control input-border-bottom" required="" name="leave_in_hand" id="leave_in_hand" value="<?php  if(!empty($leave_allocation->leave_in_hand)){echo $leave_allocation->leave_in_hand;} ?>" >
                                    </div>
                                 </div>
                                 <div class="col-md-4">
                                    <div class="form-group">	
                                       <label for="month_yr" class="col-form-label">Effective Year</label>
                                       <input   type="text" class="form-control input-border-bottom" required="" name="month_yr" id="month_yr" value="<?php  echo $leave_allocation->month_yr; ?>" readonly>
                                    </div>
                                 </div>
                              </div>
                              <br>
                              <div class="row form-group">
                                 <div class="col-md-12"><button class="btn btn-primary">Submit</button></div>
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
@section('script')

@endsection