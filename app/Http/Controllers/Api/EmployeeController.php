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
}
