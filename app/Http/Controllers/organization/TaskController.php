<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskManagement\Project;
use App\Models\TaskManagement\ProjectMembers;
use App\Models\TaskManagement\MasterLabels;
use App\Models\TaskManagement\Task;
use App\Models\User;
use DB;
use Session;

class TaskController extends Controller
{
    public function dashboard(Request $request)
    {
        $project_id = decrypt($request->id);

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
}
