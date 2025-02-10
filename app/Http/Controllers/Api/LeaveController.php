<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeaveApprover\Leave_apply;
use App\Models\LeaveApply;
use Illuminate\Http\Request;
use App\Helpers\Api\Helper;
use Validator;
use Exception;
use DB;



class LeaveController extends Controller
{
    public function leave(Request $request){
        try {
            if (auth()->check()) {
                $employeeId = auth()->user()->employee_id;
                $data = LeaveApply::where('employee_id',$employeeId)->get();
                //$data = json_decode(json_encode($data), true);
                //dd($data);
                $data->transform(function ($item) {
                    return collect($item)->map(function ($value) {
                        return $value === null ? "" : $value;
                    });
                });
                 //dd($data);
                $dynamicFlag = 1;
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
}
