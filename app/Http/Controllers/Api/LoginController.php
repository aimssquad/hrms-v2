<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
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

            // Restrict login to employees only
            if ($checkuser->user_type !== "employee") {
                return Helper::rj("Only employees can log in.", 0);
            }

            // Fetch user data
            $user = UserModel::where("email", $request->email)->first();
            $token = $user->createToken("token")->accessToken;

            // Get user details
            $user_id = $checkuser->employee_id;
            $userPrimaryId = $user->id;
            $deviceToken = $request->device_token;

            // Get employee profile image
            $userImage = DB::table('employee')->where('emp_code', $user_id)->first();
            $imagePath = $userImage->profileimage ?? null; // Handle null case

            // Update device token
            $user->update(['device_token' => $deviceToken]);

            // Get complete user details
            $checkuser = UserModel::join('employee', 'employee.emp_code', '=', 'users.employee_id')
                ->where("employee_id", $user_id)
                ->first();

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

}
