@extends('employeer.include.app')
@section('title', 'Interview  Details')
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
            <h3 class="page-title">Interview  Details</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('recruitment/dashboard')}}">Recruitment Dashboard</a></li>
               <li class="breadcrumb-item active">Interview  Details</li>
            </ul>
         </div>
      </div>
   </div>
   <!-- /Page Header -->
   <div class="row">
        <div class="card">
            <div class="card-body">
                <div class="row form-group">
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
                        <h5>Apply Date:<span> <?php
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
                                <td width="300px">Current Salary:</td>
                                <td>@if($job->sal!='') {{ number_format($job->sal,2)}} @endif</td>
                            </tr>
                            
                            <tr>
                                <td width="300px">Expected Salary:</td>
                                <td>@if($job->sal!='') {{ number_format($job->exp_sal,2)}} @endif</td>
                            </tr>
                            <tr>
                                @if($job->recruited!='')
                                <td colspan="2" width="300px"><h5>Are  there suitable settled workers available to be recruited for this role ?:<span>{{ $job->recruited }} @if($job->recruited=='Yes')( {{ $job->other }} ) @endif</span></h5></td>
                                 @endif
                            </tr>
                           
                        </table>
                        </div>
                 
                    
                   
                    
                   
                    
                   
                
                
                 
                    <!--@if($job->apply!='')-->
                    <!--<div class="col-md-4">-->
                    <!--   <div class="app-form-text">-->
                    <!--      <h5>How the candidate applied ?:<span>{{ $job->apply }}</span></h5>-->
                    <!--   </div>-->
                    <!--</div>-->
                    <!--@endif-->
                  
                 </div>
            </div>    
        </div>
   </div>
   @include('employeer.layout.message')
   <div class="row">
      <div class="card">
         <div class="card-body">
            <form action="{{url('org-recruitment/edit-interview')}}" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               <input id="id" type="hidden"  name="id" class="form-control input-border-bottom" required="" value="<?php   echo $job->id;  ?>" >
               <input id="id" type="hidden"  name="job_id" class="form-control input-border-bottom" required="" value="<?php   echo $job->job_id;  ?>" >
               <!--------------------  -->
               <div class="row form-group" style="    padding: 15px 0;">
                  <div class="col-md-4">
                     <div class=" form-group current-stage">
                        <label class="col-form-label pb-0">Current Stage of Recruitment</label>
                        <select class="select" required="" name="status">
                           <option value=""><?php  if($job->status!=''){ echo $job->status;  } ?></option>
                           <option value="Online Screen Test"  <?php  if($job->status!=''){  if($job->status=='Online Screen Test'){ echo 'selected';} } ?> >Online Screen Test</option>
                           <option value="Written Test"  <?php  if($job->status!=''){  if($job->status=='Written Test'){ echo 'selected';} } ?> >Written Test</option>
                           <option value="Telephone Interview"  <?php  if($job->status!=''){  if($job->status=='Telephone Interview'){ echo 'selected';} } ?> >Telephone Interview</option>
                           <option value="Face to Face Interview"  <?php  if($job->status!=''){  if($job->status=='Face to Face Interview'){ echo 'selected';} } ?> >Face to Face Interview</option>
                           <option value="Job Offered" <?php  if($job->status!=''){  if($job->status=='Job Offered'){ echo 'selected';} } ?>>Job Offered</option>
                           <option value="Hired" <?php  if($job->status!=''){  if($job->status=='Hired'){ echo 'selected';} } ?>>Hired</option>
                           <option value="Rejected" <?php  if($job->status!=''){  if($job->status=='Rejected'){ echo 'selected';} } ?>>Rejected</option>
                        </select>
                     </div>
                  </div>
                  <div class="col-md-8" style="">
                     <div class="form-group">	
                        <label>Remarks</label>
                        <input type="text" class="form-control" placeholder="Remarks" value="<?php  if($job->remarks!='') {  if($job->status=='Online Screen Test'  || $job->status=='Written Test'  ||  $job->status=='Telephone Interview'  || $job->status=='Face to Face Interview'  || $job->status=='Job Offered'){  echo $job->remarks;} } ?>"  name="remarks">
                     </div>
                  </div>
                 
               </div>
               <div class="row form-group" style="padding:6px 0 15px 0;">
                  <?php  if(!empty($job->upload_sh)){ ?>
                  <button class="btn btn-default download" type="button" style="    margin: 11px 0 0;"><a href="{{asset('public/'.$job->upload_sh)}}" download>Download Interview Sheet</a></button>
                  <?php									 } ?>
                  
                   <div class="col-md-4">
                     <div class=" form-group">	
                        <label>Date</label>
                        <input type="date" class="form-control" required=""  value="<?php  if(!empty($job_details)){ if($job->status=='Online Screen Test'  || $job->status=='Written Test'  ||  $job->status=='Telephone Interview'  || $job->status=='Face to Face Interview'  || $job->status=='Job Offered'){  echo date('d/m/Y', strtotime($job_details->date));} } ?>"  name="date">
                     </div>
                  </div>
                  <div class="col-md-8">
                     <div class=" form-group">	
                        <label>Upload Interview Sheet</label>
                        <input type="file" class="form-control"     name="upload_sh">
                     </div>
                  </div>
                  
               </div>
               <div class="row form-group" style="margin-top:15px;background:none">
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
@endsection