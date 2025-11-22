<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use App\Models\UserModel;
use App\Models\User;
use App\Models\Holiday;
use App\Models\Branch_location;
use App\Models\RotaEmployee;
use App\Models\Post\Post;
use App\Models\Employee;
use App\Models\TaskManagement\ProjectMembers;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Mail;
use Exception;
use Session;
use DB;

class OrganizationController extends Controller
{
    protected $_module;
    protected $_routePrefix;
    protected $_model;

    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.organization';
        $this->_model       = new UserModel();
    }

  
    
    public function Dashboard(Request $request)
    {
        $email = Session::get("emp_email");
        
        if (!empty($email)) {
            $user_type = Session::get("user_type");
            //dd($user_type);
            if ($user_type == "employer") {
                //dd($user_type);
                $data["Roledata"] = DB::table("registration")
                    ->where("status", "=", "active")
                    ->where("email", "=", $email)
                    ->first(); 
                    //dd($data["Roledata"]);
                $data['employee_count'] = DB::table('users')->join('employee', 'users.employee_id', '=', 'employee.emp_code')
                ->where('employee.emid', '=', $data["Roledata"]->reg)
                ->where('users.emid', '=', $data["Roledata"]->reg)
                ->where('users.status', '=', 'active')
                ->where('users.user_type', '=', 'employee')
                ->count(); 
                  $data['inactive_employee'] = DB::table('users')->join('employee', 'users.employee_id', '=', 'employee.emp_code')
                ->where('employee.emid', '=', $data["Roledata"]->reg)
                ->where('users.emid', '=', $data["Roledata"]->reg)
                ->where('users.status', '=', 'inactive')
                ->where('users.user_type', '=', 'employee')
                ->count();
                
                //dd($data['inactive_employee']);
                $data['migrant_emp_count'] = DB::table('users')
                ->join('employee', 'users.employee_id', '=', 'employee.emp_code')
                ->where('employee.emid', '=', $data["Roledata"]->reg)
                ->where('users.emid', '=', $data["Roledata"]->reg)
                ->where('users.status', '=', 'active')
                ->where(function ($query) {
                    $query->whereNull('employee.emp_status')
                        ->orWhere('employee.emp_status', '!=', 'LEFT');
                })
                ->where(function ($query) {
                    $query->whereNotNull('employee.visa_doc_no')
                        ->orWhereNotNull('employee.euss_ref_no');
                })
                ->where('users.user_type', '=', 'employee')
                ->count(); 
                $data["department_count"] = DB::table('department')->where('emid','=',$data["Roledata"]->reg)->count(); 
                $data['job_type_count'] = DB::table('company_job_list')->where('emid','=',$data["Roledata"]->reg)->count();
                $data['employee_dtl'] = DB::table('employee')
                    ->where('employee.emid', '=', $data["Roledata"]->reg)
                    ->orderBy('emp_dob', 'desc')
                    ->get();
                 $data['employee_birth'] = DB::table('employee')
                ->select('employee.*')
                ->where(DB::raw("DATE_FORMAT(emp_dob, '%m-%d')"), '=', DB::raw("DATE_FORMAT(CURDATE(), '%m-%d')"))
                ->where('employee.emid', '=', $data["Roledata"]->reg)
                ->get(); 

                $today = date('Y-m-d');
                $data['notices'] = DB::table('notices')
                    ->where('created_by_type', 'admin')
                    ->where('notice_for', 'organization')
                    ->whereDate('start_date', '<=', $today)
                    ->whereDate('end_date', '>=', $today)
                    ->get();
                // $data['notices'] = DB::table('notices')->where('created_by_type','admin')->where('notice_for','organization')->get();
            } else {
                
                $usemail = Session::get("user_email");
                //dd($usemail);
                $users_id = Session::get("users_id");
                $data["Roledata"] = DB::table("users")
                    ->where("id", "=", $users_id)
                    ->first();
                $emid = $data["Roledata"]->emid;      
                $data['holidays'] = Holiday::join('holiday_type', 'holiday_type.id', '=', 'holiday.holiday_type')
                    ->where('holiday.emid', $emid)
                    ->whereMonth('holiday.from_date', date('m'))
                    ->whereYear('holiday.from_date', date('Y'))
                    ->select('holiday.*', 'holiday_type.name')
                    ->get();
            
                $user = User::where('email', $usemail)
                        ->where('status', 'active')
                        ->firstOrFail();

                $data['posts'] = DB::table('post')
                    ->join('employee', function($join) {
                        $join->on('employee.emid', '=', 'post.emid')
                            ->on('employee.emp_code', '=', 'post.employee_code');
                    })
                    ->leftJoin('post_likes', function($join) use ($user) {
                        $join->on('post_likes.post_id', '=', 'post.id')
                            ->where('post_likes.emid', $user->emid)
                            ->where('post_likes.employee_code', $user->employee_id);
                    })
                    ->where('employee.status', 'active')
                    ->orderBy('post.created_at', 'desc')
                    ->select(
                        'post.*',
                        'employee.emp_fname as first_name',
                        'employee.emp_lname as last_name',
                        'employee.emp_image as employee_image',
                        'employee.emp_designation as designation',
                        DB::raw('(SELECT COUNT(*) FROM post_likes WHERE post_likes.post_id = post.id) as likes_count'),
                        DB::raw('CASE WHEN post_likes.id IS NOT NULL THEN 1 ELSE 0 END as is_liked')
                    )
                    ->get();

                // Format the data for display
                $data['posts']->transform(function ($post) use ($user) {
                    // Get comments for this post with employee details
                    $comments = DB::table('post_comments')
                        ->join('employee', function($join) {
                            $join->on('employee.emid', '=', 'post_comments.emid')
                                ->on('employee.emp_code', '=', 'post_comments.employee_code');
                        })
                        ->where('post_comments.post_id', $post->id)
                        ->where('employee.status', 'active')
                        ->orderBy('post_comments.created_at', 'asc')
                        ->select(
                            'post_comments.*',
                            'employee.emp_fname as commenter_first_name',
                            'employee.emp_lname as commenter_last_name',
                            'employee.emp_image as commenter_image',
                            'employee.emp_designation as commenter_designation'
                        )
                        ->get()
                        ->map(function ($comment) {
                            return (object)[
                                'id' => $comment->id,
                                'comment_text' => $comment->comment_text,
                                'created_at' => $comment->created_at,
                                'commenter_name' => trim($comment->commenter_first_name . ' ' . $comment->commenter_last_name),
                                'commenter_image' => $comment->commenter_image 
                                    ? asset("storage/app/public/".$comment->commenter_image) 
                                    : asset('assets/img/user.png'),
                                'commenter_designation' => $comment->commenter_designation,
                                'time_ago' => \Carbon\Carbon::parse($comment->created_at)->diffForHumans()
                            ];
                        });
                        
                    return (object)[
                        'id' => $post->id,
                        'emid' => $post->emid,
                        'employee_code' => $post->employee_code,
                        'title' => $post->title,
                        'image_path' => $post->image_path ? asset("storage/app/public/".$post->image_path) : null,
                        'created_at' => $post->created_at,
                        'updated_at' => $post->updated_at,
                        'employee_name' => trim($post->first_name . ' ' . $post->last_name),
                        'employee_image' => $post->employee_image ? asset("storage/app/public/".$post->employee_image) : asset('assets/img/user.png'),
                        'designation' => $post->designation,
                        'time_ago' => \Carbon\Carbon::parse($post->created_at)->diffForHumans(),
                        'comments' => $comments,
                        'comments_count' => $comments->count(),
                        'likes_count' => $post->likes_count ?? 0,
                        'is_liked' => $post->is_liked ?? false
                    ];
                });

                
                $orgData = User::where('employee_id',$user->emid)->first();
                $empData = Employee::where('emp_code',$user->employee_id)->first();
                //dd($empData->emp_code);
                $projectAssign = ProjectMembers::where('user_id',$empData->id)->get();
                //dd($projectAssign);
                if ($projectAssign->count() > 0) {
                    $data['project'] = $empData->emp_code;
                } else {
                    $data['project'] = "";
                }
                //dd($data['project']);


                //dd($data['posts']);
                return view('employeer.employee-corner.dashboard', $data);
                    
            }

            $user = User::where('email', $email)
            ->where('status', 'active')
            ->firstOrFail();

            $data['posts'] = DB::table('post')
            ->leftJoin('employee', function($join) {
                $join->on('employee.emid', '=', 'post.emid')
                    ->on('employee.emp_code', '=', 'post.employee_code');
            })
            ->leftJoin('post_likes', function($join) use ($user) {
                $join->on('post_likes.post_id', '=', 'post.id')
                    ->where('post_likes.emid', $user->employee_id)
                    ->where('post_likes.employee_code', $user->employee_id);
            })
            ->where(function($q) use ($user) {
                $q->where('post.emid', $user->employee_id)
                ->orWhereNull('post.emid'); // include org posts
            })
            ->where(function($q) {
                $q->whereNull('employee.status')   // allow org posts with no employee
                ->orWhere('employee.status', 'active');
            })
            ->orderBy('post.created_at', 'desc')
            ->select(
                'post.*',
                'employee.emp_fname as first_name',
                'employee.emp_lname as last_name',
                'employee.emp_image as employee_image',
                'employee.emp_designation as designation',
                DB::raw('(SELECT COUNT(*) FROM post_likes WHERE post_likes.post_id = post.id) as likes_count'),
                DB::raw('CASE WHEN post_likes.id IS NOT NULL THEN 1 ELSE 0 END as is_liked')
            )
            ->get();

            //dd($data['posts']);       
            // Transform posts with comments
            $data['posts']->transform(function ($post) use ($user) {
                $comments = DB::table('post_comments')
                    ->join('employee', function($join) {
                        $join->on('employee.emid', '=', 'post_comments.emid')
                            ->on('employee.emp_code', '=', 'post_comments.employee_code');
                    })
                    ->where('post_comments.post_id', $post->id)
                    ->where('employee.status', 'active')
                    ->orderBy('post_comments.created_at', 'asc')
                    ->select(
                        'post_comments.*',
                        'employee.emp_fname as commenter_first_name',
                        'employee.emp_lname as commenter_last_name',
                        'employee.emp_image as commenter_image',
                        'employee.emp_designation as commenter_designation'
                    )
                    ->get()
                    ->map(function ($comment) {
                        return (object)[
                            'id' => $comment->id,
                            'comment_text' => $comment->comment_text,
                            'created_at' => $comment->created_at,
                            'commenter_name' => trim($comment->commenter_first_name . ' ' . $comment->commenter_last_name),
                            'commenter_image' => $comment->commenter_image 
                                ? asset("storage/app/public/".$comment->commenter_image) 
                                : asset('assets/img/user.png'),
                            'commenter_designation' => $comment->commenter_designation,
                            'time_ago' => \Carbon\Carbon::parse($comment->created_at)->diffForHumans()
                        ];
                    });

                return (object)[
                    'id' => $post->id,
                    'emid' => $post->emid,
                    'employee_code' => $post->employee_code,
                    'title' => $post->title,
                    'image_path' => $post->image_path ? asset("storage/app/public/".$post->image_path) : null,
                    'created_at' => $post->created_at,
                    'updated_at' => $post->updated_at,
                    'employee_name' => trim($post->first_name . ' ' . $post->last_name),
                    'employee_image' => $post->employee_image ? asset("storage/app/public/".$post->employee_image) : asset('assets/img/user.png'),
                    'designation' => $post->designation,
                    'time_ago' => \Carbon\Carbon::parse($post->created_at)->diffForHumans(),
                    'comments' => $comments,
                    'comments_count' => $comments->count(),
                    'likes_count' => $post->likes_count ?? 0,
                    'is_liked' => (bool) $post->is_liked
                ];
            });

            //dd($data['posts']);
            return view($this->_routePrefix . '.dashboard', $data);
        } else {
            return redirect("/");
        }
    }
    
    
    public function quick_links(Request $request){
        $email = Session::get("emp_email");
        if (!empty(Session::get('emp_email'))) {
            
               // Fetch employee data
                $employee = DB::table('registration')->where('email', $email)->first();

                // Fetch modules assigned to the employee
                $array_role = DB::table('othorized_organization_module')
                    ->where('employee_id', $employee->reg)
                    ->pluck('module_name')
                    ->toArray();
                //dd($employee);
                return view($this->_routePrefix . '.quick-links', compact('array_role', 'employee'));

            //return view($this->_routePrefix . '.quick-links',$data);
        }else{
            return redirect('/');
        }
    }
    
    
    
    
    public function profile(Request $request){
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $data['companies_rs'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
             //dd($data['companies_rs']);
            //dd($data); 
            return view($this->_routePrefix . '.profile',$data);

        }else{
            return redirect('/');
        }
    }
    public function statistics(Request $request) {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            dd($email);

        }else{
            return redirect('/');
        }
    }
    
    public function employeesRTI(Request $request) {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            //dd($email);
            $data['companies_rs'] = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('email', '=', $email)
            ->first();
            $data['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            //dd($data['companies_rs']);    
            return view($this->_routePrefix . '.employee-rti-link',$data);
        }else{
            return redirect('/');
        }
    }
    public function authorizingOfficer(Request $request) {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            // dd($email);
            $data['companies_rs'] = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('email', '=', $email)
            ->first();
            $data['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
                //dd($data);
            return view($this->_routePrefix . '.authorizing-officer',$data);
        }else{
            return redirect('/');
        }  
    }

    public function keyContact(Request $request) {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $data['companies_rs'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            $data['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            return view($this->_routePrefix . '.key-contect',$data);
            //return view('company/employee-key-link', $data);
        }else{
            return redirect('/');
        }  
    }
    public function level1User(Request $request) {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            $data['companies_rs'] = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('email', '=', $email)
            ->first();
            $data['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            return view($this->_routePrefix . '.first-level-user',$data);
        }else{
            return redirect('/');
        } 
    }
    public function level2User(Request $request) {
        if (!empty(Session::get('emp_email'))) {
            $email = Session::get('emp_email');
            //dd($email);
            $email = Session::get('emp_email');
            $data['companies_rs'] = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('email', '=', $email)
            ->first();
            $data['Roledata'] = DB::table('registration')
                ->where('status', '=', 'active')
                ->where('email', '=', $email)
                ->first();
            return view($this->_routePrefix . '.second-level-user',$data);
        }else{
            return redirect('/');
        } 
    }

    public function pdf(){
        $email = Session::get('emp_email');
        $data['companies_rs'] = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('email', '=', $email)
            ->first();
        $data['Roledata'] = DB::table('registration')
            ->where('status', '=', 'active')
            ->where('email', '=', $email)
            ->first();
         //dd($data);
         $pdf = Pdf::loadView('my-profile-pdf', $data);
         return $pdf->download('profile.pdf');
        //return view($this->_routePrefix . '.profile',$data);
    }

    public function viewAddCompany()
    {
        try {
            $email = Session::get('emp_email');
            //dd(Session()->all());
            if (!empty($email)) {
                $data['Roledata'] = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('email', '=', $email)
                    ->first();

                $data['application_status_tareq'] = DB::table('tareq_app')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->first();

                $data['cuurenci_master'] = DB::table('location_countries')->get();
                $data['nat_or_master'] = DB::table('nat_or')->get();
                $data['type_or_master'] = DB::table('type_or')->get();
                $data['employee_upload_rs'] = DB::table('company_upload')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->get();
                $data['employee_or_rs'] = DB::table('company_employee')
                    ->where('emid', '=', $data['Roledata']->reg)
                    ->get();
                    //dd($data);
                $data['user'] = DB::table('users')->where('email',$email)->select('password')->first(); 
                return view($this->_routePrefix . '.edit-company',$data);
                //return View('company/edit-company', $data);
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function saveCompany(Request $request)
    {
        //dd($request->all());
        try {
            if (!empty(Session::get('emp_email'))) {

                

                $email = Session::get('emp_email');

                // $validated = $request->validate([
                //     'latitude' => [
                //         'required',
                //         'numeric',
                //         'between:-90,90'  
                //     ],
                //     'longitude' => [
                //         'required',
                //         'numeric',
                //         'between:-180,180'
                //     ],
                //     'org_radious' => [
                //         'required',
                //         'numeric'
                //     ]
                // ]);
                //dd($validated);
                $password = $request->validate([
                    'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]+$/'],
                ], [
                    'password.regex' => 'Password must contain at least one letter, one number, and one special character.',
                ]);
                //dd($password);
                $existingCompanyInfo = DB::table('registration')->where('status', '=', 'active')->where('email', $email)->first();
                $company_email = $request->email;
                $company_name = $request->company_name;
                if ($request->has('image')) {

                    $file = $request->file('image');
                    $extension = $request->image->extension();
                    $path = $request->image->store('employee', 'public');
                    $dataimg = array(
                        'logo' => $path,
                    );
                    DB::table('registration')->where('status', '=', 'active')->where('email', $email)->update($dataimg);
                }
                if ($request->has('proof')) {

                    $file1 = $request->file('proof');
                    $extension1 = $request->proof->extension();
                    $path1 = $request->proof->store('proof', 'public');
                    $dataimg = array(
                        'proof' => $path1,
                    );
                    DB::table('registration')->where('status', '=', 'active')->where('email', $email)->update($dataimg);
                }

                if ($request->has('key_proof')) {

                    $file1 = $request->file('key_proof');
                    $extension1 = $request->key_proof->extension();
                    $path1 = $request->key_proof->store('key_proof', 'public');
                    $dataimgh = array(
                        'key_proof' => $path1,
                    );
                    DB::table('registration')->where('status', '=', 'active')->where('email', $email)->update($dataimgh);
                }

                if ($request->hasFile('level_proof')) {
                    $file1 = $request->file('level_proof');
                    $filename = time() . '.' . $file1->getClientOriginalExtension();
                    $path1 = $file1->storeAs('level_proof', $filename, 'public');
                    $dataimgf = [
                        'level_proof' => $path1,  // Store the relative path
                    ];
                    DB::table('registration')
                        ->where('status', '=', 'active')
                        ->where('email', $email)
                        ->update($dataimgf);
                }
                

                if ($request->hasFile('level2_proof')) {
                    $file2 = $request->file('level2_proof');
                    $filename2 = time() . '.' . $file2->getClientOriginalExtension();
                    $path2 = $file2->storeAs('level2_proof', $filename2, 'public');
                    $dataimgf2 = [
                        'level2_proof' => $path2,  // Store the relative path
                    ];
                    DB::table('registration')
                        ->where('status', '=', 'active')
                        ->where('email', $email)
                        ->update($dataimgf2);
                }

                $dataup = array(
                    'com_name' => $request->com_name,
                    'f_name' => $request->f_name,

                    'l_name' => $request->l_name,

                    'p_no' => $request->p_no,
                    'pan' => $request->pan,
                    'address' => $request->address,
                    'website' => $request->website,
                    'land' => $request->land,
                    'fax' => $request->fax,
                    'pass' => $request->password,

                    'key_person' => $request->key_person,
                    'level_person' => $request->level_person,

                    'key_f_name' => $request->key_f_name,
                    'key_f_lname' => $request->key_f_lname,
                    'key_designation' => $request->key_designation,
                    'key_phone' => $request->key_phone,
                    'key_email' => $request->key_email,
                    'key_bank_status' => $request->key_bank_status,
                    'key_bank_other' => $request->key_bank_other,

                    'level_f_name' => $request->level_f_name,
                    'level_f_lname' => $request->level_f_lname,
                    'level_designation' => $request->level_designation,
                    'level_phone' => $request->level_phone,
                    'level_email' => $request->level_email,
                    'level_bank_status' => $request->level_bank_status,
                    'level_bank_other' => $request->level_bank_other,

                    'level2_f_name' => $request->level2_f_name,
                    'level2_f_lname' => $request->level2_f_lname,
                    'level2_designation' => $request->level2_designation,
                    'level2_phone' => $request->level2_phone,
                    'level2_email' => $request->level2_email,
                    'level2_bank_status' => $request->level2_bank_status,
                    'level2_bank_other' => $request->level2_bank_other,

                    'trad_status' => $request->trad_status,
                    'trad_other' => $request->trad_other,
                    'penlty_status' => $request->penlty_status,
                    'penlty_other' => $request->penlty_other,
                    'bank_status' => $request->bank_status,
                    'bank_other' => $request->bank_other,

                    'com_reg' => $request->com_reg,
                    'com_type' => $request->com_type,
                    'com_year' => $request->com_year,
                    'com_nat' => $request->com_nat,
                    'no_em' => $request->no_em,
                    'work_per' => $request->work_per,
                    'no_dire' => $request->no_dire,

                    'bank_name' => $request->bank_name,
                    'acconut_name' => $request->acconut_name,
                    'organ_email' => $request->organ_email,
                    'sort_code' => $request->sort_code,
                    'others_type' => $request->others_type,

                    'nature_type' => $request->nature_type,
                    'no_em_work' => $request->no_em_work,

                    'country' => $request->country,
                    'currency' => $request->currency,
                    'desig' => $request->desig,
                    'trad_name' => $request->trad_name,
                    'con_num' => $request->con_num,
                    'authemail' => $request->authemail,

                    'address2' => $request->address2,
                    'road' => $request->road,
                    'city' => $request->city,
                    'zip' => $request->zip,
                    'updated_at' => date('Y-m-d'),

                    'licence' => $request->licence,
                    'verify' => $request->verify,
                    'verified_on' => $request->verified_on,
                    //'status' => $request->status,
                    'license_type' => $request->license_type,

                    'sun_status' => $request->sun_status,
                    'sun_time' => $request->sun_time,
                    'sun_close' => $request->sun_close,

                    'mon_status' => $request->mon_status,
                    'mon_time' => $request->mon_time,
                    'mon_close' => $request->mon_close,

                    'tue_status' => $request->tue_status,
                    'tue_time' => $request->tue_time,
                    'tue_close' => $request->tue_close,

                    'wed_status' => $request->wed_status,
                    'wed_time' => $request->wed_time,
                    'wed_close' => $request->wed_close,

                    'thu_status' => $request->thu_status,
                    'thu_time' => $request->thu_time,
                    'thu_close' => $request->thu_close,

                    'fri_status' => $request->fri_status,
                    'fri_time' => $request->fri_time,
                    'fri_close' => $request->fri_close,

                    'sat_status' => $request->sat_status,
                    'sat_time' => $request->sat_time,
                    'sat_close' => $request->sat_close,

                    // 'latitude' => $request->latitude,
                    // 'longitude' => $request->longitude,
                    // 'org_radious' => $request->org_radious,

                );

                $Roledatauseer = DB::table('registration')
                    ->where('status', '=', 'active')
                    ->where('reg', '=', $request->reg)
                    ->first();

                if (!empty($request->id_up_doc)) {

                    $tot_item_nat_edit = count($request->id_up_doc);

                    foreach ($request->id_up_doc as $valuee) {

                        if ($request->input('type_doc_' . $valuee) != '') {

                            if ($request->has('docu_nat_' . $valuee)) {
                                $size = $request->file('docu_nat_' . $valuee)->getSize();

                                $extension_doc_edit_up = $request->file('docu_nat_' . $valuee)->extension();

                                $path_quli_doc_edit_up = $request->file('docu_nat_' . $valuee)->store('company_upload_doc', 'public');
                                $dataimgeditup = array(
                                    'docu_nat' => $path_quli_doc_edit_up,
                                );

                                DB::table('company_upload')
                                    ->where('id', $valuee)
                                    ->update($dataimgeditup);

                            }

                            $datauploadedit = array(
                                'emid' => $request->reg,
                                'type_doc' => $request->input('type_doc_' . $valuee),
                                'other_txt' => $request->input('other_doc_' . $valuee),

                            );
                            DB::table('company_upload')
                                ->where('id', $valuee)
                                ->update($datauploadedit);

                        }
                    }

                }

                if (!empty($request->type_doc)) {
                    $tot_item_nat = count($request->type_doc);

                    for ($i = 0; $i < $tot_item_nat; $i++) {
                        if ($request->type_doc[$i] != '') {
                            if (!empty($request->docu_nat[$i])) {

                                $extension_upload_doc = $request->docu_nat[$i]->extension();
                                $path_upload_doc = $request->docu_nat[$i]->store('company_upload_doc', 'public');

                            } else {
                                $path_upload_doc = '';
                            }
                            $dataupload = array(
                                'emid' => $request->reg,
                                'type_doc' => $request->type_doc[$i],
                                'other_txt' => $request->other_doc[$i],

                                'docu_nat' => $path_upload_doc,
                            );
                            DB::table('company_upload')->insert($dataupload);
                        }
                    }
                }
                if ($request->licence == 'no') {

                    DB::table('company_employee')->where('emid', '=', $request->reg)->delete();

                    $tot_title = count($request->name);

                    for ($i = 0; $i < $tot_title; $i++) {
                        if ($request->name[$i] != '') {

                            $datapaywmo = array(
                                'emid' => $request->reg,

                                'name' => $request->name[$i],
                                'department' => strtoupper($request->department[$i]),
                                'designation' => strtoupper($request->designation[$i]),
                                'job_type' => strtoupper($request->job_type[$i]),
                                'immigration' => $request->immigration[$i],

                            );

                            $lsatdeptnmdb = DB::table('department')->orderBy('id', 'DESC')->first();
                            if (empty($lsatdeptnmdb)) {
                                $pid = 'D1';
                            } else {
                                $pid = 'D' . ($lsatdeptnmdb->id + 1);
                            }

                            $datadeprt = array(
                                'department_name' => strtoupper($request->department[$i]),
                                'emid' => $request->reg,
                                'department_code' => $pid,
                            );

                            $deptnmdb = DB::table('department')->where('department_name', '=', strtoupper($request->department[$i]))->where('emid', $request->reg)->first();

                            if (empty($deptnmdb)) {
                                DB::table('department')->insert($datadeprt);

                            }
                            $deptnmdbname = DB::table('department')->where('department_name', '=', strtoupper($request->department[$i]))->where('emid', $request->reg)->first();

                            $lsatdeptnmdgb = DB::table('designation')->orderBy('id', 'DESC')->first();
                            if (empty($lsatdeptnmdgb)) {
                                $pidf = 'DE1';
                            } else {
                                $pidf = 'DE' . ($lsatdeptnmdgb->id + 1);
                            }

                            $datadesig = array(
                                'department_code' => $deptnmdbname->id,
                                'designation_code' => $pidf,
                                'designation_name' => strtoupper($request->designation[$i]),
                                'emid' => $request->reg,
                                'designation_status' => 'active',
                            );

                            $check_designation = DB::table('designation')->where('department_code', $deptnmdbname->id)->where('designation_name', strtoupper($request->designation[$i]))->where('emid', '=', $request->reg)->first();

                            if (empty($check_designation)) {
                                DB::table('designation')->insert($datadesig);

                            }

                            $employee_type = DB::table('employee_type')->where('employee_type_name', strtoupper(trim($request->job_type[$i])))->where('emid', '=', $request->reg)->first();

                            if (empty($employee_type)) {

                                DB::table('employee_type')->insert(
                                    ['employee_type_name' => strtoupper(trim($request->job_type[$i])), 'employee_type_status' => 'Active', 'emid' => $request->reg]
                                );
                            }

                            DB::table('company_employee')->insert($datapaywmo);
                        }
                    }
                } else {
                    $or_rs = DB::table('company_employee')
                        ->where('emid', '=', $request->reg)
                        ->get();
                    if (count($or_rs) == 0) {

                        DB::table('company_employee')->where('emid', '=', $request->reg)->delete();

                        $tot_title = count($request->name);

                        for ($i = 0; $i < $tot_title; $i++) {
                            if ($request->name[$i] != '') {
                                $datapaywmo = array(
                                    'emid' => $request->reg,

                                    'name' => $request->name[$i],
                                    'department' => strtoupper($request->department[$i]),
                                    'designation' => strtoupper($request->designation[$i]),
                                    'job_type' => strtoupper($request->job_type[$i]),
                                    'immigration' => $request->immigration[$i],

                                );

                                $lsatdeptnmdb = DB::table('department')->orderBy('id', 'DESC')->first();
                                if (empty($lsatdeptnmdb)) {
                                    $pid = 'D1';
                                } else {
                                    $pid = 'D' . ($lsatdeptnmdb->id + 1);
                                }

                                $datadeprt = array(
                                    'department_name' => strtoupper($request->department[$i]),
                                    'emid' => $request->reg,
                                    'department_code' => $pid,
                                );

                                $deptnmdb = DB::table('department')->where('department_name', '=', strtoupper($request->department[$i]))->where('emid', $request->reg)->first();

                                if (empty($deptnmdb)) {
                                    DB::table('department')->insert($datadeprt);

                                }
                                $deptnmdbname = DB::table('department')->where('department_name', '=', strtoupper($request->department[$i]))->where('emid', $request->reg)->first();

                                $lsatdeptnmdgb = DB::table('designation')->orderBy('id', 'DESC')->first();
                                if (empty($lsatdeptnmdgb)) {
                                    $pidf = 'DE1';
                                } else {
                                    $pidf = 'DE' . ($lsatdeptnmdgb->id + 1);
                                }

                                $datadesig = array(
                                    'department_code' => $deptnmdbname->id,
                                    'designation_code' => $pidf,
                                    'designation_name' => strtoupper($request->designation[$i]),
                                    'emid' => $request->reg,
                                    'designation_status' => 'active',
                                );

                                $check_designation = DB::table('designation')->where('department_code', $deptnmdbname->id)->where('designation_name', strtoupper($request->designation[$i]))->where('emid', '=', $request->reg)->first();

                                if (empty($check_designation)) {
                                    DB::table('designation')->insert($datadesig);

                                }

                                $employee_type = DB::table('employee_type')->where('employee_type_name', strtoupper(trim($request->job_type[$i])))->where('emid', '=', $request->reg)->first();

                                if (empty($employee_type)) {

                                    DB::table('employee_type')->insert(
                                        ['employee_type_name' => strtoupper(trim($request->job_type[$i])), 'employee_type_status' => 'Active', 'emid' => $request->reg]
                                    );
                                }

                                DB::table('company_employee')->insert($datapaywmo);
                            }
                        }
                    }
                }

                if ($existingCompanyInfo->verify == 'not approved' && $request->verify == 'approved') {

                    $data_email = array('to_name' => '', 'body_content' => 'License already applied, please issue the 1st Invoice.<p> Organisation with name "' . $existingCompanyInfo->com_name . '" .</p><p>Invoice Amount: £1500 plus VAT</p>');
                    $toemail = 'info@skilledworkerscloud.co.uk';
                    Mail::send('mailsmcommon', $data, function ($message) use ($toemail) {
                        $message->to($toemail, env('MAIL_FROM_NAME'))->subject('Organisation License Applied');
                        $message->from(env('MAIL_USERNAME'),  env('MAIL_FROM_NAME'));
                    });
                    if($existingCompanyInfo->authemail !=null || trim($existingCompanyInfo->authemail) !=''){
                     
                        $toemail = $existingCompanyInfo->authemail;
                        Mail::send('mailsmcommon', $data, function ($message) use ($toemail) {
                            $message->to($toemail, env('MAIL_FROM_NAME'))->subject('Need your action to complete sponsorship licence application');
                            $message->from(env('MAIL_USERNAME'),  env('MAIL_FROM_NAME'));
                        });
                    
                    }                    

                }

                if ($existingCompanyInfo->licence != 'yes' && $request->licence == 'yes' ) {
                    //mail to case worker for assignment of organisation
                    $data = array('to_name' => '', 'body_content' => 'Organisation with name "' . $existingCompanyInfo->com_name . '" has been applied for license. Please proceed with the HR File.');

                    $toemail = 'sales@skilledworkerscloud.co.uk';
               
                    Mail::send('mailsmcommon', $data, function ($message) use ($toemail) {
                        $message->to($toemail, env('MAIL_FROM_NAME'))->subject('New Unassigned HR');
                        $message->from(env('MAIL_USERNAME'),  env('MAIL_FROM_NAME'));
                    });

                    $data = array('to_name' => '', 'body_content' => 'Organisation with name "' . $existingCompanyInfo->com_name . '" has been applied for license. Please proceed with the Recruitement File.');
                    $toemail = 'info@skilledworkerscloud.co.uk';
                    Mail::send('mailsmcommon', $data, function ($message) use ($toemail) {
                        $message->to($toemail, env('MAIL_FROM_NAME'))->subject('New Recruitment organisation');
                        $message->from(env('MAIL_USERNAME'),  env('MAIL_FROM_NAME'));
                    });

                    $data_email = array('to_name' => '', 'body_content' => 'License already applied, please issue the 1st Invoice.<p> Organisation with name "' . $existingCompanyInfo->com_name . '" .</p><p>Invoice Amount: £1500 plus VAT</p>');
                    if($existingCompanyInfo->authemail !=null || trim($existingCompanyInfo->authemail) !=''){         
                        $toemail = $existingCompanyInfo->authemail;
                        Mail::send('mailsmsla', $data, function ($message) use ($toemail) {
                            $message->to($toemail, env('MAIL_FROM_NAME'))->subject('Need action to prepare HR File');
                            $message->from(env('MAIL_USERNAME'),  env('MAIL_FROM_NAME'));
                        });
                    }        
                }

                if ($Roledatauseer->created_at != '' && $Roledatauseer->updated_at == '') {

                    $data = array('f_name' => $request->f_name, 'l_name' => $request->l_name, 'com_name' => $request->com_name, 'p_no' => $request->p_no, 'email' => $request->email);
                    $toemail = 'info@skilledworkerscloud.co.uk';
                    Mail::send('mailorupnew', $data, function ($message) use ($toemail) {
                        $message->to($toemail, env('MAIL_FROM_NAME'))->subject('Organisation Update');
                        $message->from(env('MAIL_USERNAME'),  env('MAIL_FROM_NAME'));
                    });
                }

                DB::table('registration')->where('status', '=', 'active')->where('reg', $request->reg)->update($dataup);
                
                DB::table('users')->where('status', '=', 'active')->where('employee_id', $request->reg)->update($password);
                //DB::table('registration')->where('reg', $request->reg)->update($dataup);

                Session::flash('message', 'Organisation Information Successfully saved.');
                return redirect('organization/profile');
                
            } else {
                return redirect('/');
            }

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function index(){
        $email = Session::get("emp_email");
        if(!empty($email)){
            $emid = Session::get("emid");
            $branches = Branch_location::where('emid',$emid)
                //->where('status',1)
                ->get();
            return view($this->_routePrefix . '.branch-location', compact('branches'));
        } else {
            return redirect('/');
        }
      
    }

    public function create(){
        $email = Session::get("emp_email");
        if(!empty($email)){
            return view($this->_routePrefix .'.add-branch');
        } else {
            return redirect('/');
        }
    }

    public function store(Request $request){
        $email = Session::get("emp_email");
        //dd($request->all());
        if(!empty($email)){
            $emid = Session::get("emid");
            $validated = $request->validate([
                'branch_name' => 'required|string|max:255',
                'attendance_process' => 'required|string|max:255',
                'branch_location' => 'required|string|max:255',
                'latitude' => 'nullable|numeric',
                'longitude' => 'nullable|numeric',
                'radius' => 'nullable|numeric|min:0',
                
            ]);
            $validated['emid'] = $emid;
            $validated['status'] = 1;
            $dataExist = Branch_location::where('emid',$emid)->first();
            if($dataExist){
                Session::flash('error', 'Organisation branch location allready exist.');
                return redirect()->route('branch.location');
            }

            Branch_location::create($validated);
            Session::flash('message', 'Organisation branch location created successfully.');
            return redirect()->route('branch.location');
        } else {
            return redirect('/');
        }
          
    }

    public function changeStatus(Request $request, $id){
        $email = Session::get("emp_email");
        if(!empty($email)){
            $decodeId = base64_decode($id);
            $branch = Branch_location::find($decodeId);
            if($branch){
                $branch->update([
                    'status' => $branch->status == 1 ? 0 : 1
                ]);
                Session::flash('message', 'Status update successfully.');
                return redirect()->back();
            } else {
                Session::flash('error', 'Data not found.');
                return redirect()->back();
            }
        } else {
            return redirect('/');
        }
        
    }

    public function edit(Request $request, $id){
        $email = Session::get("emp_email");
        //dd($email);
        if(!empty($email)){
            $decodeId = base64_decode($id);
            $location = Branch_location::where('id',$decodeId)->first();
            if($location){
                return view($this->_routePrefix .'.add-branch',compact('location'));
            } else {
                Session::flash('error', 'Data not found !');
                return redirect('organization/location');
            }
        } else {
            return redirect('/');
        }
    }

    public function locationUpdate(Request $request, $id){
        $email = Session::get("emp_email");
        if(empty($email)){
            return redirect('/');
        }
         $validated = $request->validate([
            'branch_name' => 'required|string|max:255',
            'attendance_process' => 'required|string|max:255',
            'branch_location' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'radius' => 'nullable|numeric|min:0',
        ]);
        //dd($validated);
        $branch = Branch_location::findOrFail($id);
        
        $branch->update([
            'branch_name' => $validated['branch_name'],
            'attendance_process' => $validated['attendance_process'],
            'branch_location' => $validated['branch_location'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'radius' => $validated['radius'],
            'updated_at' => now()
        ]);

        Session::flash('message', 'Branch location updated successfully.');
        return redirect()->route('branch.location');
    }

    public function locationDelete(Request $request, $id){
        $email = Session::get("emp_email");
        if(empty($email)){
            return redirect('/');
        }
        $decodeId = base64_decode($id);
        $location = Branch_location::findOrFail($decodeId);
        if($location){
            $location->delete();
            Session::flash('message', 'Data delete Successfully .');
            return redirect()->route('branch.location');
        }
        Session::flash('error', 'Data not found !');
        return redirect()->route('branch.location');
        
    }


}
