<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    Route::get('leave','App\Http\Controllers\Api\LeaveController@leave');
    Route::post('employee','App\Http\Controllers\Api\EmployeeController@editEmployee');
});



