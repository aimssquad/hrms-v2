<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Guest;
//use App\Models\Role\Employee;
use App\Models\TaskManagement\MasterRoles;
use App\Models\TaskManagement\Project;
use App\Models\TaskManagement\ProjectMembers;
use Session;
use DB;

class MembersController extends Controller
{
    //
    public function __construct()
    {
        $this->ProjectMemberModel = new ProjectMembers();
    }

    public function index(Request $request)
    {
        //dd('okk');
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');

            $project_id = decrypt($request->id);

            $project  = Project::where('id', $project_id)->first();
            if (empty($project)) {
            } else {
                $projectMembers = ProjectMembers::where('project_id', $project_id)
                    ->join('employee', 'employee.id', '=', 'project_members.user_id')
                    ->select('project_members.*', 'employee.emp_fname as fname', 'employee.emp_mname as mname', 'employee.emp_lname as lname')
                    ->get();
                //dd($projectMembers);
                $email = Session::get('emp_email');
                $Roledata = DB::table('registration')->where('status', '=', 'active')

                    ->where('email', '=', $email)
                    ->first();
                $departments = DB::table('department')->where('emid', '=', $Roledata->reg)->get();
                // print_r($Roledata);
                $data['departments'] = $departments;

                $employees = DB::table('employee')->where('emid', '=', $Roledata->reg)->where(function ($query) {

                    $query->whereNull('employee.emp_status')
                        ->orWhere('employee.emp_status', '!=', 'LEFT');
                })->get();
                $roles = MasterRoles::where('project_id', $project_id)->get();
                // $roles = ['manager' => 'Manager', 'developer' => 'Developer', 'viewer' => 'Viewer'];
                $data = ['members' => $projectMembers, 'emplyees' => $employees, 'roles' => $roles, "project" => $project, 'departments' => $departments];
                // echo "<pre>";
                // print_r($data['members']);
                // echo "</pre>";
                // die;
                return View('employeer/task-management/project-management/project-members', $data);
            }
        } else {
            redirect("/");
        }
    }

    public function addMember()
    {
        return View('taskmanagement/members/project-member-add-form');
    }
    public function submitMember(Request $request)
    {
        //dd($request->all());
        $project_id = $request->id;
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');
            $validatedData = $request->validate([
                'user_id' => 'required',
                'role' => 'required',
                'permission' => 'nullable|in:view,both'
            ]);
            $isExit = ProjectMembers::where(['user_id' => $validatedData['user_id'], 'project_id' => decrypt($project_id)])->first();

            // die;
            if (empty($isExit)) {
                $validatedData['created_at'] = date('Y-m-d h:i:s');
                $validatedData['createdBy'] = $currentUser;
                $validatedData['project_id'] = decrypt($project_id);
                $project = ProjectMembers::create($validatedData);
                // return response()->json($project, 201);
                // print_r($project);
                // die;
                Session::flash('message', 'Project member has been added successfully');
            } else {
                $updatedData['createdBy'] = $currentUser;
                $updatedData['role'] = $validatedData['role'];
                $updatedData['permission'] = $validatedData['permission'];
                $updatedData['created_at'] = date('Y-m-d h:i:s');
                ProjectMembers::where('id', $isExit->id)->update($updatedData);
                Session::flash('message', 'Project member has been updated successfully');
            }
            return redirect('/org-task-management/' . $project_id . '/project-members');
        } else {
            Session::flash('error', 'Unauthorized access');
            return redirect('/org-task-management/' . $project_id . '/project-members');
            // return response()->json(['message' => 'Unauthorized access'], 401);
        }
    }
    public function removeMember(Request $request)
    {
        $members_id = $request->member_id;
        $project_id = $request->id;

        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');

            $members = ProjectMembers::where('id', decrypt($members_id))->delete();
            Session::flash('message', 'Project member has been deleted successfully');
            return redirect('/org-task-management/' . $project_id . '/project-members');
            // return response()->json(['status' => true, 'message' => 'Members has been deleted successfully']);
        } else {
            Session::flash('error', 'Unauthorized access');
            return redirect('/org-task-management/' . $project_id . '/project-members');
            // return response()->json(['status' => false, 'message' => 'Unathorized access']);
        }
        // return View('taskmanagement/members');
    }
    public function getMemberById(Request $request)
    {
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');
            $members_id = $request->input->member_id;

            $member = ProjectMembers::where('id', $members_id)->first();
            return response()->json(['status' => true, 'message' => 'Members has been fetched successfully', 'data' => $member]);
        } else {
            return response()->json(['status' => false, 'message' => 'Unathorized access']);
        }
    }
    public function getEmplyee(Request $request)
    {
        // $q = $request->input->q;

        $email = Session::get('emp_email');
        $Roledata = DB::table('registration')->where('status', '=', 'active')

            ->where('email', '=', $email)
            ->first();

        $emplyees = DB::table('employee')->where('emid', '=', $Roledata->reg)->where(function ($query) {

            $query->whereNull('employee.emp_status')
                ->orWhere('employee.emp_status', '!=', 'LEFT');
        })->get();
        // $employees = DB::table('employee')
        //     ->where('status', '=', 'active')

        //     ->get();
        return response()->json(['status' => true, 'data' => $emplyees]);
    }

    // public function editMember(Request $request, $project_id, $id)
    // {
    //     if (!empty(Session::get('user_type'))) {

    //         $currentUser = Session::get('users_id');

    //         $projectId = decrypt($project_id);
    //         $memberId  = decrypt($id);

    //         $project  = Project::where('id', $projectId)->first();

    //         // 🔥 same as index
    //         $projectMembers = ProjectMembers::where('project_id', $projectId)
    //             ->join('employee', 'employee.id', '=', 'project_members.user_id')
    //             ->select(
    //                 'project_members.*',
    //                 'employee.emp_fname as fname',
    //                 'employee.emp_mname as mname',
    //                 'employee.emp_lname as lname'
    //             )
    //             ->get();

    //         // 🔥 get selected member (IMPORTANT)
    //         $member = ProjectMembers::where('id', $memberId)->first();

    //         $email = Session::get('emp_email');

    //         $Roledata = DB::table('registration')
    //             ->where('status', 'active')
    //             ->where('email', $email)
    //             ->first();

    //         $departments = DB::table('department')
    //             ->where('emid', $Roledata->reg)
    //             ->get();

    //         $employees = DB::table('employee')
    //             ->where('emid', $Roledata->reg)
    //             ->where(function ($query) {
    //                 $query->whereNull('employee.emp_status')
    //                     ->orWhere('employee.emp_status', '!=', 'LEFT');
    //             })
    //             ->get();

    //         $roles = MasterRoles::where('project_id', $projectId)->get();

    //         return view('employeer/task-management/project-management/edit-project-member', [
    //             'members' => $projectMembers,
    //             'emplyees' => $employees,
    //             'roles' => $roles,
    //             'project' => $project,
    //             'departments' => $departments,
    //             'member' => $member // 🔥 VERY IMPORTANT
    //         ]);

    //     } else {
    //         return redirect('/');
    //     }
    // }

    //-------------------------Task control code start -------------------------

    public function getProjectMembers(Request $request)
    {   
        $project_id = decrypt($request->id);
        $members = ProjectMembers::where('project_id', $project_id)
            ->join('users', 'users.employee_id', '=', 'project_members.user_id')
            ->select('project_members.*', 'users.name as name')
            ->get();
        //$users = UserModel::where('emid',$emid)->where('user_type','employee')->where('status', 'active')->get();    
        //dd($members);    
        return view('employeer.task-management.project-controll.project-member-list', compact('members','project_id'));    
        
    }    

    public function getMembers(Request $request)
    {   
        
        $emid = Session::get('emid');
        // dd($emid);
        $type = $request->type;
        if($type == 'employee'){
            $users = Employee::where('emid',$emid)->where('status', 'active')->get();    
        }else{
            $users = Guest::where('emid',$emid)->where('status', 1)->get();    
        }   
        if($users->isEmpty()) {
            return response()->json(['status' => false, 'message' => 'No members found']);
        }  
        //dd($users); 
        return response()->json([
            'status' => true,
            'type' => $type, // 👈 important
            'data' => $users
        ]);
    }

    public function saveMember(Request $request)
    {   
        //dd($request->all());
        $email = Session::get("emp_email");
        dd($email);
        $project_id = decrypt($request->id);
        $user_id = $request->user_id;
        $role = $request->role;
        $permission = $request->member_type;

        $isExist = ProjectMembers::where('project_id', $project_id)->where('user_id', $user_id)->first();
        if($isExist){
            return response()->json(['status' => false, 'message' => 'Member already exists in this project']);
        }

        $data = [
            'project_id' => $project_id,
            'user_id' => $user_id,
            'role' => $role,
            'member_type' => $permission
        ];
        dd($data);
        ProjectMembers::create([
            'project_id' => $project_id,
            'user_id' => $user_id,
            'role' => $role,
            'permission' => $permission
        ]);
        return response()->json(['status' => true, 'message' => 'Member added to project successfully']);
    }


    //--------------------------Task control code end -------------------------



}
