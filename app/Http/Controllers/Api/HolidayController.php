<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Holiday2Type;
use App\Models\HolidayApply;
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
                if(empty($holidayType)){
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


} // End class
