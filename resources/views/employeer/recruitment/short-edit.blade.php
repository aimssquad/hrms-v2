@extends('employeer.include.app')
@section('title', 'Short Listing')
@section('content')

<style>
    .col-form-label {
    font-size: 15px;
}
.table-borderless td{
    border:0px;
    padding:5px 10px;
}
</style>
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Short Listing</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('recruitment/dashboard')}}">Recruitment Dashboard</a></li>
               <li class="breadcrumb-item active">Short Listing</li>
            </ul>
         </div>
      </div>
   </div>
   <!-- /Page Header -->
   @include('employeer.layout.message')
   <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="row">
                   <div class="col-sm-6">
                       <h3 class="p-2">Job Details</h3>
                        <table class="table table-borderless">
                        <tr>
                            <td width="100px">Job Title:</td>
                            <td>{{$job->job_title}}</td>
                        </tr>
                        <tr>
                            <td>Skill level:</td>
                            <td>{{$job->skill_level}}</td>
                        </tr>
                        <tr>
                            <td>Skill Set:</td>
                            <td>{{$job->skill}}</td>
                        </tr>
                        
                          @if($job->apply!='')
                          <tr>
                            <td>How the candidate applied ?</td>
                            <td>{{ $job->apply }}</td>
                        </tr>
                    @endif
</table>


                   </div>
                   
                  
                   <div class="col-sm-6 text-end">
                        <h5>Apply Date:<span class="ms-3 d-inline-block"> <?php
                             echo date('d/m/Y',strtotime($job->date));
                             if($job->date>='2021-02-22'){
                             echo ' '.date('h:i A ',strtotime($job->date));
                             }
                             ?></span></h5>
                   </div>
                   
                    <div class="col-sm-12">
                       <h3 class="p-2">Candidate Details</h3>
                       <table class="table table-bordered">
                            <tr>
                                <td width="300px">Candidate Name:</td>
                                <td>{{$job->name}}</td>
                            </tr>
                            
                            <tr>
                                 @if($job->dob!='')
                                <td width="300px">Date Of Birth:</td>
                                <td>{{ date('d/m/Y',strtotime($job->dob))}}</td>
                                 @endif
                            </tr>
                            
                             <tr>
                                <td width="300px">Gender:</td>
                                <td>{{$job->gender}}</td>
                            </tr>
                            <tr>
                                <td width="300px">Contact Number:</td>
                                <td>+{{$job->phone}}</td>
                            </tr>
                            <tr>
                                <td width="300px">Email:</td>
                                <td>{{$job->email}}</td>
                            </tr>
                            
                             <tr>
                                <td width="300px">Education Qualification:</td>
                                <td>{{$job->edu}}</td>
                            </tr>
                            
                             <tr>
                                <td width="300px">Current Location / Address:</td>
                                <td>{{$job->location}} @if(!empty($job->zip)) ,{{$job->zip}} @endif</td>
                            </tr>
                           
                        </table>
                        
                         <h3 class="p-2">Organization Details</h3>
                         <table class="table table-bordered">
                            <tr>
                                <td width="300px">Current Organization:</td>
                                <td>{{$job->cur_or}}</td>
                            </tr>
                            
                            <tr>
                                <td width="300px">Current Job Title:</td>
                                <td>{{$job->cur_deg}}</td>
                            </tr>
                            
                              <tr>
                                <td width="300px">Total Year of Experience:</td>
                                <td>{{$job->exp}} Years {{$job->exp_month}} Months</td>
                            </tr>
                            
                            <tr>
                                <td width="300px">Expected Salary:</td>
                                <td>@if($job->exp_sal!='') {{ number_format($job->exp_sal,2)}} @endif</td>
                            </tr>
                            
                           
                        </table>
                   </div>
                </div>
                
            </div>
        </div>
   </div> 
   <div class="row">
      <div class="card">
         <div class="card-body">
            <form action="{{url('org-recruitment/edit-short-listing')}}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               <input id="id" type="hidden"  name="id" class="form-control input-border-bottom" required="" value="<?php   echo $job->id;  ?>" >
               <input id="id" type="hidden"  name="job_id" class="form-control input-border-bottom" required="" value="<?php   echo $job->job_id;  ?>" >
               <!--------------------  -->
               <div class="row form-group" style="padding: 3px 0 15px;">
                  <div class="col-md-6">
                     <div class=" form-group current-stage">
                        <label  class="col-form-label">Are  there suitable settled workers available to be recruited for this role ?</label>
                        <select class="select" required="" name="recruited"  style="margin-top: 10px;"  onchange="trade_epmloyee(this.value);">
                           <option value=""   >Select</option>
                           <option value="Yes"  <?php  if($job->recruited!=''){  if($job->recruited=='Yes'){ echo 'selected';} } ?> >Yes</option>
                           <option value="No" <?php  if($job->recruited!=''){  if($job->recruited=='No'){ echo 'selected';} } ?>>No</option>
                        </select>
                     </div>
                  </div>
                  
                  <div class="col-md-6 " id="criman_new" <?php  if($job->recruited=='Yes'){  ?> style="display:block;" <?php }else{ ?> style="display:none;" <?php }  ?>>
                     <div class="form-group">
                        <label for="other" class="col-form-label">Give Details </label>
                        <input id="other" type="text" class="form-control input-border-bottom" name="other"  value=" @if($job->other){{  $job->other }}@endif ">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class=" form-group current-stage">
                        <label class="col-form-label">Current Stage of Recruitment</label>
                        <select class="select" required="" name="status"  style="margin-top: 10px;">
                           <option value=""><?php  if($job->status!=''){ echo $job->status;  } ?></option>
                           <option value="Interview"  <?php  if($job->status!=''){  if($job->status=='Interview'){ echo 'selected';} } ?> >Interview</option>
                           <option value="Hold" <?php  if($job->status!=''){  if($job->status=='Hold'){ echo 'selected';} } ?>>Hold</option>
                        </select>
                        <!--<label for="inputFloatingLabel-recruitment" class="placeholder">Current Stage of Recruitment</label>-->
                     </div>
                  </div>
                  <div class="col-md-12" style="    padding-top: 25px;">
                     <div class=" form-group">
                         <label  class="col-form-label">Remarks</label>
                        <input type="text" placeholder="Remarks" style="margin-top:9px" class="form-control" value="<?php  if($job->remarks!='') {  if($job->status=='Hold' || $job->status=='Interview'){  echo $job->remarks;} } ?>" name="remarks">
                     </div>
                  </div>
               </div>
               <div class="row form-group">
                  <div class="col-md-4">
                     <div class="form-group" style="margin: 7px 0 15px;">
                        <label class="col-form-label">Date </label>	
                        <input type="date" class="form-control" required=""  value="<?php  if(!empty($job_details)){ if($job->status=='Hold' || $job->status=='Interview'){  echo $job_details->date;} } ?>"  name="date">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group" style="margin: 7px 0 15px;">
                        <label class="col-form-label">From Time </label>	
                        <input type="time" class="form-control" required=""  value="<?php  if(!empty($job_details)){ if($job->status=='Hold' || $job->status=='Interview'){  echo $job_details->from_time;} } ?>"  name="from_time">
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="form-group" style="margin: 7px 0 15px;">
                        <label class="col-form-label">To Time </label>	
                        <input type="time" class="form-control" required=""  value="<?php  if(!empty($job_details)){ if($job->status=='Hold' || $job->status=='Interview'){  echo $job_details->to_time;} } ?>"  name="to_time">
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class=" form-group" style="margin: 7px 0 15px;">
                         <label  class="col-form-label">Interview Place</label>
                        <input type="text" placeholder="Interview Place" style="margin-top:9px" class="form-control" value="<?php  if($job->place!='') {  if($job->status=='Hold' || $job->status=='Interview'){  echo $job->place;} } ?>"  name="place">
                     </div>
                  </div>
                  <div class="col-md-6" >
                     <div class=" form-group" style="margin: 7px 0 15px;">
                         <label  class="col-form-label">Interview Panel</label>
                        <input type="text" placeholder="Interview Panel " style="margin-top:9px" class="form-control" value="<?php  if($job->panel!='') {  if($job->status=='Hold' || $job->status=='Interview'){  echo $job->panel;} } ?>"  name="panel">
                     </div>
                  </div>
               </div>
               <div class="row form-group" style="margin-top:15px;background:none;">
                  <div class="col-md-12 text-center">
                     <button class="btn btn-primary sub" type="submit">Submit</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
<!-- /Page Content -->
@endsection
@section('script')
<script >
   $(document).ready(function() {
       $('#basic-datatables').DataTable({
       });
   
       $('#multi-filter-select').DataTable( {
           "pageLength": 5,
           initComplete: function () {
               this.api().columns().every( function () {
                   var column = this;
                   var select = $('<select class="form-control"><option value=""></option></select>')
                   .appendTo( $(column.footer()).empty() )
                   .on( 'change', function () {
                       var val = $.fn.dataTable.util.escapeRegex(
                           $(this).val()
                           );
   
                       column
                       .search( val ? '^'+val+'$' : '', true, false )
                       .draw();
                   } );
   
                   column.data().unique().sort().each( function ( d, j ) {
                       select.append( '<option value="'+d+'">'+d+'</option>' )
                   } );
               } );
           }
       });
   
       // Add Row
       $('#add-row').DataTable({
           "pageLength": 5,
       });
   
       var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';
   
       $('#addRowButton').click(function() {
           $('#add-row').dataTable().fnAddData([
               $("#addName").val(),
               $("#addPosition").val(),
               $("#addOffice").val(),
               action
               ]);
           $('#addRowModal').modal('hide');
   
       });
   });
   function trade_epmloyee(val) {
       if(val=='Yes'){
       document.getElementById("criman_new").style.display = "block";	
           $("#other").prop('required',true);
           
       }else{
           document.getElementById("criman_new").style.display = "none";	
               $("#other").prop('required',false);
       }
   
   }
</script>
@endsection