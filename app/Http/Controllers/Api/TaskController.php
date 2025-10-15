<?php

namespace App\Http\Controllers\api;

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
    public function employeeTask(Request $request)
    {
        try {
            // Use API auth instead of Session
            $currentUser = auth()->user();

            if (!$currentUser) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Authentication required'
                ], 401);
            }

            // Find employee record
            $employee = Employee::where('emp_code', $currentUser->employee_id)
                ->where('emid', $currentUser->emid)
                ->first();

            if (!$employee) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Employee record not found'
                ], 404);
            }

            // Get projects and tasks
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

            return response()->json([
                'status' => 1,
                'message' => 'Employee tasks fetched successfully',
                'data' => array_values($groupedProjects)
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

public function members(Request $request, $id)
{
    try {
        if (!auth()->check()) {
            return response()->json([
                "status" => 401,
                "message" => "Authentication required",
                "data" => []
            ], 401);
        }

        $empData = auth()->user(); 
        $emid = $empData->emid;
        $employee_code = $empData->employee_id;

        // Project details with members and tasks
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
                't.id',
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
            'tasks' => []
        ];

        foreach ($projectData as $item) {
            if (!$groupedData['project']) {
                $groupedData['project'] = [
                    'id' => $item->project_id,
                    'title' => $item->project_title,
                    'description' => $item->project_description,
                    'status' => $item->project_status
                ];
            }

            if ($item->employee_name && !isset($groupedData['members'][$item->employee_code])) {
                $groupedData['members'][$item->employee_code] = [
                    'name' => $item->employee_name,
                    'employee_code' => $item->employee_code,
                    'role' => $item->member_role
                ];
            }

            if ($item->task_name && !isset($groupedData['tasks'][$item->task_name])) {
                $groupedData['tasks'][$item->task_name] = [
                    'task_id' => $item->id,
                    'task_name' => $item->task_name,
                    'task_desc' => $item->task_desc,
                    'start_date' => $item->start_date,
                    'expected_end_date' => $item->expected_end_date
                ];
            }
        }

        $groupedData['members'] = array_values($groupedData['members']);
        $groupedData['tasks'] = array_values($groupedData['tasks']);

        //  Fetch all posts (including replies) from single table
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

        // Index posts by ID for easy lookup
        $postIndex = $allPosts->keyBy('id');

        // Build posts with replies
        $posts = $allPosts->map(function ($post) use ($postIndex) {
            if ($post->parent_id) {
                // reply → attach its parent
                $parent = $postIndex->get($post->parent_id);

                $post->replies = $parent ? [[
                    'id'         => $parent->id,
                    'employee_code' => $parent->employee_code,
                    'parent_id'  => $parent->parent_id,
                    'title'      => $parent->title,
                    'file'       => $parent->file,
                    'created_at' => $parent->created_at,
                    'user_name'  => $parent->user_name,
                ]] : [];
            } else {
                // top-level post → empty replies
                $post->replies = [];
            }
            return $post;
        })->values();

        return response()->json([
            "status" => 200,
            "message" => "Project details fetched successfully",
            "data" => [
                "employee_code" => $employee_code,
                "project" => $groupedData,
                "posts" => $posts
            ]
        ]);

    } catch (\Exception $e) {
        return response()->json([
            "status" => 500,
            "message" => "Something went wrong",
            "error" => $e->getMessage()
        ], 500);
    }
}



//------------------
    // public function members(Request $request, $id)
    // {
    //     try {
    //         // Ensure user is authenticated
    //         if (!auth()->check()) {
    //             return response()->json([
    //                 "status" => 401,
    //                 "message" => "Authentication required",
    //                 "data" => []
    //             ], 401);
    //         }

    //         $empData = auth()->user(); 
    //         //dd($empData);
    //         $emid = $empData->emid;
    //         $employee_code = $empData->employee_id;

    //         // Fetch project details with members and tasks
    //         $projectData = DB::table('projects as p')
    //             ->leftJoin('project_members as pm', 'p.id', '=', 'pm.project_id')
    //             ->leftJoin('tasks as t', 'p.id', '=', 't.project_id')
    //             ->leftJoin('employee as e', 'pm.user_id', '=', 'e.id')
    //             ->where('p.id', $id)
    //             ->select([
    //                 'p.id as project_id',
    //                 'p.title as project_title',
    //                 'p.description as project_description',
    //                 'p.status as project_status',
    //                 'pm.role as member_role',
    //                 't.task_name',
    //                 't.task_desc',
    //                 't.start_date',
    //                 't.expected_end_date',
    //                 DB::raw("CONCAT(e.emp_fname, ' ', COALESCE(e.emp_mname, ''), ' ', e.emp_lname) as employee_name"),
    //                 'e.emp_code as employee_code'
    //             ])
    //             ->orderBy('employee_name')
    //             ->orderBy('t.start_date')
    //             ->get();

    //         // Group the data
    //         $groupedData = [
    //             'project' => null,
    //             'members' => [],
    //             'tasks' => []
    //         ];

    //         foreach ($projectData as $item) {
    //             if (!$groupedData['project']) {
    //                 $groupedData['project'] = [
    //                     'id' => $item->project_id,
    //                     'title' => $item->project_title,
    //                     'description' => $item->project_description,
    //                     'status' => $item->project_status
    //                 ];
    //             }

    //             if ($item->employee_name && !isset($groupedData['members'][$item->employee_code])) {
    //                 $groupedData['members'][$item->employee_code] = [
    //                     'name' => $item->employee_name,
    //                     'employee_code' => $item->employee_code,
    //                     'role' => $item->member_role
    //                 ];
    //             }

    //             if ($item->task_name && !isset($groupedData['tasks'][$item->task_name])) {
    //                 $groupedData['tasks'][$item->task_name] = [
    //                     'task_name' => $item->task_name,
    //                     'task_desc' => $item->task_desc,
    //                     'start_date' => $item->start_date,
    //                     'expected_end_date' => $item->expected_end_date
    //                 ];
    //             }
    //         }

    //         $groupedData['members'] = array_values($groupedData['members']);
    //         $groupedData['tasks'] = array_values($groupedData['tasks']);

    //         // Load posts with replies
    //         $posts = DB::table('project_post as p')
    //             ->leftJoin('users as u', function($join) {
    //                 $join->on('u.employee_id', '=', 'p.employee_code')
    //                     ->where(function($q) {
    //                         $q->on('u.emid', '=', 'p.emid')
    //                         ->orWhereNull('p.emid');
    //                     });
    //             })
    //             ->leftJoin('project_post_reply as r', 'r.post_id', '=', 'p.id')
    //             ->leftJoin('users as ru', function($join) {
    //                 $join->on('ru.employee_id', '=', 'r.employee_code')
    //                     ->where(function($q) {
    //                         $q->on('ru.emid', '=', 'r.emid')
    //                         ->orWhereNull('r.emid');
    //                     });
    //             })
    //             ->where('p.project_id', $id)
    //             ->where(function($q) use ($emid) {
    //                 $q->where('p.emid', $emid)
    //                 ->orWhereNull('p.emid');
    //             })
    //             ->orderBy('p.created_at', 'asc')
    //             ->select([
    //                 'p.*',
    //                 'u.name as post_user_name',
    //                 'r.id as reply_id',
    //                 'r.reply_text',
    //                 'r.created_at as reply_created_at',
    //                 'ru.name as reply_user_name'
    //             ])
    //             ->get();

    //         return response()->json([
    //             "status" => 200,
    //             "message" => "Project details fetched successfully",
    //             "data" => [
    //                 "employee_code" => $employee_code,
    //                 "project" => $groupedData,
    //                 "posts" => $posts
    //             ]
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             "status" => 500,
    //             "message" => "Something went wrong",
    //             "error" => $e->getMessage()
    //         ], 500);
    //     }
    // }

    // public function members(Request $request, $id)
    // {
    //     try {
    //         // Ensure user is authenticated
    //         if (!auth()->check()) {
    //             return response()->json([
    //                 "status" => 401,
    //                 "message" => "Authentication required",
    //                 "data" => []
    //             ], 401);
    //         }

    //         $empData = auth()->user(); 
    //         $emid = $empData->emid;
    //         $employee_code = $empData->employee_id;

    //         // Fetch project details with members and tasks
    //         $projectData = DB::table('projects as p')
    //             ->leftJoin('project_members as pm', 'p.id', '=', 'pm.project_id')
    //             ->leftJoin('tasks as t', 'p.id', '=', 't.project_id')
    //             ->leftJoin('employee as e', 'pm.user_id', '=', 'e.id')
    //             ->where('p.id', $id)
    //             ->select([
    //                 'p.id as project_id',
    //                 'p.title as project_title',
    //                 'p.description as project_description',
    //                 'p.status as project_status',
    //                 'pm.role as member_role',
    //                 't.task_name',
    //                 't.task_desc',
    //                 't.start_date',
    //                 't.expected_end_date',
    //                 DB::raw("CONCAT(e.emp_fname, ' ', COALESCE(e.emp_mname, ''), ' ', e.emp_lname) as employee_name"),
    //                 'e.emp_code as employee_code'
    //             ])
    //             ->orderBy('employee_name')
    //             ->orderBy('t.start_date')
    //             ->get();

    //         // Group the data
    //         $groupedData = [
    //             'project' => null,
    //             'members' => [],
    //             'tasks' => []
    //         ];

    //         foreach ($projectData as $item) {
    //             if (!$groupedData['project']) {
    //                 $groupedData['project'] = [
    //                     'id' => $item->project_id,
    //                     'title' => $item->project_title,
    //                     'description' => $item->project_description,
    //                     'status' => $item->project_status
    //                 ];
    //             }

    //             if ($item->employee_name && !isset($groupedData['members'][$item->employee_code])) {
    //                 $groupedData['members'][$item->employee_code] = [
    //                     'name' => $item->employee_name,
    //                     'employee_code' => $item->employee_code,
    //                     'role' => $item->member_role
    //                 ];
    //             }

    //             if ($item->task_name && !isset($groupedData['tasks'][$item->task_name])) {
    //                 $groupedData['tasks'][$item->task_name] = [
    //                     'task_name' => $item->task_name,
    //                     'task_desc' => $item->task_desc,
    //                     'start_date' => $item->start_date,
    //                     'expected_end_date' => $item->expected_end_date
    //                 ];
    //             }
    //         }

    //         $groupedData['members'] = array_values($groupedData['members']);
    //         $groupedData['tasks'] = array_values($groupedData['tasks']);

    //         // Load posts with replies
    //         $posts = DB::table('project_post as p')
    //             ->leftJoin('users as u', function($join) {
    //                 $join->on('u.employee_id', '=', 'p.employee_code')
    //                     ->where(function($q) {
    //                         $q->on('u.emid', '=', 'p.emid')
    //                         ->orWhereNull('p.emid');
    //                     });
    //             })
    //             ->leftJoin('project_post_reply as r', 'r.post_id', '=', 'p.id')
    //             ->leftJoin('users as ru', function($join) {
    //                 $join->on('ru.employee_id', '=', 'r.employee_code')
    //                     ->where(function($q) {
    //                         $q->on('ru.emid', '=', 'r.emid')
    //                         ->orWhereNull('r.emid');
    //                     });
    //             })
    //             ->where('p.project_id', $id)
    //             ->where(function($q) use ($emid) {
    //                 $q->where('p.emid', $emid)
    //                 ->orWhereNull('p.emid');
    //             })
    //             ->orderBy('p.created_at', 'asc')
    //             ->select([
    //                 'p.*',
    //                 'u.name as post_user_name',
    //                 'r.id as reply_id',
    //                 'r.reply_text',
    //                 'r.created_at as reply_created_at',
    //                 'ru.name as reply_user_name'
    //             ])
    //             ->get();

    //         // Group replies under each post
    //         $formattedPosts = [];
    //         foreach ($posts as $post) {
    //             $postId = $post->id;

    //             // If not yet added, initialize post
    //             if (!isset($formattedPosts[$postId])) {
    //                 $formattedPosts[$postId] = [
    //                     'id' => $post->id,
    //                     'emid' => $post->emid,
    //                     'project_id' => $post->project_id,
    //                     'employee_code' => $post->employee_code,
    //                     'title' => $post->title,
    //                     'file' => $post->file,
    //                     'created_at' => $post->created_at,
    //                     'updated_at' => $post->updated_at,
    //                     'post_user_name' => $post->post_user_name,
    //                     'replies' => []
    //                 ];
    //             }

    //             // Push reply if exists
    //             if ($post->reply_id) {
    //                 $formattedPosts[$postId]['replies'][] = [
    //                     'reply_id' => $post->reply_id,
    //                     'reply_text' => $post->reply_text,
    //                     'reply_created_at' => $post->reply_created_at,
    //                     'reply_user_name' => $post->reply_user_name
    //                 ];
    //             }
    //         }

    //         $formattedPosts = array_values($formattedPosts);

    //         // Final Response
    //         return response()->json([
    //             "status" => 200,
    //             "message" => "Project details fetched successfully",
    //             "data" => [
    //                 "employee_code" => $employee_code,
    //                 "project" => $groupedData,
    //                 "posts" => $formattedPosts
    //             ]
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             "status" => 500,
    //             "message" => "Something went wrong",
    //             "error" => $e->getMessage()
    //         ], 500);
    //     }
    // }
//------------------
    public function store(Request $request)
    {
        //dd('okkk');
        if (!auth()->check()) {
            return response()->json([
                "status" => 401,
                "message" => "Authentication required",
                "data" => []
            ], 401);
        }

        try {
            $user = auth()->user();
            //dd('okkk');
            $request->validate([
                'project_id' => 'required|exists:projects,id',
                'post_id' => 'required|exists:project_post,id',
                'reply_text' => 'required|string',
            ]);
            
            $reply = ProjectPostReply::create([
                'emid'          => $user->emid,
                'project_id'    => $request->project_id,
                'post_id'       => $request->post_id,
                'employee_code' => $user->employee_id,
                'reply_text'    => $request->reply_text,
            ]);

            return response()->json([
                "status"  => 200,
                "message" => "Reply added successfully",
                "data"    => $reply
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                "status"  => 500,
                "message" => "Something went wrong",
                "error"   => $e->getMessage()
            ], 500);
        }
    }

    // project releted post 
    public function empProjectPost(Request $request)
    {
        if (!auth()->check()) {
            return response()->json([
                "status"  => 401,
                "message" => "Authentication required",
                "data"    => []
            ], 401);
        }

        try {
            $user = auth()->user();

            $validator = Validator::make($request->all(), [
                'project_id' => 'required|integer|exists:projects,id',
                'parent_id'  => 'nullable|integer|exists:project_post,id', // reply to an existing post
                'file'       => 'nullable|file|mimes:pdf,png,jpg,jpeg,xls,xlsx|max:2048',
                'title'      => 'required|string|max:1000'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    "status"  => 422,
                    "message" => "Validation failed",
                    "errors"  => $validator->errors()
                ], 422);
            }

            $filePath = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('project_files', $fileName, 'public');
            }

            $post = ProjectPost::create([
                'project_id'    => $request->project_id,
                'parent_id'     => $request->parent_id,  // null = post, not null = reply
                'title'         => $request->title,
                'file'          => $filePath,
                'emid'          => $user->emid,
                'employee_code' => $user->employee_id,
                'created_at'    => now(),
                'updated_at'    => now()
            ]);

            return response()->json([
                "status"  => 200,
                "message" => $request->parent_id ? "Reply added successfully" : "Project post created successfully",
                "data"    => $post
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                "status"  => 500,
                "message" => "Something went wrong",
                "error"   => $e->getMessage()
            ], 500);
        }
    }

    public function edit($id)
    {
        try {
            // Get authenticated user (API guard)
            $user = auth('api')->user(); 

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }

            $employee_code = $user->employee_id;

            // Fetch post owned by the user
            $post = ProjectPost::where('id', $id)
                ->where('employee_code', $employee_code)
                ->first();

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found or you don’t have permission'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'post' => $post
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        //dd($request->all());
        try {
            // 🔑 Get logged in user
            $user = auth('api')->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }

            $employee_code = $user->employee_id;

            // 🔎 Find post by id & employee
            $post = ProjectPost::where('id', $id)
                ->where('employee_code', $employee_code)
                ->first();

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found or you don’t have permission'
                ], 404);
            }

            // ✅ Validation
            $validate_data = Validator::make($request->all(), [
                'title' => 'required|string|max:1000',
                'file'  => 'nullable|file|mimes:pdf,png,jpg,jpeg,xls,xlsx|max:2048',
            ]);

            if ($validate_data->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validate_data->errors()->first()
                ], 422);
            }

            $data = [
                'title' => $request->title,
                'updated_at' => now()
            ];

            // 📂 Handle file upload
            if ($request->hasFile('file')) {
                // Delete old file
                if ($post->file) {
                    Storage::disk('public')->delete($post->file);
                }

                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('project_files', $fileName, 'public');
                $data['file'] = $filePath;
            }

            // 📝 Update post
            $post->update($data);

            return response()->json([
                'success' => true,
                'message' => 'Post updated successfully',
                'post'    => $post
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            //  Get logged in user
            $user = auth('api')->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }

            $employee_code = $user->employee_id;

            // 🔎 Find post owned by current user
            $post = ProjectPost::where('id', $id)
                ->where('employee_code', $employee_code)
                ->first();

            if (!$post) {
                return response()->json([
                    'success' => false,
                    'message' => 'Post not found or you don’t have permission'
                ], 404);
            }

            // 🗑 Delete associated file if exists
            if ($post->file) {
                Storage::disk('public')->delete($post->file);
            }

            //  Delete post
            $post->delete();

            return response()->json([
                'success' => true,
                'message' => 'Post deleted successfully'
            ],200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Something went wrong',
                'error'   => $e->getMessage()
            ], 500);
        }
    }







}
