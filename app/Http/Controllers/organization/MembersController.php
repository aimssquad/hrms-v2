<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
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
        //dd('ok');
        $project_id = $request->id;
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');
            $validatedData = $request->validate([
                'user_id' => 'required',
                'role' => 'required',

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
    
    
    //-------------------------Task control code start -------------------------

    public function getProjectMembers(Request $request)
    {   
        $project_id = decrypt($request->id);
        $emid = Session::get("emid");
     
        $members = ProjectMembers::where('project_id', $project_id)
            ->join('users', 'users.employee_id', '=', 'project_members.user_id')
            ->join('project_roles', 'project_roles.id', '=', 'project_members.role')
            ->select('project_members.*', 'users.name as name','users.user_type as user_type', 'project_roles.name as role_name')
            ->get();

        //$users = UserModel::where('emid',$emid)->where('user_type','employee')->where('status', 'active')->get();    
        //dd($members); 
        $roles = DB::table('project_roles')->where('emid', $emid)->get();   
        return view('employeer.task-management.project-controll.project-member-list', compact('members','project_id', 'roles'));    
        
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
        return response()->json([
            'status' => true,
            'type' => $type, // 👈 important
            'data' => $users,
        ]);
    }

    public function saveMember(Request $request)
    {
        $email = Session::get("emp_email");
        $assignedBy = DB::table('users')->where('email', $email)->where('status', 'active')->select('employee_id')->first();
        $assignedById = $assignedBy ? $assignedBy->employee_id : null;

        // dd($assignedById);
         //dd($request->all());
        $project_id = decrypt($request->id);
        $user_id = $request->user_id;
        $role_id = $request->role;
        $user_type = $request->member_type; 

        // Check already exists
        $isExist = ProjectMembers::where('project_id', $project_id)
            ->where('user_id', $user_id)
            ->first();

        if ($isExist) {
            return response()->json([
                'status' => false,
                'message' => 'Member already exists in this project'
            ]);
        }

        // Save only role_id (NOT permission)
        ProjectMembers::create([
            'project_id' => $project_id,
            'user_id' => $user_id,
            'role' => $role_id, 
            'user_type' => $user_type, 
            'createdBy' => $assignedById
        ]);
        return redirect('/org-project-control/' . encrypt($project_id) . '/project-members'); // new route 
        // return redirect('/org-task-management/' . encrypt($project_id) . '/project-members');//old route
    }



    public function getProjectModules(Request $request)
    {
        //dd('okk');
        $email = Session::get('emp_email');
        $emid = Session::get("emid");
        //dd($email, $emid);
        $project_id = decrypt($request->id);
        // Fetch modules related to the project
        $modules = DB::table('project_module')
            ->where('project_id', $project_id)
            ->get();


        return view('employeer.task-management.project-controll.project-module-list', compact('modules', 'project_id'));
    }

    public function storeProjectModule(Request $request)
    {
        $email = Session::get('emp_email');

        if(empty($email)){
            Session::flash('error','Unauthorized access');
            return redirect('/');
        }

        $request->validate([
            'module_name' => 'required|string|max:255',
            'description' => 'required|string|min:10|max:5000',
            'order_by' => 'required|integer|min:1'
        ],[
            'module_name.required' => 'Module name is required.',
            'module_name.max' => 'Module name cannot exceed 255 characters.',

            'description.required' => 'Module description is required.',
            'description.min' => 'Description must be at least 10 characters.',
            
            'order_by.required' => 'Module order is required.',
            'order_by.integer' => 'Module order must be a number.',
            'order_by.min' => 'Order must start from 1.'
        ]);

        $project_id = decrypt($request->id);
        $emid = Session::get("emid");
       // dd($emid);
        DB::table('project_module')->insert([
            'project_id'   => $project_id,
            'module_name'  => $request->module_name,
            'description'  => $request->description,
            'order_by'     => $request->order_by,
            'created_by'   => $emid,
            'emid'         => $emid,
            'created_at'   => now()
        ]);

        Session::flash('message','Project module has been added successfully');

        return redirect('/org-project-control/' . encrypt($project_id) . '/project-modules');
    }


    // public function editProjectModule($id, $module_id)
    // {
    //     $email = Session::get('emp_email');

    //     if(empty($email)){
    //         Session::flash('error','Unauthorized access');
    //         return redirect('/');
    //     }

    //     $project_id = decrypt($id);
    //     $module_id  = decrypt($module_id);
    //     dd($project_id, $module_id);
    //     $module = DB::table('project_module')
    //                 ->where('project_id',$project_id)
    //                 ->where('id',$module_id)
    //                 ->first();

    //     if(!$module){
    //         Session::flash('error','Module not found');
    //         return redirect('/org-project-control/'.$id.'/project-modules');
    //     }

    //     return view(
    //         'employeer.task-management.project-controll.edit-project-module',
    //         compact('module','project_id')
    //     );
    // }

    public function updateProjectModule(Request $request,$id,$module_id)
    {
        $email = Session::get('emp_email');

        if(empty($email)){
            Session::flash('error','Unauthorized access');
            return redirect('/');
        }
        //dd($request->all(), $id, $module_id);
        $request->validate([
            'module_name'=>'required|max:255',
            'description'=>'required',
            'order_by'=>'required|integer|min:1'
        ]);

        DB::table('project_module')
        ->where('id',decrypt($module_id))
        ->update([
            'module_name'=>$request->module_name,
            'description'=>$request->description,
            'order_by'=>$request->order_by,
            'updated_at'=>now()
        ]);

        Session::flash('message','Module updated successfully');

        return back();
    }

    public function deleteProjectModule($id, $module_id)
    {
        $email = Session::get('emp_email');
       
        if(empty($email)){
            Session::flash('error','Unauthorized access');
            return redirect('/');
        }

        DB::table('project_module')
        ->where('id',decrypt($module_id))
        ->delete();

        Session::flash('message','Project module deleted successfully');

        return back();
    }

    //comment 
    public function getModuleComments($module_id)
    {
        $comments=DB::table('comments')
        ->leftJoin(
        'users',
        'users.employee_id',
        '=',
        'comments.user_id'
        )
        ->where('commentable_type','module')
        ->where('commentable_id',$module_id)
        ->where('is_deleted',0)
        ->select(
        'comments.*',
        'users.name'
        )
        ->orderBy('comments.id')
        ->get();

        return response()->json($comments);
    }

    public function storeCommentAjax(Request $request)
    {
        $request->validate([
        'project_id'=>'required',
        'commentable_id'=>'required',
        'message'=>'required'
        ]);

        DB::table('comments')->insert([
        'project_id'=>$request->project_id,
        'user_id'=>Session::get('emid'),
        'commentable_type'=>'module',
        'commentable_id'=>$request->commentable_id,
        'message'=>$request->message,
        'created_at'=>now()
        ]);

        return response()->json([
        'success'=>true
        ]);
    }

    public function updateCommentAjax(
        Request $request,
        $id
        ){

        DB::table('comments')
        ->where('id',$id)
        ->update([
        'message'=>$request->message,
        'edited_at'=>now()
        ]);

        return response()->json([
        'success'=>true
        ]);
    }

    public function deleteCommentAjax($id)
        {
        DB::table('comments')
        ->where('id',$id)
        ->update([
        'is_deleted'=>1
        ]);

        return response()->json([
        'success'=>true
        ]);
    }




}
