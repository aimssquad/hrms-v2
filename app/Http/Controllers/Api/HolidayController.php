<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Holiday2Type;
use App\Models\HolidayApply;
use App\Models\Holiday;
use App\Helpers\Api\Helper;
use Validator;
use Exception;
use DB;

class HolidayController extends Controller
{
    public function getHolidayType(){
        try {
            if (auth()->check()) {
                //$employeeId = auth()->user()->employee_id;
                $emid = auth()->user()->emid;
                $holidayType = Holiday2Type::where('emid',$emid)
                    ->where('status',1)
                    ->select(['id','holiday_type_name'])
                    ->get();
                //dd($holidayType);    
                if($holidayType->isEmpty()){
                    $dynamicFlag = 1;
                    $data=[];
                    $message = "No holiday type found";
                    return Helper::rjd(
                        $message,
                        $dynamicFlag,
                        $data
                    );
                }
                $holidayType->transform(function ($item) {
                    return collect($item)->map(function ($value) {
                        return $value === null ? "" : $value;
                    });
                });
                //dd($holidayType);
                $dynamicFlag = 1;
                $data=$holidayType;
                $message = "Data get successfully";
                return Helper::rjd(
                    $message,
                    $dynamicFlag,
                    $data
                );
            } else {
                $dynamicFlag = 1;
                $data=[];
                $message = "Somthing Went Wrong";
                return Helper::rjd(
                    $message,
                    $dynamicFlag,
                    $data
                );
            }    
        } catch (Exception $e) {
            return Helper::rj("Server Error.", 500);
        }        
    }

    public function applyHoliday(Request $request){
        try{
            if (auth()->check()) {
                $employeeId = auth()->user()->employee_id;
                $emid = auth()->user()->emid;
                $auth_id = DB::table('employee')->where('emp_code',$employeeId)->where('emid',$emid)->select('emp_reporting_auth')->first();
                $authId = $auth_id->emp_reporting_auth;
                $authName = DB::table('users')->where('employee_id',$authId)->select('name')->first();
                $auth_name = $authName->name;

                $validated = $request->validate([
                    'holiday_type2_id' => 'required|exists:holiday2types,id',
                    'holiday_types' => 'required|in:days,hour',
                    'form_date' => 'required|date',
                    'no_of_days' => 'nullable|string',
                    'hour' => 'nullable|string'
                ]);

                $holidayData = [
                    'employee_id' => $employeeId,
                    'holiday_type2_id' => $validated['holiday_type2_id'],
                    'emp_reporting_auth_name' => $auth_name,
                    'emp_reporting_auth_id' => $authId,
                    'apply_date' => now(),
                    'holiday_types' => $validated['holiday_types'],
                    'form_date' => $validated['form_date'],
                    'emid' => $emid,
                    'status' => 1,
                ];
                if ($request->holiday_types === 'days') {
                    $holidayData['no_of_days'] = $validated['no_of_days'];
                    $holidayData['hour'] = null;
                } else {
                    $holidayData['hour'] = $validated['hour'];
                    $holidayData['no_of_days'] = null;
                }
                $data = HolidayApply::create($holidayData);
                $dynamicFlag = 1;
                // $data=[];
                $message = "Data submit successfully";
                return Helper::rjd(
                    $message,
                    $dynamicFlag,
                    $data
                );
            } else {
                $dynamicFlag = 1;
                $data=[];
                $message = "Somthing Went Wrong";
                return Helper::rjd(
                    $message,
                    $dynamicFlag,
                    $data
                );
            }     
        } catch (Exception $e) {
            return Helper::rj("Server Error.", 500);
        }  
    }

    public function nationalHoliday(){
        try{
            if (auth()->check()) {
                $employeeId = auth()->user()->employee_id;
                $emid = auth()->user()->emid;
                $holidays = Holiday::where("holiday.emid", "=", $emid)
                    ->select("holiday_type.name", "holiday.*")
                    ->join(
                        "holiday_type",
                        "holiday.holiday_type",
                        "=",
                        "holiday_type.id"
                    )->get();
                
                if($holidays->isEmpty()){
                    $dynamicFlag = 1;
                    $data=[];
                    $message = "No holidays found";
                    return Helper::rjd(
                        $message,
                        $dynamicFlag,
                        $data
                    );
                }  

                $holidays->transform(function ($item) {
                    return collect($item)->map(function ($value) {
                        return $value === null ? "" : $value;
                    });
                });

                $dynamicFlag = 1;
                    $data=$holidays;
                    $message = "all  holidays";
                    return Helper::rjd(
                        $message,
                        $dynamicFlag,
                        $data
                    );
            }     
        } catch (Exception $e) {
            return Helper::rj("Server Error.", 500);
        } 
    }

    public function applyHolidayList(){
        try{
            if (auth()->check()) {
                //dd();
                $employeeId = auth()->user()->employee_id;
                $emid = auth()->user()->emid;
                $holidayApply = Holiday2Type::where("holiday2types.emid", "=", $emid)
                ->where("users.status","active")
                ->select("holiday2types.holiday_type_name", "users.name", "holiday_apply.*")
                ->join(
                    "holiday_apply",
                    "holiday_apply.holiday_type2_id",
                    "=",
                    "holiday2types.id"
                )->join("users",
                "users.employee_id","=","holiday_apply.employee_id")
                ->get();
             
                if($holidayApply->isEmpty()){
                    $dynamicFlag = 1;
                    $data=[];
                    $message = "Data not found";
                    return Helper::rjd(
                        $message,
                        $dynamicFlag,
                        $data
                    );
                }   
                    
                $holidayApply->transform(function ($item) {
                    return collect($item)->map(function ($value) {
                        return $value === null ? "" : $value;
                    });
                });
                //dd($holidayApply);
                $dynamicFlag = 1;
                $data = $holidayApply;
                $message = "Successfully get holiday Apply data";
                return Helper::rjd(
                    $message,
                    $dynamicFlag,
                    $data
                );
            }     
        } catch (Exception $e) {
            return Helper::rj("Server Error.", 500);
        } 
    }


} // End class
