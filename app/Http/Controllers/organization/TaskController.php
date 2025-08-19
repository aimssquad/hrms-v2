<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskManagement\Project;
use App\Models\TaskManagement\ProjectMembers;
use App\Models\TaskManagement\MasterLabels;
use App\Models\TaskManagement\Task;
use App\Models\User;
use App\Models\Employee;
use DB;
use Session;

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
            //return View('taskmanagement/tasks/tasks', $data);
            return view('employeer/task-management/project-management/dashboard', $data);
        } else {
            return redirect("/");
        }
    }


    // public function employeeTask(Request $request) {
    //     $email = Session::get("emp_email");
    //     if (empty($email)) {
    //         return redirect("/");
    //     }

    //     $currentUser = User::where('email', $email)->first();
        
    //     if (!$currentUser) {
    //         return redirect("/")->with('error', 'User not found');
    //     }

    //     $employee = Employee::where('emp_code', $currentUser->employee_id)->where('emid', $currentUser->emid)->first();

    //     //dd($employee->id);
    //     $projects['projects'] = DB::table('project_members as pm')
    //         ->join('projects as p', 'pm.project_id', '=', 'p.id')
    //         ->where('pm.user_id', $employee->id)
    //         ->select([
    //             'p.title',
    //             'p.description',
    //             'p.status',
    //             'p.emid as project_code', // Added project code if needed
    //             'pm.role'
    //         ])
    //         ->orderBy('p.title') // Optional: sort by project name
    //         ->get();
            
    //     //dd($projects);        
    //     return view('employeer/employee-corner/task/task',$projects);
    // }

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

    public function members(Request $request, $id){
        return view('employeer/employee-corner/task/tt');
    }

    




}
