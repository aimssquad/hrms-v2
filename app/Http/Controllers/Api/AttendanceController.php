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
use DateTime;
use DatePeriod;
use DateInterval;

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
                if(isset($request->from_date) && $request->to_date){
                    $startDate = $request->from_date;
                    $endDate = $request->to_date;
                     // Validate date range doesn't exceed 1 month
                    $start = new DateTime($startDate);
                    $end = new DateTime($endDate);
                    $diff = $start->diff($end);
                    
                    if ($diff->m >= 1 || $diff->y > 0) {
                        $dynamicFlag = 1;
                        $data=[];
                        $message = "Date range cannot exceed one month.";
                        return Helper::rjd(
                            $message,
                            $dynamicFlag,
                            $data
                        );
                    }
                } else{
                    $startDate = date('Y-m-01'); // First day of current month
                    $endDate = date('Y-m-t');
                }
                
                
                // 1. Get employee basic info
                $employee = DB::table('employee')
                    ->where('emp_code', $employee_id)
                    ->where('emid', $emid)
                    ->first();
            
                if (!$employee) {
                    return response()->json(['error' => 'Employee not found'], 404);
                }
            
                // 2. Get department and designation IDs
                $department = DB::table('department')
                    ->where('department_name', $employee->emp_department)
                    ->where('emid', $emid)
                    ->first();
            
                $designation = DB::table('designation')
                    ->where('designation_name', $employee->emp_designation)
                    ->where('emid', $emid)
                    ->first();
            
                // 3. Get employee shift information
                $shift = DB::table('shift_management')
                    ->where('department', $department->id ?? null)
                    ->where('emid', $emid)
                    ->first();
            
                // 4. Get employee off days based on shift
                $offDayRecord = DB::table('offday')
                    ->where('shift_code', $shift->id ?? null)
                    ->where('department', $department->id ?? null)
                    ->where('designation', $designation->id ?? null)
                    ->where('emid', $emid)
                    ->first();
            
                // Determine which days are off days
                $offDays = [];
                if ($offDayRecord) {
                    $daysMapping = [
                        'sun' => 'Sunday',
                        'mon' => 'Monday',
                        'tue' => 'Tuesday',
                        'wed' => 'Wednesday',
                        'thu' => 'Thursday',
                        'fri' => 'Friday',
                        'sat' => 'Saturday'
                    ];
                    
                    foreach ($daysMapping as $column => $dayName) {
                        if ($offDayRecord->{$column} === '1') {
                            $offDays[] = $dayName;
                        }
                    }
                }
            
                // 5. Get attendance records
                $attendance = DB::table('attandence')
                    ->where('employee_code', $employee_id)
                    ->where('emid', $emid)
                    ->whereBetween('date', [$startDate, $endDate])
                    ->orderBy('date', 'asc')
                    ->get()
                    ->keyBy(function($item) {
                        return date('Y-m-d', strtotime($item->date));
                    });
            
                // 6. Get approved leaves
                $leaves = DB::table('leave_apply')
                    ->where('employee_id', $employee_id)
                    ->where('emid', $emid)
                    ->where('status', 'APPROVED')
                    ->where(function($query) use ($startDate, $endDate) {
                        $query->whereBetween('from_date', [$startDate, $endDate])
                            ->orWhereBetween('to_date', [$startDate, $endDate])
                            ->orWhere(function($q) use ($startDate, $endDate) {
                                $q->where('from_date', '<=', $startDate)
                                    ->where('to_date', '>=', $endDate);
                            });
                    })
                    ->get();
            
                // 7. Get holidays with type names
                $holidays = DB::table('holiday as h')
                    ->join('holiday_type as ht', 'h.holiday_type', '=', 'ht.id')
                    ->where('h.emid', $emid)
                    ->where(function($query) use ($startDate, $endDate) {
                        $query->whereBetween('h.from_date', [$startDate, $endDate])
                            ->orWhereBetween('h.to_date', [$startDate, $endDate])
                            ->orWhere(function($q) use ($startDate, $endDate) {
                                $q->where('h.from_date', '<=', $startDate)
                                    ->where('h.to_date', '>=', $endDate);
                            });
                    })
                    ->select('h.*', 'ht.name as holiday_type_name')
                    ->get();
            
                // Process holidays into individual dates
                $holidayDates = [];
                foreach ($holidays as $holiday) {
                    $start = new DateTime($holiday->from_date);
                    $end = new DateTime($holiday->to_date);
                    
                    // Handle case where to_date might be before from_date
                    if ($start > $end) {
                        $temp = $start;
                        $start = $end;
                        $end = $temp;
                    }
                    
                    for ($date = clone $start; $date <= $end; $date->modify('+1 day')) {
                        $dateStr = $date->format('Y-m-d');
                        $holidayDates[$dateStr] = [
                            'name' => $holiday->holiday_descripion,
                            'type' => $holiday->holiday_type_name
                        ];
                    }
                }
            
                // Generate report
                $attendanceReport = [];
                $period = new DatePeriod(
                    new DateTime($startDate),
                    new DateInterval('P1D'),
                    new DateTime($endDate . ' +1 day')
                );
            
                foreach ($period as $date) {
                    $dateStr = $date->format('Y-m-d');
                    $dayName = $date->format('l'); // Full day name (e.g. Monday)
                    
                    $record = [
                        'Employee Name' => trim("$employee->emp_fname $employee->emp_mname $employee->emp_lname"),
                        'Employee Designation' => $employee->emp_designation,
                        'Date' => $date->format('d/m/Y'),
                        'Intime' => 'NA',
                        'Outtime' => 'NA',
                        'Duty Hour' => 'NA',
                        'Status' => 'Absent' // Default status
                    ];
                    
                    // Check if it's an off day
                    if (in_array($dayName, $offDays)) {
                        $record['Intime'] = 'Off Day';
                        $record['Status'] = 'Off Day';
                    }
                    // Check if holiday
                    elseif (isset($holidayDates[$dateStr])) {
                        $record['Intime'] = 'Holiday';
                        $record['Status'] = 'Holiday (' . $holidayDates[$dateStr]['name'] . ')';
                    }
                    // Check if on leave
                    else {
                        foreach ($leaves as $leave) {
                            $leaveStart = new DateTime($leave->from_date);
                            $leaveEnd = new DateTime($leave->to_date);
                            $currentDate = new DateTime($dateStr);
                            
                            if ($currentDate >= $leaveStart && $currentDate <= $leaveEnd) {
                                $record['Intime'] = 'Leave';
                                $record['Status'] = 'Leave (' . ($leave->leave_type_name ?? '') . ')';
                                break;
                            }
                        }
                    }
                    
                    // If attendance exists (overrides other statuses)
                    if (isset($attendance[$dateStr])) {
                        $att = $attendance[$dateStr];
                        $record['Intime'] = $att->time_in ?? 'NA';
                        $record['Outtime'] = $att->time_out ?? 'NA';
                        $record['Duty Hour'] = $att->duty_hours ?? 'NA';
                        $record['Status'] = 'Present';
                    }
                    
                    $attendanceReport[] = $record;
                }
                //dd($attendanceReport);
                $dynamicFlag = 1;
                $data=$attendanceReport;
                $message = "Employee attendance get successfully.";
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


} //End Class
