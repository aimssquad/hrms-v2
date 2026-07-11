<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\LeaveApply;
use App\Models\EmployeePermission;
use App\Models\RotaEmployee;

//holiday model
use App\Models\Holiday2Type;
use App\Models\HolidayApply;
use App\Models\Holiday;
//Attandance model
use App\Models\Attandence;
use App\Models\LeaveType;
use App\Helpers\Api\Helper;
use Validator;
use Exception;
use DB;

class EmployeeController extends Controller
{
    public function dashboard(Request $request)
    {   //dd('okk');
        try {
    
            if (!auth()->check()) {
                return Helper::rjd("Something Went Wrong", 0, []);
            }
    
            $dashboardData = $this->getDashboardData();
    
            return Helper::rjd(
                "Dashboard Data",
                1,
                $dashboardData
            );
    
        } catch (\Exception $e) {
            return Helper::rj("Server Error.", 500);
        }
    }
    
    private function getDashboardData()
    {
        $employeeId = auth()->user()->employee_id;
        $emid = auth()->user()->emid;
    
        return [
            'attendance'     => $this->attendanceData($employeeId, $emid),
            'project_details' => $this->projectDetailsData($employeeId, $emid),
            'calendar'        => $this->getHolidayCalendarData(),
            'leave_balance'   => $this->leaveBalanceData($employeeId, $emid),
        ];
    }
    
    // Holiday Calendar
    private function getHolidayCalendarData()
    {
        $employeeId = auth()->user()->employee_id;
        $emid = auth()->user()->emid;
    
        $dutyEachEmployee = DB::table('duty_roster')
            ->where('emid', $emid)
            ->where('employee_id', $employeeId)
            ->orderByDesc('id')
            ->get();
    
        if ($dutyEachEmployee->isEmpty()) {
            return [];
        }
    
        $holidayApply = Holiday2Type::where('holiday2types.emid', $emid)
            ->where('holiday_apply.employee_id', $employeeId)
            ->select('holiday2types.holiday_type_name', 'holiday_apply.*')
            ->join(
                'holiday_apply',
                'holiday_apply.holiday_type2_id',
                '=',
                'holiday2types.id'
            )
            ->get();
    
        $nationalHoliday = Holiday::where('holiday.emid', $emid)
            ->select('holiday_type.name', 'holiday.*')
            ->join(
                'holiday_type',
                'holiday.holiday_type',
                '=',
                'holiday_type.id'
            )
            ->get();
    
        $offDays = DB::table('offday')
            ->where('emid', $emid)
            ->where('shift_code', $dutyEachEmployee[0]->shift_code)
            ->get();
    
        return [
            'duty_roster'       => $dutyEachEmployee,
            'holiday_apply'     => $holidayApply,
            'national_holiday'  => $nationalHoliday,
            'off_days'          => $offDays,
        ];
    }
    
    // Project Details with task
    private function projectDetailsData($employeeId, $emid)
    {
        $projects = DB::table('work_item_assignments as wa')
    
            ->join('work_items as wi', 'wi.id', '=', 'wa.work_item_id')
    
            ->join('projects as p', 'p.id', '=', 'wi.project_id')
            
            ->whereIn('wi.type', ['task', 'subtask'])
    
            ->where('wa.employee_id', $employeeId)
    
            ->where('wa.emid', $emid)
    
            ->select(
                'p.id as project_id',
                'p.title as project_name'
            )
    
            ->groupBy(
                'p.id',
                'p.title'
            )
    
            ->get();
    
        $result = [];
    
        foreach ($projects as $project) {
    
            $totalTasks = DB::table('work_item_assignments as wa')
    
                ->join('work_items as wi', 'wi.id', '=', 'wa.work_item_id')
    
                ->where('wa.employee_id', $employeeId)
                
                ->whereIn('wi.type', ['task', 'subtask'])
    
                ->where('wa.emid', $emid)
    
                ->where('wi.project_id', $project->project_id)
    
                ->count();
    
            $completedTasks = DB::table('work_item_assignments as wa')
    
                ->join('work_items as wi', 'wi.id', '=', 'wa.work_item_id')
    
                ->where('wa.employee_id', $employeeId)
                
                ->whereIn('wi.type', ['task', 'subtask'])
    
                ->where('wa.emid', $emid)
    
                ->where('wi.project_id', $project->project_id)
    
                ->where('wa.status', 'completed')
    
                ->count();
    
            $pendingTasks = $totalTasks - $completedTasks;
    
            $progress = $totalTasks > 0
                ? round(($completedTasks / $totalTasks) * 100)
                : 0;
    
            $result[] = [
    
                'project_id'       => $project->project_id,
    
                'project_name'     => $project->project_name,
    
                'completed_tasks'  => $completedTasks,
    
                'pending_tasks'    => $pendingTasks,
    
                'total_tasks'      => $totalTasks,
    
                'progress'         => $progress
            ];
        }
    
        return $result;
    }
    
    // Aattendance record
    private function attendanceData($employeeId, $emid)
    {
        $currentMonth = now()->format('m');
        $currentYear  = now()->format('Y');
    
        $totalPresent = Attandence::where('employee_code', $employeeId)
            ->where('emid', $emid)
            ->whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->count();
    
        return [
            'current_month' => now()->format('F Y'),
            'present_days'  => $totalPresent,
        ];
    }
    
    //holiday data
    private function leaveBalanceData($employeeId, $emid)
    {
        $leaveTypes = LeaveType::join(
                'leave_allocation',
                'leave_type.id',
                '=',
                'leave_allocation.leave_type_id'
            )
            ->leftJoin(
                'leave_type2',
                'leave_type.leave_type_name',
                '=',
                'leave_type2.leave_type_name'
            )
            ->where('leave_type.emid', $emid)
            ->where('leave_allocation.emid', $emid)
            ->where('leave_allocation.employee_code', $employeeId)
            ->where('leave_allocation.leave_in_hand', '>', 0)
            ->select(
                'leave_type.id',
                'leave_type.leave_type_name',
                DB::raw('COALESCE(leave_type2.color_code, "#3a87ad") as color_code')
            )
            ->groupBy(
                'leave_type.id',
                'leave_type.leave_type_name',
                'leave_type2.color_code'
            )
            ->get();
    
        $balances = [];
    
        foreach ($leaveTypes as $leaveType) {
    
            $balance = DB::table('leave_allocation')
    
                ->where('leave_type_id', $leaveType->id)
    
                ->where('employee_code', $employeeId)
    
                ->where('emid', $emid)
    
                ->latest('id')
    
                ->value('leave_in_hand');
    
            $balances[] = [
    
                'leave_type_id'   => $leaveType->id,
    
                'leave_type_name' => $leaveType->leave_type_name,
    
                'leave_in_hand'   => $balance ?? 0,
    
                'color_code'      => $leaveType->color_code,
            ];
        }
    
        return $balances;
    }
    
    
    
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
