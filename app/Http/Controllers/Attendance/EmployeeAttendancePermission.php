<?php

namespace App\Http\Controllers\Attendance;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\User;
use App\Models\Attendance\AttendancePermission;
use App\Models\Admin\OrgAttendancePermission;
use App\Models\Admin\EmpPunchTypeMaster;
use DB;
use Session;


class EmployeeAttendancePermission extends Controller
{
     public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.attendance-permission';
        $this->_model       = new Employee();
    }

    // public function index(Request $request){
    //     if (!empty(Session::get("emp_email"))) {
    //         $email = Session::get("emp_email");

    //         $organisation = User::where('email',$email)->where('status','active')->first();
    //         $employee = Employee::where('emid',$organisation->employee_id)->get();
    //         //dd($employee);
    //         return view($this->_routePrefix .'.index', compact('employee'));
    //     } else {
    //         return redirect('/');
    //     }
        
    // }

    public function index(Request $request)
    {
        if (!empty(Session::get("emp_email"))) {
            $email = Session::get("emp_email");

            $organisation = User::where('email', $email)->where('status', 'active')->first();
            $emid = $organisation->employee_id;

            // Join employee with permission
            $employee = DB::table('employee as e')
                ->leftJoin('attendance_permission as p', function ($join) use ($emid) {
                    $join->on('e.emp_code', '=', 'p.emp_code')
                        ->where('p.emid', '=', $emid);
                })
                ->where('e.emid', $emid)
                ->where('e.status','active')
                ->select('e.*', 'p.punch_type','p.default_punch_type')
                ->get();

                $punch_type = DB::table('org_attendance_permissions AS oap')
                    ->join('emp_punch_type_masters AS ptm', 'ptm.id', '=', 'oap.punch_type_id')
                    ->where('oap.emid', $emid)
                    ->select('ptm.id', 'ptm.punch_type_name')
                    ->get();
                //dd($employee);
            return view($this->_routePrefix . '.index', compact('employee','punch_type'));
        } else {
            return redirect('/');
        }
    }


    // public function save(Request $request)
    // {
    //     // Check for valid session email
    //     if (!Session::has("emp_email")) {
    //         return redirect('/');
    //     }

    //     $email = Session::get("emp_email");

    //     // Get active organisation/user
    //     $organisation = User::where('email', $email)
    //                         ->where('status', 'active')
    //                         ->first();

    //     if (!$organisation) {
    //         return redirect()->back()->with('error', 'Invalid organization.');
    //     }

    //     $emid = $organisation->employee_id;

    //     // Validate request
    //     $validated = $request->validate([
    //         'punch_type' => 'required|string|in:GPS,QR,FaceID,Manual',
    //         'emp_code'   => 'required|array|min:1',
    //     ]);
    //     $allEmployee = Employee::where('emid',$emid)->where('status','active')->select('emid','emp_code')->get();
    //     foreach($allEmployee as $employee){
    //         AttendancePermission::updateOrCreate(
    //             ['emp_code' => $allEmployee->empCode, 'emid' => $allEmployee->emid],
    //             ['default_punch_type' => "Manual"]
    //         );  
    //     }
    //     //dd($allEmployee);

    //     $punchType = $validated['punch_type'];
    //     $employeeCodes = $validated['emp_code'];

    //     // Loop and save each permission
    //     foreach ($employeeCodes as $empCode) {
    //         AttendancePermission::updateOrCreate(
    //             ['emp_code' => $empCode, 'emid' => $emid],
    //             ['punch_type' => $punchType, 'emid' => $emid]
    //         );
    //     }
        
    //     return redirect()->back()->with('success', 'Permissions saved successfully.');
    // }

    public function save(Request $request)
    {
        if (!Session::has("emp_email")) {
            return redirect('/');
        }

        $email = Session::get("emp_email");

        $organisation = User::where('email', $email)
                            ->where('status', 'active')
                            ->first();

        if (!$organisation) {
            return redirect()->back()->with('error', 'Invalid organization.');
        }

        $emid = $organisation->employee_id;

        $validated = $request->validate([
        'punch_type' => 'required|string|in:GPS,QR,FaceID,Manual',
        'emp_code'   => 'required|array|min:1',
        ]);
        //dd($validated);
        $selectedEmpCodes = $validated['emp_code'];
        $punchType = $validated['punch_type'];

        // defult punch type data
        $punch_type = DB::table('org_attendance_permissions AS oap')
            ->join('emp_punch_type_masters AS ptm', 'ptm.id', '=', 'oap.default_punch_type_id')
            ->where('oap.emid', $emid)
            ->select('ptm.id', 'ptm.punch_type_name')
            ->first(); 
        $defult_punch_type = $punch_type->punch_type_name;    

        // STEP 1: Set default 'Manual' punch_type for all active employees under this organisation
        $allEmployees = Employee::where('emid', $emid)
                                ->where('status', 'active')
                                ->get();
        
        foreach ($allEmployees as $emp) {
            AttendancePermission::updateOrCreate(
                [
                    'emp_code' => $emp->emp_code,
                    'emid' => $emid
                ],
                [
                    'default_punch_type' => $defult_punch_type
                ]
            );
        }
        //dd($punchType);
        // STEP 2: Update selected employees with their selected punch_type
        foreach ($selectedEmpCodes as $empCode) {
            AttendancePermission::updateOrCreate(
                [
                    'emp_code' => $empCode,
                    'emid' => $emid
                ],
                [
                    'punch_type' => $punchType
                ]
            );
        }

        return redirect()->back()
            ->with('success', 'All active employees set to Manual by default. Selected employees updated with chosen punch type.');
    }




}
