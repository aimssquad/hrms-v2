<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\Registration;
use App\Models\Branch_location;
use App\Models\Attendance\AttendancePermission;
use Exception;
use Illuminate\Http\Request;
use Validator;
use DB;
use App\Helpers\Api\Helper;

class LoginController extends Controller
{
    protected $_model;
    public function __construct()
    {
        $this->_model = new UserModel();
    }
    public function sendError($error, $errorMessages = [], $code = 404)
    {
        $response = [
            "flag"=>0,
            "status"=>400,
            "success" => false,
            "message" => $error,
        ];

        if (!empty($errorMessages)) {
            $response["data"] = $errorMessages;
        }

        return response()->json($response, $code);
    }
   

    public function logout(Request $request)
    {
        $dynamicFlag = 1;

        try {
            if (auth()->user()) {
                $user = auth()->user();
                //$user->tokens()->delete(); 
                auth()->user()->token()->revoke();
                return Helper::rj("Logout successful", $dynamicFlag);
            } else {
                $dynamicFlag = 0;
                return Helper::rj("User not authenticated", $dynamicFlag);
            }
        } catch (Exception $e) {
            return Helper::rj("Server Error.", 500);
        }
    }

    public function doLogin(Request $request)
    {
        try {
            // Validation
            $validator = Validator::make($request->all(), [
                "email" => "required|email",
                "password" => "required",
            ]);
            if ($validator->fails()) {
                return $this->sendError("Validation Error.", $validator->errors());
            }

            // Validate user
            $checkuser = $this->_model->userfind($request->email, $request->password);
            if ($checkuser == null) {
                return Helper::rj("Not a valid credential", 0);
            }
            if ($checkuser->user_type !== "employee") {
                return Helper::rj("Only employees can log in.", 0);
            }

            $user = UserModel::where("email", $request->email)->first();
            $token = $user->createToken("token")->accessToken;

            $user_id = $checkuser->employee_id;
            $userPrimaryId = $user->id;
            $emid = $user->emid;
            
            if (!empty($request->fcm_token)) {
                DB::table('user_devices')->updateOrInsert(
                    ['fcm_token' => $request->fcm_token],
                    [
                        'user_id'     => $userPrimaryId,
                        'device_type' => $request->device_type ?? 'web',
                        'updated_at'  => now(),
                        'created_at'  => now(),
                    ]
                );
            }

            // Employee image
            $userImage = DB::table('employee')
                ->where('emp_code', $user_id)
                ->where('emid', $emid)
                ->first();
            $imagePath = $userImage->profileimage ?? '';

            // Update device token
            //$user->update(['device_token' => $request->device_token]);

            // Fetch full employee + user details
            $checkuser = UserModel::join('employee', function($join) {
                    $join->on('employee.emp_code', '=', 'users.employee_id')
                        ->on('employee.emid', '=', 'users.emid');
                })
                ->where('users.employee_id', $user_id)
                ->where('users.emid', $emid)
                ->first();

            // Organization info
            $org_dtl = Registration::where('reg', $emid)->select('logo','com_name')->first();
            $checkuser['org_logo'] = $org_dtl->logo ?? '';
            $checkuser['org_name'] = $org_dtl->com_name ?? '';

            // Branch location
            $org_cordinate = Branch_location::where('emid',$emid)
                ->select('latitude','longitude','radius')
                ->first();
            $checkuser['latitude']  = $org_cordinate->latitude ?? '';
            $checkuser['longitude'] = $org_cordinate->longitude ?? '';
            $checkuser['radius']    = $org_cordinate->radius ?? '';

            // Punch type
            $attendance_type = AttendancePermission::where('emp_code', $user_id)->first();
            if ($attendance_type) {
                $checkuser['punch_type'] = $attendance_type->punch_type ?: $attendance_type->default_punch_type;
            } else {
                $punch_type = DB::table('org_attendance_permissions AS oap')
                    ->join('emp_punch_type_masters AS ptm', 'ptm.id', '=', 'oap.default_punch_type_id')
                    ->where('oap.emid', $emid)
                    ->select('ptm.punch_type_name')
                    ->first();
                $checkuser['punch_type'] = $punch_type->punch_type_name ?? '';
            }

            // Replace nulls with ""
            $checkuser = json_decode(json_encode($checkuser), true);
            foreach ($checkuser as $key => $value) {
                if ($value === null) {
                    $checkuser[$key] = "";
                }
            }

            return Helper::rj(
                "Employee login success",
                1,
                $checkuser,
                $imagePath,
                $userPrimaryId,
                $token
            );

        } catch (\Exception $e) {
            return Helper::rj("Server Error.", 500);
        }
    }
    
    // Guest Login
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "email"    => "required|email",
                "password" => "required",
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "flag" => 0,
                    "message" => "Validation Error",
                    "errors" => $validator->errors()
                ], 422);
            }

            // Validate user credentials
            $checkuser = $this->_model->userfind($request->email, $request->password);
            if (!$checkuser) {
                return response()->json([
                    "flag" => 0,
                    "message" => "Not a valid credential"
                ], 401);
            }

            // Only guest can login
            if ($checkuser->user_type !== "guest") {
                return response()->json([
                    "flag" => 0,
                    "message" => "Only Guest can log in."
                ], 403);
            }
            
            // User table
            $user = UserModel::where("email", $request->email)->first();
            $token = $user->createToken("token")->accessToken;
            //dd($user);
            $user_id       = $checkuser->employee_id; // guest_id
            $userPrimaryId = $user->id;
            $emid          = $user->emid;

            // Update device token
            if ($request->filled('device_token')) {
                $user->update([
                    'device_token' => $request->device_token
                ]);
            }
            //dd($user_id, $emid);
            // Fetch guest + user details
            $userData = UserModel::join('guests', function ($join) {
                    $join->on('guests.guest_id', '=', 'users.employee_id')
                        ->on('guests.emid', '=', 'users.emid');
                })
                ->where('users.employee_id', $user_id)
                ->where('users.emid', $emid)
                ->select(
                    'users.id',
                    'users.email',
                    'users.user_type',
                    'users.employee_id',
                    'users.emid',
                    'guests.name',
                    'guests.company_name',
                    'guests.designation',
                    'guests.phone'
                )
                ->first();
            //dd($userData);
            // Organization info
            $org = Registration::where('reg', $emid)
                ->select('logo', 'com_name')
                ->first();

            $userData->org_logo = $org->logo ?? '';
            $userData->org_name = $org->com_name ?? '';

            return response()->json([
                "flag"    => 1,
                "message" => "Guest login successfully",
                "data"    => [
                    "user"    => $userData,
                    "user_id" => $userPrimaryId,
                    "token"   => $token
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                "flag" => 0,
                "message" => "Server Error",
                "error" => $e->getMessage() // remove in production
            ], 500);
        }
    }



}
