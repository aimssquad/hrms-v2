<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\LeaveApply;
use App\Helpers\Api\Helper;
use Validator;
use Exception;
use DB;

class EmployeeController extends Controller
{
    public function editEmployee(Request $request)
    {
        try{
            if (!auth()->check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
            $employeeId = auth()->user()->employee_id;
            $employee = DB::table('employee')->where('emp_code', $employeeId)->first();
            if (!$employee) {
                return response()->json(['error' => 'Employee not found'], 404);
            } 
            if (!$request->hasFile('emp_image')) {
                return response()->json(['error' => 'No image uploaded'], 400);
            }
            $file = $request->file('emp_image');
            if (!empty($employee->emp_image) && file_exists(public_path('storage/' . $employee->emp_image))) {
                unlink(public_path('storage/' . $employee->emp_image));
            }
            $filePath = $file->store('employee_logo', 'public');
            DB::table('employee')->where('emp_code', $employeeId)->update(['emp_image' => $filePath]);
            $dynamicFlag = 1;
            $data=asset('storage/' . $filePath);
            $message = "Image updated successfully";
            return Helper::rjd(
                $message,
                $dynamicFlag,
                $data
            ); 
        } catch (Exception $e) {
        return Helper::rj("Server Error.", 500);
        }
    }

    public function getEmployeeBirthday(Request $request){
        try{
            if (!auth()->check()) {
                return response()->json(['error' => 'Unauthorized'], 401);
            }
           //dd('okk');
           $emid = auth()->user()->emid;
           //dd($emid);
            $empBirthday = DB::table('employee')
            ->where('emid', $emid)
            ->whereMonth('emp_dob', date('m'))
            ->whereDay('emp_dob', date('d'))
            ->select('emp_fname','emp_mname','emp_lname','emp_department','emp_designation','emp_doj','emp_dob','emp_image','emid','emp_ps_phone')
            ->get();
            //dd($empBirthday);
            if($empBirthday->isNotEmpty()){
                $empBirthday->transform(function ($item) {
                    return collect($item)->map(function ($value) {
                        return $value === null ? "" : $value;
                    });
                });
                //dd($allEmployee);
                $dynamicFlag = 1;
                $data = $empBirthday;
                $message = "All Employees with birthdays today.";
                return Helper::rjd(
                    $message,
                    $dynamicFlag,
                    $data
                ); 
            } else {
                $dynamicFlag = 1;
                $data = [];
                $message = "No employees have birthdays today";
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

    public function employee_dtl(){
        try{
            $emid = auth()->user()->emid;
            $employee_id = auth()->user()->employee_id;

            //dd(auth()->user()->employee_id);
            $employee = Employee::where('emp_code', $employee_id)->where('emid', $emid)->get();
            dd($employee);

        } catch (Exception $e) {
            return Helper::rj("Server Error.", 500);
        }
    }


} //End class.
