<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeaveApprover\Leave_apply;
use Illuminate\Http\Request;
use App\Helpers\Api\Helper;
use Validator;
use Exception;
use DB;



class LeaveController extends Controller
{
    public function leave(Request $request){
        $dynamicFlag = 1;
        try {
            if (auth()->check()) {
                $employeeId = auth()->user()->employee_id;
                dd($employeeId);
            } else {
                $dynamicFlag = 0;
                return Helper::rj("User not authenticated", $dynamicFlag);
            }
        } catch (Exception $e) {
            return Helper::rj("Server Error.", 500);
        }
    }
}
