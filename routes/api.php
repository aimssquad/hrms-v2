<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\LeaveController;
use App\Http\Controllers\Api\EmployeeController;
use App\Http\Controllers\Api\MobileMenuController;
use App\Http\Controllers\Api\AttendanceController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

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

    
    
    Route::get('show_daily_attendance',[AttendanceController::class, 'showDailyAttendance']);
    Route::post('employee','App\Http\Controllers\Api\EmployeeController@editEmployee');
});

Route::group(['prefix' => 'v1', 'middleware' => ['auth:api']], function () {  
    Route::get('mobile-menu',[MobileMenuController::class, 'getMobileMenu']);
});



