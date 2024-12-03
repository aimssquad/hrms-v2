@extends('employeer.include.app')
@section('title', 'Home - HRMS admin template')
@php
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
$user_type = Session::get("user_type");
//dd($sidebarItems);
@endphp
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row">
         <div class="col-sm-12">
            <h3 class="page-title">Welcome {{ ucwords($Roledata->com_name ?? "NA") }}!</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item active">
                  Dashboard
               </li>
            </ul>
         </div>
      </div>
   </div>
   <!-- /Page Header -->
   <div class="row">
      <div class="card">
         <div class="card-body">
            <div class="col-xl-12 col-md-12">
               <div class="row">
                  @foreach($sidebarItems as $module)
                  {{-- 
                  <div class="col-xl-4 col-md-6 col-sm-12">
                     <div class="card border-0">
                        <div class="alert alert-primary border border-primary mb-0 p-3">
                           <div class="d-flex align-items-start">
                              <div class="text-primary w-100">
                                 --}}
                                 @if($module['module_name'] == 1)
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                 <a href="{{ url('organization/employerdashboard') }}" class="text-primary fw-semibold">
                                    <div class="card border-0">
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
                                 @else
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-building rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">Organization</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif  
                                 @endforeach
                                 @foreach($sidebarItems as $module)  
                                 @if($module['module_name'] == 2)
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-user-tie rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="{{ url('recruitment/dashboard') }}">Recruitment</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="{{url('recruitment/dashboard')}}" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-user-tie rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">Recruitment</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif  
                                 @endforeach
                                 @foreach($sidebarItems as $module)   
                                 @if($module['module_name'] == 3)
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-users rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="{{ url('organization/employee/employerdashboard') }}">Employee Administration</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="{{ url('organization/employee/employerdashboard') }}" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-users rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="{{ url('organization/employee/employerdashboard') }}">Employee Administration</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="{{ url('organization/employee/employerdashboard') }}" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif 
                                 @endforeach
                                 @foreach($sidebarItems as $module)    
                                 @if($module['module_name'] == 4)
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-calendar-alt rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="{{ url('rota-org/dashboard') }}">Rota</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="{{ url('rota-org/dashboard') }}" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-calendar-alt rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">Rota</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif 
                                 @endforeach
                                 @foreach($sidebarItems as $module)    
                                 @if($module['module_name'] == 5)
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-clock rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="{{ url('attendance-management/dashboard') }}">Attendance</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="{{ url('attendance-management/dashboard') }}" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-clock rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">Attendance</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif 
                                 @endforeach
                                 @foreach($sidebarItems as $module)    
                                 @if($module['module_name'] == 6)
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-calendar-check rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="{{ url('leave/dashboard') }}">Leave Handling</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="{{ url('leave/dashboard') }}" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-calendar-check rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">Leave Handling</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif 
                                 @endforeach
                                 @foreach($sidebarItems as $module)    
                                 @if($module['module_name'] == 7)
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-check-circle rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="{{ url('leaveapprover/leave-dashboard') }}">Leave Authosizer</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="{{ url('leaveapprover/leave-dashboard') }}" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-check-circle rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">Leave Authosizer</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif
                                 @endforeach
                                 @foreach($sidebarItems as $module) 
                                 @if($module['module_name'] == 8)
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-calendar rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="{{ url('organization/holiday-dashboard') }}">Holiday Handling</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="{{ url('organization/holiday-dashboard') }}" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-calendar rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">Holiday Handling</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif
                                 @endforeach
                                 @foreach($sidebarItems as $module) 
                                 @if($module['module_name'] == 9)
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-tasks rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">Task Control</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-tasks rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">Task Control</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif
                                 @endforeach
                                 @foreach($sidebarItems as $module) 
                                 @if($module['module_name'] == 10)
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-chart-line rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="{{ url('org-performances/dashboard') }}">Performance Control</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="{{ url('org-performances/dashboard') }}" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-chart-line rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">Performance Control</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif
                                 @endforeach
                                 @foreach($sidebarItems as $module) 
                                 @if($module['module_name'] == 11)
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-cogs rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="{{ url('organization/settings-dashboard') }}">Settings</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="{{ url('organization/settings-dashboard') }}" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-cogs rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">Settings</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif
                                 @endforeach
                                 @foreach($sidebarItems as $module) 
                                 @if($module['module_name'] == 12)
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-user-lock rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="{{ url('user-access-role/dashboard') }}">User Permissions</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="{{ url('user-access-role/dashboard') }}" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-user-lock rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="{{ url('user-access-role/dashboard') }}">User Permissions</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="{{ url('user-access-role/dashboard') }}" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif
                                 @endforeach
                                 @foreach($sidebarItems as $module) 
                                 @if($module['module_name'] == 13)
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-money-bill-wave rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">Billing</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-money-bill-wave rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">Billing</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif   
                                 @endforeach
                                 @foreach($sidebarItems as $module)  
                                 @if($module['module_name'] == 14)
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-file rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="{{ url('file-management/dashboard') }}">File Manager</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="{{ url('file-management/dashboard') }}" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-file rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">File Manager</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif    
                                 @endforeach
                                 @foreach($sidebarItems as $module) 
                                 @if($module['module_name'] == 15)
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-headset rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="{{ url('hr-support/dashboard') }}">HR Support</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="{{ url('hr-support/dashboard') }}" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-headset rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">HR Support</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif  
                                 @endforeach
                                 @foreach($sidebarItems as $module)   
                                 @if($module['module_name'] == 20)
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-sitemap rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">Organogram Chart Compliance</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-sitemap rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">Organogram Chart Compliance</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif    
                                 @endforeach
                                 @foreach($sidebarItems as $module) 
                                 @if($module['module_name'] == 21)
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-exchange-alt rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">Change Of Circumstances</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-exchange-alt rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">Change Of Circumstances</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif 
                                 @endforeach
                                 @foreach($sidebarItems as $module)    
                                 @if($module['module_name'] == 22)
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-user-plus rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="{{url('org-user-check-employee')}}">Employee Hub</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="{{url('org-user-check-employee')}}" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-user-plus rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">Employee Hub</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif  
                                 @endforeach
                                 @foreach($sidebarItems as $module)   
                                 @if($module['module_name'] == 23)
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-book rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="{{url('rota-org/visitor-dashboard')}}">Visitor Register</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="{{url('rota-org/visitor-dashboard')}}" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @else
                                 <div class="col-xl-4 col-md-6 col-sm-12">
                                    <div class="card border-0">
                                       <div class="alert alert-primary border border-primary mb-0 p-3">
                                          <div class="d-flex align-items-start">
                                             <div class="text-primary w-100">
                                                <i class="fas fa-book rota-icon-size-fixed"></i>
                                                <div class="fw-semibold d-flex justify-content-between text-card-size-fixed">
                                                   <a href="#">Visitor Register</a>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center">
                                                   <div class="fs-12"></div>
                                                   <div class="fs-12">
                                                      <a href="#" class="text-primary fw-semibold">
                                                      <i class="fa fa-arrow-circle-right fixed-card"></i> View all
                                                      </a>
                                                   </div>
                                                </div>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 @endif
                                 {{-- 
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
                  --}}
                  @endforeach
               </div>
            </div>
         </div>
      </div>
      <!-- Other Model -->
   </div>
</div>
<!-- /Page Content -->
@endsection