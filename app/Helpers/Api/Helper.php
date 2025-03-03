<?php

namespace App\Helpers\Api;

use Illuminate\Support\Facades\Auth;
use DB;
use Illuminate\Support\Str;

class Helper
{

	/**
	 * Show date with date format.
	 * @param date / datetime $date
	 * @param boolean $showTime [show time also]
	 * @param string $dateFormat custom date format [any custom date format, which is not default]
	 * @param string $timezone [User timezone]
	 * @version:    1.0.0.5
	 * @author:     Somnath Mukherjee
	 */

     public static function resp($message = '', $flag = 1, $data = [],$imagePath=[],$userPrimaryId=[], $token = [],$todayLogin=[])
    {
        $status = 200;
        return [
            'status'  => $status,
            'flag'    => $flag,
            'message' => $message,
            'todayLogin' =>$todayLogin,
            'data'    => $data,
            'imagePath' =>$imagePath,
            'token'   => $token,
            'userPrimaryId' =>$userPrimaryId
        ];
    }

    public static function respd($message = '', $flag = 1, $data = [], $total_leave = 0)
    {
        $status = 200;
        return [
            'status'  => $status,
            'flag'    => $flag,
            'message' => $message,
            'data'    => $data,
            'total_leave' => $total_leave
        ];
    }

    public static function rj($message = '', $flag = 1, $data = [],$imagePath=[],$userPrimaryId=[],$token = [],$todayLogin=[])
    {
        $response = self::resp($message, $flag,$data,$imagePath,$userPrimaryId, $token,$todayLogin);
        return response()->json($response, $response['status']);
    }

    public static function responseData($message = '', $flag = 1, $data = [],$todayLogin=[],$isHoliday=[],$todayLogout=[])
    {
        $status = 200;
        return [
            'status'  => $status,
            'flag'    => $flag,
            'message' => $message,
            'todayLogin' =>$todayLogin,
            'isHoliday' => $isHoliday,
            'todayLogout'=>$todayLogout,
            'data' =>$data,
        ];
    }

    public static function res($message = '', $flag = 1, $data = [],$todayLogin=[],$isHoliday=[],$todayLogout=[])
    {
        $response = self::responseData($message, $flag, $data,$todayLogin,$isHoliday,$todayLogout);
        return response()->json($response, $response['status']);
    }

    public static function attendence($message = '', $flag = 1, $halfDayData = [],$fullDayData = [],$totakWorkingDay=[],$data=[])
    {
        $status = 200;
        return [
            'status'  => $status,
            'flag'    => $flag,
            'message' => $message,
            'halfDay' => $halfDayData,
            'fullDay' => $fullDayData,
            'totalWorkingDay' => $totakWorkingDay,
            'data' =>$data
        ];
    }

    public static function resAttendence($message = '', $flag = 1, $halfDayData = [],$fullDayData = [],$totakWorkingDay=[],$data=[])
    {
        $response = self::attendence($message, $flag, $halfDayData,$fullDayData,$totakWorkingDay,$data);
        return response()->json($response, $response['status']);
    }


    public function replaceNullRecursive($data)
    {
        return array_map(function ($value) {
            if (is_array($value)) {
                return $this->replaceNullRecursive($value); // Use $this-> if inside a class
            }
            return is_null($value) ? "" : $value;
        }, $data);
    }

    public static function rjd($message, $flag = 1,  $data = [],$totla_leave=0)
    {
        $response = self::respd($message, $flag, $data, $totla_leave);
        return response()->json($response, $response['status']);
    }

    function fetchAndTransform($table, $conditions, $select = ['*'])
    {
        $data = ['employee','select','all'];
        $query = DB::table($table);
        foreach ($conditions as $column => $value) {
            $query->where($column, '=', $value);
        }
        $data = $query->select($select)->get();
        $data->transform(function ($item) {
            return collect($item)->map(function ($value) {
                return $value === null ? "" : $value;
            });
        });

        return $data;
    }
}
