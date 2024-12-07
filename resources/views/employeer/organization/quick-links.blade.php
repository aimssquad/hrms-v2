@extends('employeer.include.app')
@section('title', 'Home - HRMS admin template')
@section('content')
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row">
         <div class="col-sm-12">
            <h3 class="page-title">Welcome {{ ucwords($employee->com_name ?? "Employee") }}!</h3>
         </div>
      </div>
   </div>

   <!-- Modules Section -->
   <div class="row">
      <div class="card">
         <div class="card-body">
            <div class="col-xl-12 col-md-12">
               <div class="row">

                  <div class="col-xl-4 col-md-6 col-sm-12 mb-4">
                  <a href="{{ url('organization/employerdashboard') }}" class="text-primary fw-semibold">
                     <div class="card border-0 mb-0">
                        <div class="home_mainpage_super_admin_box position-relative">
                           <div class="d-flex align-items-start">
                              <div class="text-primary w-100">
                                 <div class="d-flex align-items-center gap-3">
                                    <div class="main_icon">
                                       <i class="fas fa-building rota-icon-size-fixed"></i>
                                    </div>
                                    <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                       Organization
                                    </div>
                                 </div>
                                 <div class="viewall_btn">
                                    <!-- <div class="fs-12"></div> -->
                                    <div class="">
                                       <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </a>

                  </div>

                  @php
                     // Define all available modules
                     $allModules = range(1, 19);
                     $module_icon = [
                        1 => 'las la-donate',
                        2 => 'las la-clone',
                        3 => 'la la-users',
                        4 => 'las la-calendar',
                        5 => 'las la-tachometer-alt',
                        6 => 'las la-clipboard-list ',
                        7 => 'lab la-confluence',
                        8 => 'lab la-blackberry',
                        9 => 'las la-tasks ',
                        10 => 'las la-certificate',
                        11 => 'las la-cogs',
                        12 => 'las la-universal-access',
                        13 => 'las la-pound-sign',
                        14 => 'las la-file ',
                        15 => 'las la-american-sign-language-interpreting',
                        16 => 'las la-chart-bar',
                        17 => 'las la-sync',
                        18 => 'las la-user-tie',
                        19 => 'las la-cash-register',
                     ];
                     $moduleNames = [
                        1 => 'Sponsor Compliances',
                        2 => 'Recruitment',
                        3 => 'Employee Administration',
                        4 => 'Rota',
                        5 => 'Attendance',
                        6 => 'Leave Handling',
                        7 => 'Leave Authosizer',
                        8 => 'Holiday Handling',
                        9 => 'Task Control',
                        10 => 'Performance Control',
                        11 => 'Settings',
                        12 => 'User Permissions',
                        13 => 'Billing',
                        14 => 'File Manager',
                        15 => 'Hr Support',
                        16 => 'Organogram Chart',
                        17 => 'Change Of Circumstances',
                        18 => 'Employee Hub',
                        19 => 'Visitor Register',
                     ];

                     $module_url = [
                        1 => 'org-dashboarddetails',
                        2 => 'recruitment/dashboard',
                        3 => 'organization/employee/employerdashboard',
                        4 => 'rota-org/dashboard',
                        5 => 'attendance-management/dashboard',
                        6 => 'leave/dashboard',
                        7 => 'leaveapprover/leave-dashboard',
                        8 => 'orgaization/holiday-dashboard',
                        9 => 'org-task-management/dashboard',
                        10 => 'org-performances/dashboard',
                        11 => 'organization/settings-dashboard',
                        12 => 'user-access-role/dashboard',
                        13 => 'organization/billing/dashboard',
                        14 => 'file-management/dashboard',
                        15 => 'hr-support/dashboard',
                        16 => '#',
                        17 => 'organization/circumstances',
                        18 => 'org-user-check-employee',
                        19 => 'rota-org/visitor-dashboard',
                     ];

                     // Convert employee modules to integers for comparison
                     $employeeModules = array_map('intval', $array_role);
                  @endphp

                  @foreach($allModules as $moduleId)
                     @php
                        // Determine if the employee has access to this module
                        $hasAccess = in_array($moduleId, $employeeModules);
                         // Get the module name or default to 'Unknown Module'
                        $moduleName = $moduleNames[$moduleId] ?? 'Unknown Module';
                         // Get the URL name or default to 'Unknown Url'
                         $moduleUrl = $module_url[$moduleId] ?? '#';
                         $moduleIcon = $module_icon[$moduleId] ?? 'las la-expand-arrows-alt';
                        //dd($hasAccess);
                     @endphp

                     <!-- Module Card -->
                     <div class="col-xl-4 col-md-6 col-sm-12 mb-4">
                     <a href="{{ $hasAccess ? url($moduleUrl) : '#' }}" class="text-primary fw-semibold {{ !$hasAccess ?      'disabled-link' : '' }}">
                        <div class="card {{ $hasAccess ? 'text-white' : 'bg-warning text-dark' }} border-0 mb-0">
                           <div class="home_mainpage_super_admin_box position-relative">
                              <div class="d-flex align-items-start">
                                 <div class="text-primary w-100">
                                    <div class="d-flex align-items-center gap-3">
                                       <div class="main_icon">
                                          <i class="{{$moduleIcon}} rota-icon-size-fixed"></i>
                                       </div>
                                       <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                          <h5 class="text-card-size-fixed">{{ $moduleName }}</h5>
                                       </div>
                                    </div>
                                    <div class="viewall_btn">
                                       @if($hasAccess)
                                          <div>
                                             <i class="fa fa-arrow-circle-right fixed-card"></i> View
                                          </div>
                                       @else
                                          <button class="btn btn-dark btn-sm" disabled>Upgrade Now</button>
                                       @endif
                                    </div>
                                 </div>
                              </div>
                              
                           </div>
                        </div>
                     </a>
                     </div>
                  @endforeach
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
