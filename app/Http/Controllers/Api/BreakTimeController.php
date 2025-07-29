<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BreakTimes;
use App\Helpers\Api\Helper;
use Validator;
use Exception;
use DB;
use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;

class BreakTimeController extends Controller
{
   

    public function store(Request $request)
    {
        if (!auth()->check()) {
            return Helper::rjd("Unauthorized access", 0, []);
        }

        $user = auth()->user();
        $emid = $user->emid; 
        $employee_code = $user->employee_id;
        $employee_name = $user->name;

        $validated = $request->validate([
            'break_date' => 'required|date',
            'break_time' => 'required',
            'break_location' => 'nullable|string',
            'break_latitude' => 'nullable|numeric',
            'break_longitude' => 'nullable|numeric',
            'break_device_id' => 'nullable|string',
            'punch_type' => 'nullable|string|in:GPS,QR,FaceID,Manual',
            'remarks' => 'nullable|string',
            //'punch_status' =>'required|string'
        ]);

        // Find the most recent break record for this employee (regardless of status)
        $latestBreak = BreakTimes::where('employee_code', $employee_code)
            ->where('date', $validated['break_date'])
            ->latest('created_at')
            ->first();

        if (!$latestBreak || $latestBreak->punch_status === 'Break End') {
            // Create new break start record
            $data = [
                'employee_code' => $employee_code,
                'employee_name' => $employee_name ?? '',
                'date' => $validated['break_date'],
                'break_time_start' => $validated['break_time'],
                'break_time_in_location' => $validated['break_location'] ?? '',
                'break_time_in_latitude' => $validated['break_latitude'] ?? null,
                'break_time_in_longitude' => $validated['break_longitude'] ?? null,
                'break_device_id' => $validated['break_device_id'] ?? null,
                'punch_type' => $validated['punch_type'] ?? 'GPS',
                'remarks' => $validated['remarks'] ?? '',
                'break_month' => Carbon::parse($validated['break_date'])->format('Y-m'),
                'punch_status' => 'Break Start',
                'emid' => $emid
            ];

            $created = BreakTimes::create($data);

            return response()->json([
                'flag' => 1,
                'status' => true,
                'message' => 'Break started successfully.',
                'data' => $created
            ]);
        } else {
            // Check if we're trying to create a new break start without ending previous one
            if ($latestBreak->punch_status === 'Break Start') {
                // End the previous break first
                $timeIn = Carbon::parse($latestBreak->break_time_start);
                $timeOut = Carbon::parse($validated['break_time']);
                
                // Prevent break end time being before start time
                if ($timeOut->lt($timeIn)) {
                    return response()->json([
                        'flag' => 0,
                        'status' => false,
                        'message' => 'Break end time cannot be before start time.',
                    ], 400);
                }

                $totalBreakTime = $timeIn->diffInMinutes($timeOut);
                
                $updateData = [
                    'break_time_end' => $validated['break_time'],
                    'break_time_out_location' => $validated['break_location'] ?? '',
                    'break_time_out_latitude' => $validated['break_latitude'] ?? null,
                    'break_time_out_longitude' => $validated['break_longitude'] ?? null,
                    'total_break_time' => $totalBreakTime,
                    'punch_status' => 'Break End',
                ];

                $latestBreak->update($updateData);

                return response()->json([
                    'flag' => 1,
                    'status' => true,
                    'message' => 'Break ended successfully.',
                    'data' => $latestBreak
                ]);
            }
        }
    }

    public function breakStatus(){
        //dd('okk');
        if (!auth()->check()) {
            return Helper::rjd("Unauthorized access", 0, []);
        }

        $user = auth()->user();
        $emid = $user->emid; 
        $employee_code = $user->employee_id;
        $employee_name = $user->name;
        $date = "2025-07-30";
        //$date = date('Y-m-d');
        
        // $break = BreakTimes::where('emid',$emid)->where('employee_code',$employee_code)->where('date',$date)->orderBy('date',desc)->first();
        $break = BreakTimes::where('emid', $emid)
            ->where('employee_code', $employee_code)
            ->where('date', $date)
            ->latest()      
            ->first();
        //dd($break);
        if(!$break){
              $dynamicFlag = 1;
                    $data = []; // Empty array
                    $message = "break data not found";
                    return Helper::rjd(
                        $message,
                        $dynamicFlag,
                        $data
                    );
        }

        $breakArray = $break->toArray();
        $breakAttendance = array_map(function($value) {
            return $value === null ? "" : $value;
        }, $breakArray);

        $dynamicFlag = 1;
        $data = [$breakAttendance]; // Wrap in array to make it a list
        $message = "break data get successfully";
        return Helper::rjd(
            $message,
            $dynamicFlag,
            $data
        );

    }






}
