@extends('employeer.include.app')
@section('title', 'Home - Organization Dashboard')
@php
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
$user_type = Session::get("user_type");
//dd($sidebarItems);
@endphp
@section('css')
<style>
   /* Main Container */
   .post-container {
   background: #f5f7fa;
   border-radius: 12px;
   box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
   overflow: hidden;
   height: 100%;
   display: flex;
   flex-direction: column;
   }
   /* Fixed Header */
   .post-header-container {
   background: #ffffff;
   padding: 16px 20px;
   border-bottom: 1px solid #e4e6eb;
   position: sticky;
   top: 0;
   z-index: 10;
   }
   .post-add {
   display: flex;
   justify-content: space-between;
   align-items: center;
   }
   .post-title {
   font-size: 18px;
   font-weight: 600;
   color: #050505;
   margin: 0;
   }
   .add-post-btn {
   display: flex;
   align-items: center;
   gap: 8px;
   color: #1877f2;
   text-decoration: none;
   font-weight: 500;
   padding: 8px 12px;
   border-radius: 6px;
   transition: background 0.2s;
   }
   .add-post-btn:hover {
   background: rgba(24, 119, 242, 0.1);
   }
   .add-post-btn i {
   font-size: 16px;
   }
   /* Scrollable Content */
   /* .post-scroll-container {
   flex: 1;
   overflow-y: auto;
   padding: 0 16px;
   } */
   #post-scroll-container {
   max-height: 90vh; 
   overflow-y: auto;
   padding-right: 2px; 
   scrollbar-width: thin;
   scrollbar-color: #ff9900 #fcfcfb;
   }
   /* Post Card */
   .post-card {
   background: #ffffff;
   border-radius: 8px;
   margin: 16px 0;
   box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
   }
   /* Post Header */
   .post-header {
   display: flex;
   justify-content: space-between;
   align-items: center;
   padding: 12px 16px;
   }
   .user-info {
   display: flex;
   align-items: center;
   gap: 12px;
   }
   .post-avatar {
   width: 40px;
   height: 40px;
   border-radius: 50%;
   object-fit: cover;
   border: 2px solid #e4e6eb;
   }
   .user-details {
   display: flex;
   flex-direction: column;
   }
   .post-username {
   font-size: 15px;
   font-weight: 600;
   margin: 0;
   color: #050505;
   }
   .post-timestamp {
   font-size: 12px;
   color: #65676b;
   margin-top: 2px;
   }
   .post-options {
   background: none;
   border: none;
   color: #65676b;
   font-size: 16px;
   cursor: pointer;
   padding: 8px;
   border-radius: 50%;
   transition: background 0.2s;
   }
   .post-options:hover {
   background: rgba(0, 0, 0, 0.05);
   }
   /* Post Content */
   .post-content-container {
   padding: 0 16px 12px;
   }
   .post-content {
   font-size: 15px;
   line-height: 1.4;
   color: #050505;
   margin: 0 0 12px 0;
   }
   .post-image-container {
   border-radius: 8px;
   overflow: hidden;
   margin-top: 12px;
   }
   .post-image {
   width: 100%;
   max-height: 500px;
   object-fit: cover;
   display: block;
   }
   /* Post Stats */
   .post-stats {
   padding: 10px 16px;
   border-top: 1px solid #e4e6eb;
   border-bottom: 1px solid #e4e6eb;
   }
   .stats-content {
   display: flex;
   justify-content: space-between;
   align-items: center;
   font-size: 14px;
   color: #65676b;
   }
   .likes-count, .comments-count {
   display: flex;
   align-items: center;
   gap: 6px;
   }
   .like-count-badge {
   background: #1877f2;
   color: white;
   width: 18px;
   height: 18px;
   border-radius: 50%;
   display: flex;
   align-items: center;
   justify-content: center;
   font-size: 10px;
   }
   /* Action Buttons */
   .post-actions {
   padding: 8px 0;
   display: flex;
   border-bottom: 1px solid #e4e6eb;
   }
   .btn-action {
   flex: 1;
   background: none;
   border: none;
   padding: 8px 0;
   font-size: 14px;
   color: #65676b;
   cursor: pointer;
   display: flex;
   align-items: center;
   justify-content: center;
   gap: 8px;
   border-radius: 4px;
   transition: background 0.2s;
   }
   .btn-action:hover {
   background: rgba(0, 0, 0, 0.05);
   }
   .btn-action i {
   font-size: 16px;
   }
   .like-btn.liked {
   color: #1877f2;
   }
   .like-btn.liked i {
   font-weight: 900;
   }
   /* Comments Section */
   .post-comments {
   padding: 12px 16px;
   display: none; /* Initially hidden */
   }
   .comment-item {
   display: flex;
   gap: 8px;
   margin-bottom: 12px;
   }
   .comment-avatar {
   width: 32px;
   height: 32px;
   border-radius: 50%;
   object-fit: cover;
   flex-shrink: 0;
   }
   .comment-bubble {
   flex: 1;
   }
   .comment-header {
   display: flex;
   align-items: center;
   gap: 8px;
   margin-bottom: 4px;
   }
   .comment-username {
   font-size: 13px;
   font-weight: 600;
   margin: 0;
   color: #050505;
   }
   .comment-time {
   font-size: 11px;
   color: #65676b;
   }
   .comment-text {
   font-size: 14px;
   color: #050505;
   margin: 0;
   line-height: 1.4;
   }
   /* Add Comment */
   .add-comment {
   padding: 12px 16px;
   border-top: 1px solid #e4e6eb;
   display: flex;
   gap: 8px;
   align-items: center;
   }
   .comment-form {
   flex: 1;
   display: flex;
   gap: 8px;
   }
   .comment-input {
   flex: 1;
   border: 1px solid #e4e6eb;
   border-radius: 18px;
   padding: 8px 12px;
   font-size: 14px;
   outline: none;
   transition: border 0.2s;
   }
   .comment-input:focus {
   border-color: #1877f2;
   }
   .comment-post-btn {
   background: #1877f2;
   color: white;
   border: none;
   border-radius: 18px;
   padding: 8px 16px;
   font-size: 14px;
   font-weight: 500;
   cursor: pointer;
   transition: background 0.2s;
   }
   .comment-post-btn:hover {
   background: #166fe5;
   }
   /* Show comments when active */
   .post-card.active .post-comments {
   display: block;
   }
   /*--------------- Edit and delete button css -------------*/
   .post-options-container {
   position: relative;
   display: inline-block;
   }
   .post-options {
   background: none;
   border: none;
   color: #666;
   cursor: pointer;
   padding: 5px 10px;
   font-size: 16px;
   }
   .post-options:hover {
   color: #333;
   }
   .options-dropdown {
   display: none;
   position: absolute;
   right: 0;
   background-color: #fff;
   min-width: 120px;
   box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.1);
   border-radius: 4px;
   z-index: 1;
   padding: 5px 0;
   }
   .options-dropdown button {
   width: 100%;
   text-align: left;
   padding: 8px 16px;
   background: none;
   border: none;
   color: #333;
   cursor: pointer;
   font-size: 14px;
   display: flex;
   align-items: center;
   gap: 8px;
   }
   .options-dropdown button:hover {
   background-color: #f5f5f5;
   }
   .options-dropdown button i {
   width: 16px;
   text-align: center;
   }
   .show-dropdown {
   display: block;
   }
   .edit-post-btn i {
   color: #46a1f7; /* Green icon */
   }
   .delete-post-btn i {
   color: #fa5305; /* Red icon */
   }
   /*--------------- End Edit and delete button css -------------*/
   .btn-reply {
   background: none;
   border: none;
   color: #999;
   font-size: 11px;
   padding: 2px;
   cursor: pointer;
   margin-top: 3px;
   }
   .btn-reply:hover {
   color: #555;
   }
</style>
@endsection
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row">
         <div class="col-sm-12">
            <h3 class="page-title">
               {{\App\Helpers\Helper::cachedTrans('Welcome')}}
               {{ \App\Helpers\Helper::cachedTrans(ucwords($Roledata->com_name ?? "NA") )}}!
            </h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item active">
                  {{\App\Helpers\Helper::cachedTrans('Dashboard')}}
               </li>
            </ul>
         </div>
      </div>
   </div>
   <!-- /Page Header -->
   <div class="row">
      <!--<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">-->
      <!--    <div class="card dash-widget">-->
      <!--        <div class="card-body">-->
      <!--            <span class="dash-widget-icon"><i class="fa-solid fa-user"></i></span>-->
      <!--            <div class="dash-widget-info">-->
      <!--                <h3>{{$employee_count ?? 0}}</h3>-->
      <!--                <span>Active Employees</span>-->
      <!--            </div>-->
      <!--            <div class="arrow-icon pt-2" style="text-align: center; margin-top: -10px;">-->
      <!--                <a href="{{url('organization/employeeee')}}">-->
      <!--                    <span class="p-2"style=" color: #fd9330;">View</span><i class="fa-solid fa-arrow-right" style=" color: #fd9330;"></i>-->
      <!--                </a>-->
      <!--            </div>-->
      <!--        </div>-->
      <!--    </div>-->
      <!--</div>-->
      <!-- <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">-->
      <!--    <div class="card dash-widget">-->
      <!--        <div class="card-body">-->
      <!--            <span class="dash-widget-icon">-->
      <!--                <i class="fa-solid fa-user"></i>-->
      <!--            </span>-->
      <!--            <div class="dash-widget-info">-->
      <!--                <h3>{{$inactive_employee ?? 0}}</h3>-->
      <!--                <span>Inactive Employees</span>-->
      <!--            </div>-->
      <!--            <div class="arrow-icon pt-2" style="text-align: center; margin-top: -10px;">-->
      <!--                <a href="{{url('organization/inactiveEmployee')}}">-->
      <!--                    <span class="p-2"style=" color: #fd9330;">View</span><i class="fa-solid fa-arrow-right" style=" color: #fd9330;"></i>-->
      <!--                </a>-->
      <!--            </div>-->
      <!--        </div>-->
      <!--    </div>-->
      <!--</div>-->
      <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
         <div class="card dash-widget">
            <a href="{{url('org-settings/vw-department')}}">
               <div class="card-body">
                  <div class="dash-widget-info">
                     <span>{{\App\Helpers\Helper::cachedTrans('Total Departments')}}</span>
                     <h3>{{\App\Helpers\Helper::cachedTrans($department_count ?? 0 )}}</h3>
                  </div>
                  <span class="dash-widget-icon"><i class="fa-solid fa-cubes"></i></span>
                  <div class="arrow-icon pt-2" style="text-align: center; margin-top: -10px;">
                     <span><span>{{\App\Helpers\Helper::cachedTrans('View')}}</span></span><i class="fa-solid fa-arrow-right"></i>
                  </div>
               </div>
            </a>
         </div>
      </div>
      <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
         <div class="card dash-widget">
            <a href="{{url('org-dashboard-migrant-employees')}}">
               <div class="card-body">
                  <div class="dash-widget-info">
                     <span>{{\App\Helpers\Helper::cachedTrans('Migrants Employees')}}</span>
                     <h3>{{\App\Helpers\Helper::cachedTrans($migrant_emp_count ?? 0)}}</h3>
                  </div>
                  <span class="dash-widget-icon"><i class="fa-solid fa-dollar-sign"></i></span>
                  <div class="arrow-icon pt-2" style="text-align: center; margin-top: -10px;">
                     <span>{{\App\Helpers\Helper::cachedTrans('View')}}</span><i class="fa-solid fa-arrow-right"></i>
                  </div>
               </div>
            </a>
         </div>
      </div>
      <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
         <div class="card dash-widget">
            <a href="{{url('recruitment/job_list')}}">
               <div class="card-body">
                  <div class="dash-widget-info">
                     <span>{{\App\Helpers\Helper::cachedTrans('Total Job Types')}}</span>
                     <h3>{{\App\Helpers\Helper::cachedTrans($job_type_count ?? 0)}}</h3>
                  </div>
                  <span class="dash-widget-icon"><i class="fa-regular fa-gem"></i></span>
                  <div class="arrow-icon pt-2" style="text-align: center; margin-top: -10px;">
                     <span>{{\App\Helpers\Helper::cachedTrans('View')}}</span><i class="fa-solid fa-arrow-right"></i>
                  </div>
               </div>
            </a>
         </div>
      </div>
      <div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
         <div class="card dash-widget">
            <a href="{{url('billing/list')}}">
               <div class="card-body">
                  <div class="dash-widget-info">
                     <span>{{\App\Helpers\Helper::cachedTrans('Billing')}}</span>
                     <h3>{{\App\Helpers\Helper::cachedTrans($paid_amount ?? 0)}}</h3>
                  </div>
                  <span class="dash-widget-icon"><i class="fa-regular fa-gem"></i></span>
                  <div class="arrow-icon pt-2" style="text-align: center; margin-top: -10px;">
                     <span>{{\App\Helpers\Helper::cachedTrans('View')}}</span><i class="fa-solid fa-arrow-right"></i>
                  </div>
               </div>
            </a>
         </div>
      </div>
   </div>
   <div class="row staff-grid-row">
      <div class="col-lg-8 col-md-12 col-12">
         <div class="row">
            <div class="col-xl-4 col-md-6 col-sm-12">
               <a href="{{ url('organization/profile') }}" class="text-primary fw-semibold editProfile_tab">
                  <div class="card border-0">
                     <div class="alert mb-0 dashboard-card">
                        <div class="position-absolute abstract" style="z-index: 0;">
                           <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                              <style>
                                 .s0 {
                                 opacity: .05;
                                 fill: var(--vz-success)
                                 }
                              </style>
                              <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                           </svg>
                        </div>
                        <div class="d-flex align-items-start">
                           <div class="text-primary w-100 db-box">
                              <div class="img-box">
                                 <i class="fa fa-user-edit "></i>
                              </div>
                              <div class="img-box-text">
                                 <div class="fw-semibold d-flex text-card-size-fixed mb-1">{{\App\Helpers\Helper::cachedTrans('Profile')}}</div>
                                 <div class="d-flex align-items-center">
                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                    <div class="fs-12 edit_profile">
                                       {{\App\Helpers\Helper::cachedTrans('Edit')}} <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="fa fa-arrow-circle-right" data-bs-original-title="fa fa-arrow-circle-right"></i>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
               <a href="{{ url('employees-according-to-rti') }}" class="text-primary fw-semibold editProfile_tab">
                  <div class="card border-0">
                     <div class="alert mb-0 dashboard-card">
                        <div class="position-absolute abstract" style="z-index: 0;">
                           <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                              <style>
                                 .s0 {
                                 opacity: .05;
                                 fill: var(--vz-success);
                                 }
                              </style>
                              <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                           </svg>
                        </div>
                        <div class="d-flex align-items-start">
                           <div class="text-primary w-100 db-box">
                              <div class="img-box">
                                 <i class="fa fa-users"></i>
                              </div>
                              <div class="img-box-text">
                                 <div class="fw-semibold d-flex text-card-size-fixed mb-1">{{\App\Helpers\Helper::cachedTrans('Employees (RTI)')}}</div>
                                 <div class="d-flex align-items-center">
                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                    <div class="fs-12 edit_profile">
                                       <span>{{\App\Helpers\Helper::cachedTrans('View all')}}</span>
                                       <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="View all" data-bs-original-title="View all"></i>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
               <a href="{{ url('authorizing-officer') }}" class="text-primary fw-semibold editProfile_tab">
                  <div class="card border-0">
                     <div class="alert mb-0 dashboard-card">
                        <div class="position-absolute abstract" style="z-index: 0;">
                           <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                              <style>
                                 .s0 {
                                 opacity: .05;
                                 fill: var(--vz-success);
                                 }
                              </style>
                              <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                           </svg>
                        </div>
                        <div class="d-flex align-items-start">
                           <div class="text-primary w-100 db-box">
                              <div class="img-box">
                                 <i class="fa fa-user-tie"></i>
                              </div>
                              <div class="img-box-text">
                                 <div class="fw-semibold d-flex text-card-size-fixed mb-1">{{\App\Helpers\Helper::cachedTrans('Authorizing Officer')}}</div>
                                 <div class="d-flex align-items-center">
                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                    <div class="fs-12 edit_profile">
                                       <span>{{\App\Helpers\Helper::cachedTrans('View all')}}</span>
                                       <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="View all" data-bs-original-title="View all"></i>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
               <a href="{{ url('key-contact') }}" class="text-primary fw-semibold editProfile_tab">
                  <div class="card border-0">
                     <div class="alert mb-0 dashboard-card">
                        <div class="position-absolute abstract" style="z-index: 0;">
                           <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                              <style>
                                 .s0 {
                                 opacity: .05;
                                 fill: var(--vz-success);
                                 }
                              </style>
                              <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                           </svg>
                        </div>
                        <div class="d-flex align-items-start">
                           <div class="text-primary w-100 db-box">
                              <div class="img-box">
                                 <i class="fa fa-id-badge"></i>
                              </div>
                              <div class="img-box-text">
                                 <div class="fw-semibold d-flex text-card-size-fixed mb-1">{{\App\Helpers\Helper::cachedTrans('Key Contact')}}</div>
                                 <div class="d-flex align-items-center">
                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                    <div class="fs-12 edit_profile">
                                       <span>{{\App\Helpers\Helper::cachedTrans('View all')}}</span>
                                       <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="View all" data-bs-original-title="View all"></i>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
               <a href="{{ url('level-1-user') }}" class="text-primary fw-semibold editProfile_tab">
                  <div class="card border-0">
                     <div class="alert mb-0 dashboard-card">
                        <div class="position-absolute abstract" style="z-index: 0;">
                           <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                              <style>
                                 .s0 {
                                 opacity: .05;
                                 fill: var(--vz-success);
                                 }
                              </style>
                              <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                           </svg>
                        </div>
                        <div class="d-flex align-items-start">
                           <div class="text-primary w-100 db-box">
                              <div class="img-box">
                                 <i class="fa fa-user-shield"></i>
                              </div>
                              <div class="img-box-text">
                                 <div class="fw-semibold d-flex text-card-size-fixed mb-1"> {{\App\Helpers\Helper::cachedTrans('Level 1 User')}}</div>
                                 <div class="d-flex align-items-center">
                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                    <div class="fs-12 edit_profile">
                                       <span>{{\App\Helpers\Helper::cachedTrans('View all')}}</span>
                                       <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="View all" data-bs-original-title="View all"></i>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
               <a href="{{ url('level-2-user') }}" class="text-primary fw-semibold editProfile_tab">
                  <div class="card border-0">
                     <div class="alert mb-0 dashboard-card">
                        <div class="position-absolute abstract" style="z-index: 0;">
                           <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                              <style>
                                 .s0 {
                                 opacity: .05;
                                 fill: var(--vz-success);
                                 }
                              </style>
                              <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                           </svg>
                        </div>
                        <div class="d-flex align-items-start">
                           <div class="text-primary w-100 db-box">
                              <div class="img-box">
                                 <i class="fa fa-user-cog"></i>
                              </div>
                              <div class="img-box-text">
                                 <div class="fw-semibold d-flex text-card-size-fixed mb-1"> {{\App\Helpers\Helper::cachedTrans('Level 2 User')}}</div>
                                 <div class="d-flex align-items-center">
                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                    <div class="fs-12 edit_profile">
                                       <span>{{\App\Helpers\Helper::cachedTrans('View all')}}</span>
                                       <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="View all" data-bs-original-title="View all"></i>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-xl-4 col-md-6 col-sm-12">
               <a href="{{ url('org-dashboarddetails') }}" class="text-primary fw-semibold editProfile_tab">
                  <div class="card border-0">
                     <div class="alert mb-0 dashboard-card">
                        <div class="position-absolute abstract" style="z-index: 0;">
                           <svg version="1.2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 200 120" width="200" height="120">
                              <style>
                                 .s0 {
                                 opacity: .05;
                                 fill: var(--vz-success);
                                 }
                              </style>
                              <path id="Shape 8" class="s0" d="m189.5-25.8c0 0 20.1 46.2-26.7 71.4 0 0-60 15.4-62.3 65.3-2.2 49.8-50.6 59.3-57.8 61.5-7.2 2.3-60.8 0-60.8 0l-11.9-199.4z"></path>
                           </svg>
                        </div>
                        <div class="d-flex align-items-start">
                           <div class="text-primary w-100 db-box">
                              <div class="img-box">
                                 <i class="fa fa-check-circle"></i>
                              </div>
                              <div class="img-box-text">
                                 <div class="fw-semibold d-flex text-card-size-fixed mb-1"> {{\App\Helpers\Helper::cachedTrans('Sponsor Compliance')}}</div>
                                 <div class="d-flex align-items-center">
                                    <div class="fs-12 op-8 mb-1 text-card-size-fixed fixed-12"></div>
                                    <div class="fs-12 edit_profile">
                                       <span> {{\App\Helpers\Helper::cachedTrans('View all')}}</span>
                                       <i class="fa fa-arrow-circle-right fixed-card" data-bs-toggle="tooltip" aria-label="View all" data-bs-original-title="View all"></i>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </a>
            </div>
            <div class="col-12">
               <div class="col-lg-12 col-md-12 col-12 d-flex">
                  <div class="card flex-fill">
                     <div class="card-body">
                        <div class="statistic-header">
                           <h4>{{\App\Helpers\Helper::cachedTrans('Important')}}</h4>
                           {{-- 
                           <div class="important-notification">
                              <a href="#">
                              View All <i class="fe fe-arrow-right-circle"></i>
                              </a>
                           </div>
                           --}}
                        </div>
                        <div class="notification-tab">
                           <ul class="nav nav-tabs">
                              <li>
                                 <a href="#" class="active" data-bs-toggle="tab" data-bs-target="#notification_tab">
                                 <i class="la la-bell"></i> {{\App\Helpers\Helper::cachedTrans('Notifications')}}
                                 </a>
                              </li>
                           </ul>
                           <div class="tab-content">
                              <div class="tab-pane active" id="notification_tab">
                                 <div class="employee-noti-content" style="max-height: 380px; overflow-y: auto;">
                                    <ul class="employee-notification-list">
                                       @foreach($notices as $notice)
                                       <li class="employee-notification-grid">
                                          <div class="employee-notification-icon">
                                             {{-- <a href="#">
                                             <span class="badge-soft-danger rounded-circle">{{ $notice->title }}</span>
                                             </a> --}}
                                             <a href="{{ asset('storage/' . $notice->image) }}" target="_blank">
                                             <span class="badge-soft-danger rounded-circle">{{ \App\Helpers\Helper::cachedTrans($notice->title) }}</span>
                                             </a>
                                          </div>
                                          <div class="employee-notification-content">
                                             <h6>
                                                <a href="#">{{ \App\Helpers\Helper::cachedTrans(strip_tags($notice->description) )}}</a>
                                             </h6>
                                             <ul class="nav">
                                                <li>{{ \Carbon\Carbon::parse($notice->start_date)->format('d-m-Y') }}</li>
                                                <li>{{ \Carbon\Carbon::parse($notice->end_date)->format('d-m-Y') }}</li>
                                             </ul>
                                          </div>
                                       </li>
                                       @endforeach
                                    </ul>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               {{-- Message Center start --}}
               {{-- <div class="col-xl-12 col-md-12 d-flex">
                  <div class="card employee-month-card flex-fill">
                     <div class="card-body">

                           <h4 class="mb-3">
                              {{ \App\Helpers\Helper::cachedTrans('Message Center') }}
                           </h4>

                           <div class="list-group">

                              <!-- Group 1 -->
                              <a href="javascript:void(0)"
                                 class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                 <div class="d-flex align-items-center">
                                       <div class="avatar bg-primary text-white rounded-circle me-3"
                                          style="width:45px;height:45px;display:flex;align-items:center;justify-content:center;">
                                          H
                                       </div>
                                       <div>
                                          <h6 class="mb-0">HRMS Project</h6>
                                          <small class="text-muted">Please update task status</small>
                                       </div>
                                 </div>
                                 <div class="text-end">
                                       <small class="text-muted d-block">10:45 AM</small>
                                       <span class="badge bg-success rounded-pill">3</span>
                                 </div>
                              </a>

                              <!-- Group 2 -->
                              <a href="javascript:void(0)"
                                 class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                 <div class="d-flex align-items-center">
                                       <div class="avatar bg-warning text-white rounded-circle me-3"
                                          style="width:45px;height:45px;display:flex;align-items:center;justify-content:center;">
                                          P
                                       </div>
                                       <div>
                                          <h6 class="mb-0">Payroll Team</h6>
                                          <small class="text-muted">Salary sheet approved</small>
                                       </div>
                                 </div>
                                 <div class="text-end">
                                       <small class="text-muted d-block">Yesterday</small>
                                 </div>
                              </a>

                              <!-- Group 3 -->
                              <a href="javascript:void(0)"
                                 class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                 <div class="d-flex align-items-center">
                                       <div class="avatar bg-success text-white rounded-circle me-3"
                                          style="width:45px;height:45px;display:flex;align-items:center;justify-content:center;">
                                          J
                                       </div>
                                       <div>
                                          <h6 class="mb-0">JetSki Booking</h6>
                                          <small class="text-muted">Client confirmed booking</small>
                                       </div>
                                 </div>
                                 <div class="text-end">
                                       <small class="text-muted d-block">09:15 AM</small>
                                       <span class="badge bg-success rounded-pill">5</span>
                                 </div>
                              </a>

                              <!-- Group 4 -->
                              <a href="javascript:void(0)"
                                 class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">
                                 <div class="d-flex align-items-center">
                                       <div class="avatar bg-danger text-white rounded-circle me-3"
                                          style="width:45px;height:45px;display:flex;align-items:center;justify-content:center;">
                                          D
                                       </div>
                                       <div>
                                          <h6 class="mb-0">Design Team</h6>
                                          <small class="text-muted">UI finalized</small>
                                       </div>
                                 </div>
                                 <div class="text-end">
                                       <small class="text-muted d-block">Monday</small>
                                 </div>
                              </a>

                           </div>

                     </div>
                  </div>
               </div> --}}
               {{-- task summery Start --}}
               <div class="col-xl-12 col-md-12 d-flex">
                  <div class="card flex-fill" style="background-color: #f7ede0" >
                     <div class="card-header">
                        <h4 class="text-left">Task Summary</h4>
                     </div>
                     <div class="card-body">
                        <div class="table-responsive">
                           <table class="table table-striped custom-table" >
                              <thead>
                                 <tr>
                                    <th> {{\App\Helpers\Helper::cachedTrans('Sl No.')}} </th>
                                    <th style="color: blue;"> {{\App\Helpers\Helper::cachedTrans('Project Name')}} </th>
                                    <th style="color: red;"> {{\App\Helpers\Helper::cachedTrans('In-completed Tasks')}} </th>
                                    <th style="color: green;"> {{\App\Helpers\Helper::cachedTrans('Completed Tasks')}} </th>
                                    <th style="color: blue;">{{\App\Helpers\Helper::cachedTrans('Total Task')}}</th>
                                 </tr>
                              </thead>
                              <tbody>
                                 @forelse($p_summary as $key => $group)
                                 <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <td style="color: blue;">
                                       {{ $group->title ?? 'N/A' }}
                                    </td>

                                    <td>
                                       <a style="color: red;" href="{{ url('/org-task-management/'.encrypt($group->project_id).'/task-summary') }}">
                                             {{ $group->incomplete_tasks }}
                                       </a>
                                    </td>

                                    <td>
                                       <a style="color: green;" href="{{ url('/org-task-management/'.encrypt($group->project_id).'/task-summary') }}">
                                             {{ $group->completed_tasks }}
                                       </a>
                                    </td>

                                    <td style="color: blue;">
                                       {{ $group->total_tasks }}
                                    </td>
                                 </tr>
                                 @empty
                                 <tr>
                                    <td colspan="5">No project messages yet</td>
                                 </tr>
                                 @endforelse
                                 </tbody>
                           </table>
                        </div>  
                     </div>
                  </div>      
               </div>   
               {{-- task summery end --}}
               <div class="col-xl-12 col-md-12 d-flex">
                  <div class="card employee-month-card flex-fill">
                     <div class="card-body">

                           <h4 class="mb-3">
                              {{ \App\Helpers\Helper::cachedTrans('Message Center') }}
                           </h4>

                           <div class="list-group">

                              @forelse($projectData as $group)
                              {{-- <h1>{{$group['project_id']}}</h1> --}}
                              <a href="{{url('/org-task-management/'.encrypt($group['project_id']).'/chat')}}"
                                 class="list-group-item list-group-item-action d-flex justify-content-between align-items-center">

                                 <div class="d-flex align-items-center">
                                       <!-- Avatar -->
                                       <div class="avatar bg-primary text-white rounded-circle me-3"
                                          style="width:45px;height:45px;display:flex;align-items:center;justify-content:center;">
                                          {{ strtoupper(substr($group['project_name'], 0, 1)) }}
                                       </div>

                                       <!-- Project Info -->
                                       <div>
                                          <h6 class="mb-0">{{ $group['project_name'] }}</h6>
                                          <small class="text-muted">
                                             {{ $group['employee'] }}
                                             @if($group['employee']) :
                                             @endif
                                             {{ $group['last_message'] }}
                                          </small>
                                       </div>
                                 </div>

                                 <!-- Time -->
                                 <div class="text-end">
                                       <small class="text-muted d-block">
                                          {{ $group['time'] }}
                                       </small>
                                 </div>

                              </a>
                              @empty
                              <div class="text-center text-muted p-3">
                                 No project messages yet
                              </div>
                              @endforelse

                           </div>

                     </div>
                  </div>
               </div>


               {{-- @if(!$employee_birth->isEmpty())
               <div class="col-xl-12 col-md-12 d-flex">
                  <div class="card employee-month-card flex-fill" style="height: 200px;">
                     <div class="card-body">
                        <div class="row align-items-center">
                           <div class="col-lg-9 col-md-12">
                              <div class="employee-month-details">
                                 <h4> {{\App\Helpers\Helper::cachedTrans('Birthday Employee')}}</h4>
                                 <p> {{\App\Helpers\Helper::cachedTrans('We are proud to celebrate your birthday today!')}}</p>
                              </div>
                              <div class="employee-month-content">
                                 <h6> {{\App\Helpers\Helper::cachedTrans('Happy Birthday,')}} 
                                    @foreach($employee_birth as $emp)
                                    {{ $emp->emp_fname }} {{ $emp->emp_lname }}@if(!$loop->last), @endif
                                    @endforeach
                                 </h6>
                                 <!-- Assuming the first employee's designation will be shown, or you can adjust this -->
                                 <p>{{ $employee_birth->first()->emp_designation ?? 'Employee' }}</p>
                              </div>
                           </div>
                           @if($employee_birth->count() == 1)
                           <div class="col-lg-3 col-md-12">
                              <div class="employee-month-img">
                                 <a href="{{ asset('storage/app/public/' . $employee_birth->first()->emp_image) }}" class="avatar" target="_blank">
                                 <img src="{{ asset('storage/app/public/' . $employee_birth->first()->emp_image) }}" alt="Employee Image">
                                 </a>
                              </div>
                           </div>
                           @endif
                        </div>
                     </div>
                  </div>
               </div>
               @else
               <div class="col-xl-12 col-md-12 d-flex">
                  <div class="card employee-month-card flex-fill" style="height: 200px;">
                     <div class="card-body">
                        <div class="row align-items-center">
                           <div class="col-lg-9 col-md-12">
                              <div class="employee-month-details">
                                 <h4>{{ \App\Helpers\Helper::cachedTrans('Birthday Employee') }}</h4>
                                 <p>{{ \App\Helpers\Helper::cachedTrans('No birthdays today.') }}</p>
                              </div>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
               @endif --}}
            </div>
         </div>
      </div>
      <div class="col-lg-4 col-md-12 col-12 d-flex">
      
        <div class="card flex-fill">
            <div class="post-container">
                <!-- Fixed Header Section -->
                <div class="post-header-container">
                    <div class="post-add">
                        <h4 class="post-title">All Posts</h4>
                        <a href="#" class="add-post-btn">
                            <i class="fas fa-plus-circle"></i> Add Post
                        </a>
                    </div>
                </div>
                
                <!-- Scrollable Content -->
                <div class="post-scroll-container" id="post-scroll-container">
                    @foreach($posts as $post)
                    <!-- Post Card -->
                    <div class="post-card">
                        <!-- Post Header -->
                        <div class="post-header">
                            <div class="user-info">
                                <img src="{{ $post->employee_image ? asset($post->employee_image) : asset('user.png') }}" alt="{{ $post->employee_name }}" class="post-avatar">
                                <div class="user-details">
                                    <h5 class="post-username">{{ $post->employee_name }}</h5>
                                    <small class="post-timestamp">{{ $post->time_ago }}</small>
                                    <small class="post-designation">{{ $post->designation }}</small>
                                </div>
                            </div>
                            {{-- @if($Roledata->reg === $post->emid) --}}
                            <div class="post-options-container">
                                <button class="post-options" onclick="toggleOptions(this)">
                                    <i class="fas fa-ellipsis-h"></i>
                                </button>
                                
                                <div class="options-dropdown">
                                    <button class="edit-post-btn " 
                                            data-post-id="{{ $post->id }}"
                                            data-employee-code="{{ $post->employee_code }}"
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editPostModal">
                                        <i class="fas fa-edit"></i> Edit
                                    </button>
                                        
                                    <button class="delete-post-btn" onclick="window.location.href='{{ route('posts.delete', ['id' => $post->id, 'emp_id' => $post->employee_code]) }}'">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </div>
                            </div>
                            {{-- @endif --}}
                        </div>

                        <!-- Post Content -->
                        <div class="post-content-container">
                            <p class="post-content">{{ $post->title }}</p>
                            
                            @if($post->image_path)
                            <!-- Post Image -->
                            <div class="post-image-container">
                                <img src="{{ $post->image_path }}" 
                                    alt="Post content" 
                                    class="post-image">
                            </div>
                            @endif
                        </div>

                        <!-- Likes and Comments Count -->
                        <div class="post-stats">
                            <div class="stats-content">
                                <div class="likes-count">
                                    <span class="like-count-badge">
                                        <i class="fas fa-thumbs-up"></i>
                                    </span>
                                    <span>{{ $post->likes_count }}</span>
                                </div>
                                <div class="comments-count">
                                    <span>{{ $post->comments_count }} comment{{ $post->comments_count != 1 ? 's' : '' }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="post-actions">
                            {{-- <button class="btn-action like-btn" data-post-id="{{ $post->id }}">
                                <i class="far fa-thumbs-up"></i>
                                Like
                            </button> --}}
                            <button class="btn-action like-btn {{ $post->is_liked ? 'liked' : '' }}" 
                                    data-post-id="{{ $post->id }}">
                                <i class="{{ $post->is_liked ? 'fas' : 'far' }} fa-thumbs-up"></i>
                                {{ $post->is_liked ? 'Liked' : 'Like' }}
                            </button>
                            <button class="btn-action comment-toggle-btn">
                                <i class="fas fa-comment"></i>
                                Comment
                            </button>
                        </div>

                        <!-- Comments Section -->
                            <div class="post-comments">
                                @foreach($post->comments as $comment)
                                    <div class="comment-item">
                                        <img src="{{ $comment->commenter_image ? $comment->commenter_image : asset('assets/img/user.png') }}" 
                                            alt="{{ $comment->commenter_name }}" 
                                            class="comment-avatar">
                                        <div class="comment-bubble">
                                            <div class="comment-header">
                                                <h6 class="comment-username">{{ $comment->commenter_name }}</h6>
                                                <small class="comment-time">{{ $comment->time_ago }}</small>
                                            </div>
                                            <p class="comment-text">{{ $comment->comment_text }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        <!-- Add Comment -->
                        <div class="add-comment">
                            <img src="{{asset('assets/img/user.png')}}" alt="You" class="comment-avatar">
                            <form class="comment-form" data-post-id="{{ $post->id }}">
                                @csrf
                                <div class="comment-form">
                                    <input type="hidden" name="post_id" value="{{ $post->id }}">
                                    <input type="text" placeholder="Write a comment..." class="comment-input" name="comment_text" required>
                                    <button type="submit" class="comment-post-btn">Post</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Add this modal HTML right after your post-container div -->
        <div class="modal fade" id="addPostModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Create New Post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="postForm" method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="form-group mb-3">
                                <textarea class="form-control @error('content') is-invalid @enderror" 
                                        id="postContent" name="content" rows="5" 
                                        placeholder="What's on your mind?" required>{{ old('content') }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-group mb-3">
                                <label for="postFile">Add File (Optional - Images, PDF, Word, Video)</label>
                                <input type="file" class="form-control @error('post_file') is-invalid @enderror" 
                                    id="postFile" name="post_file"
                                    accept="image/*,.pdf,.doc,.docx,video/*">
                                @error('post_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Max file size: 10MB | Allowed formats: JPEG, PNG, GIF, PDF, DOC, DOCX, MP4, MOV, AVI</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Post</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
            <!------------end create post model ------------------>
            <!-- Edit Modal -->
        <div class="modal fade" id="editPostModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Post</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editPostForm" method="post" action="{{ route('posts.update') }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="post_id" id="editPostId">
                            <input type="hidden" name="remove_file" id="removeFileFlag" value="0">

                            <div class="form-group mb-3">
                                <textarea class="form-control" id="editPostContent" name="content" rows="5" required></textarea>
                                <div class="invalid-feedback"></div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="editPostFile">Update File</label>
                                <input type="file" class="form-control" id="editPostFile" name="post_file"
                                    accept="image/*,.pdf,.doc,.docx,video/*">
                                <small class="text-muted">Max file size: 10MB | Allowed formats: JPEG, PNG, GIF, PDF, DOC, DOCX, MP4, MOV, AVI</small>
                                
                                <div id="currentFileContainer" class="mt-3" style="display:none;">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <strong>Current File:</strong>
                                        <button type="button" id="removeFileBtn" class="btn btn-sm btn-danger">Remove File</button>
                                    </div>
                                    <div id="currentFilePreview" class="mt-2"></div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Update Post</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
					
      </div>
   </div>
</div>
<!-- /Page Content -->
@endsection

@section('script')
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Toggle comments
		document.querySelectorAll('.comment-toggle-btn').forEach(button => {
			button.addEventListener('click', function() {
				const postCard = this.closest('.post-card');
				postCard.classList.toggle('active');
				
				// Update button text
				const isActive = postCard.classList.contains('active');
				if(isActive){
					this.innerHTML = `<i class="fas fa-comment primary" style="color:blue;"></i> ${isActive ? 'Comment' : 'Comment'}`;
				}else {
					this.innerHTML = `<i class="fas fa-comment" style="color:gray;"></i> ${isActive ? 'Comment' : 'Comment'}`;
				}
				// this.innerHTML = `<i class="fas fa-comment" style="color:blue;"></i> ${isActive ? 'Hide Comments' : 'Comment'}`;
			});
		});
		
		// Toggle like
		document.querySelectorAll('.like-btn').forEach(button => {
			button.addEventListener('click', function() {
				this.classList.toggle('liked');
				const icon = this.querySelector('i');
				icon.classList.toggle('far');
				icon.classList.toggle('fas');
				
				// Update like count (example)
				const likeCount = this.closest('.post-card').querySelector('.likes-count span:last-child');
				const currentCount = parseInt(likeCount.textContent);
				//likeCount.textContent = this.classList.contains('liked') ? currentCount + 1 : currentCount - 1;
			});
		});
	});
</script>

<script>
	document.addEventListener('DOMContentLoaded', function() {
	// Get modal instance
	var addPostModal = new bootstrap.Modal(document.getElementById('addPostModal'));
	
	// Show modal when Add Post is clicked
	document.querySelector('.add-post-btn').addEventListener('click', function(e) {
		e.preventDefault();
		addPostModal.show();
	});
	
	});
</script>





<script>
	$(document).ready(function() {
		// Handle comment form submission
		//alert('okk');
		$('.comment-form').on('submit', function(e) {
			e.preventDefault();
			//alert('okkkk');
			const form = $(this);
			const postId = form.data('post-id');
			const commentText = form.find('[name="comment_text"]').val().trim();
			
			if (!commentText) return;
			
			// Show loading state
			const submitBtn = form.find('.comment-post-btn');
			submitBtn.prop('disabled', true).text('Posting...');
			
			$.ajax({
				//url: '/comments',
				url:'{{url('comments')}}',
				method: 'POST',
				data: form.serialize(),
				success: function(response) {
					if (response.success) {
						// Clear the input
						form.find('[name="comment_text"]').val('');
						
						// Append the new comment to the comments section
						const commentsSection = form.closest('.post-card').find('.post-comments');
						
						// Create new comment HTML
						const newComment = `
							<div class="comment-item">
								<img src="${response.commenter.employee_image || 'https://randomuser.me/api/portraits/men/1.jpg'}" 
									alt="${response.commenter.employee_name}" class="comment-avatar">
								<div class="comment-bubble">
									<div class="comment-header">
										<h6 class="comment-username">${response.commenter.employee_name}</h6>
										<small class="comment-time">Just now</small>
									</div>
									<p class="comment-text">${response.comment.comment_text}</p>
								</div>
							</div>
						`;
						
						// Append the new comment
						commentsSection.append(newComment);
						
						// Update comment count
						const commentsCount = commentsSection.find('.comment-item').length;
						form.closest('.post-card').find('.comments-count span').text(commentsCount + ' comment' + (commentsCount !== 1 ? 's' : ''));
					}
				},
				error: function(xhr) {
					console.error('Error:', xhr.responseText);
					alert('Failed to post comment. Please try again.');
				},
				complete: function() {
					submitBtn.prop('disabled', false).text('Post');
				}
			});
		});
	});


	//like functionality
	$(document).on('click', '.like-btn', function() {
		const button = $(this);
		const postId = button.data('post-id');
		  const token = $('meta[name="csrf-token"]').attr('content');
    
			// Validate elements exist
			if (!token) {
				console.error('CSRF token not found');
				return;
			}
		
		$.ajax({
		
			url: `{{ url('posts') }}/${postId}/like`,
			method: 'POST',
			// headers: {
			// 	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			// },
			  headers: {
					'X-CSRF-TOKEN': token
				},
			beforeSend: function() {
				button.prop('disabled', true);
			}, 
			cache: false,
			success: function(response) {
				if (response.success) {
					// Update like count and button state
					const likeCount = button.closest('.post-actions').siblings('.post-stats').find('.likes-count span:last');
					const currentCount = parseInt(likeCount.text()) || 0;
					
					if (response.action === 'liked') {
						likeCount.text(currentCount + 1);
						button.html('<i class="fas fa-thumbs-up"></i> Liked');
					} else {
						likeCount.text(Math.max(0, currentCount - 1));
						button.html('<i class="far fa-thumbs-up"></i> Like');
					}
				}
			},
			error: function(xhr) {
				console.error('Like error:', xhr.responseText);
				alert('Failed to process like. Please try again.');
			},
			complete: function() {
				button.prop('disabled', false);
			}
		});
	});


	//-----------for edit and delete button show
	function toggleOptions(button) {
		// Close all other dropdowns first
		document.querySelectorAll('.options-dropdown').forEach(dropdown => {
			if (dropdown !== button.nextElementSibling) {
				dropdown.classList.remove('show-dropdown');
			}
		});
		
		// Toggle the current dropdown
		const dropdown = button.nextElementSibling;
		dropdown.classList.toggle('show-dropdown');
	}

	// Close dropdown when clicking outside
	document.addEventListener('click', function(event) {
		if (!event.target.closest('.post-options-container')) {
			document.querySelectorAll('.options-dropdown').forEach(dropdown => {
				dropdown.classList.remove('show-dropdown');
			});
		}
	});
</script>


<script>
	$(document).ready(function() {
		// When edit button is clicked
		$(document).on('click', '.edit-post-btn', function() {
			const postId = $(this).data('post-id');
			const employeeCode = $(this).data('employee-code');
			//alert(postId);
			// Show loading state
			$('#editPostModal').find('.modal-body').prepend(
				'<div class="text-center py-3" id="loadingSpinner">' +
				'<div class="spinner-border text-primary"></div>' +
				'<p>Loading post data...</p>' +
				'</div>'
			);
			
			// AJAX request to fetch post data
			$.ajax({
				//url: 'posts/' + postId + '/edit',
				url:`{{ url('posts') }}/${postId}/edit`,
				
				type: 'GET',
				data: { employee_code: employeeCode },
				success: function(response) {
					$('#loadingSpinner').remove();
					
					// Set form action
					//$('#editPostForm').attr('action', '/hrms-v2/posts/' + postId);
					$('#editPostId').val(postId);
					$('#editPostContent').val(response.title);
					$('#removeFileFlag').val('0');
					
					// Handle file display
					if (response.image_path) {
						const fileUrl = "https://skilledworkerscloud.co.uk/hrms-v2/storage/app/public/" + response.image_path;
						const fileExtension = response.image_path.split('.').pop().toLowerCase();
						
						let filePreviewHtml = '';
						if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExtension)) {
							filePreviewHtml = `<img src="${fileUrl}" class="img-thumbnail" style="max-height: 150px;">`;
						} else if (fileExtension === 'pdf') {
							filePreviewHtml = `<i class="fas fa-file-pdf fa-3x text-danger"></i><br>
											<a href="${fileUrl}" target="_blank">View PDF</a>`;
						} else if (['doc', 'docx'].includes(fileExtension)) {
							filePreviewHtml = `<i class="fas fa-file-word fa-3x text-primary"></i><br>
											<a href="${fileUrl}" target="_blank">View Document</a>`;
						} else if (['mp4', 'mov', 'avi'].includes(fileExtension)) {
							filePreviewHtml = `<video controls style="max-width: 100%; max-height: 150px;">
											<source src="${fileUrl}" type="video/${fileExtension}">
											Your browser does not support the video tag.
											</video>`;
						} else {
							filePreviewHtml = `<a href="${fileUrl}" target="_blank">Download File</a>`;
						}
						
						$('#currentFilePreview').html(filePreviewHtml);
						$('#currentFileContainer').show();
					} else {
						$('#currentFileContainer').hide();
					}
				},
				error: function(xhr) {
					$('#loadingSpinner').html('<div class="alert alert-danger">Error loading post data</div>');
					console.error('Error:', xhr.responseText);
				}
			});
		});
		
		// Remove file button handler
		$('#removeFileBtn').click(function() {
			$('#currentFileContainer').hide();
			$('#removeFileFlag').val('1');
			$('#editPostFile').val('');
		});
		
		// Form submission handler
		// $('#editPostForm').submit(function(e) {
		// 	e.preventDefault();
		// 	const formData = new FormData(this);
			
		// 	$.ajax({
		// 		url: $(this).attr('action'),
		// 		type: 'POST',
		// 		data: formData,
		// 		processData: false,
		// 		contentType: false,
		// 		success: function(response) {
		// 			$('#editPostModal').modal('hide');
		// 			location.reload(); // Or update the post dynamically
		// 		},
		// 		error: function(xhr) {
		// 			alert('Error updating post: ' + xhr.responseJSON.message);
		// 		}
		// 	});
		// });
	});
</script>
@endsection