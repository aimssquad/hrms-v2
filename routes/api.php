<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LeaveController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\MobileMenuController;
use App\Http\Controllers\Api\AttendanceController;
use App\Http\Controllers\Api\HolidayController;


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['prefix' => 'v1/', 'middleware' => ['api']], function () {
    Route::post('login', 'App\Http\Controllers\Api\LoginController@doLogin');
});

Route::middleware(['auth:api'])->group(function () {
    Route::post('v1/logout', 'App\Http\Controllers\Api\LoginController@logout');
});

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api']], function () {
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

    Route::get('show_daily_attendance',[AttendanceController::class, 'showDailyAttendance']);
    Route::get('get_branch',[AttendanceController::class, 'getBranch']);

    // Route::post('creat-temp-attendance',[AttendanceController::class, 'createTempAttendance']);
    // Route::post('show-attendance',[AttendanceController::class, 'showAttendance']);

    Route::post('create-monthy-attendance',[AttendanceController::class, 'createMonthlyAttendance']);
   
});

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api']], function () {  
    Route::post('creat-attendance',[AttendanceController::class, 'store']);
    Route::post('show-attendance',[AttendanceController::class, 'showEmpAttendance']);
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

