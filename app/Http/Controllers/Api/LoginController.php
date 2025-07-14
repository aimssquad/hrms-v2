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
    public function doLogin(Request $request)
    {
        $dynamicFlag = 1;

        try {
            // Validate input
            $validator = Validator::make($request->all(), [
                "email" => "required|email",
                "password" => "required",
            ]);

            if ($validator->fails()) {
                return $this->sendError("Validation Error.", $validator->errors());
            }

            // Find user with email and password
            $checkuser = $this->_model->userfind($request->email, $request->password);

            if ($checkuser == null) {
                $dynamicFlag = 0;
                return Helper::rj("Not a valid credential", $dynamicFlag);
            }
            if ($checkuser->user_type !== "employee") {
                return Helper::rj("Only employees can log in.", 0);
            }
            $user = UserModel::where("email", $request->email)->first();
            $token = $user->createToken("token")->accessToken;

            // Get user details
            $user_id = $checkuser->employee_id;
            $userPrimaryId = $user->id;
            $deviceToken = $request->device_token;

            // Get employee profile image
            $userImage = DB::table('employee')->where('emp_code', $user_id)->first();
            $imagePath = $userImage->profileimage ?? ''; // Handle null case

            // Update device token
            $user->update(['device_token' => $deviceToken]);

            // Get complete user details
            $checkuser = UserModel::join('employee', 'employee.emp_code', '=', 'users.employee_id')
                ->where("employee_id", $user_id)
                ->first();
            //dd($checkuser);    
            
            $org_cordinate = Branch_location::where('emid',$checkuser->emid)->select('latitude','longitude','radius')->first();
            if($org_cordinate != null){
                //return Helper::rj("organization not found.", 0);
                $checkuser['latitude']  = $org_cordinate->latitude;
                $checkuser['longitude'] = $org_cordinate->longitude;
                $checkuser['radius']    = $org_cordinate->radius;  
            } else {
                $checkuser['latitude']  = '';
                $checkuser['longitude'] = '';
                $checkuser['radius']    = ''; 
            }
            
            $attendance_type = AttendancePermission::where('emp_code', $user_id)->first();
            if($attendance_type != null){
                $employee['attendance_type'] = $attendance_type->punch_type;
                if($employee['attendance_type'] !=""){
                    $checkuser['punch_type'] = $attendance_type->punch_type;
                } else {
                    $checkuser['punch_type'] = $attendance_type->default_punch_type;
                }
            } else {
                $punch_type = DB::table('org_attendance_permissions AS oap')
                ->join('emp_punch_type_masters AS ptm', 'ptm.id', '=', 'oap.default_punch_type_id')
                ->where('oap.emid', $user->emid)
                ->select('ptm.id', 'ptm.punch_type_name')
                ->first();
                if($punch_type !=null){
                    $checkuser['punch_type'] = $punch_type->punch_type_name;
                }  
            }
          

            //dd($punch_type->punch_type_name);
            $checkuser = json_decode(json_encode($checkuser), true);
            foreach ($checkuser as $key => $value) {
                    if ($value === null) {
                        $checkuser[$key] = "";
                    }
                }
           
            $dynamicFlag = 1;
            return Helper::rj(
                "Employee login success",
                $dynamicFlag,
                $checkuser,
                $imagePath,
                $userPrimaryId,
                $token
            );

        } catch (Exception $e) {
            return Helper::rj("Server Error.", 500);
        }
    }

    public function logout(Request $request)
    {
        $dynamicFlag = 1;

        try {
            if (auth()->user()) {
                $user = auth()->user();
                $user->tokens()->delete(); 

                return Helper::rj("Logout successful", $dynamicFlag);
            } else {
                $dynamicFlag = 0;
                return Helper::rj("User not authenticated", $dynamicFlag);
            }
        } catch (Exception $e) {
            return Helper::rj("Server Error.", 500);
        }
    }


}
