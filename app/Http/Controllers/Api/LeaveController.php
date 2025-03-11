<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeaveApprover\Leave_apply;
use App\Models\LeaveApply;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\User;
use App\Models\offdays;
use App\Models\leaveAllocation;
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
                $fromDate = $request->from_date;
                $toDate = $request->to_date;
                $employeeId = auth()->user()->employee_id;
                $query = LeaveApply::with('leaveType')
                    ->where('employee_id', $employeeId);
                $totalMaxNo = leaveAllocation::where('employee_code', $employeeId)->sum('max_no');
                $totalLeaveInHand = leaveAllocation::where('employee_code', $employeeId)->sum('leave_in_hand');
                $leaveBalance = $totalMaxNo - $totalLeaveInHand;
                $totalLeaveBalance = $leaveBalance > 0 ? $leaveBalance : 0;
    
                if (!empty($fromDate) && !empty($toDate)) {
                    $query->whereBetween('from_date', [$fromDate, $toDate]);
                }
                $data = $query->get();
                
                 // Step 1: Extract all unique emp_lv_sanc_auth values
            $empLvSancAuthValues = $data->pluck('emp_lv_sanc_auth')->unique()->filter()->values();

            // Step 2: Fetch corresponding names from the users table
            $users = User::whereIn('employee_id', $empLvSancAuthValues)
                ->pluck('name', 'employee_id');

            // Step 3: Transform data to replace emp_lv_sanc_auth with names
            $data->transform(function ($item) use ($users) {
                $item->emp_lv_sanc_auth = $item->emp_lv_sanc_auth
                    ? ($users[$item->emp_lv_sanc_auth] ?? 'No Authority Assigned')
                    : 'No Authority Assigned';
                return collect($item)->map(function ($value) {
                    return $value === null ? "" : $value;
                });
            });
    
                // Return response
                $dynamicFlag = 1;
                $message = "Data get successfully";
                return Helper::rjd(
                    $message,
                    $dynamicFlag,
                    $data,
                    $totalLeaveBalance
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

    public function leaveNo(Request $request){
        try{
            if (auth()->check()) {
                $employeeId = auth()->user()->employee_id;
                //dd($employeeId);
                $data = leaveAllocation::with(['leaveType' => function ($query) {
                    $query->where('leave_type_status', 'active'); // Only active leave types
                }])
                ->where('employee_code', $employeeId)
                ->select('leave_type_id', 'max_no')
                ->get();
                $data->transform(function ($item) {
                return [
                    'max_no' => $item->max_no,
                    'leave_type_name' => $item->leaveType ? $item->leaveType->leave_type_name : null
                ];
                });
                $data->transform(function ($item) {
                    return collect($item)->map(function ($value) {
                        return $value === null ? "" : $value;
                    });
                });
               //dd($data);
                $dynamicFlag = 1;
                $totalLeave=0;
                $message = "Data get successfully";
                return Helper::rjd(
                    $message,
                    $dynamicFlag,
                    $data,
                    $totalLeave
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

    public function leave_type(Request $request){
        try {
            if (auth()->check()) {
                $emid = auth()->user()->emid;
                //$leaveType = LeaveType::where('emid',$emid)->get();
                $leaveType = LeaveType::join(
                    "leave_allocation",
                    "leave_type.id",
                    "=",
                    "leave_allocation.leave_type_id"
                )
                    ->select(
                        "leave_type.*",
                        "leave_allocation.id as lv_alloc_id",
                        "leave_allocation.month_yr"
                    )
                    ->where("leave_type.emid", "=", $emid)
                    ->where(
                        "leave_allocation.emid",
                        "=",
                        $emid
                    )
                    ->where("leave_allocation.emid", "=", $emid)
    
                    ->where("leave_allocation.leave_in_hand", "!=", 0)
                    ->groupBy('leave_type.id')
                    ->get();
                
                $leaveType->transform(function ($item) {
                    return collect($item)->map(function ($value) {
                        return $value === null ? "" : $value;
                    });
                });
                //dd($leaveType);
                $dynamicFlag = 1;
                $data=$leaveType;
                $message = "Now you can access leave type";
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

    public function leave_in_hand(Request $request){
        try {
            if (auth()->check()) {
                $empDtl = auth()->user();
                $emid = $empDtl->emid;
                $employee_code = $empDtl->employee_id;
                $leave_type_id = $request->leave_type_id;

                $leaveinhand=DB::table('leave_allocation')
                    ->where('leave_type_id','=',$leave_type_id)
                    ->where('employee_code','=',$employee_code)
                    ->where('emid','=',$emid)
                    ->orderBy('id','DESC')
                    ->first();

                if (!empty($leaveinhand)) {
                    if ($leaveinhand->leave_in_hand > 0) {
                        $leaveInHand = $leaveinhand->leave_in_hand;   
                        $dynamicFlag = 1;
                        $data = ["leave_in_hand"=> $leaveInHand];
                        $message = "Leave in hand";
                        return Helper::rjd(
                            $message,
                            $dynamicFlag,
                            $data
                        );
                    } 
                } 
                $dynamicFlag = 1;
                $data = 0;
                $message = "You have no leave";
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

    public function leaveApply(Request $request){
        //dd($request->all());
        try {
            if (auth()->check()) {
                //dd(auth()->user());
                $employeeId = auth()->user()->employee_id;
                $emid = auth()->user()->emid;
                //dd()
                $request->validate([
                    'doc_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,docx|max:3000',
                    'leave_cos' => 'required',
                    'notify_email' => 'nullable|email'
                ]);
                $toemail = $request->notify_email;
                //dd($request->leave_type);
                //--------------------------------------------
                // $user_id = Session::get('users_id');
                $users = DB::table('users')->where('employee_id', '=', $employeeId)->first();
                //dd($users);
                $satnew = 'Saturday';
                $sunnew = 'Sunday';
                $total_wk_days = 0;
                $date1_ts = strtotime($request->from_date);
                $date2_ts = strtotime($request->to_date);
                $diff = $date2_ts - $date1_ts;
                $leave_tyepenew = DB::table('leave_type')->where('id', '=', $request->leave_type)->first();
                //dd($leave_tyepenew);
                $Date1 = date('d-m-Y', strtotime($request->from_date));
                $Date2 = date('d-m-Y', strtotime($request->to_date));
                
            // Declare an empty array
                $array = array();

            // Use strtotime function
                $Variable1 = strtotime($Date1);
                $Variable2 = strtotime($Date2);

            // Use for loop to store dates into array
                // 86400 sec = 24 hrs = 60*60*24 = 1 day
                for ($currentDate = $Variable1; $currentDate <= $Variable2;
                    $currentDate += (86400)) {

                    $Store = date('Y-m-d', $currentDate);

                    $array[] = $Store;
                }
                //dd($leave_tyepenew);
                if (trim($leave_tyepenew->alies)) {
                    //dd('okk');
                    $total_wk_days = (round($diff / 86400) + 1);

                    $daysnew = 0;
                    if (date('d', strtotime($request->from_date)) > $total_wk_days) {
                        $total_wk_days = date('d', strtotime($request->from_date)) + ($total_wk_days - 1);

                    } else if (date('d', strtotime($request->from_date)) != 1) {
                        $total_wk_days = date('d', strtotime($request->from_date)) + ($total_wk_days - 1);
                    } else {
                        $total_wk_days = $total_wk_days;
                    }
                    if (date('d', strtotime($request->from_date)) == date('d', strtotime($request->to_date))) {
                        $total_wk_days = date('d', strtotime($request->from_date));
                    }

                    foreach ($array as $valueogf) {
                    //   dd("hello");
                        $new_f = $valueogf;
                        $duty_auth = DB::table('duty_roster')

                            ->where('employee_id', '=', $users->employee_id)
                            ->where('emid', '=', $users->emid)

                            ->orderBy('id', 'DESC')
                            ->first();
                        //  dd($duty_auth);
                        $holidays = DB::table('holiday')
                            ->whereDate('from_date', '<=', $new_f)
                            ->whereDate('to_date', '>=', $new_f)

                            ->where('emid', '=', $users->emid)
                            ->first();

                        $offg = array();
                        if (!empty($duty_auth)) {

                            $shift_auth = DB::table('shift_management')

                                ->where('id', '=', $duty_auth->shift_code)

                                ->where('emid', '=', $users->emid)
                                ->orderBy('id', 'DESC')
                                ->first();
                            $off_auth = DB::table('offday')

                                ->where('shift_code', '=', $duty_auth->shift_code)

                                ->where('emid', '=', $users->emid)
                                ->orderBy('id', 'DESC')
                                ->first();
                             //dd($off_auth);
                            $off_day = 0;
                            if (!empty($off_auth)) {
                                if ($off_auth->sun == '1') {

                                    $off_day = $off_day + 1;
                                    $offg[] = 'Sunday';
                                }
                                if ($off_auth->mon == '1') {
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Monday';
                                }

                                if ($off_auth->tue == '1') {
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Tuesday';
                                }

                                if ($off_auth->wed == '1') {
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Wednesday';
                                }

                                if ($off_auth->thu == '1') {
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Thursday';
                                }

                                if ($off_auth->fri == '1') {
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Friday';
                                }
                                if ($off_auth->sat == '1') {
                                    $off_day = $off_day + 1;
                                    $offg[] = 'Saturday';
                                }

                            }
                        }
                        if (in_array(date('l', strtotime($new_f)), $offg)) {

                        } else {
                            $daysnew++;
                        }

                    }

                } else {
                    $diff = abs(strtotime($to_date) - strtotime($from_date));
                    $years = floor($diff / (365 * 60 * 60 * 24));
                    $months = floor(($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24));
                    $days = (floor(($diff - $years * 365 * 60 * 60 * 24 - $months * 30 * 60 * 60 * 24) / (60 * 60 * 24))) + 1;
                    $daysnew = $days;
                }

                //echo $daysnew;
                
                $no_of_leave = $daysnew;
                $leaveinhand=DB::table('leave_allocation')
                    ->where('leave_type_id','=',$request->leave_type)
                    ->where('employee_code','=',$employeeId)
                    ->where('emid','=',$emid)
                    ->orderBy('id','DESC')
                    ->first();
                if ($leaveinhand->leave_in_hand > 0){
                    $leaveInHand = $leaveinhand->leave_in_hand;
                } else {
                    $leaveInHand = 0;
                }    
                //dd($leaveInHand);
                //-----------------------------------
                $report_auth = Employee::where("emp_code", "=", $employeeId)
                    ->where("emid", "=", $emid)
                    ->first();
                
                if (!empty($report_auth)) {
                    $report_auth_name = $report_auth->emp_reporting_auth;
                } else {
                    $report_auth_name = "";
                }
                if (!empty($report_auth)) {
                    $emp_lv_sanc_auth = $report_auth->emp_lv_sanc_auth;
                } else {
                    $emp_lv_sanc_auth = "";
                }
                $employee_id = $report_auth->emp_code;
                $employee_name = $report_auth->emp_fname .' '. $report_auth->emp_mname .' '. $report_auth->emp_lname;
                //dd($no_of_leave);
              

                if(!empty($request->file('doc_image'))){
                    $path = $request->file('doc_image')->store('leave-apply', 'public'); 
                } else {
                    $path = "";
                }  
                if ($leaveInHand >= $no_of_leave) {
                    $data["employee_id"] = $employeeId;
                    $data["employee_name"] = $employee_name;
                    $data["emp_reporting_auth"] = $report_auth_name;
                    $data["emp_lv_sanc_auth"] = $emp_lv_sanc_auth;
                    $data["date_of_apply"] = date("Y-m-d");
                    $data["doc_image"] = $path;
                    $data["leave_type"] = $request->leave_type;
                    $data["half_cl"] = $request->half_cl;
                    $data["from_date"] = $request->from_date;
                    $data["to_date"] = $request->to_date;
                    $data["no_of_leave"] = $no_of_leave;
                    $data["leave_cos"] = $request->leave_cos;
                    $data["status"] = "NOT APPROVED";
                    $data["emid"] = $emid;
                    //dd($data);
                    $leave_apply = DB::table("leave_apply")->insert($data);

                    $dynamicFlag = 1;
                    $data=[];
                    $message = "Leave Apply Successfully.";
                    return Helper::rjd(
                        $message,
                        $dynamicFlag,
                        $data
                    );
                } else {
                    $dynamicFlag = 1;
                    $data=[];
                    $message = "Sorry, No Leave Available";
                    return Helper::rjd(
                        $message,
                        $dynamicFlag,
                        $data
                    );
                }
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

    public function getAllEmployee(Request $request)
    {
        try {
            if (auth()->check()) {
                $empDtl = auth()->user();
                $emid = $empDtl->emid;
                $allEmployee = User::where('emid',$emid)->where('user_type','employee')->where('status','active')->select('employee_id','name','email')->get();
                if($allEmployee){
                    $allEmployee->transform(function ($item) {
                        return collect($item)->map(function ($value) {
                            return $value === null ? "" : $value;
                        });
                    });
                    //dd($allEmployee);
                    $dynamicFlag = 1;
                    $data = $allEmployee;
                    $message = "You have no leave";
                    return Helper::rjd(
                        $message,
                        $dynamicFlag,
                        $data
                    );  
                } else {
                    $dynamicFlag = 1;
                    $data = [];
                    $message = "No Employee Found";
                    return Helper::rjd(
                        $message,
                        $dynamicFlag,
                        $data
                    );
                }
                 
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

} //End Class
