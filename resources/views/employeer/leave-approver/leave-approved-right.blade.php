@extends('employeer.include.app')
@section('title', 'Leave Application list')
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
@endphp
@section('content')
@php
function my_simple_crypt( $string, $action = 'encrypt' ) {
// you may change these values to your own
$secret_key = 'bopt_saltlake_kolkata_secret_key';
$secret_iv = 'bopt_saltlake_kolkata_secret_iv';
$output = false;
$encrypt_method = "AES-256-CBC";
$key = hash( 'sha256', $secret_key );
$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
if( $action == 'encrypt' ) {
$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
}
else if( $action == 'decrypt' ){
$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
}
return $output;
}
@endphp
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Leave Application list</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('leaveapprover/leave-dashboard')}}">Leave Authosizer Dashboard</a></li>
               <li class="breadcrumb-item active">Leave Application list</li>
            </ul>
         </div>
      </div>
   </div>
   @include('employeer.layout.message')
   <!-- /Page Header -->
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-header">
               <h4 class="card-title">Leave Approval Details</h4>
            </div>
            <?php
               $reg = Session::get('emid');
               //  $Roledata = DB::table('registration')      
                       
               //               ->where('email','=',$pemail) 
               //               ->first();
               $job_details=DB::table('employee')->where('emp_code', '=', $LeaveApply[0]->employee_id )->where('emid', '=', $reg )->orderBy('id', 'DESC')->first();
               
               ?>
            <div class="card-body">
               <form action="{{url('leave-approver/leave-approved-right')}}" method="post" enctype="multipart/form-data" >
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <input type="hidden" name="apply_id" value="{{ $LeaveApply[0]->id }}">
                  <input type="hidden" name="employee_id" value="{{ $LeaveApply[0]->employee_id }}">
                  <input type="hidden" name="no_of_leave" value="{{ $LeaveApply[0]->no_of_leave }}">
                  <input type="hidden" name="leave_type" value="{{ $LeaveApply[0]->leave_type}}">
                  <input type="hidden" name="month_yr" value="{{ date("Y", strtotime($LeaveApply[0]->from_date))}}">
                  <div class="row form-group">
                     <div class="col-md-4">
                        <div class="app-form-text">
                           <h5>Employment Type:<span>{{$job_details->emp_status}}</span></h5>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="app-form-text">
                           <h5>Employee Code:<span>{{ $LeaveApply[0]->employee_id }}</span></h5>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="app-form-text">
                           <h5>Employee Name:<span>{{$job_details->emp_fname}} {{$job_details->emp_mname}} {{$job_details->emp_lname}}</span></h5>
                        </div>
                     </div>
                  </div>
                  <input type="hidden" id="current_status" value="{{ $LeaveApply[0]->status }}">
                  <!-- 2nd Row -->
                  <div class="row form-group">
                     <div class="col-md-4">
                        <div class="app-form-text">
                           <h5>Leave Type:<span>{{ $LeaveApply[0]->leave_type_name }}</span></h5>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="app-form-text">
                           <h5>Leave Status:<span>{{ $LeaveApply[0]->status }}</span></h5>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="app-form-text">
                           <h5>No. Of Leave:<span>{{ $LeaveApply[0]->no_of_leave }}</span></h5>
                        </div>
                     </div>
                  </div>
                  <!-- 3rd row -->
                  <div class="row form-group">
                     <div class="col-md-4">
                        <div class="app-form-text">
                           <h5>From Date:<span>{{ $leaveapplyfromDate = date("d/m/Y", strtotime($LeaveApply[0]->from_date)) }}</span></h5>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="app-form-text">
                           <h5>To Date:<span>{{ $leaveapplytoDate = date("d/m/Y", strtotime($LeaveApply[0]->to_date)) }}</span></h5>
                        </div>
                     </div>
                  </div>
                  <!-- Table -->
                  <div class="row form-group">
                     <div class="col-md-12">
                        <div class="table-heading">
                           <h2>List of Last Three Approved Leave</h2>
                        </div>
                        <table id="" class="display table table-striped table-hover" >
                           <thead>
                              <tr class="table-th-bg">
                                 <th>SL No.</th>
                                 <th>From Date</th>
                                 <th>To Date</th>
                                 <th>Date Of Application</th>
                                 <th>No.of Leave</th>
                                 <th>Approved Date</th>
                              </tr>
                           </thead>
                           <tbody>
                              <?php 
                                 if(count($Prev_leave)!=0){
                                     ?>
                              @foreach($Prev_leave as $lvapply)
                              <tr class="table-tr">
                                 <td class="serial" style="text-align:center;">{{$loop->iteration}}</td>
                                 <td style="text-align:center;"><span class="product">{{\Carbon\Carbon::parse($lvapply->from_date)->format('d/m/Y')}}</span></td>
                                 <td style="text-align:center;"><span class="product">{{\Carbon\Carbon::parse($lvapply->to_date)->format('d/m/Y')}}</span></td>
                                 <td style="text-align:center;"><span class="date">{{\Carbon\Carbon::parse($lvapply->date_of_apply)->format('d/m/Y')}}</span></td>
                                 <td style="text-align:center;"><span class="date">{{ $lvapply->no_of_leave }}</span></td>
                                 <td style="text-align:center;"><span class="name">{{\Carbon\Carbon::parse($lvapply->updated_at)->format('d/m/Y')}}</span></td>
                              </tr>
                              @endforeach
                              <?php
                                 }
                                 else{ ?>
                              <tr class="table-tr">
                                 <td class="serial" style="text-align:center;"></td>
                                 <td style="text-align:center;"></td>
                                 <td style="text-align:center;"></td>
                                 <td style="text-align:center;">No Data Found.</td>
                                 <td style="text-align:center;"></td>
                                 <td style="text-align:center;"></td>
                              </tr>
                              <?php }
                                 ?>
                           </tbody>
                        </table>
                     </div>
                  </div>
                  <!-- Leave request Status -->
                  <div class="row form-group">
                     <div class="col-md-4 ">
                        <div class=" form-group form-floating-label">
                           <label for="leave_status" style="font-size: 14px!important;" class="col-form-label">Leave Request Status</label>
                           <select id="leave_status" type="text" class="form-control input-border-bottom"  name="leave_check" id="leave_status" onchange="remarkStatus();" required  style="margin-top: 10px;">
                              <option value="">Select</option>
                              <option  value="NOT APPROVED" <?php  if($LeaveApply[0]->status!=''){  if($LeaveApply[0]->status=='NOT APPROVED'){ echo 'selected';} } ?> >Not Approved</option>
                              <option value="APPROVED" <?php  if($LeaveApply[0]->status!=''){  if($LeaveApply[0]->status=='APPROVED'){ echo 'selected';} } ?> >Approved</option>
                              <option  value="REJECTED" <?php  if($LeaveApply[0]->status!=''){  if($LeaveApply[0]->status=='REJECTED'){ echo 'selected';} } ?> >Rejected</option>
                              <option  value="CANCEL" <?php  if($LeaveApply[0]->status!=''){  if($LeaveApply[0]->status=='CANCEL'){ echo 'selected';} } ?> >Cancel</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class=" form-group form-floating-label">	
                           <label for="status_remarks"  style="font-size: 14px!important;" class="col-form-label">Remarks</label>	
                           <input id="status_remarks" type="text"  name="status_remarks"   value="<?php  if(!empty($LeaveApply[0]->status_remarks)){ echo $LeaveApply[0]->status_remarks;} ?>" class="form-control input-border-bottom"  >
                        </div>
                     </div>
                     <div class="col-md-4">
                        <a class="apply" href="#">	
                        {{-- <button class="btn btn-primary apply" type="submit">Apply</button> --}}
                     </div>
                  </div>
                  <br>
                  <button class="btn btn-primary apply" type="submit">Apply</button>
            </div>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- /Page Content -->
@endsection
@section('script')
<script>
   function confirmDelete(url) {
       if (confirm("Are you sure you want to delete this holiday type?")) {
           window.location.href = url;
       }
   }
   
</script>
@endsection