<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Mail;
use Session;
use Validator;
use view;
use Exception;
use App\Models\UserModel;
use Illuminate\Support\Facades\Cache;
use App\Mail\SendOTP;


class LandingController extends Controller
{
    public function otpRegister(Request $request){
         //dd($request->all());
        $data = $request->validate([
            'subadmin' => 'required',
            'org_code' => 'nullable',
            'com_name' => 'required|string|max:255',
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'email' => 'required|email|unique:registration,email',
            'domain_name' => 'nullable|string',
            'country' => 'required|string',
            'country_code' => 'required|string',
            'p_no' => 'required|string|max:15',
            'pass' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],
            'con_password' => 'required|same:pass',
        ], [
            'pass.regex' => 'Password must contain at least one letter, one number, and one special character.',
        ]);
        // dd($data);
        // Check if the email is valid
        $eml = explode(".", $request->email);
        if (count($eml) > 4) {
            Session::flash("message", "Invalid input");
            return redirect("register");
        }
    
        // Check if the phone number is valid
        if ($request->p_no != "" && substr($request->p_no, 0, 2) == "83") {
            Session::flash("message", "Invalid input");
            return redirect("register");
        }
    
        // Check if the user already exists
        $Employee = DB::table("users")->where("email", "=", $request->email)->first();
        if ($Employee) {
            Session::flash("message", "Email already exists");
            return redirect("register");
        }
        $org_code = '';
        if($request->org_code){
            $org_code = $request->org_code;
        } else {
            $org_code = '';
        }
        $subadmin_data = DB::table('sub_admin_registrations')->where('org_code', $org_code)->first();
        if(empty($subadmin_data)){
            $sub_comname = '';
        } else {
            $sub_comname = $subadmin_data->com_name;
        }
        // Generate a 6-digit OTP
        $otp = rand(100000, 999999);
       
        $registrationData = ['com_name'=>$request->com_name, 'f_name'=>$request->f_name, 'l_name'=>$request->l_name, 'email'=>$request->email, 'p_no'=>$request->p_no, 'pass'=>$request->pass, 'subadmin'=>$request->subadmin, 'org_code'=>$request->org_code, 'country'=>$request->country, 'country_code'=>$request->country_code,'domain_name'=>$request->domain_name];
        // Store the OTP and registration data in the cache for 5 minutes
        Cache::put('registration_data_' . $request->email, $registrationData, now()->addMinutes(10));
        Cache::put('otp_' . $request->email, $otp, now()->addMinutes(10));
        $toemail = $request->email;
        $data = ['otp' => $otp, 'email'=>$request->email,'com_name'=>$request->com_name];
        Mail::send("mail-otp", $data, function ($message) use ($toemail) {
            $message
                ->to($toemail)
                ->subject("Your One-Time Password (OTP) for Verification");
            $message->from(env('MAIL_USERNAME'));
        });
        return redirect()->route('verify.otp')->with('email', $request->email);
    }
    public function showOTPForm()
    {
        return view('email-authentication');
    }

    public function completeRegistration(Request $request)
    {
        // Validate the request
        $request->validate([
            'otp' => 'required|string|size:6',
            'email' => 'required|email',
        ]);

        // Retrieve the stored OTP and registration data
        $storedOTP = Cache::get('otp_' . $request->email);
        $registrationData = Cache::get('registration_data_' . $request->email);
        
        // Check if the OTP matches
        if ($storedOTP && $storedOTP == $request->otp) {
            $Employee = DB::table("users")
                ->where("email", "=", $registrationData['email'])
                ->first();

            if (empty($Employee)) {
                $employee_pid = DB::table("registration")
                    ->orderBy("id", "DESC")
                    ->first();

                if (empty($employee_pid)) {
                    $pid = "EM1";
                } else {
                    $pid = "EM" . ($employee_pid->id + 1);
                }
                if($registrationData['subadmin'] == 'Organization'){ 
                    $subadmin_data = DB::table('sub_admin_registrations')->where('org_code', $registrationData['org_code'])->first();
                    if(empty($subadmin_data)){
                        $sub_comname = '';
                    } else {
                        $sub_comname = $subadmin_data->com_name;
                    }
                    $datareg = [
                        "com_name" => $registrationData['com_name'],
                        "f_name" => $registrationData['f_name'],

                        "l_name" => $registrationData['l_name'],
                        "reg" => $pid,
                        "email" => $registrationData['email'],
                        "organ_email" => $registrationData['email'],
            
                        "status" => "active",
                        "verify" => "not approved",
                        "licence" => "no",

                        "country"=>$registrationData['country'],
                        "country_code"=>$registrationData['country_code'],

                        "org_code" => $registrationData['org_code'],
                        "p_no" => $registrationData['p_no'],
                        "pass" => $registrationData['pass'],
                        "created_at" => date("Y-m-d h:i:s"),
                    ];
                    //dd($datareg);
                    DB::table("registration")->insert($datareg);

                    $datauser = [
                        "name" => $registrationData['com_name'],
                        "user_type" => "employer",

                        "status" => "inActive",
                        "employee_id" => $pid,
                        "email" => $registrationData['email'],

                        "updated_at" => date("Y-m-d h:i:s"),
                        "created_at" => date("Y-m-d h:i:s"),
                        "password" => $registrationData['pass'],
                    ];
                    //dd($datauser);
                    DB::table("users")->insert($datauser);

                    $le_type = DB::table("le_type")->get();
                    //dd( $le_type);
                    foreach ($le_type as $value_le) {
                        $datauserleave = [
                            "leave_type_name" => $value_le->leave_type_name,
                            "alies" => $value_le->alies,

                            "remarks" => $value_le->remarks,
                            "emid" => $pid,
                            "leave_type_status" => "active",
                        ];
                        DB::table("leave_type")->insert($datauserleave);
                    }

                    $em_type = DB::table("em_type")->get();

                    foreach ($em_type as $value_em) {
                        $datauseremployty = [
                            "employee_type_name" => $value_em->name,

                            "emid" => $pid,
                            "employee_type_status" => "Active",
                        ];
                        DB::table("employee_type")->insert($datauseremployty);
                    }

                    $data = [
                        "org_code"=>$registrationData['org_code'],
                        "f_name" => $registrationData['f_name'],
                        "l_name" => $registrationData['l_name'],
                        "com_name" => $registrationData['com_name'],
                        "p_no" => $registrationData['p_no'],
                        "email" => $registrationData['email'],
                    ];

                    $toemail = $registrationData['email'];
                    $toemail = 'info@skilledworkerscloud.co.uk';
                    Mail::send("mailre", $data, function ($message) use ($toemail) {
                        $message
                            ->to($toemail, env('MAIL_FROM_NAME'))
                            ->subject("New Organisation Registered");
                        $message->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'));
                    });
                
                    //dd($data);
                    if(!empty($registrationData['org_code'])){
                        $org_code = $registrationData['org_code'];
                        $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'];
                        // Extract only the domain name and store it in a variable
                        $domainName = preg_replace('/^www\./', '', parse_url($baseUrl, PHP_URL_HOST));
                        $baseUrl = $baseUrl."/hrms-v2";
                        $data = [
                            "f_name" => $registrationData['f_name'],
                            "l_name" => $registrationData['l_name'],
                            "com_name" => $registrationData['com_name'],
                            "p_no" => $registrationData['p_no'],
                            "email" => $registrationData['email'],
                            "pass" => $registrationData['pass'],
                            "web"  => $baseUrl,
                        ];
                        $toemail = $registrationData['email'];
                        // Mail::send("mailor", $data, function ($message) use ($toemail, $sub_comname) {
                        //     $message->to($toemail, env('MAIL_FROM_NAME'))->subject("Welcome to $sub_comname");
                        //     $message->from(env('MAIL_USERNAME'),  env('MAIL_FROM_NAME'));
                        // });
                    } else{
                        $data = [
                            "f_name" => $registrationData['f_name'],
                            "l_name" => $registrationData['l_name'],
                            "com_name" => $registrationData['com_name'],
                            "p_no" => $registrationData['p_no'],
                            "email" => $registrationData['email'],
                            "pass" => $registrationData['pass'],
                            "web"  => env('BASE_URL'),
                        ];
                        $toemail = $registrationData['email'];
                        //return view('register-email',$data);
                        Mail::send("register-email", $data, function ($message) use ($toemail) {
                            $message
                                ->to($toemail, env('MAIL_FROM_NAME'))
                                ->subject(
                                    "Welcome to SWC HRMS. Your Organization Registration is Successful!"
                                );
                            $message->from(env('MAIL_USERNAME'),  env('MAIL_FROM_NAME'));
                        });
                    }
                

                
                } elseif ($registrationData['subadmin'] == 'Partner') {

                    $reg_pid = DB::table("sub_admin_registrations")
                    ->orderBy("id", "DESC")
                    ->first();
                    if (empty($reg_pid)) {
                    $pid = "SUBA1";
                    } else {
                        $pid = "SUBA" . ($reg_pid->id + 1);
                    }
                

                    $datareg = [
                        "com_name" => $registrationData['com_name'],
                        "f_name" => $registrationData['f_name'],

                        "l_name" => $registrationData['l_name'],
                        "reg" => $pid,
                        "email" => $registrationData['email'],
                        "organ_email" => $registrationData['email'],
                        "domain_name" => $registrationData['domain_name'],
            
                        "status" => "active",
                        "verify" => "not approved",
                        "licence" => "no",

                        "country"=>$registrationData['country'],
                        "country_code"=>$registrationData['country_code'],

                        "p_no" => $registrationData['p_no'],
                        "pass" => $registrationData['pass'],
                        "created_at" => date("Y-m-d h:i:s"),
                    ];
                    //dd('okk');
                    //dd($datareg);
                    DB::table("sub_admin_registrations")->insert($datareg);

                    $datauser = [
                        "name" => $registrationData['com_name'],
                        "user_type" => "sub-admin",

                        "status" => "inActive",
                        "employee_id" => $pid,
                        "email" => $registrationData['email'],

                        "updated_at" => date("Y-m-d h:i:s"),
                        "created_at" => date("Y-m-d h:i:s"),
                        "password" => $registrationData['pass'],
                    ];
                    DB::table("users")->insert($datauser);

                    $le_type = DB::table("le_type")->get();
                    //dd( $le_type);
                    foreach ($le_type as $value_le) {
                        $datauserleave = [
                            "leave_type_name" => $value_le->leave_type_name,
                            "alies" => $value_le->alies,

                            "remarks" => $value_le->remarks,
                            "emid" => $pid,
                            "leave_type_status" => "active",
                        ];
                        DB::table("leave_type")->insert($datauserleave);
                    }

                    $em_type = DB::table("em_type")->get();

                    foreach ($em_type as $value_em) {
                        $datauseremployty = [
                            "employee_type_name" => $value_em->name,

                            "emid" => $pid,
                            "employee_type_status" => "Active",
                        ];
                        DB::table("employee_type")->insert($datauseremployty);
                    }
                    $data1 = [
                        'user_type'=>$registrationData['subadmin'],
                        "f_name" => $registrationData['f_name'],
                        "l_name" => $registrationData['l_name'],
                        "com_name" => $registrationData['com_name'],
                        "p_no" => $registrationData['p_no'],
                        "email" => $registrationData['email'],
                    ];
                    $toemail_superadmin = 'info@skilledworkerscloud.co.uk';
                    Mail::send("mailre", $data1, function ($message) use ($toemail_superadmin) {
                        $message
                            ->to($toemail_superadmin, env('MAIL_FROM_NAME'))
                            ->subject("New Partner Registered");
                        $message->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'));
                    });

                    $data = [
                        "f_name" => $registrationData['f_name'],
                        "l_name" => $registrationData['l_name'],
                        "com_name" => $registrationData['com_name'],
                        "p_no" => $registrationData['p_no'],
                        "email" => $registrationData['email'],
                        "pass" => $registrationData['pass'],
                        "web"  => env('BASE_URL'),
                    ];
                    $toemail = $registrationData['email'];
                    // Mail::send("register-email", $data, function ($message) use ($toemail) {
                    //     $message->to($toemail, env('MAIL_FROM_NAME'))
                    //         ->subject("Welcome to SWCH HRMS. Your Partner Organization Registration is Successful!");
                    //     $message->from(env('MAIL_USERNAME'),  env('MAIL_FROM_NAME'));
                    // });
                }
                // Clear the OTP and registration data from the cache
                Cache::forget('otp_' . $request->email);
                Cache::forget('registration_data_' . $request->email);
                Session::flash(
                    "message",
                    "Thank you for registration, will get back to you soon."
                );
                return redirect("register");
            } else {
                Session::flash("message", "Email ID already exists even when we brand new email.");
                return redirect("register");
            }  
        } else {
            Session::flash(
                "message",
                "Invalid OTP. Please try again."
            );
            // Redirect back with an error message
            return redirect('register');
        }
    }

    public function index()
    {
        //dd('okk');
        //$videos = DB::table('login_page_image')->get();
        $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'];
        // Extract only the domain name and store it in a variable
        $domainName = preg_replace('/^www\./', '', parse_url($baseUrl, PHP_URL_HOST));

        // echo "Base URL: " . $baseUrl . "<br>";
        // echo "Domain Name: " . $domainName;
        $data = [];
        $data['dName'] = $domainName;
        
        if ($domainName != 'skilledworkerscloud.co.uk' && $domainName != 'swcworlds.com') {
            // Fetch the domain from the database
            $domain = DB::table('sub_admin_registrations')->where('domain_name', $domainName)->first();
            if ($domain) {
                $data['domain_name'] = $domain;
            } else {
                $data['domain_name'] = null; // Set to null if no domain is found
            }
           
        } else {
            $data['domain_name'] = null; 
            //dd($data);
        }

        $data['videos'] = DB::table('login_page_image')
        ->orderBy('slide_order', 'asc') // Order by slide_order in descending order
        ->get();
        //dd($data);
        return view('index', $data);
        //return view("index");
    }
    public function indexloginpay()
    {
        return view("index-pay");
    }
    public function indexser()
    {
        return view("user-login");
    }
    // public function indexfor()
    // {
    //     return view("forgot-password");
    // }

  
    
    public function register($org_code = null)
    {
        $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'];
        // Extract only the domain name and store it in a variable
        $domainName = preg_replace('/^www\./', '', parse_url($baseUrl, PHP_URL_HOST));

        // echo "Base URL: " . $baseUrl . "<br>";
        // echo "Domain Name: " . $domainName;
        $data = [];
        $data['dName'] = $domainName;
        if ($domainName != 'skilledworkerscloud.co.uk' && $domainName != 'swcworlds.com') {
            // Fetch the domain from the database
            $domain = DB::table('sub_admin_registrations')->where('domain_name', $domainName)->first();
    
            // Set the domain name in the data array
            if ($domain) {
                $data['domain_name'] = $domain;
            } else {
                $data['domain_name'] = null; // Set to null if no domain is found
            }
        } else {
            $data['domain_name'] = null; 
        }
            $videos = DB::table('register_page_image')
            ->orderBy('slide_order', 'asc')
            ->get();
                
                if ($org_code !== null) {
                    $data['org_code'] = $org_code;
                }
                
                $data['user_details'] = DB::table('country')->get();
                
                // Merge the videos into the data array
                $data['videos'] = $videos;
                
                // Return the view with all data
                return view('register', $data);
    }
    
    public function getCountryCode(Request $request)
    {
        $countryName = $request->country;
        // Assuming you have a model `Country` with `name` and `phonecode` attributes
        $country = DB::table('country')->where('name', $countryName)->first();

        if ($country) {
            return response()->json(['phonecode' => $country->phonecode]);
        } else {
            return response()->json(['phonecode' => null], 404);
        }
    }


    public function employerdashboard()
    {
        try {
            $email = Session::get("emp_email");
            if (!empty($email)) {
                return view("employer-dashboard");
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }

    // public function Doregister(Request $request)
    // {
    //     //dd($request->all());
    //     //dd($_SERVER);
    //     // if ($_SERVER['HTTP_HOST'] != 'workpermitcloud.co.uk') {
    //     //     Session::flash('message', 'Invalid Referrer');
    //     //     return redirect('register');
    //     // }

    //     // if ($_SERVER['HTTP_REFERER'] != 'http://localhost/hrms/register' || $_SERVER['HTTP_REFERER'] != 'https://workpermitcloud.co.uk/hrms/register') {
    //     //     die('don\'t be an jerk, ruin your own site');
    //     // }
    //     $password = $request->validate([
    //         'pass' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],
    //     ], [
    //         'pass.regex' => 'Password must contain at least one letter, one number, and one special character.',
    //     ]);
    //     //dd($password['pass']);
    //     if($request->subadmin == ""){
    //         Session::flash("message", "Invalid input");
    //         return redirect("register");
    //     }    
    //     //dd($request->all());
    //     $eml = [];
    //     if ($request->email != "") {
    //         $eml = explode(".", $request->email);
    //         //dd($eml);
    //     }
    //     if (count($eml) > 4) {
    //         Session::flash("message", "Invalid input");
    //         return redirect("register");
    //     }
    //     if ($request->p_no != "" && substr($request->p_no, 0, 2) == "83") {
    //         // case-insensitive here
    //         Session::flash("message", "Invalid input");
    //         return redirect("register");
    //     }
    //     //dd(stripos("83", $request->p_no));
    //     if ($request->pass != $request->con_password) {
    //         Session::flash(
    //             "message",
    //             "Password and Confirm Password both not same"
    //         );
    //         return redirect("register")->withInput();
    //     } else {
    //         $Employee = DB::table("users")
    //             ->where("email", "=", $request->email)
    //             ->first();

    //         if (empty($Employee)) {
    //             $employee_pid = DB::table("registration")
    //                 ->orderBy("id", "DESC")
    //                 ->first();

    //             if (empty($employee_pid)) {
    //                 $pid = "EM1";
    //             } else {
    //                 $pid = "EM" . ($employee_pid->id + 1);
    //             }
    //             if($request->subadmin == 'Organization'){ 
    //                 //dd($request->org_code);
    //                $subadmin_data = DB::table('sub_admin_registrations')->where('org_code', $request->org_code)->first();
    //                //dd($subadmin_data);
    //                if(empty($subadmin_data)){
    //                     $sub_comname = '';
    //                } else {
    //                     $sub_comname = $subadmin_data->com_name;
    //                }
                   
    //                 //dd($sub_email);
    //                 $datareg = [
    //                     "com_name" => $request->com_name,
    //                     "f_name" => $request->f_name,

    //                     "l_name" => $request->l_name,
    //                     "reg" => $pid,
    //                     "email" => $request->email,
    //                     "organ_email" => $request->email,
            
    //                     "status" => "active",
    //                     "verify" => "not approved",
    //                     "licence" => "no",

    //                     "country"=>$request->country,
    //                     "country_code"=>$request->country_code,

    //                     "org_code" => $request->org_code,
    //                     "p_no" => $request->p_no,
    //                     "pass" => $password['pass'],
    //                     "created_at" => date("Y-m-d h:i:s"),
    //                 ];
    //                 //dd($datareg);
    //                 DB::table("registration")->insert($datareg);

    //                 $datauser = [
    //                     "name" => $request->com_name,
    //                     "user_type" => "employer",

    //                     "status" => "inActive",
    //                     "employee_id" => $pid,
    //                     "email" => $request->email,

    //                     "updated_at" => date("Y-m-d h:i:s"),
    //                     "created_at" => date("Y-m-d h:i:s"),
    //                     "password" => $password['pass'],
    //                 ];
    //                 //dd($datauser);
    //                 DB::table("users")->insert($datauser);

    //                 $le_type = DB::table("le_type")->get();
    //                 //dd( $le_type);
    //                 foreach ($le_type as $value_le) {
    //                     $datauserleave = [
    //                         "leave_type_name" => $value_le->leave_type_name,
    //                         "alies" => $value_le->alies,

    //                         "remarks" => $value_le->remarks,
    //                         "emid" => $pid,
    //                         "leave_type_status" => "active",
    //                     ];
    //                     DB::table("leave_type")->insert($datauserleave);
    //                 }

    //                 $em_type = DB::table("em_type")->get();

    //                 foreach ($em_type as $value_em) {
    //                     $datauseremployty = [
    //                         "employee_type_name" => $value_em->name,

    //                         "emid" => $pid,
    //                         "employee_type_status" => "Active",
    //                     ];
    //                     DB::table("employee_type")->insert($datauseremployty);
    //                 }

    //                 $data = [
    //                     "f_name" => $request->f_name,
    //                     "l_name" => $request->l_name,
    //                     "com_name" => $request->com_name,
    //                     "p_no" => $request->p_no,
    //                     "email" => $request->email,
    //                 ];

    //                 $toemail = $request->email;
    //                 $toemail = 'info@skilledworkerscloud.co.uk';
    //                 Mail::send("mailre", $data, function ($message) use ($toemail) {
    //                     $message
    //                         ->to($toemail, env('MAIL_FROM_NAME'))
    //                         ->subject("New Organisation Registered");
    //                     $message->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'));
    //                 });
                   
    //                 //dd($data);
    //                 if(!empty($request->org_code)){
    //                     $org_code = $request->org_code;
    //                     $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'];
    //                     // Extract only the domain name and store it in a variable
    //                     $domainName = preg_replace('/^www\./', '', parse_url($baseUrl, PHP_URL_HOST));
    //                     $baseUrl = $baseUrl."/hrms-v2";
    //                     $data = [
    //                         "f_name" => $request->f_name,
    //                         "l_name" => $request->l_name,
    //                         "com_name" => $request->com_name,
    //                         "p_no" => $request->p_no,
    //                         "email" => $request->email,
    //                         "pass" => $password['pass'],
    //                         "web"  => $baseUrl,
    //                     ];
    //                     $toemail = $request->email;
    //                     // Mail::send("mailor", $data, function ($message) use ($toemail, $sub_comname) {
    //                     //     $message->to($toemail, env('MAIL_FROM_NAME'))->subject("Welcome to $sub_comname");
    //                     //     $message->from(env('MAIL_USERNAME'),  env('MAIL_FROM_NAME'));
    //                     // });
    //                 } else{
    //                     $data = [
    //                         "f_name" => $request->f_name,
    //                         "l_name" => $request->l_name,
    //                         "com_name" => $request->com_name,
    //                         "p_no" => $request->p_no,
    //                         "email" => $request->email,
    //                         "pass" => $password['pass'],
    //                         "web"  => env('BASE_URL'),
    //                     ];
    //                     $toemail = $request->email;
    //                     Mail::send("register-email", $data, function ($message) use ($toemail) {
    //                         $message
    //                             ->to($toemail, env('MAIL_FROM_NAME'))
    //                             ->subject(
    //                                 "Welcome to SWC HRMS. Your Organization Registration is Successful!"
    //                             );
    //                         $message->from(env('MAIL_USERNAME'),  env('MAIL_FROM_NAME'));
    //                     });
    //                 }
                  

                
    //             } elseif ($request->subadmin == 'Partner') {

    //                  $reg_pid = DB::table("sub_admin_registrations")
    //                 ->orderBy("id", "DESC")
    //                 ->first();
    //                  if (empty($reg_pid)) {
    //                 $pid = "SUBA1";
    //                 } else {
    //                     $pid = "SUBA" . ($reg_pid->id + 1);
    //                 }
                  

    //                 $datareg = [
    //                     "com_name" => $request->com_name,
    //                     "f_name" => $request->f_name,

    //                     "l_name" => $request->l_name,
    //                     "reg" => $pid,
    //                     "email" => $request->email,
    //                     "organ_email" => $request->email,
    //                     "domain_name" => $request->domain_name,

    //                     "status" => "active",
    //                     "verify" => "not approved",
    //                     "licence" => "no",

    //                     "country"=>$request->country,
    //                     "country_code"=>$request->country_code,

    //                     "p_no" => $request->p_no,
    //                     "pass" => $password['pass'],
    //                     "created_at" => date("Y-m-d h:i:s"),
    //                 ];
    //                 //dd('okk');
    //                  //dd($datareg);
    //                 DB::table("sub_admin_registrations")->insert($datareg);

    //                 $datauser = [
    //                     "name" => $request->com_name,
    //                     "user_type" => "sub-admin",

    //                     "status" => "inActive",
    //                     "employee_id" => $pid,
    //                     "email" => $request->email,

    //                     "updated_at" => date("Y-m-d h:i:s"),
    //                     "created_at" => date("Y-m-d h:i:s"),
    //                     "password" => $password['pass'],
    //                 ];
    //                 DB::table("users")->insert($datauser);

    //                 $le_type = DB::table("le_type")->get();
    //                 //dd( $le_type);
    //                 foreach ($le_type as $value_le) {
    //                     $datauserleave = [
    //                         "leave_type_name" => $value_le->leave_type_name,
    //                         "alies" => $value_le->alies,

    //                         "remarks" => $value_le->remarks,
    //                         "emid" => $pid,
    //                         "leave_type_status" => "active",
    //                     ];
    //                     DB::table("leave_type")->insert($datauserleave);
    //                 }

    //                 $em_type = DB::table("em_type")->get();

    //                 foreach ($em_type as $value_em) {
    //                     $datauseremployty = [
    //                         "employee_type_name" => $value_em->name,

    //                         "emid" => $pid,
    //                         "employee_type_status" => "Active",
    //                     ];
    //                     DB::table("employee_type")->insert($datauseremployty);
    //                 }
    //                 $data = [
    //                     "f_name" => $request->f_name,
    //                     "l_name" => $request->l_name,
    //                     "com_name" => $request->com_name,
    //                     "p_no" => $request->p_no,
    //                     "email" => $request->email,
    //                     "pass" => $password['pass'],
    //                     "web"  => env('BASE_URL'),
    //                 ];
    //                 $toemail = $request->email;
    //                 Mail::send("register-email", $data, function ($message) use ($toemail) {
    //                     $message->to($toemail, env('MAIL_FROM_NAME'))
    //                         ->subject("Welcome to SWCH HRMS. Your Partner Organization Registration is Successful!");
    //                     $message->from(env('MAIL_USERNAME'),  env('MAIL_FROM_NAME'));
    //                 });
    //             }
    //             Session::flash(
    //                 "message",
    //                 "Thank you for registration, will get back to you soon."
    //             );
    //             return redirect("register");
    //         } else {
    //             Session::flash("message", "Email ID already exists even when we brand new email.");
    //             return redirect("register");
    //         }
    //     }
    // }

    public function Dashboard(Request $request)
    {
        //dd($request->input("emp_email"));
        if ($request->input("emp_email")) { 
            $Employee1 = DB::table("users")
                ->where(
                    "email",
                    "=",
                    base64_decode($request->input("emp_email"))
                )
                ->where("user_type", "!=", "admin")
                ->where("status", "=", "active")
                ->first();

            Session::put("emp_email", $Employee1->email);
            Session::put("emp_pass", $Employee1->password);
            Session::put("user_type", $Employee1->user_type);
            Session::put("users_id", $Employee1->id);
        }
        
        $email = Session::get("emp_email");
        
        if (!empty($email)) {
            $user_type = Session::get("user_type");
            //dd($user_type);
            if ($user_type == "employer") {
                $data["Roledata"] = DB::table("registration")
                    ->where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first(); //dd($data);
            } else {

                $usemail = Session::get("user_email");
                $users_id = Session::get("users_id");
                //dd($usemail);
                $dtaem = DB::table("users")

                    ->where("id", "=", $users_id)
                    ->first();//dd($dtaem);
                $data["Roledata"] = DB::table("employee")
                    ->where("emid", "=", $dtaem->emid)
                    ->where("emp_code", "=", $dtaem->employee_id)
                    ->first();

                $data["Roles_auth"] = DB::table("role_authorization")
                    ->where("emid", "=", $dtaem->emid)
                    ->where("member_id", "=", $dtaem->email)
                    ->get()
                    ->toArray();
                    //dd($data);
            }
            //dd($data["Roles_auth"]);
            //dd($data);
            return View("employer-dashboard", $data);
        } else {
            return redirect("/");
        }
    }

    public function Doforgot(Request $request)
    {
        // dd('okk');
        // dd(env('MAIL_FROM_ADDRESS'));
        $Employee = DB::table("users")
            ->where("email", "=", $request->email)
            ->where("status", "=", "active")
            ->where("user_type", "!=", "admin")
            ->first();

        if (!empty($Employee)) {
            $Roledata = DB::table("users")

                ->where("employee_id", "=", $Employee->emid)
                ->where("status", "=", "active")
                ->first();
            $base_url = env('BASE_URL');

            $data = ["pass" => $Employee->password, "name" => $Employee->name,"web"=>$base_url ];
            $toemail = $request->email;
            Mail::send("mailforgot", $data, function ($message) use ($toemail) {
                $message
                    ->to($toemail, env('MAIL_FROM_NAME'))
                    ->subject("Forgot  Password ");
                $message->from(env('MAIL_USERNAME'),env('MAIL_FROM_NAME'));
            });
           

            Session::flash("message", "Mail sent successfully.");
            return redirect("forgot-password");
        } else {
            Session::flash("error", "Your email id was wrong!!");
            return redirect("forgot-password");
        }
    }
    public function DoLogin(Request $request)
    {
         //dd($request->all());

        $validator = Validator::make(
            $request->all(),
            [
                "email" => "required",
                "psw" => "required",
            ],
            [
                "email.required" => "Email Required",
                "psw.required" => "Password Required",
            ]
        );

        if ($validator->fails()) {
            return redirect("/")
                ->withErrors($validator)
                ->withInput();
        } else { //dd('op');
            $Employee = UserModel::where("email", "=", $request->email)
                ->where("password", "=", $request->psw)
                ->where("status", "=", "active")
                ->where("user_type", "!=", "admin")
                ->first();
            //  dd($Employee);
            if (!empty($Employee)) { 
                
                if ($Employee->user_type == "employer") { 
                    //dd('okk');
                    //emid=$Employee->employee_id
                    //check for subscription
                    $subsCnt = DB::Table("subscriptions")
                        ->where("emid", "=", $Employee->employee_id)
                        ->count();
                    
                    if ($subsCnt > 0) {
                        $subscription = DB::Table("subscriptions")
                            ->where("emid", "=", $Employee->employee_id)
                            ->where("expiry_date", ">=", date("Y-m-d"))
                            ->where("status", "=", "active")
                            ->first();

                        if (!empty($subscription)) {
                            Session::put("employee_id", $request->employee_id);
                            Session::put("emp_email", $request->email);
                            Session::put("user_type", $Employee->user_type);
                            Session::put("users_id", $Employee->id);
                            Session::put("emp_pass", $request->psw);
                            Session::put("user_email", $request->email);
                        } else {
                            Session::flash(
                                "error",
                                "Your subscription plan expired!! Renew to continue."
                            );
                            return redirect("/");
                        }
                    } else {
                        //dd($request->employee_id);
                        //dd($Employee);
                        Session::put("employee_id", $request->employee_id);
                        Session::put("emp_email", $request->email);
                        Session::put("user_type", $Employee->user_type);
                        Session::put("users_id", $Employee->id);
                        Session::put("emp_pass", $request->psw);
                        Session::put("emid",$Employee->employee_id);
                    }
                } else {
                    if($Employee->user_type == "sub-admin"){
                        Session::flash("error", "Your email or password was wrong!!");
                        return redirect("subadmin");
                    }
                    //emid=$Employee->emid
                    //check for subscription
                    $subsCnt = DB::Table("subscriptions")
                        ->where("emid", "=", $Employee->emid)
                        ->count();

                    if ($subsCnt > 0) {
                        //dd('ranjan');
                        $subscription = DB::Table("subscriptions")
                            ->where("emid", "=", $Employee->emid)
                            ->where("expiry_date", ">=", date("Y-m-d"))
                            ->where("status", "=", "active")
                            ->first();

                        if (!empty($subscription)) {
                            $Roledata = DB::table("users")
                                ->where("employee_id", "=", $Employee->emid)
                                ->where("status", "=", "active")
                                ->first();
                                
                            if (!empty($Roledata)) {
                                Session::put("employee_id", $request->employee_id);
                                Session::put("emp_email", $Roledata->email);
                                Session::put("user_email", $request->email);
                                Session::put("user_type", $Employee->user_type);
                                Session::put("users_id", $Employee->id);
                                Session::put("emp_pass", $request->psw);
                            } else {
                                Session::flash(
                                    "error",
                                    "You are not active!!"
                                );
                                return redirect("/");
                            }
                        } else {
                            Session::flash(
                                "error",
                                "Your organisation subscription plan expired!! Try after renewal."
                            );
                            return redirect("/");
                        }
                    } else {
                        $Roledata = DB::table("users")
                            ->where("employee_id", "=", $Employee->employee_id)
                            ->where("status", "=", "active")
                            ->first();
                         
                        if (!empty($Roledata)) {
                            //dd($Roledata); 
                            Session::put("employee_id", $request->employee_id);
                            Session::put("emp_email", $Roledata->email);
                            Session::put("user_email", $request->email);
                            Session::put("user_type", $Employee->user_type);
                            Session::put("users_id", $Employee->id);
                            Session::put("emp_pass", $request->psw);
                            Session::put("emid",$Roledata->emid);
                        } else {
                            //dd("ranjan");
                            Session::flash("error", "You are not active!!");
                            return redirect("/");
                        }
                    }
                }
               
                return redirect()->intended("organization/employerdashboard"); 
                // return redirect()->intended("otpvalidate");
            } else { 
                Session::flash("error", "Your email or password was wrong!!");
                return redirect("/");
            }
        }
        //  @if(auth()->check())
        //auth()->user()->name
    }

    public function otp(Request $request){
        try {
            $email = Session::get("emp_email");
            if (!empty($email)) {
                return view("otp");
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }

    }
    public function otpsend(Request $request){
        try {
            $email = Session::get("emp_email");
            if (!empty($email)) {
                // dd($email);
                $randomNumber = mt_rand(100000, 999999);
                $base_url = env('BASE_URL');
                $toemail = $email;
                $Employee = UserModel::where("email", $email)->first();
                $data = ["otp" =>$randomNumber, "name" => $Employee->name, "url" => $base_url];
                if ($Employee) {
                    $Employee->otp = $randomNumber;
                    $Employee->save();
                    Mail::send("mailotp", $data, function ($message) use ($toemail) {
                        $message
                            ->to($toemail, "SWCH")
                            ->subject("OTP Validation");
                        $message->from("infoswc@skilledworkerscloud.co.uk", "Swch");
                    });
                }

                //return redirect()->intended("employerdashboard");
                Session::flash("message", "Send otp check your mail!!");
                return redirect()->back();
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\FrontException($e->getMessage());
        }
    }
    public function otpvalidate(Request $request)
    {
        try {
            $email = Session::get("emp_email");
            if (!empty($email)) {
                $Employee = UserModel::where("email", $email)
                    ->where("otp", $request->otp)
                    ->first();
                if (!empty($Employee)) {
                    // Successful OTP validation, redirect to employerdashboard
                    return redirect()->intended("employerdashboard");
                } else {
                    // Invalid OTP
                    Session::flash("error", "Your otp is wrong!!");
                    return redirect()->back();
                }
            } else {
                return redirect("/");
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }
    public function Logout(Request $request)
    {
        $user_type = Session::get("usersu_type");
        if ($user_type == "sub-admin") {
            Session::flush();
            Session::flash("message", "You are successfully Logout.");
            return redirect("/subadmin");
        }
        Session::forget("users_id");
        Session::forget("user_type");
        Session::forget("emp_pass");
        Session::forget("emp_email");
        Session::forget("admin_userpp_email");
        Session::forget("admin_userpp_member");
        Session::forget("admin_userp_user_type");
        Session::flush();
        Session::flash("message", "You are successfully Logout.");
        return redirect("/");
    }

    public function DoLoginuser(Request $request)
    {

        $Employee = DB::table("users_admin_emp")
            ->where("login_id", "=", $request->email)
            ->where("password", "=", $request->psw)
            ->where("status", "=", "active")
            ->where("user_type", "=", "user")
            ->first();
        // dd($Employee);
        if (!empty($Employee)) {
            Session::put("admin_userpp_email", $Employee->login_id);
            Session::put("admin_userpp_member", $Employee->employee_id);
            Session::put("admin_userp_user_type", $Employee->user_type);

            return redirect("user-check-organisation");
        } else {
            Session::flash("message", "Your Login Id Or password was wrong!!");
            return redirect("user-login");
        }
    }

    public function indexserorganisation()
    {
        if (!empty(Session::get("admin_userpp_email"))) {
            $member = Session::get("admin_userpp_member");

            $data["users"] = DB::table("role_authorization_admin_organ")
                ->where("member_id", "=", $member)
                ->where("status", "=", "active")
                ->get();

            return view("organisation-list", $data);
        } else {
            return redirect("user-login");
        }
    }

    public function DoLoginorganisation(Request $request)
    {
        if (!empty(Session::get("admin_userpp_email"))) {
            $member = Session::get("admin_userpp_member");

            $Employee = DB::table("users")
                ->where("employee_id", "=", $request->com)
                ->where("status", "=", "active")
                ->where("user_type", "=", "employer")
                ->first();

            //dd($request->com);

            if (!empty($Employee)) {
                Session::put("emp_email", $Employee->email);
                Session::put("user_type", $Employee->user_type);
                Session::put("users_id", $Employee->id);
                Session::put("emp_pass", $Employee->password);
                return redirect()->intended("employerdashboard");
            } else {
                Session::flash("message", "Organisation Is not active!!");
                return redirect("user-login");
            }
        } else {
            return redirect("user-login");
        }
    }

    public function Logoutusert(Request $request)
    {
        Session::forget("users_id");
        Session::forget("admin_userpp_email");
        Session::forget("admin_userpp_member");
        Session::forget("admin_userp_user_type");
        Session::forget("user_type");
        Session::forget("emp_pass");
        Session::forget("emp_email");
        Session::flash("message", "You are successfully Logout.");
        return redirect("user-login");
    }

    public function DoLoginpay(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                "email" => "required",
                "psw" => "required",
            ],
            [
                "email.required" => "Email Required",
                "psw.required" => "Password Required",
            ]
        );

        if ($validator->fails()) {
            return redirect("/")
                ->withErrors($validator)
                ->withInput();
        } else {
            $Employee = DB::table("users")
                ->where("email", "=", $request->email)
                ->where("password", "=", $request->psw)
                ->where("status", "=", "active")
                ->where("user_type", "!=", "admin")
                ->first();

            if (!empty($Employee)) {
                if ($Employee->user_type == "employer") {
                    Session::put("emp_email", $request->email);
                    Session::put("user_type", $Employee->user_type);
                    Session::put("users_id", $Employee->id);
                    Session::put("emp_pass", $request->psw);
                    return redirect("billingorganization/billinglist");
                } else {
                    Session::flash("message", "You are not Organisation!!");
                    return redirect("login-pay");
                }
            } else {
                Session::flash("message", "Your email or password was wrong!!");
                return redirect("login-pay");
            }
        }
        //  @if(auth()->check())
        //auth()->user()->name
    }

    public function payregister()
    {
        return view("register-pay");
    }

    public function Dopayregister(Request $request)
    {
        if ($request->pass != $request->con_password) {
            Session::flash(
                "message",
                "Password and Confirm Password both not same"
            );
            return redirect("register");
        } else {
            $Employee = DB::table("users")
                ->where("email", "=", $request->email)
                ->first();

            if (empty($Employee)) {
                $employee_pid = DB::table("registration")

                    ->orderBy("id", "DESC")

                    ->first();
                if (empty($employee_pid)) {
                    $pid = "EM1";
                } else {
                    $pid = "EM" . ($employee_pid->id + 1);
                }

                $datareg = [
                    "com_name" => $request->com_name,
                    "f_name" => $request->f_name,

                    "l_name" => $request->l_name,
                    "reg" => $pid,
                    "email" => $request->email,
                    "organ_email" => $request->email,

                    "status" => "active",
                    "verify" => "not approved",
                    "licence" => "no",

                    "p_no" => $request->p_no,
                    "pass" => $request->pass,
                    "created_at" => date("Y-m-d"),
                ];
                DB::table("registration")->insert($datareg);

                $datauser = [
                    "name" => $request->com_name,
                    "user_type" => "employer",

                    "status" => "active",
                    "employee_id" => $pid,
                    "email" => $request->email,

                    "updated_at" => date("Y-m-d h:i:s"),
                    "created_at" => date("Y-m-d h:i:s"),
                    "password" => $request->pass,
                ];
                DB::table("users")->insert($datauser);

                $le_type = DB::table("le_type")->get();

                foreach ($le_type as $value_le) {
                    $datauserleave = [
                        "leave_type_name" => $value_le->leave_type_name,
                        "alies" => $value_le->alies,

                        "remarks" => $value_le->remarks,
                        "emid" => $pid,
                        "leave_type_status" => "active",
                    ];
                    DB::table("leave_type")->insert($datauserleave);
                }

                $em_type = DB::table("em_type")->get();

                foreach ($em_type as $value_em) {
                    $datauseremployty = [
                        "employee_type_name" => $value_em->name,

                        "emid" => $pid,
                        "employee_type_status" => "Active",
                    ];
                    DB::table("employee_type")->insert($datauseremployty);
                }

                $data = [
                    "f_name" => $request->f_name,
                    "l_name" => $request->l_name,
                    "com_name" => $request->com_name,
                    "p_no" => $request->p_no,
                    "email" => $request->email,
                    "desig" => $request->desig,
                ];
                $toemail = "infoswc@skilledworkerscloud.co.uk";
                Mail::send("mailre", $data, function ($message) use ($toemail) {
                    $message
                        ->to($toemail, "SkilledWorkerscloud")
                        ->subject("Organisation   Details");
                    $message->from(
                        "infoswc@skilledworkerscloud.co.uk",
                        "skilledworkerscloud"
                    );
                });

                $datamail = [
                    "f_name" => $request->f_name,
                    "l_name" => $request->l_name,
                    "com_name" => $request->com_name,
                    "p_no" => $request->p_no,
                    "email" => $request->email,
                    "desig" => $request->desig,
                ];
                $toemail = "infoswc@skilledworkerscloud.co.uk";
                Mail::send("mailre", $datamail, function ($message) use (
                    $toemail
                ) {
                    $message
                        ->to($toemail, "SkilledWorkerscloud")
                        ->subject("Organisation   Details");
                    $message->from(
                        "infoswc@skilledworkerscloud.co.uk",
                        "SkilledWorkerscloud"
                    );
                });

                $data = [
                    "f_name" => $request->f_name,
                    "l_name" => $request->l_name,
                    "com_name" => $request->com_name,
                    "p_no" => $request->p_no,
                    "email" => $request->email,
                    "pass" => $request->pass,
                ];
                $toemail = $request->email;
                Mail::send("mailor", $data, function ($message) use ($toemail) {
                    $message
                        ->to($toemail, "SkilledWorkerscloud")
                        ->subject(
                            "Welcome to Work Permit Cloud HR Management System"
                        );
                    $message->from(
                        "infoswc@skilledworkerscloud.co.uk",
                        "SkilledWorkerscloud"
                    );
                });

                Session::flash(
                    "message",
                    "Thank you for registration.Please check your email for next steps."
                );

                return redirect("login-pay-register");
            } else {
                Session::flash("message", "Email id already exits.");
                return redirect("login-pay-register");
            }
        }
        //  @if(auth()->check())
        //auth()->user()->name
    }

    public function indexpayfor()
    {
        return view("forgot-password-pay");
    }

    public function Dopayforgot(Request $request)
    {
        $Employee = DB::table("users")
            ->where("email", "=", $request->email)
            ->where("status", "=", "active")
            ->where("user_type", "!=", "admin")
            ->first();

        if (!empty($Employee)) {
            $Roledata = DB::table("users")

                ->where("employee_id", "=", $Employee->emid)
                ->where("status", "=", "active")
                ->first();

            $data = ["pass" => $Employee->password, "name" => $Employee->name];
            $toemail = $request->email;
            Mail::send("mailforgot", $data, function ($message) use ($toemail) {
                $message
                    ->to($toemail, "SkilledWorkerscloud")
                    ->subject("Forgot  Password ");
                $message->from(
                    "infoswc@skilledworkerscloud.co.uk",
                    "SkilledWorkerscloud"
                );
            });

            Session::flash("message", "Mail sent successfully.");
            return redirect("login-pay-forgot-password");
        } else {
            Session::flash("message", "Your email id was wrong!!");
            return redirect("login-pay-forgot-password");
        }
    }
}
