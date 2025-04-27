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
                // $emp_shift = DB::table('shift_management')->where('')   
                //dd($department, $designation, $department_id, $designation_id, $shift_id,$employee_id);
                // $Roledata = DB::table('registration')->where('status', '=', 'active')
                //     ->where('reg', '=', $emid)
                //     ->first();
                // $data['Roledata'] = DB::table('registration')->where('status', '=', 'active')
                //     ->where('reg', '=', $emid)
                //     ->first();

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
                                                //dd($employee_attendence->emp_code);
                                                // $data['result'] .= '<tr>
                                                //     <input type="hidden" class="form-control" readonly="" name="employee_code" value="' . $employee_attendence->emp_code . '">
                                                //         <input type="hidden" class="form-control" readonly="" name="employee_name" value="' . $employee_attendence->emp_fname . ' ' . $employee_attendence->emp_mname . ' ' . $employee_attendence->emp_lname . '">
                                                //     <input type="hidden" class="form-control" readonly="" name="month[]" value="' . date('m/Y', strtotime($start_date)) . '">
                                                //     <input type="hidden" class="form-control" readonly="" name="date[]" value="' . $new_f . '">

                                                //     <input type="hidden" class="form-control" readonly="" name="time_in_location[]" value="NA">
                                                //     <input type="hidden" class="form-control" readonly="" name="time_out_location[]" value="NA">

                                                //     <td>' . $fh . '</td>
                                                //     <td>' . $employee_attendence->emp_code . '</td>
                                                //     <td>' . $employee_attendence->emp_fname . ' ' . $employee_attendence->emp_mname . ' ' . $employee_attendence->emp_lname . '</td>
                                                //     <td>' . date('d/m/Y', strtotime($new_f)).'<br>('.date('l', strtotime($new_f)) . ')</td>
                                                //     <td><input type="time" class="form-control" id="time_in'.$fh.'" data-id="'.$fh.'"  name="time_in[]" value="' . $shift_auth->time_in . '" onblur="setDutyHours('.$fh.')"></td>
                                                //     <td>NA</td>
                                                //     <td><input type="time" class="form-control" id="time_out'.$fh.'" data-id="'.$fh.'" name="time_out[]" value="' . $shift_auth->time_out . '" onblur="setDutyHours('.$fh.')"></td>
                                                //     <td>NA</td>
                                                //     <td><input type="text" class="form-control" readonly="" name="duty_hours[]" id="duty_hours'.$fh.'" data-id="'.$fh.'"  value="' . $duty_hours . '"></td>
                                                // </tr>';
                                                $response['data'][] = [
                                                    'employee_code' => $employee_attendence->emp_code,
                                                    'employee_name' => $employee_attendence->emp_fname . ' ' . $employee_attendence->emp_mname . ' ' . $employee_attendence->emp_lname,
                                                    'month' => date('m/Y', strtotime($start_date)),
                                                    'date' => $new_f,
                                                    'time_in_location' => 'NA',
                                                    'time_out_location' => 'NA',
                                                    'display_date' => date('d/m/Y', strtotime($new_f)) . '<br>(' . date('l', strtotime($new_f)) . ')',
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

                    $data['employee_type_rs'] = DB::table('employee_type')->where('emid', '=', $emid)->where('employee_type_status', '=', 'Active')->get();
                    $data['departs'] = DB::table('department')->where('emid', '=', $emid)->get();
                    if ($gu > 0) {
                        //Session::flash('message', 'Attendance Data already exits');
                        $dynamicFlag = 1;
                        $data=[];
                        $message = "Attendance Data already exits.";
                        return Helper::rjd(
                            $message,
                            $dynamicFlag,
                            $data
                        );
                    }
                    //return response()->json($response);

                    $dynamicFlag = 1;
                    $data=$response;
                    $message = "Data get successfully.";
                    return Helper::rjd(
                        $message,
                        $dynamicFlag,
                        $data
                    );
                    //return view($this->_routePrefix . '.genarate-list',$data);
                    //return view('attendance/genarate-list', $data);
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
