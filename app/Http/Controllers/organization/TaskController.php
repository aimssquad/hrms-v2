<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TaskManagement\Project;
use App\Models\TaskManagement\ProjectMembers;
use App\Models\TaskManagement\MasterLabels;
use App\Models\TaskManagement\Task;
use App\Models\User;
use App\Models\Employee;
use App\Models\ProjectPost;
use App\Models\ProjectPostReply;
use DB;
use Session;
use Storage;

class TaskController extends Controller
{
    public function dashboard(Request $request)
    {
        $project_id = decrypt($request->id);
        //dd($project_id);
        // dd(Session::all());
        if (!empty(Session::get('user_type'))) {
            $currentUser = Session::get('users_id');
            $currentUserType = Session::get('user_type');
            $project = Project::where('id', $project_id)->first();
            $data = [];
            $projectMembers = ProjectMembers::where('project_id', $project_id)
                ->leftJoin('employee', 'employee.id', '=', 'project_members.user_id')
                ->select('project_members.*', 'employee.emp_fname as fname', 'employee.emp_mname as mname', 'employee.emp_lname as lname')
                ->get();
            // print_r($projectMembers);
            // die;
            $data['members'] = $projectMembers;

            $labels = MasterLabels::where('project_id', $project_id)->get();
            $data['labels'] = $labels;
            if ($currentUser === $project->createdBy || $currentUserType === 'employer') {
                $tasks = Task::select('tasks.*', 'e.emp_fname as fname', 'e.emp_mname as mname', 'e.emp_lname as lname')
                    ->where('project_id', $project_id)
                    ->leftJoin('employee as e', 'e.id', '=', 'tasks.assignedTo')
                    ->get();
                $data['tasks'] = $tasks;
            } else {
                $currentUserEmpDetails = User::select('users.*', 'e.id as emp_id')
                    ->leftJoin('employee as e', 'e.emp_code', '=', 'users.employee_id')
                    ->where('users.id', $currentUser)
                    ->first();
                $projectMember = ProjectMembers::where(['project_id' => $project_id, 'user_id' => $currentUserEmpDetails->emp_id])->first();
                if ($projectMember->role === 'manager') {
                    $tasks = Task::select('tasks.*', 'e.emp_fname as fname', 'e.emp_mname as mname', 'e.emp_lname as lname')
                        ->where('project_id', $project_id)
                        ->leftJoin('employee as e', 'e.id', '=', 'tasks.assignedTo')

                        ->get();
                    $data['tasks'] = $tasks;
                    
                } else {

                    $tasks = Task::select('tasks.*', 'e.emp_fname as fname', 'e.emp_mname as mname', 'e.emp_lname as lname')
                        ->where(['project_id' => $project_id, 'assignedTo' => $currentUserEmpDetails->emp_id])
                        ->leftJoin('employee as e', 'e.id', '=', 'tasks.assignedTo')
                        ->get();
                    $data['tasks'] = $tasks;
                }
            }
            $data['project_id'] = $project_id;
            //return View('taskmanagement/tasks/tasks', $data);
            return view('employeer/task-management/project-management/dashboard', $data);
        } else {
            return redirect("/");
        }
    }



    public function employeeTask(Request $request) {
        $email = Session::get("emp_email");
        if (empty($email)) {
            return redirect("/");
        }

        $currentUser = User::where('email', $email)->first();
        
        if (!$currentUser) {
            return redirect("/")->with('error', 'User not found');
        }

        $employee = Employee::where('emp_code', $currentUser->employee_id)
                        ->where('emid', $currentUser->emid)
                        ->first();

        if (!$employee) {
            return redirect("/")->with('error', 'Employee record not found');
        }

        $projects = DB::table('project_members as pm')
            ->join('projects as p', 'pm.project_id', '=', 'p.id')
            ->leftJoin('tasks as t', function($join) use ($employee) {
                $join->on('t.project_id', '=', 'p.id')
                    ->where('t.assignedTo', $employee->id);
            })
            ->where('pm.user_id', $employee->id)
            ->select([
                'p.id as project_id',
                'p.title as project_title',
                'p.description as project_description',
                'p.status as project_status',
                'p.emid as project_code',
                'pm.role as project_role',
                't.id as task_id',
                't.task_name',
                't.task_desc',
                't.start_date',
                't.expected_end_date',
                't.status as task_status'
            ])
            ->orderBy('p.title')
            ->orderBy('t.start_date')
            ->get();

        // Group projects with their tasks
        $groupedProjects = [];
        foreach ($projects as $project) {
            $projectId = $project->project_id;
            
            if (!isset($groupedProjects[$projectId])) {
                $groupedProjects[$projectId] = [
                    'project_id' => $project->project_id,
                    'project_title' => $project->project_title,
                    'project_description' => $project->project_description,
                    'project_status' => $project->project_status,
                    'project_code' => $project->project_code,
                    'project_role' => $project->project_role,
                    'tasks' => []
                ];
            }
            
            if ($project->task_id) {
                $groupedProjects[$projectId]['tasks'][] = [
                    'task_id' => $project->task_id,
                    'task_name' => $project->task_name,
                    'task_desc' => $project->task_desc,
                    'start_date' => $project->start_date,
                    'expected_end_date' => $project->expected_end_date,
                    'task_status' => $project->task_status
                ];
            }
        }
        //dd($groupedProjects);
        return view('employeer/employee-corner/task/task', [
            'projects' => array_values($groupedProjects)
        ]);
    }


    // public function members(Request $request, $id)
    // {
    //     $email = Session::get("emp_email");
    //     if (empty($email)) {
    //         return redirect("/");
    //     }
        
    //     $empData = User::where('email', $email)->first();
    //     $emid = $empData->emid;
    //     $employee_code = $empData->employee_id;

    //     $projectData = DB::table('projects as p')
    //         ->leftJoin('project_members as pm', 'p.id', '=', 'pm.project_id')
    //         ->leftJoin('tasks as t', 'p.id', '=', 't.project_id')
    //         ->leftJoin('employee as e', 'pm.user_id', '=', 'e.id')
    //         ->where('p.id', $id)
    //         ->select([
    //             'p.id as project_id',
    //             'p.title as project_title',
    //             'p.description as project_description',
    //             'p.status as project_status',
    //             'pm.role as member_role',
    //             't.task_name',
    //             't.task_desc',
    //             't.start_date',
    //             't.expected_end_date',
    //             DB::raw("CONCAT(e.emp_fname, ' ', COALESCE(e.emp_mname, ''), ' ', e.emp_lname) as employee_name"),
    //             'e.emp_code as employee_code'
    //         ])
    //         ->orderBy('employee_name')
    //         ->orderBy('t.start_date')
    //         ->get();
    //     //dd($projectData);        
    //     // Group the data by project
    //     $groupedData = [
    //         'project' => null,
    //         'members' => [],
    //         'tasks' => []
    //     ];

    //     foreach ($projectData as $item) {
    //         // Set project info (only once)
    //         if (!$groupedData['project']) {
    //             $groupedData['project'] = [
    //                 'id' => $item->project_id,
    //                 'title' => $item->project_title,
    //                 'description' => $item->project_description,
    //                 'status' => $item->project_status
    //             ];
    //         }

    //         // Add unique members
    //         if ($item->employee_name && !isset($groupedData['members'][$item->employee_code])) {
    //             $groupedData['members'][$item->employee_code] = [
    //                 'name' => $item->employee_name,
    //                 'employee_code' => $item->employee_code,
    //                 'role' => $item->member_role
    //             ];
    //         }

    //         // Add unique tasks
    //         if ($item->task_name && !isset($groupedData['tasks'][$item->task_name])) {
    //             $groupedData['tasks'][$item->task_name] = [
    //                 'task_name' => $item->task_name,
    //                 'task_desc' => $item->task_desc,
    //                 'start_date' => $item->start_date,
    //                 'expected_end_date' => $item->expected_end_date
    //             ];
    //         }
    //     }

    //     // Convert to simple arrays
    //     $groupedData['members'] = array_values($groupedData['members']);
    //     $groupedData['tasks'] = array_values($groupedData['tasks']);
    //     //dd($groupedData);
    //     $data['id'] = $id;
    //     $data['post_data'] = ProjectPost::with('user') // Add relationship if you have one
    //         ->where('project_id', $id)
    //         ->orderBy('created_at', 'asc')
    //         ->get(); 
    //     dd($data['post_data']);
    //     // Pass employee_code to the view to identify "my" messages
    //     return view('employeer/employee-corner/task/tt', compact('data', 'employee_code','groupedData'));
    // }

    




    public function empProjectPost(Request $request)
    {
        $email = Session::get("emp_email");
        if (empty($email)) {
            return redirect("/");
        }
        //dd($request->all());
        $empData = User::where('email', $email)->first();
        $emid = $empData->emid;
        $employee_code = $empData->employee_id;

        $validate_data = Validator::make($request->all(), [
            'project_id' => 'required|integer',
            'parent_id' => 'nullable|integer',
            'file' => 'nullable|file|mimes:pdf,png,jpg,jpeg,xls,xlsx|max:2048',
            'title' => 'required|string|max:1000'
        ]);
       
        if ($validate_data->fails()) {
            //dd($validate_data->errors()->all()); 
            return redirect()->back()
                ->withErrors($validate_data)
                ->withInput();
        }
  
        $filePath = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            // Store file in storage/app/public/project_files directory
            $filePath = $file->storeAs('project_files', $fileName, 'public');
        }

        $data = [
            'project_id' => $request->project_id,
            'parent_id' => $request->parent_id,
            'title' => $request->title,
            'file' => $filePath,
            'emid' => $emid,
            'employee_code' => $employee_code,
            'created_at' => now(),
            'updated_at' => now()
        ];
        //dd($data);
        ProjectPost::create($data);

        // Redirect with success message
        return redirect()->back()->with('success', 'Project post created successfully!');
    }

    // Add these methods to your controller

    public function edit($id)
    {
        //dd($id);
        $email = Session::get("emp_email");
        if (empty($email)) {
            return redirect("/");
        }
        //dd($request->all());
        $empData = User::where('email', $email)->first();
        $emid = $empData->emid;
        $employee_code = $empData->employee_id;

        $post = ProjectPost::where('id', $id)
                    ->where('employee_code', $employee_code)
                    ->firstOrFail();
        //dd($post);            
        return response()->json([
            'success' => true,
            'post' => $post
        ]);
    }

    public function update(Request $request, $id)
    {
        $email = Session::get("emp_email");
        if (empty($email)) {
            return redirect("/");
        }
        $empData = User::where('email', $email)->first();
        $emid = $empData->emid;
        $employee_code = $empData->employee_id;

        $post = ProjectPost::where('id', $id)
                    ->where('employee_code', $employee_code)
                    ->firstOrFail();
                    
        $validate_data = Validator::make($request->all(), [
            'title' => 'required|string|max:1000',
            'file' => 'nullable|file|mimes:pdf,png,jpg,jpeg,xls,xlsx|max:2048',
        ]);
    
        if ($validate_data->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validate_data->errors()->first()
            ]);
        }

        $data = [
            'title' => $request->title,
            'updated_at' => now()
        ];

        if ($request->hasFile('file')) {
            // Delete old file if exists
            if ($post->file) {
                Storage::disk('public')->delete($post->file);
            }
            
            $file = $request->file('file');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('project_files', $fileName, 'public');
            $data['file'] = $filePath;
        }

        $post->update($data);

        return response()->json([
            'success' => true,
            'message' => 'Post updated successfully'
        ]);
    }

    public function destroy(Request $request, $id)
    {
        $email = Session::get("emp_email");
        //dd($email);
        if (empty($email)) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $empData = User::where('email', $email)->first();
        $employee_code = $empData->employee_id;
        //dd($id, $employee_code);
        $post = ProjectPost::where('id', $id)
                    ->where('employee_code', $employee_code)
                    ->firstOrFail();
        //dd($post);            
        // Delete associated file if exists
        if ($post->file) {
            Storage::disk('public')->delete($post->file);
        }
        
        $post->delete();

        return response()->json([
            'success' => true,
            'message' => 'Post deleted successfully'
        ]);
    }


    public function members(Request $request, $id)
    {
        $email = Session::get("emp_email");
        if (empty($email)) {
            return redirect("/");
        }
        
        $empData = User::where('email', $email)->first();
        $emid = $empData->emid;
        $employee_code = $empData->employee_id;

        // Fetch project details with members and tasks
        $projectData = DB::table('projects as p')
            ->leftJoin('project_members as pm', 'p.id', '=', 'pm.project_id')
            ->leftJoin('tasks as t', 'p.id', '=', 't.project_id')
            ->leftJoin('employee as e', 'pm.user_id', '=', 'e.id')
            ->where('p.id', $id)
            ->select([
                'p.id as project_id',
                'p.title as project_title',
                'p.description as project_description',
                'p.status as project_status',
                'pm.role as member_role',
                't.task_name',
                't.task_desc',
                't.start_date',
                't.expected_end_date',
                DB::raw("CONCAT(e.emp_fname, ' ', COALESCE(e.emp_mname, ''), ' ', e.emp_lname) as employee_name"),
                'e.emp_code as employee_code'
            ])
            ->orderBy('employee_name')
            ->orderBy('t.start_date')
            ->get();

        // Group the data by project
        $groupedData = [
            'project' => null,
            'members' => [],
            'tasks' => []
        ];

        foreach ($projectData as $item) {
            // Project info
            if (!$groupedData['project']) {
                $groupedData['project'] = [
                    'id' => $item->project_id,
                    'title' => $item->project_title,
                    'description' => $item->project_description,
                    'status' => $item->project_status
                ];
            }

            // Unique members
            if ($item->employee_name && !isset($groupedData['members'][$item->employee_code])) {
                $groupedData['members'][$item->employee_code] = [
                    'name' => $item->employee_name,
                    'employee_code' => $item->employee_code,
                    'role' => $item->member_role
                ];
            }

            // Unique tasks
            if ($item->task_name && !isset($groupedData['tasks'][$item->task_name])) {
                $groupedData['tasks'][$item->task_name] = [
                    'task_name' => $item->task_name,
                    'task_desc' => $item->task_desc,
                    'start_date' => $item->start_date,
                    'expected_end_date' => $item->expected_end_date
                ];
            }
        }

        $groupedData['members'] = array_values($groupedData['members']);
        $groupedData['tasks'] = array_values($groupedData['tasks']);

        // Load posts with replies
        $data['id'] = $id;
        // $data['post_data'] = ProjectPost::with(['user', 'replies.user']) // eager load replies + reply user
        //     ->where('project_id', $id)
        //     ->where('emid',$emid)
        //     ->orderBy('created_at', 'asc')
        //     ->get();


        $data['post_data'] = DB::table('project_post as p')
            ->leftJoin('users as u', function($join) {
                $join->on('u.employee_id', '=', 'p.employee_code')
                    ->where(function($q) {
                        $q->on('u.emid', '=', 'p.emid')
                        ->orWhereNull('p.emid'); // allow null org
                    });
            })
            ->leftJoin('project_post_reply as r', 'r.post_id', '=', 'p.id')
            ->leftJoin('users as ru', function($join) {
                $join->on('ru.employee_id', '=', 'r.employee_code')
                    ->where(function($q) {
                        $q->on('ru.emid', '=', 'r.emid')
                        ->orWhereNull('r.emid'); // allow null org on replies too
                    });
            })
            ->where('p.project_id', $id)
            ->where(function($q) use ($emid) {
                $q->where('p.emid', $emid)
                ->orWhereNull('p.emid');
            })
            ->orderBy('p.created_at', 'asc')
            ->select([
                'p.*',
                'u.name as post_user_name',
                'r.id as reply_id',
                'r.reply_text',
                'r.created_at as reply_created_at',
                'ru.name as reply_user_name'
            ])
            ->get();


            
        dd($data['post_data']);
        return view('employeer/employee-corner/task/tt', compact('data', 'employee_code', 'groupedData'));
    }

    public function store(Request $request)
    {
        $email = Session::get("emp_email");
        if (empty($email)) {
            return redirect("/");
        }
        
        $empData = User::where('email', $email)->first();
        //dd($empData);
        $emid = $empData->emid;
        $employee_code = $empData->employee_id;
        
        $request->validate([
            'project_id' => 'required',
            'post_id' => 'required|exists:project_post,id',
            'reply_text' => 'required|string',
        ]);

        ProjectPostReply::create([
            'emid' => $emid,
            'project_id' => $request->project_id,
            'post_id' => $request->post_id,
            'employee_code' => $employee_code,
            'reply_text' => $request->reply_text,
        ]);

        return back()->with('success', 'Reply added successfully.');
    }



    




}
