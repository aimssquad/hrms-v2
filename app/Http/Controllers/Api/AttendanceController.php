<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\RotaEmployee;
use App\Models\Registration;
use App\Models\Employee;
use App\Models\Attandence;
use App\Models\BreakTimes;
use App\Models\Branch_location;
use App\Models\TempAttendance;
use App\Helpers\Api\Helper;
use Validator;
use Exception;
use DB;
use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;

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

    public function createMonthlyAttendance(Request $request){
        try {
            if (auth()->check()) {
                $employee_id = auth()->user()->employee_id;
                $employee_name = auth()->user()->name;
                $emid = auth()->user()->emid; 
                //dd(auth()->user());
                $emp_dtl = DB::table('employee')->where('emp_code',$employee_id)->where('emid',$emid)->first();
                $department = $emp_dtl->emp_department;
                $designation = $emp_dtl->emp_designation;
                $emp_department = DB::table('department')->where('department_name',$department)->where('emid',$emid)->first();
                $department_id = $emp_department->id;
                $emp_designtion = DB::table('designation')->where('department_code',$department_id)->where('emid',$emid)->where('designation_name',$designation)->first();
                $designation_id = $emp_designtion->id;
               
                $emp_roster = DB::table('duty_roster')
                    ->where('department',$department_id)
                    ->where('designation',$designation_id)
                    ->where('emid',$emid)
                    ->where('employee_id',$employee_id)
                    ->first();
                $shift_id = $emp_roster->id;
                $shift_code = $emp_roster->shift_code;

                $data['result'] = '';

                $employee_code = $employee_id;
                $end_date = date('Y-m-d', strtotime($request->end_date));
                $start_date = date('Y-m-d', strtotime($request->start_date));

                if (date('m', strtotime($end_date)) != date('m', strtotime($start_date))) {
                    $dynamicFlag = 1;
                    $data=[];
                    $message = "Month are not same";
                    return Helper::rjd(
                        $message,
                        $dynamicFlag,
                        $data
                    );
                } else {

                    $emp_details = DB::table('employee')->where('emp_code', '=', $employee_code)->where('emid', '=', $emid)->orderBy('id', 'DESC')->first();
                    $join_date = $emp_details->emp_doj;
                    $total_wk_days = 0;
                    $date1_ts = strtotime($start_date);
                    $date2_ts = strtotime($end_date);
                    $diff = $date2_ts - $date1_ts;
                    $gu = 0;
                    
                    $total_wk_days = (round($diff / 86400) + 1);
                    $holidays = DB::table('holiday')->where('from_date', '>=', $start_date)
                        ->where('to_date', '<=', $end_date)
                        ->where('emid', '=', $emid)
                        ->get();
                    $totday = 0;
                    //dd($holidays);
                    $offgholi = array();
                    foreach ($holidays as $holiday) {
                        $totday = $totday + $holiday->day;
                        if ($holiday->day > 1) {

                            for ($weh = date('d', strtotime($holiday->from_date)); $weh <= date('d', strtotime($holiday->to_date)); $weh++) {
                                if ($weh < 10 && $weh != '01') {
                                    $weh = '0' . $weh;
                                } else if ($weh == '01') {
                                    $weh = $weh;
                                } else {
                                    $weh = $weh;
                                }

                                $offgholi[] = date('Y-m', strtotime($holiday->from_date)) . '-' . $weh;
                            }
                        } else {
                            $offgholi[] = $holiday->from_date;
                        }
                    }
                    //dd($employee_code, $emid, $shift_id);
                    $duty_auth = DB::table('duty_roster')
                        ->where('employee_id', '=', $employee_code)
                        ->where('emid', '=', $emid)
                        ->where('shift_code', '=', $shift_code)
                        ->orderBy('id', 'ASC')
                        ->first();
                    //dd($duty_auth);
                    $offg = array();

                    //dd($shift_id);

                    if (!empty($duty_auth)) {

                        $shift_auth = DB::table('shift_management')
                            ->where('id', '=', $shift_code)

                            ->where('emid', '=', $emid)
                            ->orderBy('id', 'DESC')
                            ->first();
                        //dd($shift_auth);

                        $off_auth = DB::table('offday')

                            ->where('shift_code', '=', $duty_auth->shift_code)

                            ->where('emid', '=', $emid)
                            ->orderBy('id', 'DESC')
                            ->first();
                        //dd('opkk');
                    
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
                        //dd($offg);
                        $new_off = 0;
                        $fh = 1;

                        if (date('d', strtotime($start_date)) > $total_wk_days) {
                            $total_wk_days = date('d', strtotime($start_date)) + ($total_wk_days - 1);
                        } else if (date('d', strtotime($start_date)) != 1) {
                            $total_wk_days = date('d', strtotime($start_date)) + ($total_wk_days - 1);
                        } else {
                            $total_wk_days = $total_wk_days;
                        }
                        if (date('d', strtotime($start_date)) == date('d', strtotime($end_date))) {
                            $total_wk_days = date('d', strtotime($start_date));
                        }
                        //dd($total_wk_days);
                        for ($we = date('d', strtotime($start_date)); $we <= $total_wk_days; $we++) {

                            if (!empty($duty_auth)) {
                                $new_f = date('Y-m', strtotime($start_date)) . '-' . $we;
                                //dd($new_f);
                                $laeveppnre = DB::table('leave_apply')

                                    ->where('employee_id', '=', $employee_code)
                                    ->where('emid', '=', $emid)
                                    ->where('from_date', '<=', $new_f)
                                    ->where('to_date', '>=', $new_f)
                                    ->where('status', '=', 'APPROVED')
                                    ->orderBy('id', 'DESC')
                                    ->first();
                                //dd($laeveppnre);    
                                $laeveppnrejj = DB::table('leave_apply')

                                    ->where('employee_id', '=', $employee_code)
                                    ->where('emid', '=', $emid)
                                    ->where('from_date', '<=', $new_f)
                                    ->where('to_date', '>=', $new_f)
                                    ->where('status', '!=', 'APPROVED')
                                    ->orderBy('id', 'DESC')
                                    ->first();

                                    //dd($new_f);

                                if ($off_day >= 0) {

                                    if ((!empty($laeveppnre) || !empty($laeveppnrejj) && $join_date != $new_f)) {
                                        //dd('okk');
                                        if (in_array(date('l', strtotime($new_f)), $offg) && $join_date != $new_f) {
                                            //echo $new_f.'<br>';
                                            if (in_array($new_f, $offgholi) && $join_date != $new_f) {

                                            } else {

                                                $new_off = $new_off + 1;
                                            }

                                        }
                                        //dd($new_off);
                                    } else {
                                        //dd('kkk');
                                        if (in_array($new_f, $offgholi) && $join_date != $new_f) {

                                        } else if (in_array(date('l', strtotime($new_f)), $offg) && $join_date != $new_f) {

                                        } else {
                                        //dd('ooo');
                                            $month_entry = DB::table('attandence')->where('month', '=', date('m/Y', strtotime($start_date)))
                                                ->where('time_in', '=', $shift_auth->time_in)
                                                ->where('date', '=', $new_f)
                                                ->where('employee_code', '=', $employee_code)->where('emid', '=', $emid)->first();
                                            //dd($month_entry);
                                            if (empty($month_entry)) {

                                                $employee_attendence = DB::table('employee')
                                                    ->where('emp_code', '=', $employee_code)
                                                    ->where('emid', '=', $emid)
                                                    ->first();
                                                //dd($employee_attendence);   
                                                $datein = strtotime(date("Y-m-d " . $shift_auth->time_in));
                                                $dateout = strtotime(date("Y-m-d " . $shift_auth->time_out));
                                                $difference = abs($dateout - $datein) / 60;
                                                $hours = floor($difference / 60);
                                                $minutes = ($difference % 60);
                                                $minutes = str_pad($minutes,2,"0",STR_PAD_LEFT);
                                                $duty_hours = $hours . ":" . $minutes;
                                                $response['data'][] = [
                                                    'employee_code' => $employee_attendence->emp_code,
                                                    'employee_name' => $employee_attendence->emp_fname . ' ' . $employee_attendence->emp_mname . ' ' . $employee_attendence->emp_lname,
                                                    'month' => date('m/Y', strtotime($start_date)),
                                                    'date' => $new_f,
                                                    'time_in_location' => 'NA',
                                                    'time_out_location' => 'NA',
                                                    'display_date' => date('d/m/Y', strtotime($new_f)) . '(' . date('l', strtotime($new_f)) . ')',
                                                    'time_in' => $shift_auth->time_in,
                                                    //'time_in_location_display' => 'NA',
                                                    'time_out' => $shift_auth->time_out,
                                                    //'time_out_location_display' => 'NA',
                                                    'duty_hours' => $duty_hours
                                                ];

                                                $fh++;
                                            } else if (!empty($month_entry)) {
                                                $gu++;
                                            }

                                        }
                                    }

                                }

                            }

                        }

                    }

                    if ($gu > 0) {
                        $dynamicFlag = 1;
                        $data=[];
                        $message = "Attendance Data already exits.";
                        return Helper::rjd(
                            $message,
                            $dynamicFlag,
                            $data
                        );
                    }

                    $dynamicFlag = 1;
                    $data=$response;
                    $message = "Data get successfully.";
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


    // public function store(Request $request)
    // {
    //     if (!auth()->check()) {
    //         return Helper::rjd("Something Went Wrong", 1, []);
    //     }

    //     $user = auth()->user();
    //     //dd($user);
    //     $emid = $user->emid; 
    //     $employee_code = $user->employee_id;
    //     $employee_name = $user->name;
    //     //dd($user);
    //     $validated = $request->validate([
    //         'date' => 'required|date',
    //         'time' => 'required',
    //         'location' => 'nullable|string',
    //         'latitude' => 'nullable|numeric',
    //         'longitude' => 'nullable|numeric',
    //         'device_id' => 'nullable|string',
    //         'location_accuracy' => 'nullable|numeric',
    //         'is_location_mocked' => 'nullable|boolean',
    //         'photo_proof' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
    //         'punch_type' => 'nullable|string',
    //         'remarks' => 'nullable|string',
    //     ]);
        
    //     // Handle image upload if provided
    //     $photoProofPath = null;
    //     if ($request->hasFile('photo_proof')) {
    //         $photoProofPath = $request->file('photo_proof')->store('temp-attendance', 'public');
    //     } elseif ($request->filled('photo_proof')) {
    //         $photoProofPath = $this->storeBase64Image($request->photo_proof);
    //     }

    //     $attendance = TempAttendance::where('employee_code', $employee_code)
    //         ->where('date', $validated['date'])
    //         ->first();
    //     //dd($attendance);
    //     if (!$attendance) {
    //         // First punch => Login
    //         $data = [
    //             'employee_code' => $employee_code,
    //             'employee_name' => $employee_name ?? '',
    //             'date' => $validated['date'],
    //             'time_in' => $validated['time'],
    //             'time_in_location' => $validated['location'] ?? '',
    //             'time_in_latitude' => $validated['latitude'] ?? null,
    //             'time_in_longitude' => $validated['longitude'] ?? null,
    //             'device_id' => $validated['device_id'] ?? null,
    //             'location_accuracy' => $validated['location_accuracy'] ?? null,
    //             'is_location_mocked' => $validated['is_location_mocked'] ?? 0,
    //             'photo_proof' => $photoProofPath,
    //             'punch_type' => $validated['punch_type'] ?? 'Manual',
    //             'remarks' => $validated['remarks'] ?? '',
    //             'month' => Carbon::parse($validated['date'])->format('Y-m'),
    //             'punch_status' => 'IN',
    //             'emid' => $emid
    //         ];

    //         $created = TempAttendance::create($data);

    //         return response()->json([
    //             'flag' => 1,
    //             'status' => 200,
    //             'message' => 'Login recorded successfully.',
    //             'data' => $created
    //         ]);
    //     } else {
    //         // Second punch => Logout
    //         $timeIn = Carbon::parse($attendance->time_in);
    //         $timeOut = Carbon::parse($validated['time']);
    //         $dutyHours = $timeIn->diffInHours($timeOut) . ':' . $timeIn->diff($timeOut)->format('%I');

    //         $totalBreakMinutes = BreakTimes::where('emid', $emid)
    //             ->where('employee_code', $employee_code)
    //             ->where('date', $validated['date'])
    //             ->sum('total_break_time');

    //         // Convert minutes to HH:MM:SS format
    //         if ($totalBreakMinutes) {
    //             $hours = floor($totalBreakMinutes / 60);
    //             $minutes = $totalBreakMinutes % 60;
    //             $seconds = 0; // Add seconds if needed
                
    //             $totalBreak = sprintf("%02d:%02d:%02d", $hours, $minutes, $seconds);
    //         } else {
    //             $totalBreak = '00:00:00';
    //         }

    //         //dd($totalBreak);
    //         $updateData = [
    //             'time_out' => $validated['time'],
    //             'time_out_location' => $validated['location'] ?? '',
    //             'time_out_latitude' => $validated['latitude'] ?? null,
    //             'time_out_longitude' => $validated['longitude'] ?? null,
    //             'break_hours' => $totalBreak,
    //             'duty_hours' => $dutyHours,
    //             'punch_status' => 'OUT',
    //         ];

    //         if ($photoProofPath) {
    //             $updateData['photo_proof_out'] = $photoProofPath;
    //         }

    //         $attendance->update($updateData);

    //         return response()->json([
    //             'flag' => 1,
    //             'status' => 200,
    //             'message' => 'Logout recorded successfully.',
    //             'data' => $attendance
    //         ]);
    //     }
    // }

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return Helper::rjd("Something Went Wrong", 1, []);
        }

        $user = auth()->user();
        $emid = $user->emid; 
        $employee_code = $user->employee_id;
        $employee_name = $user->name;

        $validated = $request->validate([
            'date' => 'required|date',
            'time' => 'required',
            'location' => 'nullable|string',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'device_id' => 'nullable|string',
            'location_accuracy' => 'nullable|numeric',
            'is_location_mocked' => 'nullable|boolean',
            'photo_proof' => 'nullable|sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'punch_type' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);
        
        $photoProofPath = null;
        if ($request->hasFile('photo_proof')) {
            $photoProofPath = $request->file('photo_proof')->store('temp-attendance', 'public');
        } elseif ($request->filled('photo_proof')) {
            $photoProofPath = $this->storeBase64Image($request->photo_proof);
        }

        $attendance = TempAttendance::where('employee_code', $employee_code)
            ->where('date', $validated['date'])
            ->first();

        if (!$attendance) {
            // First Punch (Login) → Save ONLY in temp_attendances
            $data = [
                'employee_code'      => $employee_code,
                'employee_name'      => $employee_name ?? '',
                'date'               => $validated['date'],
                'time_in'            => $validated['time'],
                'time_in_location'   => $validated['location'] ?? '',
                'time_in_latitude'   => $validated['latitude'] ?? null,
                'time_in_longitude'  => $validated['longitude'] ?? null,
                'device_id'          => $validated['device_id'] ?? null,
                'location_accuracy'  => $validated['location_accuracy'] ?? null,
                'is_location_mocked' => $validated['is_location_mocked'] ?? 0,
                'photo_proof'        => $photoProofPath,
                'punch_type'         => $validated['punch_type'] ?? 'Manual',
                'remarks'            => $validated['remarks'] ?? '',
                'month'              => Carbon::parse($validated['date'])->format('Y-m'),
                'punch_status'       => 'IN',
                'emid'               => $emid
            ];

            $created = TempAttendance::create($data);

            return response()->json([
                'flag' => 1,
                'status' => 200,
                'message' => 'Login recorded successfully.',
                'data' => $created
            ]);

        } else {
            // Second Punch (Logout) → Save in temp_attendances + main attandence
            $timeIn = Carbon::parse($attendance->time_in);
            $timeOut = Carbon::parse($validated['time']);
            $dutyHours = $timeIn->diffInHours($timeOut) . ':' . $timeIn->diff($timeOut)->format('%I');

            $totalBreakMinutes = BreakTimes::where('emid', $emid)
                ->where('employee_code', $employee_code)
                ->where('date', $validated['date'])
                ->sum('total_break_time');

            $totalBreak = $totalBreakMinutes
                ? sprintf("%02d:%02d:%02d", floor($totalBreakMinutes / 60), $totalBreakMinutes % 60, 0)
                : '00:00:00';

            $updateData = [
                'time_out'          => $validated['time'],
                'time_out_location' => $validated['location'] ?? '',
                'time_out_latitude' => $validated['latitude'] ?? null,
                'time_out_longitude'=> $validated['longitude'] ?? null,
                'break_hours'       => $totalBreak,
                'duty_hours'        => $dutyHours,
                'punch_status'      => 'OUT',
            ];

            if ($photoProofPath) {
                $updateData['photo_proof_out'] = $photoProofPath;
            }

            $attendance->update($updateData);

            // ✅ Save into attandence table ONLY if not exists
            $alreadyExists = Attandence::where('emid', $emid)
                ->where('employee_code', $employee_code)
                ->where('date', $validated['date'])
                ->exists();

            if (!$alreadyExists) {
                Attandence::create([
                    'employee_code'     => $employee_code,
                    'employee_name'     => $employee_name,
                    'date'              => $validated['date'],
                    'time_in'           => $attendance->time_in,
                    'time_out'          => $updateData['time_out'],
                    'month'             => Carbon::parse($validated['date'])->format('m/Y'),
                    'time_in_location'  => $attendance->time_in_location,
                    'time_out_location' => $updateData['time_out_location'],
                    'duty_hours'        => $dutyHours,
                    'emid'              => $emid,
                ]);
            }

            return response()->json([
                'flag' => 1,
                'status' => 200,
                'message' => 'Logout recorded successfully.',
                'data' => $attendance
            ]);
        }
    }




    protected function storeBase64Image($base64String)
    {
        try {
            @list($type, $fileData) = explode(';', $base64String);
            @list(, $fileData) = explode(',', $fileData); 
            $extension = explode('/', $type)[1];
            
            if (!in_array($extension, ['jpeg', 'png', 'jpg', 'gif'])) {
                throw new \Exception('Invalid image type');
            }
            
            $fileName = uniqid().'.'.$extension;
            $destinationPath = storage_path('app/public/temp-attendance/');
            
            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0755, true);
            }
            
            file_put_contents($destinationPath.$fileName, base64_decode($fileData));
            
            return 'temp-attendance/'.$fileName;
        } catch (\Exception $e) {
            \Log::error('Failed to store base64 image: '.$e->getMessage());
            return null;
        }
    }


    public function showEmpAttendance(Request $request)
    {
        try {
            if (auth()->check()) {
                $validated = $request->validate([
                    'from_date' => 'nullable|date_format:Y-m-d',
                    'to_date' => 'nullable|date_format:Y-m-d'
                ]);

                $employee_id = auth()->user()->employee_id;
                $emid = auth()->user()->emid;

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
                    ->where('department_status', 'active')
                    ->first();

                $designation = DB::table('designation')
                    ->where('designation_name', $employee->emp_designation)
                    ->where('emid', $emid)
                    ->first();

                // 3. Get employee shift information
                $shift = DB::table('shift_management')
                    ->where('department', $department->id ?? null)
                    ->where('designation', $designation->id ?? null)
                    ->where('emid', $emid)
                    ->first();

                if (empty($shift)) {
                    return Helper::rjd("Please Assign shift first", 1, []);
                }

                // 4. Get employee off days based on shift
                $offDayRecord = DB::table('offday')
                    ->where('shift_code', $shift->id ?? null)
                    ->where('department', $department->id ?? null)
                    ->where('designation', $designation->id ?? null)
                    ->where('emid', $emid)
                    ->first();

                if (empty($offDayRecord)) {
                    return Helper::rjd("Please Assign offday first", 1, []);
                }

                // Determine which days are off days
                $offDays = [];
                $daysMapping = [
                    'sun' => 0, 'mon' => 1, 'tue' => 2, 'wed' => 3,
                    'thu' => 4, 'fri' => 5, 'sat' => 6
                ];
                foreach ($daysMapping as $column => $dayIndex) {
                    if ($offDayRecord->{$column} === '1') {
                        $offDays[] = $dayIndex;
                    }
                }

                // 5. Set date range
                $startDate = !empty($validated['from_date']) ? $validated['from_date'] : date('Y-m-01');
                $endDate   = !empty($validated['to_date']) ? $validated['to_date'] : date('Y-m-t');

                $period = new DatePeriod(
                    new DateTime($startDate),
                    new DateInterval('P1D'),
                    new DateTime(date('Y-m-d', strtotime($endDate . ' +1 day')))
                );

                // Filter out off days
                $workingDays = [];
                foreach ($period as $date) {
                    $dayOfWeek = (int)$date->format('w'); // 0 = Sun, 6 = Sat
                    if (!in_array($dayOfWeek, $offDays)) {
                        $workingDays[] = $date->format('Y-m-d');
                    }
                }

                // 6. Get attendance records for working days
                $attendance = TempAttendance::where('employee_code', $employee_id)
                    ->where('emid', $emid)
                    ->whereIn('date', $workingDays)
                    ->where('punch_status','OUT')
                    ->orderBy('date', 'desc')
                    ->get();

                // 7. Build complete attendance (present + absent)
                $completeAttendance = [];
                foreach ($workingDays as $workingDay) {
                    $record = $attendance->firstWhere('date', $workingDay);

                    if ($record) {
                        // $completeAttendance[] = [
                        //     'id' => $record->id ?? '',
                        //     'employee_code' => $record->employee_code ?? '',
                        //     'employee_name' => $record->employee_name ?? '',
                        //     'date' => $record->date ?? '',
                        //     'time_in' => $record->time_in ?? '',
                        //     'time_out' => $record->time_out ?? '',
                        //     'time_in_location' => $record->time_in_location ?? '',
                        //     'time_out_location' => $record->time_out_location ?? '',
                        //     'time_in_latitude' => $record->time_in_latitude ?? '',
                        //     'time_in_longitude' => $record->time_in_longitude ?? '',
                        //     'time_out_latitude' => $record->time_out_latitude ?? '',
                        //     'time_out_longitude' => $record->time_out_longitude ?? '',
                        //     'duty_hours' => $record->duty_hours ?? '',
                        //     'break_hours' => $record->break_hours ?? '',
                        //     'month' => $record->month ?? '',
                        //     'emid' => $record->emid ?? '',
                        //     'device_id' => $record->device_id ?? '',
                        //     'location_accuracy' => $record->location_accuracy ?? '',
                        //     'is_location_mocked' => $record->is_location_mocked ?? '',
                        //     'photo_proof' => $record->photo_proof ?? '',
                        //     'punch_type' => $record->punch_type ?? '',
                        //     'punch_status' => $record->punch_status ?? '',
                        //     'remarks' => $record->remarks ?? '',
                        //     'created_at' => $record->created_at ?? '',
                        //     'updated_at' => $record->updated_at ?? ''
                        // ];
                        $completeAttendance[] = [
                            'id' => $record->id ?? '',
                            'employee_code' => $record->employee_code ?? '',
                            'employee_name' => $record->employee_name ?? '',
                            'date' => $record->date ?? '',
                            'time_in' => $record->time_in ?? '',
                            'time_out' => $record->time_out ?? '',
                            'time_in_location' => $record->time_in_location ?? '',
                            'time_out_location' => $record->time_out_location ?? '',
                            'time_in_latitude' => $record->time_in_latitude ?? '',
                            'time_in_longitude' => $record->time_in_longitude ?? '',
                            'time_out_latitude' => $record->time_out_latitude ?? '',
                            'time_out_longitude' => $record->time_out_longitude ?? '',
                            'duty_hours' => $record->duty_hours ?? '',
                            'break_hours' => $record->break_hours ?? '',
                            'month' => $record->month ?? '',
                            'emid' => $record->emid ?? '',
                            'device_id' => $record->device_id ?? '',
                            'location_accuracy' => $record->location_accuracy ?? '',
                            'is_location_mocked' => $record->is_location_mocked ?? '',
                            'photo_proof' => $record->photo_proof ?? '',
                            'punch_type' => $record->punch_type ?? '',
                            'punch_status' => $record->punch_status ?? '',
                            'remarks' => $record->remarks ?? '',
                            'created_at' => $record->created_at ?? '',
                            'updated_at' => $record->updated_at ?? ''
                        ];
                    } else {
                        // Absent record
                        // $completeAttendance[] = [
                        //     'id' => 0,
                        //     'employee_code' => '',
                        //     'employee_name' => '',
                        //     'date' => $workingDay, 
                        //     'time_in' => '00:00:00',
                        //     'time_out' => '00:00:00',
                        //     'time_in_location' => '',
                        //     'time_out_location' => '',
                        //     'time_in_latitude' => '',
                        //     'time_in_longitude' => '',
                        //     'time_out_latitude' => '',
                        //     'time_out_longitude' => '',
                        //     'duty_hours' => '',
                        //     'break_hours' => '',
                        //     'month' => '',
                        //     'emid' => '',
                        //     'device_id' => '',
                        //     'location_accuracy' => '00.0',
                        //     'is_location_mocked' => 0,
                        //     'photo_proof' => '',
                        //     'punch_type' => '',
                        //     'punch_status' => '',
                        //     'remarks' => '',
                        //     'created_at' => '',
                        //     'updated_at' => ''
                        // ];
                         $completeAttendance[] = [
                            'id' => (int)($record->id ?? 0),
                            'employee_code' => (string)($record->employee_code ?? ''),
                            'employee_name' => (string)($record->employee_name ?? ''),
                            'date' => (string)($workingDay ?? ''),
                            'time_in' => (string)($record->time_in ?? '00:00:00'),
                            'time_out' => (string)($record->time_out ?? '00:00:00'),
                            'time_in_location' => (string)($record->time_in_location ?? ''),
                            'time_out_location' => (string)($record->time_out_location ?? ''),
                            'time_in_latitude' => (string)($record->time_in_latitude ?? ''),
                            'time_in_longitude' => (string)($record->time_in_longitude ?? ''),
                            'time_out_latitude' => (string)($record->time_out_latitude ?? ''),
                            'time_out_longitude' => (string)($record->time_out_longitude ?? ''),
                            'duty_hours' => (string)($record->duty_hours ?? ''),
                            'break_hours' => (string)($record->break_hours ?? ''),
                            'month' => (string)($record->month ?? ''),
                            'emid' => (string)($record->emid ?? ''),
                            'device_id' => (string)($record->device_id ?? ''),
                            'location_accuracy' => (string)($record->location_accuracy ?? '00.0'),
                            'is_location_mocked' => (int)($record->is_location_mocked ?? 0),
                            'photo_proof' => (string)($record->photo_proof ?? ''),
                            'punch_type' => (string)($record->punch_type ?? ''),
                            'punch_status' => (string)($record->punch_status ?? ''),
                            'remarks' => (string)($record->remarks ?? ''),
                            'created_at' => (string)($record->created_at ?? ''),
                            'updated_at' => (string)($record->updated_at ?? '')
                        ];
                    }
                }

                // 8. Summary
                $totalWorkingDays = count($workingDays);
                $presentDays = $attendance->count();
                $absentDays = $totalWorkingDays - $presentDays;

                $summary = [
                    'total_working_days' => $totalWorkingDays,
                    'present_days' => $presentDays,
                    'absent_days' => $absentDays,
                    'from_date' => $startDate,
                    'to_date' => $endDate
                ];

                if (empty($completeAttendance)) {
                    return Helper::rjd("Attendance not found", 1, []);
                }

                return response()->json([
                    'status'=>200,
                    'flag' => 1,
                    'data'=> $completeAttendance,
                    'total_leave'=> $presentDays,
                    'message' => "Data retrieved successfully"

                ]);

                // 9. Response
                // return response()->json([
                //     'status' => 200,
                //     'flag' => 1,
                //     'data' => $completeAttendance,
                //     'summary' => $summary,
                //     'message' => "Data retrieved successfully"
                // ]);
            }
        } catch (Exception $e) {
            return Helper::rj("Server Error.", 500);
        }
    }



    //this is testing function for attendance filtaring 
    // public function showEmpAttendance(Request $request) {
    //     try {
    //         if (auth()->check()) {
    //             $validated = $request->validate([
    //                 'from_date' => 'nullable|date_format:Y-m-d',
    //                 'to_date' => 'nullable|date_format:Y-m-d'
    //             ]);
                
    //             $employee_id = auth()->user()->employee_id;
    //             $emid = auth()->user()->emid;
                
    //             // 1. Get employee basic info
    //             $employee = DB::table('employee')
    //                 ->where('emp_code', $employee_id)
    //                 ->where('emid', $emid)
    //                 ->first();
                
    //             if (!$employee) {
    //                 return response()->json(['error' => 'Employee not found'], 404);
    //             }
                
    //             // 2. Get department and designation IDs
    //             $department = DB::table('department')
    //                 ->where('department_name', $employee->emp_department)
    //                 ->where('emid', $emid)
    //                 ->where('department_status','active')
    //                 ->first();
    //             //dd($employee->emp_designation);
    //             $designation = DB::table('designation')
    //                 ->where('designation_name', $employee->emp_designation)
    //                 //->where('department_code',$department->id)
    //                 ->where('emid', $emid)
    //                 ->first();
    //             //dd($designation);
    //             // 3. Get employee shift information
    //             $shift = DB::table('shift_management')
    //                 ->where('department', $department->id ?? null)
    //                 ->where('designation',$designation->id?? null)
    //                 ->where('emid', $emid)
    //                 ->first();

    //             if(empty($shift)){
    //                 $dynamicFlag = 1;
    //                 $data = [];
    //                 $message = "Please Assign shift first";
    //                 return Helper::rjd($message, $dynamicFlag, $data);
    //             }    
    //             //dd($shift);
    //             // 4. Get employee off days based on shift
    //             $offDayRecord = DB::table('offday')
    //                 ->where('shift_code', $shift->id ?? null)
    //                 ->where('department', $department->id ?? null)
    //                 ->where('designation', $designation->id ?? null)
    //                 ->where('emid', $emid)
    //                 ->first();
    //             //dd($offDayRecord);
    //             if(empty($offDayRecord)){
    //                 $dynamicFlag = 1;
    //                 $data = [];
    //                 $message = "Please Assign offday first";
    //                 return Helper::rjd($message, $dynamicFlag, $data);
    //             }

    //             //dd($offDayRecord);
    //             // Determine which days are off days
    //             $offDays = [];
    //             if ($offDayRecord) {
    //                 $daysMapping = [
    //                     'sun' => 0, // Sunday
    //                     'mon' => 1, // Monday
    //                     'tue' => 2, // Tuesday
    //                     'wed' => 3, // Wednesday
    //                     'thu' => 4, // Thursday
    //                     'fri' => 5, // Friday
    //                     'sat' => 6  // Saturday
    //                 ];
                    
    //                 foreach ($daysMapping as $column => $dayIndex) {
    //                     if ($offDayRecord->{$column} === '1') {
    //                         $offDays[] = $dayIndex;
    //                     }
    //                 }
    //             }
    //             //dd($offDays);
    //             // Set date range - default to current month if not specified
    //             $startDate = !empty($validated['from_date']) ? $validated['from_date'] : date('Y-m-01');
    //             $endDate = !empty($validated['to_date']) ? $validated['to_date'] : date('Y-m-t');
                
    //             // Generate all dates in the range
    //             $period = new DatePeriod(
    //                 new DateTime($startDate),
    //                 new DateInterval('P1D'),
    //                 new DateTime(date('Y-m-d', strtotime($endDate . ' +1 day')))
    //             );
                
    //             // Filter out off days to get only working days
    //             $workingDays = [];
    //             foreach ($period as $date) {
    //                 $dayOfWeek = (int)$date->format('w'); // 0 (Sunday) to 6 (Saturday)
    //                 if (!in_array($dayOfWeek, $offDays)) {
    //                     $workingDays[] = $date->format('Y-m-d');
    //                 }
    //             }
    //             //dd($workingDays);
    //             // Get attendance records for working days only
    //             //dd($workingDays);
    //             $attendance = TempAttendance::where('employee_code', $employee_id)
    //                 ->where('emid', $emid)
    //                 ->whereIn('date', $workingDays)
    //                 ->orderBy('date', 'desc')
    //                 ->get();
    //             //dd($attendance);
    //             // Create complete response with all working days
    //             $completeAttendance = [];
    //             foreach ($workingDays as $workingDay) {
    //                 // Find attendance record for this working day
    //                 $record = $attendance->firstWhere('date', $workingDay);
                    
    //                 if ($record) {
    //                     $completeAttendance[] = [
    //                         'id' => $record->id ?? '',
    //                         'employee_code' => $record->employee_code ?? '',
    //                         'employee_name' => $record->employee_name ?? '',
    //                         'date' => $record->date ?? '',
    //                         'time_in' => $record->time_in ?? '',
    //                         'time_out' => $record->time_out ?? '',
    //                         'time_in_location' => $record->time_in_location ?? '',
    //                         'time_out_location' => $record->time_out_location ?? '',
    //                         'time_in_latitude' => $record->time_in_latitude ?? '',
    //                         'time_in_longitude' => $record->time_in_longitude ?? '',
    //                         'time_out_latitude' => $record->time_out_latitude ?? '',
    //                         'time_out_longitude' => $record->time_out_longitude ?? '',
    //                         'duty_hours' => $record->duty_hours ?? '',
    //                         'break_hours' => $record->break_hours ?? '',
    //                         'month' => $record->month ?? '',
    //                         'emid' => $record->emid ?? '',
    //                         'device_id' => $record->device_id ?? '',
    //                         'location_accuracy' => $record->location_accuracy ?? '',
    //                         'is_location_mocked' => $record->is_location_mocked ?? '',
    //                         'photo_proof' => $record->photo_proof ?? '',
    //                         'punch_type' => $record->punch_type ?? '',
    //                         'punch_status' => $record->punch_status ?? '',
    //                         'remarks' => $record->remarks ?? '',
    //                         'created_at' => $record->created_at ?? '',
    //                         'updated_at' => $record->updated_at ?? ''
    //                     ];
    //                 } else {
    //                     $defaultDate = \Carbon\Carbon::parse($workingDay)->addDay()->format('Y-m-d');
    //                     $completeAttendance[] = [
    //                         'id' => (int)($record->id ?? 0),
    //                         'employee_code' => (string)($record->employee_code ?? ''),
    //                         'employee_name' => (string)($record->employee_name ?? ''),
    //                         'date' => (string)($defaultDate ?? ''),
    //                         'time_in' => (string)($record->time_in ?? '00:00:00'),
    //                         'time_out' => (string)($record->time_out ?? '00:00:00'),
    //                         'time_in_location' => (string)($record->time_in_location ?? ''),
    //                         'time_out_location' => (string)($record->time_out_location ?? ''),
    //                         'time_in_latitude' => (string)($record->time_in_latitude ?? ''),
    //                         'time_in_longitude' => (string)($record->time_in_longitude ?? ''),
    //                         'time_out_latitude' => (string)($record->time_out_latitude ?? ''),
    //                         'time_out_longitude' => (string)($record->time_out_longitude ?? ''),
    //                         'duty_hours' => (string)($record->duty_hours ?? ''),
    //                         'break_hours' => (string)($record->break_hours ?? ''),
    //                         'month' => (string)($record->month ?? ''),
    //                         'emid' => (string)($record->emid ?? ''),
    //                         'device_id' => (string)($record->device_id ?? ''),
    //                         'location_accuracy' => (string)($record->location_accuracy ?? '00.0'),
    //                         'is_location_mocked' => (int)($record->is_location_mocked ?? 0),
    //                         'photo_proof' => (string)($record->photo_proof ?? ''),
    //                         'punch_type' => (string)($record->punch_type ?? ''),
    //                         'punch_status' => (string)($record->punch_status ?? ''),
    //                         'remarks' => (string)($record->remarks ?? ''),
    //                         'created_at' => (string)($record->created_at ?? ''),
    //                         'updated_at' => (string)($record->updated_at ?? '')
    //                     ];
    //                 }
    //             }
                
    //             // Add summary information
    //             $totalWorkingDays = count($workingDays);
    //             $presentDays = $attendance->count();
    //             $absentDays = $totalWorkingDays - $presentDays;
                
    //             $summary = [
    //                 'total_working_days' => $totalWorkingDays,
    //                 'present_days' => $presentDays,
    //                 'absent_days' => $absentDays,
    //                 'from_date' => $startDate,
    //                 'to_date' => $endDate
    //             ];
                
    //             if(empty($completeAttendance)){
    //                 $dynamicFlag = 1;
    //                 $data = [];
    //                 $message = "Attendance not found";
    //                 return Helper::rjd($message, $dynamicFlag, $data);
    //             }

    //             //$dynamicFlag = 1;
    //             //$data = $completeAttendance;
    //             //$summary = $summary;
    //             // $data = [
    //             //     'attendance' => $completeAttendance,
    //             //     'summary' => $summary
    //             // ];
    //             // $message = "Data retrieved successfully";

    //             return response()->json([
    //                 'status'=>200,
    //                 'flag' => 1,
    //                 'data'=> $completeAttendance,
    //                 'total_leave'=> $presentDays,
    //                 'message' => "Data retrieved successfully"

    //             ]);

    //             //return Helper::rjd($message, $dynamicFlag, $data);
    //         }
    //     } catch (Exception $e) {
    //         return Helper::rj("Server Error.", 500);
    //     }         
    // }

    // this is my main function for attendance filtaring through date
    // public function showEmpAttendance(Request $request) {
    //     try {
    //         if (auth()->check()) {
    //             $validated = $request->validate([
    //                 'from_date' => 'nullable|date_format:Y-m-d',
    //                 'to_date' => 'nullable|date_format:Y-m-d'
    //             ]);
    //             //dd(auth()->user());
    //             $employee_id = auth()->user()->employee_id;
    //             $emid = auth()->user()->emid;
                
    //             // Base query
    //             $query = TempAttendance::where('employee_code', $employee_id)
    //                                 ->where('emid', $emid)
    //                                 ->orderBy('date', 'desc');

         
    //             if (!empty($validated['from_date']) && !empty($validated['to_date'])) {
    //                 $query->whereBetween('date', [$validated['from_date'], $validated['to_date']]);
    //             } 
             
    //             elseif (!empty($validated['from_date'])) {
    //                 $query->where('date', '>=', $validated['from_date']);
    //             }
    //             // Apply single date filter if only to_date is provided
    //             elseif (!empty($validated['to_date'])) {
    //                 $query->where('date', '<=', $validated['to_date']);
    //             }
    //             // If no date filters, get last 7 records
    //             else {
    //                 $query->limit(7);
    //             }

    //             $attendance = $query->get();

    //             if($attendance->isEmpty()){
    //                 $dynamicFlag = 1;
    //                 $data=[];
    //                 $message = "Attendance  not found";
    //                 return Helper::rjd(
    //                     $message,
    //                     $dynamicFlag,
    //                     $data
    //                 );
    //             }


    //             $attendance->transform(function ($item) {
    //                 return collect($item)->map(function ($value) {
    //                     return $value === null ? "" : $value;
    //                 });
    //             });

    //             $dynamicFlag = 1;
    //             $data=$attendance;
    //             $message = "Data get successfully";
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



    

    public function showEmpAttendanceStatus(Request $request) {
        try {
            if (auth()->check()) {
                $employee_id = auth()->user()->employee_id;
                $emid = auth()->user()->emid;
                $date = date('Y-m-d');
                
                // Base query
                $attendance = Attandence::where('employee_code', $employee_id)
                                    ->where('emid', $emid)
                                    ->where('date', $date)
                                    ->orderBy('id','desc')
                                    ->first();

                if (!$attendance) {
                    $dynamicFlag = 1;
                    $data = []; // Empty array
                    $message = "Attendance not found";
                    return Helper::rjd(
                        $message,
                        $dynamicFlag,
                        $data
                    );
                }

                // Convert the single model to array and replace nulls with empty strings
                $attendanceArray = $attendance->toArray();
                $cleanedAttendance = array_map(function($value) {
                    return $value === null ? "" : $value;
                }, $attendanceArray);

                $dynamicFlag = 1;
                $data = [$cleanedAttendance]; // Wrap in array to make it a list
                $message = "Data get successfully";
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
