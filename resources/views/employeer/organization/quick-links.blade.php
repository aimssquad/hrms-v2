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
                     $allModules = range(1, 18);
                     $moduleNames = [
                        // 1 => 'Organization',
                        1 => 'Recruitment',
                        2 => 'Employee Administration',
                        3 => 'Rota',
                        4 => 'Attendance',
                        5 => 'Leave Handling',
                        6 => 'Leave Authosizer',
                        7 => 'Holiday Handling',
                        8 => 'Task Control',
                        9 => 'Performance Control',
                        10 => 'Settings',
                        11 => 'User Permissions',
                        12 => 'Billing',
                        13 => 'File Manager',
                        14 => 'Hr Support',
                        15 => 'Organogram Chart',
                        16 => 'Change Of Circumstances',
                        17 => 'Employee Hub',
                        18 => 'Visitor Register',
                     ];

                     $module_url = [
                        // 1 => 'organization/employerdashboard',
                        1 => 'recruitment/dashboard',
                        2 => 'organization/employee/employerdashboard',
                        3 => 'rota-org/dashboard',
                        4 => 'attendance-management/dashboard',
                        5 => 'leave/dashboard',
                        6 => 'leaveapprover/leave-dashboard',
                        7 => 'orgaization/holiday-dashboard',
                        8 => 'org-task-management/dashboard',
                        9 => 'org-performances/dashboard',
                        10 => 'organization/settings-dashboard',
                        11 => 'user-access-role/dashboard',
                        12 => 'organization/billing-show',
                        13 => 'file-management/dashboard',
                        14 => 'hr-support/dashboard',
                        15 => '#',
                        16 => 'organization/circumstances',
                        17 => 'org-user-check-employee',
                        18 => 'rota-org/visitor-dashboard',
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
                                          <i class="fas fa-building rota-icon-size-fixed"></i>
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
