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
                     <div class="card bg-success text-white border-0">
                        <div class="card-body text-center">
                           <h5 class="card-title">Organization</h5>
                              <a href="{{ url('organization/employerdashboard') }}" class="btn btn-light btn-sm">View <span class="	fas fa-arrow-circle-right"></span></a>
                        </div>
                     </div>
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
                        <div class="card {{ $hasAccess ? 'bg-success text-white' : 'bg-warning text-dark' }} border-0">
                           <div class="card-body text-center">
                              {{-- <h5 class="card-title">Module {{ $moduleId }}</h5> --}}
                              <h5 class="card-title">{{ $moduleName }}</h5>
                              {{-- <p>Status: <strong>{{ $hasAccess ? 'Accessible' : 'Not Accessible' }}</strong></p> --}}
                              @if($hasAccess)
                                 <a href="{{ url($moduleUrl) }}" class="btn btn-light btn-sm">View <span class="	fas fa-arrow-circle-right"></span></a>
                              @else
                                 <button class="btn btn-dark btn-sm" disabled>Upgrade Now</button>
                              @endif
                           </div>
                        </div>
                     </div>
                  @endforeach
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
