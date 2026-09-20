@extends('employeer.include.app')
@section('title', \App\Helpers\Helper::cachedTrans('Sponsor Compaliance'))
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
//dd($sidebarItems);
@endphp
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row">
         <div class="col-sm-12">
            <h3 class="page-title">Welcome! <span class="dual-lang-sub notranslate">Welcome!</span></h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item active">
                  {{\App\Helpers\Helper::cachedTrans(ucwords($Roledata->com_name))}} <span class="dual-lang-sub notranslate">{{ucwords($Roledata->com_name)}}</span>
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
         <div class="row g-4">
            <div class="col-xl-4 col-lg-4 col-md-6">
               <a href="{{url('org-company-profile/edit-company')}}?c_id={{base64_encode($Roledata->id)}}" class="modern-card-link">
                  <div class="modern-card">
                     <div class="modern-card-header">
                     <div class="modern_icon_wrapper">
                              <i class="fa fa-building modern-icon"></i>
                           </div>
                           <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans("Organisation Profile")}} <span class="dual-lang-sub notranslate">Organisation Profile</span></h4>
                     </div>
                     <div class="modern-card-body">
                           <div class="modern-status">
                              @if($Roledata->updated_at != '')
                              <span class="status-badge complete">{{\App\Helpers\Helper::cachedTrans("Complete")}} </span> <span class="dual-lang-sub notranslate">Complete</span>
                              @else
                              <span class="status-badge incomplete">{{\App\Helpers\Helper::cachedTrans("Incomplete")}} </span> <span class="dual-lang-sub notranslate">Incomplete</span>
                              @endif
                           </div>
                           <div class="modern-arrow">
                              <span class="employee-count">9</span>
                              <i class="fa fa-arrow-right"></i>
                           </div>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <a href="{{url('org-dashboard-employees')}}" class="modern-card-link">
                  <div class="modern-card">
                     <div class="modern-card-header">
                     <div class="modern_icon_wrapper">
                              <i class="fa fa-building modern-icon"></i>
                           </div>
                           <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans("All Employee List")}} <span class="dual-lang-sub notranslate">All Employee List</span></h4>
                     </div>
                     <div class="modern-card-body">
                        <div class="modern-status">
                           <!-- @if($Roledata->updated_at != '')
                           <span class="status-badge complete">Complete</span>
                           @else
                           <span class="status-badge incomplete">Incomplete</span>
                           @endif -->
                        </div>
                        <div class="modern-arrow">
                           <span class="employee-count">{{ count($employee_active) }}</span>
                           <i class="fa fa-arrow-right"></i>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <a href="{{ url('org-dashboard-migrant-employees') }}" class="modern-card-link">
                  <div class="modern-card">
                     <div class="modern-card-header">
                     <div class="modern_icon_wrapper">
                              <i class="fa fa-building modern-icon"></i>
                           </div>
                           <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans("Migrant Employee List")}} <span class="dual-lang-sub notranslate">Migrant Employee List</span></h4>
                     </div>
                     <div class="modern-card-body">
                        <div class="modern-status"></div>
                        <div class="modern-arrow">
                           <span class="employee-count">{{ count($employee_migarnt) }}</span>
                           <i class="fa fa-arrow-right"></i>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <a href="{{ url('org-dashboard-right-works') }}" class="modern-card-link">
                  <div class="modern-card">
                     <div class="modern-card-header">
                     <div class="modern_icon_wrapper">
                              <i class="fa fa-building modern-icon"></i>
                           </div>
                           <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans("RTW Checks & Share  Code")}} <span class="dual-lang-sub notranslate">(RTW Checks & Share  Code)</span></h4>
                     </div>
                     <div class="modern-card-body">
                        <div class="modern-status"></div>
                        <div class="modern-arrow">
                           <span class="employee-count">{{ count($employee_migarnt) }}</span>
                           <i class="fa fa-arrow-right"></i>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            @if($user_type ==="employee")
            @foreach($sidebarItems['Recruitment'] as $rotaItem)
                @if($rotaItem['submenu_name'] == 'Dashboard' && $rotaItem['can_add'] == 1)
            <div class="col-xl-4 col-lg-4 col-md-6">
               <a 
               href="{{ url('recruitment/dashboard')}}" target="_self" class="modern-card-link">
                  <div class="modern-card">
                     <div class="modern-card-header">
                     <div class="modern_icon_wrapper">
                              <i class="fa fa-building modern-icon"></i>
                           </div>
                           <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans("Recruitment Process")}} <span class="dual-lang-sub notranslate">Recruitment Process</span></h4>
                     </div>
                     <div class="modern-card-body">
                        <div class="modern-status"></div>
                        <div class="modern-arrow">
                           <span class="employee-count">0</span>
                           <i class="fa fa-arrow-right"></i>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            @endif
            @endforeach
            @else
            <div class="col-xl-4 col-lg-4 col-md-6">
               <a 
               href="{{url('recruitment/dashboard')}}" 
               target="_self" 
               class="modern-card-link">
                  <div class="modern-card">
                     <div class="modern-card-header">
                     <div class="modern_icon_wrapper">
                              <i class="fa fa-building modern-icon"></i>
                           </div>
                           <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans("Recruitment Process")}} <span class="dual-lang-sub notranslate">Recruitment Process</span></h4>
                     </div>
                     <div class="modern-card-body">
                        <div class="modern-status"></div>
                        <div class="modern-arrow">
                           <span class="employee-count">0</span>
                           <i class="fa fa-arrow-right"></i>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            @endif
            @if($user_type ==="employee")
               @foreach($sidebarItems['Leave Management'] as $rotaItem)
                  @if($rotaItem['submenu_name'] == 'Dashboard' && $rotaItem['can_add'] == 1)
                     <div class="col-xl-4 col-lg-4 col-md-6">
                        <a href="{{ url('leave/dashboard') }}" target="_self" class="modern-card-link">
                           <div class="modern-card">
                              <div class="modern-card-header">
                              <div class="modern_icon_wrapper">
                                       <i class="fa fa-building modern-icon"></i>
                                    </div>
                                    <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans("Leave Management")}} <span class="dual-lang-sub notranslate">Leave Management</span></h4>
                              </div>
                              <div class="modern-card-body">
                                 <div class="modern-status"></div>
                                 <div class="modern-arrow">
                                    <span class="employee-count">0</span>
                                    <i class="fa fa-arrow-right"></i>
                                 </div>
                              </div>
                           </div>
                        </a>
                     </div>
                  @endif
               @endforeach
            @else
            <div class="col-xl-4 col-lg-4 col-md-6">
               <a 
               href="{{ url('leave/dashboard') }}" 
               target="_self" 
               class="modern-card-link">
                  <div class="modern-card">
                     <div class="modern-card-header">
                     <div class="modern_icon_wrapper">
                              <i class="fa fa-building modern-icon"></i>
                           </div>
                           <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans("Leave Management")}} <span class="dual-lang-sub notranslate">Leave Management</span></h4>
                     </div>
                     <div class="modern-card-body">
                        <div class="modern-status"></div>
                        <div class="modern-arrow">
                           <span class="employee-count">0</span>
                           <i class="fa fa-arrow-right"></i>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            @endif
            <div class="col-xl-4 col-lg-4 col-md-6">
               <a href="#" class="modern-card-link">
                  <div class="modern-card">
                     <div class="modern-card-header">
                     <div class="modern_icon_wrapper">
                              <i class="fa fa-building modern-icon"></i>
                           </div>
                           <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans("Payroll")}} <span class="dual-lang-sub notranslate">Payroll</span></h4>
                     </div>
                     <div class="modern-card-body">
                        <div class="modern-status"></div>
                        <div class="modern-arrow">
                           <span class="employee-count">0</span>
                           <i class="fa fa-arrow-right"></i>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            @if($user_type ==="employee")
            @else
               <div class="col-xl-4 col-lg-4 col-md-6">
                  <a href="{{ url('org-dashboard/key-contact') }}" class="modern-card-link">
                     <div class="modern-card">
                        <div class="modern-card-header">
                        <div class="modern_icon_wrapper">
                                 <i class="fa fa-building modern-icon"></i>
                              </div>
                              <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans("Key Contact")}} <span class="dual-lang-sub notranslate">Key Contact</span></h4>
                        </div>
                        <div class="modern-card-body">
                           <div class="modern-status"></div>
                           <div class="modern-arrow">
                              <span class="employee-count">0</span>
                              <i class="fa fa-arrow-right"></i>
                           </div>
                        </div>
                     </div>
                  </a>
               </div>
            @endif
            <div class="col-xl-4 col-lg-4 col-md-6">
               <a href="{{ url('org-dashboard/sponsor-management-dossier-new') }}" class="modern-card-link">
                  <div class="modern-card">
                     <div class="modern-card-header">
                     <div class="modern_icon_wrapper">
                              <i class="fa fa-building modern-icon"></i>
                           </div>
                           <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans("Sponsor Management Dossier")}} <span class="dual-lang-sub notranslate">Sponsor Management Dossier</span></h4>
                     </div>
                     <div class="modern-card-body">
                        <div class="modern-status"></div>
                        <div class="modern-arrow">
                           <span class="employee-count">0</span>
                           <i class="fa fa-arrow-right"></i>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <a href="{{ url('org-dashboard-migrant-employees') }}" class="modern-card-link">
                  <div class="modern-card">
                     <div class="modern-card-header">
                     <div class="modern_icon_wrapper">
                              <i class="fa fa-building modern-icon"></i>
                           </div>
                           <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans("Monitoring & Reporting")}} <span class="dual-lang-sub notranslate">Monitoring & Reporting</span></h4>
                     </div>
                     <div class="modern-card-body">
                        <div class="modern-status"></div>
                        <div class="modern-arrow">
                           <span class="employee-count">0</span>
                           <i class="fa fa-arrow-right"></i>
                        </div>
                     </div>
                  </div>
               </a>

            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <a href="{{ url('org-dashboard/message-center') }}" class="modern-card-link">
                  <div class="modern-card">
                     <div class="modern-card-header">
                           <div class="modern_icon_wrapper">
                              <i class="fa fa-building modern-icon"></i>
                           </div>
                           <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans("Message Centre")}} <span class="dual-lang-sub notranslate">Message Centre</span></h4>
                     </div>
                     <div class="modern-card-body">
                        <div class="modern-status"></div>
                        <div class="modern-arrow">
                           <span class="employee-count">0</span>
                           <i class="fa fa-arrow-right"></i>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="modern-card-link">
                  <div class="modern-card position-relative" style="height: 136px;">
                     <div class="modern-card-header">
                           <div class="modern_icon_wrapper">
                              <i class="fa fa-building modern-icon"></i>
                           </div>
                           <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans("Staff Report")}} <span class="dual-lang-sub notranslate">Staff Report</span></h4>
                     </div>
                     <div class="modern-card-body">
                        <div class="modern-status"></div>
                        <div class="modern-arrow d-flex align-items-center w-100">
                           <form method="post" action="{{ url('org-document/staff-report-excel') }}" enctype="multipart/form-data" class="w-100">
                              <input type="hidden" name="_token" value="{{ csrf_token() }}">
                              <button class="text-fixed-white w-100 text-end position-absolute top-0 start-0 h-100" style="background: none !important; border: 0px;" type="submit">
                                 <i class="fa fa-arrow-right position-absolute" style="bottom: 20px; right: 20px"></i>
                              </button>
                              {{-- <i class="fa fa-arrow-right position-absolute" style="bottom: 20px; right: 20px"></i> --}}
                           </form>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="modern-card">
                  <div class="modern-card-header text-fixed-white">
                     <div class="modern_icon_wrapper">
                        <i class="fa fa-building modern-icon"></i>
                     </div>
                     <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans("Absent Report")}} <span class="dual-lang-sub notranslate">Absent Report</span></h4>
                  </div>
                  <div class="modern-card-body">
                     <div class="d-flex align-items-center w-100">
                           <div></div>
                           <div class="ms-auto">
                              <?php 
                              if ($usetype == 'employee') {
                                 if (in_array('54', $arrrole)) {
                              ?>
                                 <a href="{{ url('org-dashboard/absent-report') }}" class="modern-card-link">
                                       <i class="fa fa-arrow-right"></i>
                                 </a>
                              <?php
                                 } else {
                              ?>
                                 <a href="#" class="modern-card-link">
                                       <i class="fa fa-arrow-right"></i>
                                 </a>
                              <?php
                                 }
                              } else {
                              ?>
                                 <a href="{{ url('org-dashboard/absent-report') }}" class="modern-card-link">
                                       <i class="fa fa-arrow-right"></i>
                                 </a>
                              <?php	
                              } 
                              ?>
                           </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="modern-card">
                  <div class="modern-card-header text-fixed-white">
                     <div class="modern_icon_wrapper">
                              <i class="fa fa-building modern-icon"></i>
                           </div>
                     <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans("Change Of Circumstances")}} <span class="dual-lang-sub notranslate">Change Of Circumstances</span></h4>
                  </div>
                  <div class="modern-card-body">
                     <div class="d-flex align-items-center w-100">
                           <div></div>
                           <div class="ms-auto">
                              <?php 
                              if ($usetype == 'employee') {
                                 if (in_array('76', $arrrole)) {
                              ?>
                                 <a href="{{ url('org-dashboard/change-of-circumstances') }}" class="modern-card-link">
                                       <i class="fa fa-arrow-right"></i>
                                 </a>
                              <?php
                                 } else {
                              ?>
                                 <a href="#" class="modern-card-link">
                                       <i class="fa fa-arrow-right"></i>
                                 </a>
                              <?php
                                 }
                              } else {
                              ?>
                                 <a href="{{ url('org-dashboard/change-of-circumstances') }}" class="modern-card-link ">
                                       <i class="fa fa-arrow-right"></i>
                                 </a>
                              <?php	
                              } 
                              ?>
                           </div>
                     </div>
                  </div>
               </div>

            </div>
            <div class="col-xl-4 col-lg-4 col-md-6">
               <div class="modern-card">
                  <div class="modern-card-header text-fixed-white">
                  <div class="modern_icon_wrapper">
                              <i class="fa fa-building modern-icon"></i>
                           </div>
                     <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans("Contract Agreement")}} <span class="dual-lang-sub notranslate">Contract Agreement</span></h4>
                  </div>
                  <div class="modern-card-body">
                     <div class="d-flex align-items-center w-100">
                           <div></div>
                           <div class="ms-auto">
                              <?php 
                              if ($usetype == 'employee') {
                                 if (in_array('78', $arrrole)) {
                              ?>
                                 <a href="{{ url('org-dashboard/contract-agreement') }}" class="modern-card-link">
                                       <i class="fa fa-arrow-right"></i>
                                 </a>
                              <?php
                                 } else {
                              ?>
                                 <a href="#" class="modern-card-link">
                                       <i class="fa fa-arrow-right"></i>
                                 </a>
                              <?php
                                 }
                              } else {
                              ?>
                                 <a href="{{ url('org-dashboard/contract-agreement') }}" class="modern-card-link">
                                       <i class="fa fa-arrow-right"></i>
                                 </a>
                              <?php	
                              } 
                              ?>
                           </div>
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-lg-12 col-md-12 mt-5">
               <!--<div class="visa-head">-->
               <!--   <h3 style="color:#FF902F;">Visa Notification</h3>-->
               <!--</div>-->
             @include('employeer.layout.message')
               <div class="card" style="margin-bottom:30px;">
                  <div class="card-body">
                     <div class="card-header">
                        <h3 style="color:#FF902F;">{{\App\Helpers\Helper::cachedTrans("Visa/RTW Notification")}} <span class="dual-lang-sub notranslate">Visa/RTW Notification</span></h3>
                     </div>
                     <div class="table-responsive">
                        <table id="basic-datatables" class="table table-striped custom-table" >
                           <thead>
                              <tr>
                                 <th>Employee Code
                                    <span class="dual-lang-sub notranslate">Employee Code</span>
                                 </th>
                                 <th>Employee Name
                                    <span class="dual-lang-sub notranslate">Employee Name</span>
                                 </th>
                                 <th>Address 
                                    <span class="dual-lang-sub notranslate">Address</span>
                                 </th>
                                 <th>Share Code 
                                    <span class="dual-lang-sub notranslate">Share Code</span>
                                 </th>
                                 <th>Share Date Check 
                                    <span class="dual-lang-sub notranslate">Share Date Check</span>
                                 </th>
                                 <th>Share Issue Date 
                                    <span class="dual-lang-sub notranslate">Share Issue Date</span>
                                 </th>
                                 <th>Share Expiry Date 
                                    <span class="dual-lang-sub notranslate">Share Expiry Date</span>
                                 </th>
                                 <th>Passport No. 
                                    <span class="dual-lang-sub notranslate">Passport No.</span>
                                 </th>
                                 <th>BRP No. 
                                    <span class="dual-lang-sub notranslate">BRP No.</span>
                                 </th>
                                 <th>Visa Issue Date 
                                    <span class="dual-lang-sub notranslate">Visa Issue Date</span>
                                 </th>
                                 <th>Visa Expiry Date 
                                    <span class="dual-lang-sub notranslate">Visa Expiry Date</span>
                                 </th>
                                 <th>Visa Reminder - 90 days  
                                    <span class="dual-lang-sub notranslate">Visa Reminder - 90 days </span>
                                 </th>
                                 <th>View  
                                    <span class="dual-lang-sub notranslate">View</span>
                                 </th>
                                 <th>Send  
                                    <span class="dual-lang-sub notranslate">Send</span>
                                 </th>
                                 <th>Visa Reminder - 60 days 
                                    <span class="dual-lang-sub notranslate">Visa Reminder - 60 days </span>
                                 </th>
                                 <th>View  
                                    <span class="dual-lang-sub notranslate">View</span>
                                 </th>
                                 <th>Send  
                                    <span class="dual-lang-sub notranslate">Send</span>
                                 </th>
                                 <th>Visa Reminder - 30 days  
                                    <span class="dual-lang-sub notranslate">Visa Reminder - 30 days </span>
                                 </th>
                                 <th>View
                                    <span class="dual-lang-sub notranslate">View</span>
                                 </th>
                                 <th>Send
                                    <span class="dual-lang-sub notranslate">Send</span>
                                 </th>
                                 <th>Email Send
                                    <span class="dual-lang-sub notranslate">Email Send</span>
                                 </th>
                              </tr>
                           </thead>
                           <tbody>
                              @foreach($employee_migarnt as $employee)
                              @if( $employee->visa_exp_date!='1970-01-01') @if( $employee->visa_exp_date!='')
                                 <tr>
                                    {{-- Employee Code: DO NOT TRANSLATE --}}
                                    <td>{{ $employee->emp_code }}</td>

                                    {{-- Employee Name: TRANSLATE --}}
                                    <td>
                                       {{ \App\Helpers\Helper::cachedTrans($employee->emp_fname) }}
                                       {{ $employee->emp_mname ? \App\Helpers\Helper::cachedTrans($employee->emp_mname) : '' }}
                                       {{ $employee->emp_lname ? \App\Helpers\Helper::cachedTrans($employee->emp_lname) : '' }}
                                    </td>

                                    {{-- Address: TRANSLATE --}}
                                    <td>
                                       {{ $employee->emp_pr_street_no
                                             ? \App\Helpers\Helper::cachedTrans($employee->emp_pr_street_no)
                                             : '' }}

                                       @if($employee->emp_per_village)
                                             , {{ \App\Helpers\Helper::cachedTrans($employee->emp_per_village) }}
                                       @endif

                                       @if($employee->emp_pr_state)
                                             , {{ \App\Helpers\Helper::cachedTrans($employee->emp_pr_state) }}
                                       @endif

                                       @if($employee->emp_pr_city)
                                             , {{ \App\Helpers\Helper::cachedTrans($employee->emp_pr_city) }}
                                       @endif

                                       @if($employee->emp_pr_pincode)
                                             , {{ $employee->emp_pr_pincode }}
                                       @endif

                                       @if($employee->emp_pr_country)
                                             , {{ \App\Helpers\Helper::cachedTrans($employee->emp_pr_country) }}
                                       @endif
                                    </td>

                                    {{-- Share Code: DO NOT TRANSLATE --}}
                                    <td>{{ $employee->share_code }}</td>

                                    {{-- Dates: DO NOT TRANSLATE --}}
                                    <td>{{ $employee->share_date_check }}</td>
                                    <td>{{ $employee->share_issue_date }}</td>
                                    <td>{{ $employee->share_expiry_date }}</td>

                                    {{-- Passport / Visa numbers: DO NOT TRANSLATE --}}
                                    <td>{{ $employee->pass_doc_no }}</td>
                                    <td>{{ $employee->visa_doc_no }}</td>

                                    {{-- Visa Issue Date --}}
                                    <td>
                                       @if($employee->visa_issue_date != '1970-01-01' && $employee->visa_issue_date != '')
                                             {{ date('d/m/Y', strtotime($employee->visa_issue_date)) }}
                                       @endif
                                    </td>

                                    {{-- Visa Expiry Date --}}
                                    <td style="color:red;">
                                       @if($employee->visa_exp_date != '1970-01-01' && $employee->visa_exp_date != '')
                                             {{ date('d/m/Y', strtotime($employee->visa_exp_date)) }}
                                       @endif
                                    </td>

                                    {{-- 90 Days Before Expiry --}}
                                    <td style="color:red;">
                                       @if($employee->visa_exp_date != '1970-01-01' && $employee->visa_exp_date != '')
                                             {{ date('d/m/Y', strtotime($employee->visa_exp_date . ' - 90 days')) }}
                                       @endif
                                    </td>

                                    {{-- First Letter View --}}
                                    <td>
                                       <a href="{{ url('dashboard/migrant-dash-firstletter/' . base64_encode($employee->emp_code)) }}"
                                          target="_blank">
                                             <i class="fas fa-eye"></i>
                                       </a>
                                    </td>

                                    {{-- First Letter Send --}}
                                    <td>
                                       <a href="{{ url('dashboard/migrant-firstletter-send/' . base64_encode($employee->emp_code)) }}">
                                             <i class="fas fa-paper-plane"></i>
                                       </a>
                                    </td>

                                    {{-- 60 Days Before Expiry --}}
                                    <td style="color:red;">
                                       @if($employee->visa_exp_date != '1970-01-01' && $employee->visa_exp_date != '')
                                             {{ date('d/m/Y', strtotime($employee->visa_exp_date . ' - 60 days')) }}
                                       @endif
                                    </td>

                                    {{-- Second Letter View --}}
                                    <td>
                                       <a href="{{ url('dashboard/migrant-dash-secondletter/' . base64_encode($employee->emp_code)) }}"
                                          target="_blank">
                                             <i class="fas fa-eye"></i>
                                       </a>
                                    </td>

                                    {{-- Second Letter Send --}}
                                    <td>
                                       <a href="{{ url('dashboard/migrant-secondletter-send/' . base64_encode($employee->emp_code)) }}">
                                             <i class="fas fa-paper-plane"></i>
                                       </a>
                                    </td>

                                    {{-- 30 Days Before Expiry --}}
                                    <td style="color:red;">
                                       @if($employee->visa_exp_date != '1970-01-01' && $employee->visa_exp_date != '')
                                             {{ date('d/m/Y', strtotime($employee->visa_exp_date . ' - 30 days')) }}
                                       @endif
                                    </td>

                                    {{-- Third Letter View --}}
                                    <td>
                                       <a href="{{ url('dashboard/migrant-dash-thiredletter/' . base64_encode($employee->emp_code)) }}"
                                          target="_blank">
                                             <i class="fas fa-eye"></i>
                                       </a>
                                    </td>

                                    {{-- Third Letter Send --}}
                                    <td>
                                       <a href="{{ url('dashboard/migrant-thirdletter-send/' . base64_encode($employee->emp_code)) }}">
                                             <i class="fas fa-paper-plane"></i>
                                       </a>
                                    </td>

                                    {{-- Email Send: KEEP EMAIL/PHONE DATA UNTRANSLATED --}}
                                    <td>
                                       <a href="{{ url('dashboard-details/send-mail/' . base64_encode($employee->emid) . '/' . base64_encode($employee->emp_code)) }}">
                                             <i class="fas fa-paper-plane"></i>
                                       </a>
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
                     <h3 style="color:#FF902F;">Passport Notification <span class="dual-lang-sub notranslate">Passport Notification</span></h3>
                  </div>
                  <div class="card-body">
                     <div class="table-responsive">
                        <table id="pass-datatables" class="table table-striped custom-table datatable" >
                           <thead>
                              <tr>
                                 <th>Employee Code <span class="dual-lang-sub notranslate">Employee Code</span></th>
                                 <th>Employee Name <span class="dual-lang-sub notranslate">Employee Name</span></th>
                                 <th>Address<span class="dual-lang-sub notranslate">Address</span></th>
                                 <th>Passport No.<span class="dual-lang-sub notranslate">Passport No.</span></th>
                                 <th>BRP No.<span class="dual-lang-sub notranslate">BRP No.</span></th>
                                 <th>Passport Issue Date<span class="dual-lang-sub notranslate">Passport Issue Date</span></th>
                                 <th>Passport Expiry Date<span class="dual-lang-sub notranslate">Passport Expiry Date</span></th>
                                 <th>Passport Reminder - 90 days <span class="dual-lang-sub notranslate">Passport Reminder - 90 days </span></th>
                                 <th>View <span class="dual-lang-sub notranslate">View</span></th>
                                 <th>Send <span class="dual-lang-sub notranslate">Send</span></th>
                                 <th>Passport Reminder - 60 days <span class="dual-lang-sub notranslate">Passport Reminder - 60 days </span></th>
                                 <th>View <span class="dual-lang-sub notranslate">View</span></th>
                                 <th>Send <span class="dual-lang-sub notranslate">Send</span></th>
                                 <th>Passport Reminder - 30 days <span class="dual-lang-sub notranslate">Passport Reminder - 30 days </span></th>
                                 <th>View<span class="dual-lang-sub notranslate">View</span></th>
                                 <th>Send <span class="dual-lang-sub notranslate">Send</span></th>
                                 <th>Email Send<span class="dual-lang-sub notranslate">Email Send</span></th>
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