@extends('employeer.include.app')
@section('title', 'Sponsor Compaliance')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row">
         <div class="col-sm-12">
            <h3 class="page-title">Welcome!</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item active">
                  {{ucwords($Roledata->com_name)}}
               </li>
            </ul>
         </div>
      </div>
   </div>
   <!-- /Page Header -->
   <br>
   <?php
      $usetype = Session::get('user_type'); 
      if( $usetype=='employee'){
      $usemail = Session::get('user_email'); 
      $users_id = Session::get('users_id'); 
      $dtaem=DB::table('users')      
               
                ->where('id','=',$users_id) 
                ->first();
      $Roles_auth = DB::table('role_authorization')      
                ->where('emid','=',$dtaem->emid) 
                ->where('member_id','=',$dtaem->email) 
                ->get()->toArray();
      $arrrole=array();
      foreach($Roles_auth as $valrol){
      $arrrole[]=$valrol->menu;
      }	
      
      }
      
      
      ?>
   <div class="dash-inr">
      <div class="container">
         <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="card" style="background:#f5a45d;">
                  <div class="card-header text-fixed-white">
                     <i class="fa fa-building"></i>
                     <h4 style="font-size:14px;" class="text-fixed-white">Organisation Profile</h4>
                  </div>
                  <div class="card-body">
                     <div class="d-flex align-items-center w-100">
                        <div class="text-fixed-white">
                           <div class="fs-15 fw-semibold">
                              @if($Roledata->updated_at!='' )
                              <h5 style="font-size:14px"class="text-fixed-white">Complete</h5>
                              @else
                              <h5 style="font-size:14px;"class="text-fixed-white">Incomplete</h5>
                              @endif
                           </div>
                        </div>
                        <div class="ms-auto">
                           <a href="{{url('org-company-profile/edit-company')}}?c_id={{base64_encode($Roledata->id)}}" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="card" style="background:#FF902F;">
                  <div class="card-header text-fixed-white">
                     <i class="fa fa-sitemap"></i>
                     <h4 style="font-size:14px;" class="text-fixed-white">All Employee List</h4>
                  </div>
                  <div class="card-body">
                     <div class="d-flex align-items-center w-100">
                        <div class="">
                           <div class="fs-15 fw-semibold">
                              <h5 >{{ count($employee_active)}}</h5>
                           </div>
                        </div>
                        <div class="ms-auto">
                           <?php 
                              if( $usetype=='employee'){
                                 if(in_array('1', $arrrole)){
                              ?>
                           <a href="{{url('org-dashboard-employees')}}" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php }else{ ?> <a href="#" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php }
                              }else{ ?> <a href="{{url('org-dashboard-employees')}}" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php	} ?>	
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="card" style="background: linear-gradient(135deg, #fc0202, #00ff40);">
                  <div class="card-header text-fixed-white">
                     <i class="fa fa-blind"></i>
                     <h4 style="font-size:14px;" class="text-fixed-white">Migrant Employee List</h4>
                  </div>
                  <div class="card-body">
                     <div class="d-flex align-items-center w-100">
                        <div class="">
                           <div class="fs-15 fw-semibold">
                              <h5>{{ count($employee_migarnt)}}</h5>
                           </div>
                        </div>
                        <div class="ms-auto">
                           <?php 
                              if( $usetype=='employee'){
                              if(in_array('1', $arrrole))
                              {
                              
                              ?>
                           <a href="{{url('org-dashboard-migrant-employees')}}"  class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php
                              }else{
                                  ?>  <a href="#" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php
                              }
                                                                  }else{
                                                                  ?> <a href="{{url('org-dashboard-migrant-employees')}}" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php	
                              }     
                              ?>					
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="card" style="background: #FF902F;">
                  <div class="card-header text-fixed-white">
                     <i class="fa fa-user-secret"></i>
                     <h4 style="font-size:14px;" class="text-fixed-white">Right to Work checks</h4>
                  </div>
                  <div class="card-body">
                     <div class="d-flex align-items-center w-100">
                        <div class="">
                        </div>
                        <div class="ms-auto">
                           <a href="{{url('org-dashboard-right-works')}}" class="text-fixed-white">	<i class="fa fa-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="card" style="background: #FF902F;">
                  <div class="card-header text-fixed-white">
                     <i class="fa fa-building"></i>
                     <h4 style="font-size:14px;" class="text-fixed-white">Recruitment Process </h4>
                  </div>
                  <div class="card-body">
                     <div class="d-flex align-items-center w-100">
                        <div class="">
                        </div>
                        <div class="ms-auto">
                           <?php 
                              if( $usetype=='employee'){
                              if(in_array('2', $arrrole))
                              {
                              
                              ?>
                           <a href="{{url('recruitment/dashboard')}}" target="_blank" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php
                              }else{
                              	?>  <a href="#" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php
                              }
                              									}else{
                              									?> <a href="{{url('recruitment/dashboard')}}" target="_blank" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php	
                              }
                              
                              ?>	
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="card" style="background: #FF902F;">
                  <div class="card-header text-fixed-white">
                     <i class="fa fa-building"></i>
                     <h4 style="font-size:14px;" class="text-fixed-white">Leave Management</h4>
                  </div>
                  <div class="card-body">
                     <div class="d-flex align-items-center w-100">
                        <div class="">
                        </div>
                        <div class="ms-auto">
                           <?php 
                              if( $usetype=='employee'){
                              if(in_array('3', $arrrole))
                              {
                              
                              ?>
                           <a href="{{url('leavedashboard')}}" target="_blank" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php
                              }else{
                                  ?>  <a href="#" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php
                              }
                                                                  }else{
                                                                  ?> <a href="{{url('leave/dashboard')}}" target="_blank" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php	
                              }
                              
                              ?>	
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="card" style="background: #FF902F;">
                  <div class="card-header text-fixed-white">
                     <i class="fa fa-building"></i>
                     <h4 style="font-size:14px;" class="text-fixed-white">Payroll</h4>
                  </div>
                  <div class="card-body">
                     <div class="d-flex align-items-center w-100">
                        <div class="">
                        </div>
                        <div class="ms-auto">
                           <a href="#" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="card" style="background:#FF902F;">
                  <div class="card-header text-fixed-white">
                     <i class="fa fa-building"></i>
                     <h4 style="font-size:14px;" class="text-fixed-white">Key Contact</h4>
                  </div>
                  <div class="card-body">
                     <div class="d-flex align-items-center w-100">
                        <div class="">
                        </div>
                        <div class="ms-auto">
                           <a href="{{url('org-dashboard/key-contact')}}" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="card" style="background: #FF902F;">
                  <div class="card-header text-fixed-white">
                     <i class="fa fa-building"></i>
                     <h4 style="font-size:14px;" class="text-fixed-white">Sponsor Management Dossier</h4>
                  </div>
                  <div class="card-body">
                     <div class="d-flex align-items-center w-100">
                        <div class="">
                        </div>
                        <div class="ms-auto">
                           <a href="{{url('org-dashboard/sponsor-management-dossier')}}" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
                <div class="card" style="background: #FF902F;">
                  <div class="card-header text-fixed-white">
                     <i class="fa fa-building"></i>
                     <h4 style="font-size:14px;" class="text-fixed-white">Monitoring & Reporting</h4>
                  </div>
                  <div class="card-body">
                     <div class="d-flex align-items-center w-100">
                        <div class="">
                        </div>
                        <div class="ms-auto">
                           <?php 
                              if( $usetype=='employee'){
                              if(in_array('1', $arrrole))
                              {
                              
                              ?>
                           <a href="{{url('org-dashboard-migrant-employees')}}" >
                           <?php
                              }else{
                                  ?>  <a href="#" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php
                              }
                                                                  }else{
                                                                  ?> <a href="{{url('org-dashboard-migrant-employees')}}" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php	
                              }
                              
                              ?>	
                        </div>
                     </div>
                  </div>
                </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="card" style="background: #FF902F;">
                  <div class="card-header text-fixed-white">
                     <i class="fa fa-building"></i>
                     <h4 style="font-size:14px;" class="text-fixed-white">Message Centre</h4>
                  </div>
                  <div class="card-body">
                     <div class="d-flex align-items-center w-100">
                        <div class="">
                        </div>
                        <div class="ms-auto">
                           <a href="{{url('org-dashboard/message-center')}}" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="card" style="background: #FF902F;">
                  <div class="card-header text-fixed-white">
                     <i class="fa fa-building"></i>
                     <h4 style="font-size:14px;" class="text-fixed-white">Staff Report</h4>
                  </div>
                  <div class="card-body">
                     <div class="d-flex align-items-center w-100">
                        <div class="">
                        </div>
                        <div class="ms-auto">
                           <form  method="post" action="{{ url('org-document/staff-report-excel') }}" enctype="multipart/form-data" >
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <button class="text-fixed-white" style="background: none !important; border:0px;" type="submit"><i class="fa fa-arrow-right"></i></button>	
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="card" style="background: #FF902F;">
                  <div class="card-header text-fixed-white">
                     <i class="fa fa-building"></i>
                     <h4 style="font-size:14px;" class="text-fixed-white">Absent Report</h4>
                  </div>
                  <div class="card-body">
                     <div class="d-flex align-items-center w-100">
                        <div class="">
                        </div>
                        <div class="ms-auto">
                           <?php 
                              if( $usetype=='employee'){
                              if(in_array('54', $arrrole))
                              {
                              
                              ?>
                           <a href="{{url('org-dashboard/absent-report')}}" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php
                              }else{
                                  ?>  <a href="#" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php
                              }
                                                                  }else{
                                                                  ?> <a href="{{url('org-dashboard/absent-report')}}" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php	
                              } 
                              ?>					
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="card" style="background: #FF902F;">
                  <div class="card-header text-fixed-white">
                     <i class="fa fa-building"></i>
                     <h4 style="font-size:14px;" class="text-fixed-white">Change Of Circumstances</h4>
                  </div>
                  <div class="card-body">
                     <div class="d-flex align-items-center w-100">
                        <div class="">
                        </div>
                        <div class="ms-auto">
                           <?php 
                              if( $usetype=='employee'){
                              if(in_array('76', $arrrole))
                              {
                              
                              ?>
                           <a href="{{url('org-dashboard/change-of-circumstances')}}" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php
                              }else{
                                  ?>  <a href="#"class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php
                              }
                                                                  }else{
                                                                  ?> <a href="{{url('org-dashboard/change-of-circumstances')}}" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php	
                              }     
                              ?>								
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="card" style="background: #FF902F;">
                  <div class="card-header text-fixed-white">
                     <i class="fa fa-building"></i>
                     <h4 style="font-size:14px;" class="text-fixed-white">Contract Agreement</h4>
                  </div>
                  <div class="card-body">
                     <div class="d-flex align-items-center w-100">
                        <div class="">
                        </div>
                        <div class="ms-auto">
                           <?php 
                              if( $usetype=='employee'){
                              if(in_array('78', $arrrole))
                              {
                              
                              ?>
                           <a href="{{url('org-dashboard/contract-agreement')}}" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php
                              }else{
                                  ?>  <a href="#" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php
                              }
                                                                  }else{
                                                                  ?> <a href="{{url('org-dashboard/contract-agreement')}}" class="text-fixed-white"><i class="fa fa-arrow-right"></i></a>
                           <?php	
                              }
                              
                              ?>									
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-12 col-md-12">
               <!--<div class="visa-head">-->
               <!--   <h3 style="color:#FF902F;">Visa Notification</h3>-->
               <!--</div>-->
             @include('employeer.layout.message')
               <div class="card" style="margin-bottom:30px;">
                  <div class="card-body">
                     <div class="card-header">
                        <h3 style="color:#FF902F;">E-VISA / VISA  NOTIFICATION</h3>
                     </div>
                     <div class="table-responsive">
                        <table id="basic-datatables" class="table table-striped custom-table" >
                           <thead>
                              <tr>
                                 <th>Employee Code</th>
                                 <th>Employee Name</th>
                                 <th>Address</th>
                                 <th>Passport No.</th>
                                 <th>BRP No.</th>
                                 <th>Visa Issue Date</th>
                                 <th>Visa Expiry Date</th>
                                 <th>Visa Reminder - 90 days </th>
                                 <th>View </th>
                                 <th>Send </th>
                                 <th>Visa Reminder - 60 days </th>
                                 <th>View </th>
                                 <th>Send </th>
                                 <th>Visa Reminder - 30 days </th>
                                 <th>View</th>
                                 <th>Send </th>
                                 <th>Email Send</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($employee_migarnt as $employee)
                              @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='')
                              <tr>
                                 <td>{{ $employee->emp_code}}</td>
                                 <td>{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }}</td>
                                 <td>{{ $employee->emp_pr_street_no}} @if( $employee->emp_per_village) ,{{ $employee->emp_per_village}} @endif @if( $employee->emp_pr_state) ,{{ $employee->emp_pr_state}} @endif @if( $employee->emp_pr_city) ,{{ $employee->emp_pr_city}} @endif
                                    @if( $employee->emp_pr_pincode) ,{{ $employee->emp_pr_pincode}} @endif  @if( $employee->emp_pr_country) ,{{ $employee->emp_pr_country}} @endif
                                 </td>
                                 <td>{{ $employee->pass_doc_no }}</td>
                                 <td>{{ $employee->visa_doc_no }}</td>
                                 <td>    @if( $employee->visa_issue_date!='1970-01-01') @if( $employee->visa_issue_date!='') {{ date('d/m/Y',strtotime($employee->visa_issue_date)) }} @endif  @endif</td>
                                 <td>    @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='') {{ date('d/m/Y',strtotime($employee->visa_exp_date)) }} @endif  @endif</td>
                                 <td  style="color:red;">    @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='') {{   date('d/m/Y',strtotime($employee->visa_exp_date.'  - 90  days'))}} 
                                    &nbsp &nbsp  
                                 <td><a href="{{url('dashboard/migrant-dash-firstletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a></td>
                                 &nbsp
                                 <td><a href="{{url('dashboard/migrant-firstletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a>
                                    @endif  @endif
                                 </td>
                                 <td  style="color:red;">    @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='') {{   date('d/m/Y',strtotime($employee->visa_exp_date.'  - 60  days'))}}  
                                    &nbsp &nbsp 
                                 <td> <a href="{{url('dashboard/migrant-dash-secondletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a> </td>
                                 &nbsp
                                 <td><a href="{{url('dashboard/migrant-secondletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a> @endif  @endif</td>
                                 <td  style="color:red;">    @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='') {{   date('d/m/Y',strtotime($employee->visa_exp_date.'  - 30  days'))}} 
                                    &nbsp &nbsp  
                                 <td><a href="{{url('dashboard/migrant-dash-thiredletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a></td>
                                 &nbsp
                                 <td><a href="{{url('dashboard/migrant-thirdletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a> @endif  @endif</td>
                                 <td>
                                    <a href="{{url('dashboard-details/send-mail/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a>
                                 </td>
                              </tr>
                              @endif  @endif
                              @endforeach  
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <!--<div class="visa-head">-->
               <!--   <h3 style="color:#FF902F;">Passport Notification</h3>-->
               <!--</div>-->
               <!--@if(Session::has('pasmessage'))										-->
               <!--<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('pasmessage') }}</em></div>-->
               <!--@endif-->
               <div class="card" style="margin-bottom:30px;">
                  <div class="card-header">
                     <h3 style="color:#FF902F;">Passport Notification</h3>
                  </div>
                  <div class="card-body">
                     <div class="table-responsive">
                        <table id="pass-datatables" class="table table-striped custom-table datatable" >
                           <thead>
                              <tr>
                                 <th>Employee Code</th>
                                 <th>Employee Name</th>
                                 <th>Address</th>
                                 <th>Passport No.</th>
                                 <th>BRP No.</th>
                                 <th>Passport Issue Date</th>
                                 <th>Passport Expiry Date</th>
                                 <th>Passport Reminder - 90 days </th>
                                 <th>View </th>
                                 <th>Send </th>
                                 <th>Passport Reminder - 60 days </th>
                                 <th>View </th>
                                 <th>Send </th>
                                 <th>Passport Reminder - 30 days </th>
                                 <th>View</th>
                                 <th>Send </th>
                                 <th>Email Send</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($employee_migarnt as $employee)
                              @if( $employee->pass_exp_date!='1970-01-01') @if( $employee->pass_exp_date!='')
                              <tr>
                                 <td>{{ $employee->emp_code}}</td>
                                 <td>{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }}</td>
                                 <td>{{ $employee->emp_pr_street_no}} @if( $employee->emp_per_village) ,{{ $employee->emp_per_village}} @endif @if( $employee->emp_pr_state) ,{{ $employee->emp_pr_state}} @endif @if( $employee->emp_pr_city) ,{{ $employee->emp_pr_city}} @endif
                                    @if( $employee->emp_pr_pincode) ,{{ $employee->emp_pr_pincode}} @endif  @if( $employee->emp_pr_country) ,{{ $employee->emp_pr_country}} @endif
                                 </td>
                                 <td>{{ $employee->pass_doc_no }}</td>
                                 <td>{{ $employee->visa_doc_no }}</td>
                                 <td>    @if( $employee->pas_iss_date!='1970-01-01') @if( $employee->pas_iss_date!='') {{ date('d/m/Y',strtotime($employee->pas_iss_date)) }} @endif  @endif</td>
                                 <td>    @if( $employee->pass_exp_date!='1970-01-01') @if( $employee->pass_exp_date!='') {{ date('d/m/Y',strtotime($employee->pass_exp_date)) }} @endif  @endif</td>
                                 <td  style="color:red;">    @if( $employee->pass_exp_date!='1970-01-01') @if( $employee->pass_exp_date!='') {{   date('d/m/Y',strtotime($employee->pass_exp_date.'  - 90  days'))}} 
                                    &nbsp &nbsp  
                                 <td><a href="{{url('dashboard/passportmigrant-dash-firstletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a></td>
                                 &nbsp
                                 <td><a href="{{url('dashboard/passportmigrant-firstletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a>
                                    @endif  @endif
                                 </td>
                                 <td  style="color:red;">    @if( $employee->pass_exp_date!='1970-01-01') @if( $employee->pass_exp_date!='') {{   date('d/m/Y',strtotime($employee->pass_exp_date.'  - 60  days'))}}  
                                    &nbsp &nbsp 
                                 <td> <a href="{{url('dashboard/passportmigrant-dash-secondletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a> </td>
                                 &nbsp
                                 <td><a href="{{url('dashboard/passportmigrant-secondletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a> @endif  @endif</td>
                                 <td  style="color:red;">    @if( $employee->pass_exp_date!='1970-01-01') @if( $employee->pass_exp_date!='') {{   date('d/m/Y',strtotime($employee->pass_exp_date.'  - 30  days'))}} 
                                    &nbsp &nbsp  
                                 <td><a href="{{url('dashboard/passportmigrant-dash-thiredletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a></td>
                                 &nbsp
                                 <td><a href="{{url('dashboard/passportmigrant-thirdletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a> @endif  @endif</td>
                                 <td>
                                    <a href="{{url('dashboard-details/passend-mail/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a>
                                 </td>
                              </tr>
                              @endif  
                              @endif
                              @endforeach  
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <!--<div class="visa-head">-->
               <!--   <h3 style="color:#FF902F;">DBS Notification</h3>-->
               <!--</div>-->
               <!--@if(Session::has('pasmessage'))										-->
               <!--<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('pasmessage') }}</em></div>-->
               <!--@endif-->
               <div class="card" style="margin-bottom:30px;">
                  <div class="card-header">
                     <h3 style="color:#FF902F;">DBS Notification</h3>
                  </div>
                  <div class="card-body">
                     <div class="table-responsive">
                        <table id="dbs-datatables" class="table table-striped custom-table datatable" >
                           <thead>
                              <tr>
                                 <th>Employee Code</th>
                                 <th>Employee Name</th>
                                 <th>Address</th>
                                 <th>DBS Type</th>
                                 <th>Reference Number No.</th>
                                 <th>Issue Date</th>
                                 <th>Expiry Date</th>
                                 <th>Reminder - 90 days </th>
                                 <th>View </th>
                                 <th>Send </th>
                                 <th>Reminder - 60 days </th>
                                 <th>View </th>
                                 <th>Send </th>
                                 <th>Reminder - 30 days </th>
                                 <th>View</th>
                                 <th>Send </th>
                                 <th>Email Send</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($employee_migarnt as $employee)
                              @if( $employee->dbs_exp_date!='1970-01-01') @if( $employee->dbs_exp_date!='')
                              <tr>
                                 <td>{{ $employee->emp_code}}</td>
                                 <td>{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }}</td>
                                 <td>{{ $employee->emp_pr_street_no}} @if( $employee->emp_per_village) ,{{ $employee->emp_per_village}} @endif @if( $employee->emp_pr_state) ,{{ $employee->emp_pr_state}} @endif @if( $employee->emp_pr_city) ,{{ $employee->emp_pr_city}} @endif
                                    @if( $employee->emp_pr_pincode) ,{{ $employee->emp_pr_pincode}} @endif  @if( $employee->emp_pr_country) ,{{ $employee->emp_pr_country}} @endif
                                 </td>
                                 <td>{{ $employee->dbs_type }}</td>
                                 <td>{{ $employee->dbs_ref_no }}</td>
                                 <td>    @if( $employee->dbs_issue_date!='1970-01-01') @if( $employee->dbs_issue_date!='') {{ date('d/m/Y',strtotime($employee->dbs_issue_date)) }} @endif  @endif</td>
                                 <td>    @if( $employee->dbs_exp_date!='1970-01-01') @if( $employee->dbs_exp_date!='') {{ date('d/m/Y',strtotime($employee->dbs_exp_date)) }} @endif  @endif</td>
                                 <td  style="color:red;">    @if( $employee->dbs_exp_date!='1970-01-01') @if( $employee->dbs_exp_date!='') {{   date('d/m/Y',strtotime($employee->dbs_exp_date.'  - 90  days'))}} 
                                    &nbsp &nbsp  
                                 <td><a href="{{url('dashboard/dbsmigrant-dash-firstletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a></td>
                                 &nbsp
                                 <td><a href="{{url('dashboard/dbsmigrant-firstletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a>
                                    @endif  @endif
                                 </td>
                                 <td  style="color:red;">    @if( $employee->dbs_exp_date!='1970-01-01') @if( $employee->dbs_exp_date!='') {{   date('d/m/Y',strtotime($employee->dbs_exp_date.'  - 60  days'))}}  
                                    &nbsp &nbsp 
                                 <td> <a href="{{url('dashboard/dbsmigrant-dash-secondletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a> </td>
                                 &nbsp
                                 <td><a href="{{url('dashboard/dbsmigrant-secondletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a> @endif  @endif</td>
                                 <td  style="color:red;">    @if( $employee->dbs_exp_date!='1970-01-01') @if( $employee->dbs_exp_date!='') {{   date('d/m/Y',strtotime($employee->dbs_exp_date.'  - 30  days'))}} 
                                    &nbsp &nbsp  
                                 <td><a href="{{url('dashboard/dbsmigrant-dash-thiredletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a></td>
                                 &nbsp
                                 <td><a href="{{url('dashboard/dbsmigrant-thirdletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a> @endif  @endif</td>
                                 <td>
                                    <a href="{{url('dashboard-details/send-mail/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a>
                                 </td>
                              </tr>
                              @endif  
                              @endif
                              @endforeach  
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <!--<div class="visa-head">-->
               <!--   <h3 style="color:#FF902F;">EUSS Notification</h3>-->
               <!--</div>-->
               <!--@if(Session::has('pasmessage'))										-->
               <!--<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('pasmessage') }}</em></div>-->
               <!--@endif-->
               <div class="card" style="margin-bottom:30px;">
                  <div class="card-header">
                     <h3 style="color:#FF902F;">EUSS Notification</h3>
                  </div>
                  <div class="card-body">
                     <div class="table-responsive">
                        <table id="dbs-datatables" class="table table-striped custom-table datatable" >
                           <thead>
                              <tr>
                                 <th>Employee Code</th>
                                 <th>Employee Name</th>
                                 <th>Address</th>
                                 <th>Reference Number No.</th>
                                 <th>Issue Date</th>
                                 <th>Expiry Date</th>
                                 <th>Reminder - 90 days </th>
                                 <th>View </th>
                                 <th>Send </th>
                                 <th>Reminder - 60 days </th>
                                 <th>View </th>
                                 <th>Send </th>
                                 <th>Reminder - 30 days </th>
                                 <th>View</th>
                                 <th>Send </th>
                                 <th>Email Send</th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($employee_migarnt as $employee)
                              @if( $employee->euss_exp_date!='1970-01-01') @if( $employee->euss_exp_date!='')
                              <tr>
                                 <td>{{ $employee->emp_code}}</td>
                                 <td>{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }}</td>
                                 <td>{{ $employee->emp_pr_street_no}} @if( $employee->emp_per_village) ,{{ $employee->emp_per_village}} @endif @if( $employee->emp_pr_state) ,{{ $employee->emp_pr_state}} @endif @if( $employee->emp_pr_city) ,{{ $employee->emp_pr_city}} @endif
                                    @if( $employee->emp_pr_pincode) ,{{ $employee->emp_pr_pincode}} @endif  @if( $employee->emp_pr_country) ,{{ $employee->emp_pr_country}} @endif
                                 </td>
                                 <td>{{ $employee->euss_ref_no }}</td>
                                 <td>    @if( $employee->euss_issue_date!='1970-01-01') @if( $employee->euss_issue_date!='') {{ date('d/m/Y',strtotime($employee->euss_issue_date)) }} @endif  @endif</td>
                                 <td>    @if( $employee->euss_exp_date!='1970-01-01') @if( $employee->euss_exp_date!='') {{ date('d/m/Y',strtotime($employee->euss_exp_date)) }} @endif  @endif</td>
                                 <td  style="color:red;">    @if( $employee->euss_exp_date!='1970-01-01') @if( $employee->euss_exp_date!='') {{   date('d/m/Y',strtotime($employee->euss_exp_date.'  - 90  days'))}} 
                                    &nbsp &nbsp  
                                 <td><a href="{{url('dashboard/eussmigrant-dash-firstletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a></td>
                                 &nbsp
                                 <td><a href="{{url('dashboard/eussmigrant-firstletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a>
                                    @endif  @endif
                                 </td>
                                 <td  style="color:red;">    @if( $employee->euss_exp_date!='1970-01-01') @if( $employee->euss_exp_date!='') {{   date('d/m/Y',strtotime($employee->euss_exp_date.'  - 60  days'))}}  
                                    &nbsp &nbsp 
                                 <td> <a href="{{url('dashboard/eussmigrant-dash-secondletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a> </td>
                                 &nbsp
                                 <td><a href="{{url('dashboard/eussmigrant-secondletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a> @endif  @endif</td>
                                 <td  style="color:red;">    @if( $employee->euss_exp_date!='1970-01-01') @if( $employee->euss_exp_date!='') {{   date('d/m/Y',strtotime($employee->euss_exp_date.'  - 30  days'))}} 
                                    &nbsp &nbsp  
                                 <td><a href="{{url('dashboard/eussmigrant-dash-thiredletter/'.base64_encode($employee->emp_code))}}" target="_blank"><i class="fas fa-eye" ></i></a></td>
                                 &nbsp
                                 <td><a href="{{url('dashboard/eussmigrant-thirdletter-send/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a> @endif  @endif</td>
                                 <td>
                                    <a href="{{url('dashboard-details/send-mail/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code))}}" ><i class="fas fa-paper-plane"></i></a>
                                 </td>
                              </tr>
                              @endif  
                              @endif
                              @endforeach  
                           </tbody>
                        </table>
                     </div>
                  </div>
               </div>
               <!--<div class="visa-head">-->
               <!--   <h3 style="color:#FF902F;">Right to Work</h3>-->
               <!--</div>-->
               <div class="card">
                  <div class="card-header">
                     <h3 style="color:#FF902F;">Right to Work</h3>
                  </div>
                  <div class="card-body">
                     <div class="table-responsive">
                        <table class="table table-striped custom-table datatable" style="width:100%">
                           <thead>
                              <tr>
                                 <td>Sl. No.</td>
                                 <td>Subject</td>
                                 <td>Link</td>
                              </tr>
                           </thead>
                           <tbody>
                              <tr class="odd">
                                 <td>1</td>
                                 <td>Right to Work</td>
                                 <td><a href="https://www.gov.uk/view-right-to-work" target="_blank">https://www.gov.uk/view-right-to-work</a></td>
                              </tr>
                           </tbody>
                        </table>
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
// <script>
   //     $(document).ready(function() {
   //       $('#basic-datatables').DataTable({
   //       });
      
   //       $('#multi-filter-select').DataTable( {
   //           "pageLength": 5,
   //           initComplete: function () {
   //               this.api().columns().every( function () {
   //                   var column = this;
   //                   var select = $('<select class="form-control"><option value=""></option></select>')
   //                   .appendTo( $(column.footer()).empty() )
   //                   .on( 'change', function () {
   //                       var val = $.fn.dataTable.util.escapeRegex(
   //                           $(this).val()
   //                           );
      
   //                       column
   //                       .search( val ? '^'+val+'$' : '', true, false )
   //                       .draw();
   //                   } );
      
   //                   column.data().unique().sort().each( function ( d, j ) {
   //                       select.append( '<option value="'+d+'">'+d+'</option>' )
   //                   } );
   //               } );
   //           }
   //       });
      
   //       // Add Row
   //       $('#add-row').DataTable({
   //           "pageLength": 5,
   //       });
      
   //       var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';
      
   //       $('#addRowButton').click(function() {
   //           $('#add-row').dataTable().fnAddData([
   //               $("#addName").val(),
   //               $("#addPosition").val(),
   //               $("#addOffice").val(),
   //               action
   //               ]);
   //           $('#addRowModal').modal('hide');
      
   //       });
   //   });
   // 
</script>
@endsection