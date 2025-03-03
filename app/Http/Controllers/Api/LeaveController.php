<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\LeaveApprover\Leave_apply;
use App\Models\LeaveApply;
use App\Models\Employee;
use App\Models\LeaveType;
use App\Models\User;
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
            // if (auth()->check()) {
            //     $fromDate = $request->from_date;
            //     $toDate = $request->to_date;
            //     $employeeId = auth()->user()->employee_id;
            //     $query = LeaveApply::with('leaveType')->where('employee_id',$employeeId);
            //     $totalMaxNo = leaveAllocation::where('employee_code', $employeeId)->sum('max_no');
            //     $totalLeaveInHand = leaveAllocation::where('employee_code', $employeeId)->sum('leave_in_hand');
            //     $leaveBalance = $totalMaxNo - $totalLeaveInHand;
            //     $totalLeaveBalance ='';
            //     if($leaveBalance >0){
            //         $totalLeaveBalance =  $leaveBalance;
            //     } else {
            //         $totalLeaveBalance = 0;
            //     }


            //     if (!empty($fromDate) && !empty($toDate)) {
            //         $query->whereBetween('from_date', [$fromDate, $toDate]);
            //     }
            //     $data = $query->get();

            //     //dd($data[0]->emp_lv_sanc_auth);
            //     $data->transform(function ($item) {
            //         return collect($item)->map(function ($value) {
            //             return $value === null ? "" : $value;
            //         });
            //     });
                
            //     $dynamicFlag = 1;
            //     $message = "Data get successfully";
            //     return Helper::rjd(
            //         $message,
            //         $dynamicFlag,
            //         $data,
            //         $totalLeaveBalance
            //     );
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
                //dd(auth()->user()->emid);
                $employeeId = auth()->user()->employee_id;
                $emid = auth()->user()->emid;
                //dd($emid);
                $request->validate([
                    'doc_image' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf,docx|max:3000',
                ]);
    
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
                //dd($employee_name);
                $diff = abs(
                    strtotime($request->to_date) - strtotime($request->from_date)
                );
                //dd($diff);
                $years = floor($diff / (365 * 60 * 60 * 24));
                $months = floor(
                    ($diff - $years * 365 * 60 * 60 * 24) / (30 * 60 * 60 * 24)
                );
                $days =
                    floor(
                        ($diff -
                            $years * 365 * 60 * 60 * 24 -
                            $months * 30 * 60 * 60 * 24) /
                            (60 * 60 * 24)
                    ) + 1;
                //dd($days);
                if($days == $request->days){
                   $no_of_leave =  $request->days;
                } else {
                    $no_of_leave =  $days;
                }

                if(!empty($request->file('doc_image'))){
                    $path = $request->file('doc_image')->store('leave-apply', 'public'); 
                } else {
                    $path = "";
                }  
                if ($request->leave_inhand >= $no_of_leave) {
                    $data["employee_id"] = $employeeId;
                    $data["employee_name"] = $employee_name;
                    $data["emp_reporting_auth"] = $report_auth_name;
                    $data["emp_lv_sanc_auth"] = $emp_lv_sanc_auth;
                    $data["date_of_apply"] = date(
                        "Y-m-d",
                        strtotime($request->date_of_apply)
                    );
                    $data["doc_image"] = $path;
                    $data["leave_type"] = $request->leave_type;
                    $data["half_cl"] = $request->half_cl;
                    $data["from_date"] = $request->from_date;
                    $data["to_date"] = $request->to_date;
                    $data["no_of_leave"] = $no_of_leave;
                    $data["status"] = "NOT APPROVED";
                    $data["emid"] = $emid;
                    //dd($data);
                    $leave_apply = DB::table("leave_apply")->insert($data);

                    $dynamicFlag = 1;
                    $data=[];
                    $message = "Leave Apply Successfully..!.";
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
} //End Class
