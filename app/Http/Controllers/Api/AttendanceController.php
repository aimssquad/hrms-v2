<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RotaEmployee;
use App\Models\Registration;
use App\Models\Employee;
use App\Models\Branch_location;
use App\Models\TempAttendance;
use App\Helpers\Api\Helper;
use Validator;
use Exception;
use DB;

class AttendanceController extends Controller
{
    // public function showDailyAttendance(Request $request)
    // { 
    //     //dd('okk');
    //     try{
    //         if (auth()->check()) {
    //             $employee_id = auth()->user()->employee_id;
    //             //dd($employee_id);
    //             $data = RotaEmployee::where("employee_id",$employee_id)
    //                 ->orderBy("date", "DESC")
    //                 ->get();
    //             $data->transform(function ($item) {
    //                 return collect($item)->map(function ($value) {
    //                     return $value === null ? "" : $value;
    //                 });
    //             });    
    //             //dd($data);    
    //             $dynamicFlag = 1;
    //             //$totalLeave=0;
    //             $message = "Data get successfully";
    //             return Helper::rjd(
    //                 $message,
    //                 $dynamicFlag,
    //                 $data
    //             ); 
    //         } else {
    //             $dynamicFlag = 1;
    //             $data=[];
    //             $message = "Somthing Went Wrong";
    //             return Helper::rjd(
    //                 $message,
    //                 $dynamicFlag,
    //                 $data
    //             );
    //         }
    //     } catch (Exception $e) {
    //         return Helper::rj("Server Error.", 500);
    //     }
    // }

    public function createTempAttendance(Request $request){
        try {
            if (auth()->check()) {
                $employee_id = auth()->user()->employee_id;
                $employee_name = auth()->user()->name;
                $emid = auth()->user()->emid;
               
                //dd(auth()->user());
                $data = $request->validate([
                    //'branch_id' => 'nullable|numeric',
                    'time_in_location' => 'nullable|date_format:H:i',
                    'time_out_location' => 'nullable|date_format:H:i', 
                    'date' => 'nullable|date'
                ]);
                $data['employee_id'] = $employee_id;
                $data['employee_name'] = $employee_name; 
                $data['emid'] = $emid;
                //dd($data);
                $temporary_attendance = TempAttendance::create($data);
                $dynamicFlag = 1;
                $data=$data;
                $message = "Attendance Submit Successfully.";
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

    public function showAttendance(Request $request)
    { 
        //dd('okk');
        try{
            if (auth()->check()) {
                $employee_id = auth()->user()->employee_id;
                $emid = auth()->user()->emid;
                $attendance = DB::table('attandence')->where('employee_code',$employee_id)->where('emid',$emid)->get();
                $leave = DB::table('leave_apply')->where('employee_id', $employee_id)->where('emid', $emid)->get();
                $holidays = DB::table('holiday as h')
                ->join('holiday_type as ht', 'h.holiday_type', '=', 'ht.id')
                ->where('h.emid',$emid)
                ->get();
                $employee = DB::table('employee')->where('emp_code',$employee_id)->where('emid',$emid)->first();
                $employeeDepartment = DB::table('department')->where('department_name',$employee->emp_department)->where('emid',$emid)->first();
                $employeeDesignation = DB::table('designation')->where('designation_name',$employee->emp_designation)->where('emid',$emid)->first();
                $shift = DB::table('shift_management')->where('department',$employeeDepartment->id)->where('emid',$emid)->first();
                
                $offDays = DB::table('offday')
                    ->where('department',$employeeDepartment->id)
                    ->where('shift_code',$shift->id)
                    ->where('designation',$employeeDesignation->id)
                    ->where('emid',$emid)
                    ->get();
                
                dd($offDays);
                //dd($employeeDepartment->id, $shift->id, $employeeDesignation->id);
               // dd($employee);

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
