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
                     $allModules = range(1, 19);
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
                        13 => 'organization/billing-show',
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
