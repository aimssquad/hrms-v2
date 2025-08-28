<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\LeaveApply;
use App\Models\EmployeePermission;
use App\Models\RotaEmployee;
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
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        try{
            $emid = auth()->user()->emid;
            $employee_id = auth()->user()->employee_id;

            //dd(auth()->user()->employee_id);
            $data = Employee::where('emp_code', $employee_id)->where('emid', $emid)->get();
            //$data['role']
            if(empty($data)){
                $dynamicFlag = 0;
                $data = [];
                $message = "No employee found";
                return Helper::rjd(
                    $message,
                    $dynamicFlag,
                    $data
                );
            }

            $dynamicFlag = 1;
            $data = $data;
            $message = "Employee get successfully";
            return Helper::rjd(
                $message,
                $dynamicFlag,
                $data
            ); 

        } catch (Exception $e) {
            return Helper::rj("Server Error.", 500);
        }
    }

    public function workStore(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $emid = auth()->user()->emid;
            $employee_id = auth()->user()->employee_id;

            // validate employee exists
            $employee = Employee::where("emp_code", $employee_id)
                ->where("emid", $emid)
                ->first();

            if (!$employee) {
                return Helper::rjd("No employee found", 0, []);
            }

            // total minutes
            $tot = $request->w_min + ($request->w_hours * 60);

            // handle file upload if exists
            $path_ps_doc = "";
            if ($request->hasFile("file")) {
                $file_ps_doc = $request->file("file");
                $extension_ps_doc = $file_ps_doc->extension();
                $path_ps_doc = $file_ps_doc->store("tasks", "public");
            }

            $taskData = [
                "employee_id" => $employee_id,
                "emid"        => $emid,
                "file"        => $path_ps_doc,

                "w_hours"     => $request->w_hours,
                "w_min"       => $request->w_min,
                "in_time"     => date("h:i A", strtotime($request->in_time)),
                "out_time"    => date("h:i A", strtotime($request->out_time)),
                "min_tol"     => $tot,
                "date"        => date("Y-m-d", strtotime($request->date)),

                "remarks"     => $request->remarks,
                "cr_date"     => date("Y-m-d"),
            ];

            RotaEmployee::insert($taskData);

            return Helper::rjd("Daily Work Update Added Successfully", 1, $taskData);

        } catch (\Exception $e) {
            return Helper::rj("Server Error: " . $e->getMessage(), 500);
        }
    }

    public function workUpdateList()
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $emid = auth()->user()->emid;
            $employee_id = auth()->user()->employee_id;

            $tasks = RotaEmployee::where("employee_id", $employee_id)
                ->where("emid", $emid)
                ->orderBy("date", "desc")
                ->get();

            if ($tasks->isEmpty()) {
                return Helper::rjd("No tasks found", 0, []);
            }

            return Helper::rjd("Tasks fetched successfully", 1, $tasks);

        } catch (\Exception $e) {
            return Helper::rj("Server Error: " . $e->getMessage(), 500);
        }
    }

    public function workUpdateEdit($id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $emid = auth()->user()->emid;
            $employee_id = auth()->user()->employee_id;

            $task = RotaEmployee::where("id", $id)
                ->where("employee_id", $employee_id)
                ->where("emid", $emid)
                ->first();

            if (!$task) {
                return Helper::rjd("Daily Work Update not found", 0, []);
            }

            return Helper::rjd("Daily Work Update fetched successfully", 1, $task);

        } catch (\Exception $e) {
            return Helper::rj("Server Error: " . $e->getMessage(), 500);
        }
    }

    public function workUpdate(Request $request, $id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        try {
            $emid = auth()->user()->emid;
            $employee_id = auth()->user()->employee_id;

            $task = RotaEmployee::where("id", $id)
                ->where("employee_id", $employee_id)
                ->where("emid", $emid)
                ->first();

            if (!$task) {
                return Helper::rjd("Daily Work Update not found", 0, []);
            }

            
            $path_ps_doc = $task->file;
            if ($request->hasFile("file")) {
                $file_ps_doc = $request->file("file");
                $extension_ps_doc = $file_ps_doc->extension();
                $path_ps_doc = $file_ps_doc->store("tasks", "public");
            }

            $tot = $request->w_min + ($request->w_hours * 60);

            $task->update([
                "file"        => $path_ps_doc,
                "w_hours"     => $request->w_hours,
                "w_min"       => $request->w_min,
                "in_time"     => date("h:i A", strtotime($request->in_time)),
                "out_time"    => date("h:i A", strtotime($request->out_time)),
                "min_tol"     => $tot,
                "date"        => date("Y-m-d", strtotime($request->date)),
                "remarks"     => $request->remarks,
            ]);

            return Helper::rjd("Daily Work Update updated successfully", 1, $task);

        } catch (\Exception $e) {
            return Helper::rj("Server Error: " . $e->getMessage(), 500);
        }
    }






} //End class.
