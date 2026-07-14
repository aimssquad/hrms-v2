<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LeaveController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\MobileMenuController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\HolidayController;
use App\Http\Controllers\Api\BreakTimeController;
use App\Http\Controllers\Api\PostController;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\NoticeController;
use App\Http\Controllers\Api\HelpdeskController;
use App\Http\Controllers\Api\EmpNotificationSettingController;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\WorkItemController;
use App\Http\Controllers\Api\WorkItemAssignmentController;
use App\Http\Controllers\Api\WorkItemPermissionController;
use App\Http\Controllers\Api\WorkItemCommentController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'v1/', 'middleware' => ['api']], function () {
    Route::post('login', 'App\Http\Controllers\Api\LoginController@doLogin');
    Route::post('guest/login', 'App\Http\Controllers\Api\LoginController@login');
});

Route::middleware(['auth:api'])->group(function () {
    Route::post('v1/logout', 'App\Http\Controllers\Api\LoginController@logout');
    
    // All employee dashboard data
    Route::get('v1/employee-dashboard', [EmployeeController::class,'dashboard']);
});

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api']], function () {
    Route::get('leve-dashboard',[LeaveController::class,'dashboard']);
    Route::post('leave',[LeaveController::class,'leave']);
    Route::get('leave-type',[LeaveController::class,'leave_type']);
    Route::post('leave-in-hand',[LeaveController::class, 'leave_in_hand']);
    Route::post('leave-apply',[LeaveController::class, 'leaveApply']);
    Route::get('leave_no',[LeaveController::class, 'leaveNo']);
    Route::get('get-employee',[LeaveController::class, 'getAllEmployee']);
    Route::get('leave-balance',[LeaveController::class, 'getAllLeaveBalance']);
    Route::get('leave-calendar',[LeaveController::class, 'getLeaveCalendar']);
    
    Route::get('employee-birthday',[EmployeeController::class, 'getEmployeeBirthday']);
    Route::post('employee','App\Http\Controllers\Api\EmployeeController@editEmployee');
    
    Route::get('employee', [EmployeeController::class, 'employee_dtl']);

    Route::get('show_daily_attendance',[AttendanceController::class, 'showDailyAttendance']);
    Route::get('get_branch',[AttendanceController::class, 'getBranch']);

    // Route::post('creat-temp-attendance',[AttendanceController::class, 'createTempAttendance']);
    // Route::post('show-attendance',[AttendanceController::class, 'showAttendance']);

    Route::post('create-monthy-attendance',[AttendanceController::class, 'createMonthlyAttendance']);
   
});

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api']], function () {  
    Route::post('creat-attendance',[AttendanceController::class, 'store']);
    Route::post('show-attendance',[AttendanceController::class, 'showEmpAttendance']);
    Route::get('attendance-status',[AttendanceController::class, 'showEmpAttendanceStatus']);
    Route::post('creat-break',[BreakTimeController::class, 'store']);
    Route::get('break-status',[BreakTimeController::class, 'breakStatus']);
    Route::post('attendance-report', [AttendanceController::class, 'attendanceReport']);
    //for aminul
    Route::post('show-emp-attendance',[AttendanceController::class, 'showEmpAttandanceWF']);

});

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api']], function () {  
    Route::get('mobile-menu',[MobileMenuController::class, 'getMobileMenu']);
});

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api']], function () { 
    Route::get('holiday-list', [HolidayController::class, 'nationalHoliday']); 
    Route::get('holiday-type',[HolidayController::class, 'getHolidayType']);
    Route::post('holiday-apply', [HolidayController::class, 'applyHoliday']);
    Route::get('holiday-apply-list', [HolidayController::class, 'applyHolidayList']);
    Route::get('holiday-calender', [HolidayController::class, 'holidayCalender']);
});

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api']], function () {  
    Route::post('emp-post',[PostController::class, 'savePost']);
    Route::post('post-comment',[PostController::class, 'saveComment']);
    Route::post('posts-like/{post}',[PostController::class, 'toggleLike']);
    Route::get('all-post',[PostController::class, 'allPost']);
});

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api']], function () { 
    Route::get('list-work-update',[EmployeeController::class, 'workUpdateList']);
    Route::post('work-update',[EmployeeController::class, 'workStore']);
    Route::get('work-edit/{id}',[EmployeeController::class, 'workUpdateEdit']);
    Route::put('work-update/{id}',[EmployeeController::class, 'workUpdate']);
  
});

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api']], function () { 
    Route::get('project-list',[TaskController::class, 'employeeTask']);
    Route::post('project-task-add',[TaskController::class, 'createProjectTask']);
    Route::get('project-wise-member/{projectId}',[TaskController::class, 'projectWiseMember']);
    Route::get('project-wise-task-summary',[TaskController::class, 'projectWiseTaskSummary']);
    Route::get('/projects/members/{project}', [TaskController::class, 'members']);

    Route::post('project/post',[TaskController::class, 'empProjectPost']);    
    Route::get('/project-posts/{id}/edit', [TaskController::class, 'edit']);
    Route::put('/project-posts/{id}', [TaskController::class, 'update']);
    Route::delete('/project-posts/{id}', [TaskController::class, 'destroy']);
    Route::post('/project-post-reply', [TaskController::class, 'store']);

    Route::get('project-task-comment/{id}', [TaskController::class, 'taskComment']);
    Route::post('project-task-comment-add', [TaskController::class, 'add_emp_task_comment']);

    Route::get('project-wise-task/{id}', [TaskController::class, 'getProjectTasks']);

    Route::post('task-status-change/{id}', [TaskController::class, 'changeTaskStatus']);
    
    Route::get('message-center', [TaskController::class, 'messageCenter']);
  
});

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api']], function () { 
    Route::get('emp-notice',[NoticeController::class, 'empNotice']);
    Route::get('/notification/status/{id}',[NoticeController::class, 'status']);
    
    Route::get('/emp-notification/modules',[EmpNotificationSettingController::class, 'index']);
    Route::put('/emp-notification/is-muted',[EmpNotificationSettingController::class, 'isMuted']);
    Route::get('/emp-notification/all',[EmpNotificationSettingController::class, 'allNotifications']);
    Route::put('/emp-notification/read/{id}',[EmpNotificationSettingController::class, 'markAsRead']);
  
});

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api']], function () { 
    Route::post('raise-ticket', [HelpdeskController::class, 'helpdeskStore']);
  
});


// Project controll all routes
Route::group(['prefix' => 'v1', 'middleware' => ['auth:api']], function () { 
    
    Route::get('project-permission/{projectId}', [ProjectController::class, 'getEmployeePermissions']);
    Route::get('project-emp-permission', [ProjectController::class, 'allPermissions']);
    
    Route::get('project-emp-module/{projectId}', [ProjectController::class, 'allModules']);
    Route::post('project-module-create', [ProjectController::class, 'createModule']);
    Route::get('project-module-edit/{id}', [ProjectController::class, 'editModule']);
    Route::post('project-module-update/{id}', [ProjectController::class, 'updateModule']);
    Route::delete('project-module-delete/{id}/{projectId}', [ProjectController::class, 'deleteModule']);
    
    Route::get('project-module-permission/{moduleId}', [ProjectController::class, 'projectModulePermissionList']);
    Route::post('project-module-permission-create', [ProjectController::class, 'projectModulePermissionAdd']);
    Route::get('project-module-permission-edit/{id}', [ProjectController::class, 'projectModulePermissionEdit']);
    Route::post('project-module-permission-update/{id}', [ProjectController::class, 'projectModulePermissionUpdate']);
    Route::delete('project-module-permission-delete/{id}', [ProjectController::class, 'projectModulePermissionDelete']);
    
    Route::get('project-role', [ProjectController::class, 'roleList']);
    Route::post('project-role-create', [ProjectController::class, 'createRole']);
    Route::get('project-role-edit/{id}', [ProjectController::class, 'editRole']);
    Route::post('project-role-update/{id}', [ProjectController::class, 'updateRole']);
    Route::delete('project-role-delete/{id}', [ProjectController::class, 'deleteRole']);
    
    
    Route::post('project-member-store', [ProjectController::class, 'storeProjectMember']);
    Route::get('all-members-for-project/{userType}', [ProjectController::class, 'allMembersForProject']);
    
    //testing route 
     Route::post('/work-items', [WorkItemController::class, 'store']);
     Route::get('/project-tree/{projectId}', [WorkItemController::class, 'getProjectTree']);
     Route::get('/getAllModule/{projectId}', [WorkItemController::class, 'getAllModule']);
     Route::get('/children/{parentId}', [WorkItemController::class, 'getChildren']);
     Route::get('/employee-tasks/{employeeId}', [WorkItemController::class, 'getEmployeeTasks']);
     
     // show all lavel details
    Route::get('module-details/{workItemId}/{projectId}', [WorkItemController::class, 'getWorkItemDetails']);
     
     
     //Route::post('/assign-work-item', [WorkItemAssignmentController::class, 'assign']);
     Route::post('/assign-work-item', [WorkItemAssignmentController::class, 'employeeGiveProjectAccess']);
     
     Route::get('/work-item-employees/{id}', [WorkItemAssignmentController::class, 'getAssignedEmployees']);
     Route::post('/remove-assignment', [WorkItemAssignmentController::class, 'remove']);
     Route::get('my-task/{projectId}',[WorkItemAssignmentController::class, 'myAssignedWork']);
     Route::post('/task-completed-remarks', [WorkItemAssignmentController::class, 'submitTask']);
     Route::get('task-compleated/{id}',[WorkItemAssignmentController::class, 'completedTasks']);
     
     Route::get('admin-task-check/{projectId}',[WorkItemAssignmentController::class, 'allTask']);
     Route::get('admin-sub-task-check/{projectId}',[WorkItemAssignmentController::class, 'allSubTask']);
     
    Route::post('/give-permission', [WorkItemPermissionController::class, 'givePermission']);
    Route::get('/employee-permissions/{employeeId}', [WorkItemPermissionController::class, 'employeePermissions']);
    Route::post('/remove-permission', [WorkItemPermissionController::class, 'removePermission']);
    
    Route::get('permission-wise-project', [WorkItemController::class, 'projectList']);
    
    // Employee Project create
    Route::post('/projects', [ProjectController::class, 'projectStore']);
    Route::get('/projects/{id}', [ProjectController::class, 'editProject']);
    Route::post('/projects/update/{id}', [ProjectController::class, 'updateProject']);
    
    Route::get('master-permission-list', [ProjectController::class, 'masterPermissionList']);
    
    Route::get('master-role-permission/{roleId}',[ProjectController::class, 'getRolePermissions']);
    Route::post('/create-update-master-role-permission',[ProjectController::class, 'createUpdateRolePermissions']);
    
    // each lavel comment 
    Route::post('work-item-comment/store', [WorkItemCommentController::class, 'store']);
    Route::get('work-item-comment/{projectId}/{workItemId}',[WorkItemCommentController::class, 'index']);
    Route::delete('work-item-comment/delete/{id}',[WorkItemCommentController::class, 'delete']);
    
    Route::post('project/chat/read',[WorkItemCommentController::class, 'markProjectMessagesAsRead']);
    //Employee project dashboard
    Route::get('/emp-project-dashboard', [WorkItemController::class, 'projectDashboard']);
    //employee particular project dashboard
    Route::get('/emp-project-summary/{projectId}', [WorkItemController::class, 'getProjectModuleSummary']);
  
});
