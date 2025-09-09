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
use DB;
use Session;
use Storage;

class ChatController extends Controller
{
    // public function chat(Request $request){
    //     $email = Session::get("emp_email");
    //     if (empty($email)) {
    //         return redirect("/");
    //     }
    //     $id = decrypt($request->id);
    //     //dd($project_id);
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
        
    //     // Pass employee_code to the view to identify "my" messages
    //     //C:\Users\Home\Desktop\new-hrms\hrms-v2\resources\views\employeer\task-management\project-management\project-chat.blade.php
    //     return view('employeer/task-management/project-management/project-chat', compact('data', 'employee_code','groupedData'));
    // }

    public function chat(Request $request)
{
    $email = Session::get("emp_email");
    if (empty($email)) {
        return redirect("/");
    }

    $id = decrypt($request->id);

    $empData = User::where('email', $email)->first();
    $emid = $empData->emid;
    $employee_code = $empData->employee_id;

    // 🔹 Project details with members & tasks
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

    $groupedData = [
        'project' => null,
        'members' => [],
        'tasks'   => []
    ];

    foreach ($projectData as $item) {
        if (!$groupedData['project']) {
            $groupedData['project'] = [
                'id'          => $item->project_id,
                'title'       => $item->project_title,
                'description' => $item->project_description,
                'status'      => $item->project_status
            ];
        }

        if ($item->employee_name && !isset($groupedData['members'][$item->employee_code])) {
            $groupedData['members'][$item->employee_code] = [
                'name'          => $item->employee_name,
                'employee_code' => $item->employee_code,
                'role'          => $item->member_role
            ];
        }

        if ($item->task_name && !isset($groupedData['tasks'][$item->task_name])) {
            $groupedData['tasks'][$item->task_name] = [
                'task_name'         => $item->task_name,
                'task_desc'         => $item->task_desc,
                'start_date'        => $item->start_date,
                'expected_end_date' => $item->expected_end_date
            ];
        }
    }

    $groupedData['members'] = array_values($groupedData['members']);
    $groupedData['tasks']   = array_values($groupedData['tasks']);

    // 🔥 Fetch all posts & replies from one table
    $allPosts = DB::table('project_post as p')
        ->leftJoin('users as u', function($join) {
            $join->on('u.employee_id', '=', 'p.employee_code')
                 ->where(function($q) {
                     $q->on('u.emid', '=', 'p.emid')
                       ->orWhereNull('p.emid');
                 });
        })
        ->where('p.project_id', $id)
        ->orderBy('p.created_at', 'asc')
        ->orderBy('p.id', 'asc') // 🔑 ensures id 1 before id 2 if timestamps same
        ->select([
            'p.id',
            'p.parent_id',
            'p.title',
            'p.file',
            'p.created_at',
            'p.employee_code', 
            'u.name as user_name'
        ])
        ->get();

    // Index posts by id for lookup
    $postIndex = $allPosts->keyBy('id');

    // Build replies into each post
    $posts = $allPosts->map(function ($post) use ($postIndex) {
        if ($post->parent_id) {
            // reply → attach its parent
            $parent = $postIndex->get($post->parent_id);

            $post->replies = $parent ? [[
                'id'         => $parent->id,
                'parent_id'  => $parent->parent_id,
                'title'      => $parent->title,
                'file'       => $parent->file,
                'created_at' => $parent->created_at,
                'user_name'  => $parent->user_name,
            ]] : [];
        } else {
            $post->replies = [];
        }
        return $post;
    })->values();

    $data['id']        = $id;
    $data['post_data'] = $posts;

    return view(
        'employeer/task-management/project-management/project-chat',
        compact('data', 'employee_code', 'groupedData')
    );
}

}
