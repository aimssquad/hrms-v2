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
use App\Models\TaskManagement\TaskComment;
use DB;
use Session;
use Storage;
use App\Events\ProjectPostCreated;
use App\Models\UserModel;
use App\Models\Notification;
use App\Services\FirebaseService;

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
                    'pm.permission as permission',
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
                        'permission' => $project->permission,
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

    // public function members(Request $request, $id)
    // {
    //     try {
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

    //         // Project details with members and tasks
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
    //                 'p.project_start_date as project_start_date',
    //                 'p.project_end_date as project_end_date',
    //                 'pm.role as member_role',
    //                 't.id',
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
    //                     'status' => $item->project_status,
    //                     'project_start_date' => $item->project_start_date,
    //                     'project_end_date' => $item->project_end_date
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
    //                     'task_id' => $item->id,
    //                     'task_name' => $item->task_name,
    //                     'task_desc' => $item->task_desc,
    //                     'start_date' => $item->start_date,
    //                     'expected_end_date' => $item->expected_end_date
    //                 ];
    //             }
    //         }

    //         $groupedData['members'] = array_values($groupedData['members']);
    //         $groupedData['tasks'] = array_values($groupedData['tasks']);

    //         //  Fetch all posts (including replies) from single table
    //         $allPosts = DB::table('project_post as p')
    //             ->leftJoin('users as u', function($join) {
    //                 $join->on('u.employee_id', '=', 'p.employee_code')
    //                     ->where(function($q) {
    //                         $q->on('u.emid', '=', 'p.emid')
    //                         ->orWhereNull('p.emid');
    //                     });
    //             })
    //             ->where('p.project_id', $id)
    //             ->orderBy('p.created_at', 'asc')
    //             ->select([
    //                 'p.id',
    //                 'p.parent_id',
    //                 'p.title',
    //                 'p.file',
    //                 'p.created_at',
    //                 'p.employee_code',
    //                 'u.name as user_name'
    //             ])
    //             ->get();

    //         // Index posts by ID for easy lookup
    //         $postIndex = $allPosts->keyBy('id');

    //         // Build posts with replies
    //         $posts = $allPosts->map(function ($post) use ($postIndex) {
    //             if ($post->parent_id) {
    //                 // reply → attach its parent
    //                 $parent = $postIndex->get($post->parent_id);

    //                 $post->replies = $parent ? [[
    //                     'id'         => $parent->id,
    //                     'employee_code' => $parent->employee_code,
    //                     'parent_id'  => $parent->parent_id,
    //                     'title'      => $parent->title,
    //                     'file'       => $parent->file,
    //                     'created_at' => $parent->created_at,
    //                     'user_name'  => $parent->user_name,
    //                 ]] : [];
    //             } else {
    //                 // top-level post → empty replies
    //                 $post->replies = [];
    //             }
    //             return $post;
    //         })->values();

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

    public function members(Request $request, $id)
    {
        try {
            // Auth check
            if (!auth()->check()) {
                return response()->json([
                    "status" => 401,
                    "message" => "Authentication required",
                    "data" => []
                ], 401);
            }

            $empData = auth()->user();
            $employee_code = $empData->employee_id;

            /* ======================================================
            | PROJECT + MEMBERS + TASKS (EMPLOYEE + GUEST)
            ====================================================== */
            $projectData = DB::table('projects as p')
                ->leftJoin('project_members as pm', 'p.id', '=', 'pm.project_id')

                // employee join (only when user_type = employee)
                ->leftJoin('employee as e', function ($join) {
                    $join->on('pm.user_id', '=', 'e.id')
                        ->where('pm.user_type', '=', 'employee');
                })

                // guest join (only when user_type = guest)
                ->leftJoin('guests as g', function ($join) {
                    $join->on('pm.user_id', '=', 'g.id')
                        ->where('pm.user_type', '=', 'guest');
                })

                ->leftJoin('tasks as t', 'p.id', '=', 't.project_id')
                ->where('p.id', $id)
                ->select([
                    'p.id as project_id',
                    'p.title as project_title',
                    'p.description as project_description',
                    'p.status as project_status',
                    'p.project_start_date',
                    'p.project_end_date',

                    'pm.user_type',
                    'pm.role as member_role',

                    // employee fields
                    DB::raw("CONCAT(e.emp_fname, ' ', COALESCE(e.emp_mname, ''), ' ', e.emp_lname) as employee_name"),
                    'e.emp_code as employee_code',

                    // guest fields
                    'g.name as guest_name',
                    'g.guest_id as guest_code',

                    // task fields
                    't.id as task_id',
                    't.task_name',
                    't.task_desc',
                    't.start_date',
                    't.expected_end_date'
                ])
                ->orderBy('t.start_date')
                ->get();

            /* ======================================================
            | GROUP DATA
            ====================================================== */
            $groupedData = [
                'project' => null,
                'members' => [],
                'tasks'   => []
            ];

            foreach ($projectData as $item) {

                // 📌 Project (once)
                if (!$groupedData['project']) {
                    $groupedData['project'] = [
                        'id' => $item->project_id,
                        'title' => $item->project_title,
                        'description' => $item->project_description,
                        'status' => $item->project_status,
                        'project_start_date' => $item->project_start_date,
                        'project_end_date' => $item->project_end_date,
                    ];
                }

                // 👤 EMPLOYEE MEMBER
                if ($item->user_type === 'employee' && $item->employee_code) {
                    if (!isset($groupedData['members'][$item->employee_code])) {
                        $groupedData['members'][$item->employee_code] = [
                            'name' => $item->employee_name,
                            'employee_code' => $item->employee_code,
                            'role' => $item->member_role,
                            'user_type' => 'employee' 
                        ];
                    }
                }

                /* ===============================
                | GUEST MEMBER
                =============================== */
                if ($item->user_type === 'guest' && $item->guest_code) {
                    if (!isset($groupedData['members'][$item->guest_code])) {
                        $groupedData['members'][$item->guest_code] = [
                            'name' => $item->guest_name,
                            'employee_code' => $item->guest_code, 
                            'role' => $item->member_role,
                            'user_type' => 'guest' 
                        ];
                    }
                }

                // 📋 TASKS
                if ($item->task_name && !isset($groupedData['tasks'][$item->task_id])) {
                    $groupedData['tasks'][$item->task_id] = [
                        'task_id' => $item->task_id,
                        'task_name' => $item->task_name,
                        'task_desc' => $item->task_desc,
                        'start_date' => $item->start_date,
                        'expected_end_date' => $item->expected_end_date
                    ];
                }
            }

            // Normalize arrays
            $groupedData['members'] = array_values($groupedData['members']);
            $groupedData['tasks']   = array_values($groupedData['tasks']);

            /* ======================================================
            | POSTS + REPLIES
            ====================================================== */
            $allPosts = DB::table('project_post as p')
                ->leftJoin('users as u', function ($join) {
                    $join->on('u.employee_id', '=', 'p.employee_code')
                        ->where(function ($q) {
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

            $postIndex = $allPosts->keyBy('id');

            $posts = $allPosts->map(function ($post) use ($postIndex) {
                if ($post->parent_id) {
                    $parent = $postIndex->get($post->parent_id);
                    $post->replies = $parent ? [[
                        'id' => $parent->id,
                        'employee_code' => $parent->employee_code,
                        'parent_id' => $parent->parent_id,
                        'title' => $parent->title,
                        'file' => $parent->file,
                        'created_at' => $parent->created_at,
                        'user_name' => $parent->user_name,
                    ]] : [];
                } else {
                    $post->replies = [];
                }
                return $post;
            })->values();

            /* ======================================================
            | RESPONSE
            ====================================================== */
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

  
    // this post and reply code working fine
    // public function empProjectPost(Request $request, FirebaseService $firebase)
    // {
    //     if (!auth()->check()) {
    //         return response()->json([
    //             "status"  => 401,
    //             "message" => "Authentication required",
    //             "data"    => []
    //         ], 401);
    //     }

    //     try {
    //         $user = auth()->user();

    //         $validator = Validator::make($request->all(), [
    //             'project_id' => 'required|integer|exists:projects,id',
    //             'parent_id'  => 'nullable|integer|exists:project_post,id',
    //             'file'       => 'nullable|file|mimes:pdf,png,jpg,jpeg,xls,xlsx|max:2048',
    //             'title'      => 'required|string|max:1000'
    //         ]);

    //         if ($validator->fails()) {
    //             return response()->json([
    //                 "status"  => 422,
    //                 "message" => "Validation failed",
    //                 "errors"  => $validator->errors()
    //             ], 422);
    //         }

    //         /** ========= FILE ========= */
    //         $filePath = null;
    //         if ($request->hasFile('file')) {
    //             $file = $request->file('file');
    //             $fileName = time() . '_' . $file->getClientOriginalName();
    //             $filePath = $file->storeAs('project_files', $fileName, 'public');
    //         }

    //         /** ========= SAVE POST ========= */
    //         $post = ProjectPost::create([
    //             'project_id'    => $request->project_id,
    //             'parent_id'     => $request->parent_id,
    //             'title'         => $request->title,
    //             'file'          => $filePath,
    //             'emid'          => $user->emid,
    //             'employee_code' => $user->employee_id,
    //             'created_at'    => now(),
    //             'updated_at'    => now()
    //         ]);

    //         /** ========= PROJECT MEMBERS (EXCEPT SENDER) ========= */
    //         $memberCodes = DB::table('project_members as pm')
    //             ->join('employee as e', 'e.id', '=', 'pm.user_id')
    //             ->where('pm.project_id', $request->project_id)
    //             ->where('e.emp_code', '!=', $user->employee_id)
    //             ->pluck('e.emp_code');

    //         /** ========= DB NOTIFICATION ========= */
    //         foreach ($memberCodes as $empCode) {
    //             Notification::create([
    //                 'emid' => $user->emid,
    //                 'employee_id' => $empCode,
    //                 'title' => 'New Project Message',
    //                 'description' => $request->title,
    //                 'status' => 0,
    //             ]);
    //         }

    //         /** ========= LIVE BROADCAST ========= */
    //         event(new ProjectPostCreated([
    //             'project_id' => $request->project_id,
    //             'emid' => $user->emid,
    //             'post' => $post
    //         ]));

    //         /** ========= FCM PUSH ========= */
    //         $tokens = UserModel::where('emid', $user->emid)
    //             ->whereIn('employee_id', $memberCodes)
    //             ->whereNotNull('device_token')
    //             ->pluck('device_token');

    //         foreach ($tokens as $token) {
    //             $firebase->sendNotification(
    //                 $token,
    //                 'New Project Message',
    //                 $request->title,
    //                 [
    //                     'type' => 'project_post',
    //                     'project_id' => (string) $request->project_id,
    //                     'post_id' => (string) $post->id
    //                 ]
    //             );
    //         }

    //         return response()->json([
    //             "status"  => 200,
    //             "message" => $request->parent_id
    //                 ? "Reply added successfully"
    //                 : "Project post created successfully",
    //             "data"    => $post
    //         ], 200);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             "status"  => 500,
    //             "message" => "Something went wrong",
    //             "error"   => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function empProjectPost(Request $request, FirebaseService $firebase)
    {
        if (!auth()->check()) {
            return response()->json([
                "status"  => 401,
                "message" => "Authentication required",
                "data"    => []
            ], 401);
        }

        try {
            /* ================= AUTH USER ================= */
            $user = auth()->user();
            //dd()
            /* ================= VALIDATION ================= */
            $validator = Validator::make($request->all(), [
                'project_id' => 'required|integer|exists:projects,id',
                'parent_id'  => 'nullable|integer|exists:project_post,id',
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

            /* ================= IDENTIFY SENDER ================= */
            $senderCode = null;
            $senderName = null;
            if ($user->user_type === 'employee') {

                $emp = DB::table('employee')
                    ->where('emid', $user->emid)
                    ->where('emp_code', $user->employee_id)
                    ->select('id', 'emp_code', 'emp_fname', 'emp_lname')
                    ->first();

                if (!$emp) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Employee not found'
                    ], 404);
                }

                $senderCode = $emp->emp_code;
                $senderName = $emp->emp_fname .' '. $emp->emp_lname;
            } elseif ($user->user_type === 'guest') {

                $guest = DB::table('guests')
                    ->where('emid', $user->emid)
                    ->where('guest_id', $user->employee_id)
                    ->select('id', 'guest_id', 'name')
                    ->first();

                if (!$guest) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Guest not found'
                    ], 404);
                }

                $senderCode = $guest->guest_id;
                $senderName = $guest->name;


            } else {
                return response()->json([
                    'status' => 403,
                    'message' => 'Invalid user type'
                ], 403);
            }

            /* ================= FILE UPLOAD ================= */
            $filePath = null;
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('project_files', $fileName, 'public');
            }

            /* ================= SAVE POST ================= */
            $post = ProjectPost::create([
                'project_id'    => $request->project_id,
                'parent_id'     => $request->parent_id,
                'title'         => $request->title,
                'file'          => $filePath,
                'emid'          => $user->emid,
                'employee_code' => $senderCode,   // emp_code OR guest_id
                'created_at'    => now(),
                'updated_at'    => now()
            ]);

            /* ================= GET PROJECT MEMBERS (EMP + GUEST) ================= */
            $memberCodes = DB::table('project_members as pm')

                // employee join
                ->leftJoin('employee as e', function ($join) {
                    $join->on('pm.user_id', '=', 'e.id')
                        ->where('pm.user_type', 'employee');
                })

                // guest join
                ->leftJoin('guests as g', function ($join) {
                    $join->on('pm.user_id', '=', 'g.id')
                        ->where('pm.user_type', 'guest');
                })

                ->where('pm.project_id', $request->project_id)
                ->select([
                    'pm.user_type',
                    'e.emp_code',
                    'g.guest_id'
                ])
                ->get()
                ->map(function ($m) {
                    return $m->user_type === 'employee'
                        ? $m->emp_code
                        : $m->guest_id;
                })
                ->filter(function ($code) use ($senderCode) {
                    return $code && $code !== $senderCode;
                })
                ->unique()
                ->values();

            /* ================= DB NOTIFICATION ================= */
            foreach ($memberCodes as $code) {
                Notification::create([
                    'emid' => $user->emid,
                    'employee_id' => $code,
                    'title' => 'New Project Message',
                    'description' => $request->title,
                    'status' => 0,
                ]);
            }
            $post['name'] = $senderName;
            /* ================= LIVE BROADCAST ================= */
            event(new ProjectPostCreated([
                'project_id' => $request->project_id,
                'emid' => $user->emid,
                'post' => $post
            ]));

            /* ================= FCM PUSH ================= */
            $tokens = UserModel::where('emid', $user->emid)
                ->whereIn('employee_id', $memberCodes)
                ->whereNotNull('device_token')
                ->pluck('device_token');

            // foreach ($tokens as $token) {
            //     $firebase->sendNotification(
            //         $token,
            //         'New Project Message',
            //         $request->title,
            //         [
            //             'type' => 'project_post',
            //             'project_id' => (string) $request->project_id,
            //             'post_id' => (string) $post->id
            //         ]
            //     );
            // }

            return response()->json([
                "status"  => 200,
                "message" => $request->parent_id
                    ? "Reply added successfully"
                    : "Project post created successfully",
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

    // public function taskComment ($id){
    //     $user = auth('api')->user();

    //     $task_comment = TaskComment::where('task_id',$id)->get();

    //      return response()->json([
    //             'success' => true,
    //             'data'    => $task_comment,  
    //             'message' => 'Post deleted successfully'
    //         ],200);
    // }

    public function taskComment($id)
    {
        $user = auth('api')->user();

        $task_comments = TaskComment::where('task_id', $id)->get();

        // Add comment type (organization / employee)
        $task_comments->transform(function ($comment) {
            // Check if createdBy exists in users table
            $isOrgComment = \DB::table('users')->where('id', $comment->createdBy)->exists();

            $comment->comment_type = $isOrgComment ? 'admin' : 'employee';
            return $comment;
        });

        return response()->json([
            'success' => true,
            'data'    => $task_comments,
            'message' => 'Task comments retrieved successfully'
        ], 200);
    }

    // public function add_emp_task_comment (Request $request){
    //     $user = auth('api')->user();
    //     $employee =  Employee::where('emid',$user->emid)->where('emp_code',$user->employee_id)->first();
    //     dd($employee);
    // }

    public function add_emp_task_comment(Request $request)
    {
        $user = auth('api')->user();

        // Validate request
        $validated = $request->validate([
            'task_id' => 'required|integer',
            'comment_details' => 'required|string',
        ]);

        // Try to detect if the user is an employee
        $employee = Employee::where('emid', $user->emid)
            ->where('emp_code', $user->employee_id)
            ->first();

        // Create comment
        $comment = new TaskComment();
        $comment->task_id = $validated['task_id'];
        $comment->comment_details = $validated['comment_details'];
        $comment->status = 'active';
        $comment->created_at = now();

        if ($employee) {
            // Comment by employee
            $comment->createdBy = $employee->id;
        } else {
            // Comment by organization (user)
            $comment->createdBy = $user->id;
        }

        $comment->save();

        // Add comment_type for clarity in response
        $comment->comment_type = $employee ? 'employee' : 'organization';

        return response()->json([
            'success' => true,
            'data' => $comment,
            'message' => 'Comment added successfully',
        ], 200);
    }


    // public function getProjectTasks($project_id)
    // {
    //     $user = auth('api')->user();
    //     // Fetch all labels for the project
    //     $employee = Employee::where('emid', $user->emid)
    //         ->where('emp_code', $user->employee_id)
    //         ->first();

    //     $labels = DB::table('tm_master_labels')
    //         ->where('project_id', $project_id)
    //         ->pluck('title'); // only the label names like ['Todo', 'Resolved', 'WIP']

    //     // Fetch all tasks for this project (with assigned employee)
    //     $tasks = Task::where('project_id', $project_id)
    //         ->where('assignedTo',$employee->id)
    //         ->with('assignedEmployee:id,emp_fname')
    //         ->get();

    //     // Prepare response
    //     $data = [];

    //     foreach ($labels as $label) {
    //         // Match tasks whose status = label title
    //         $filtered = $tasks->filter(function ($task) use ($label) {
    //             return strtolower($task->status) === strtolower($label);
    //         })->map(function ($task) {
    //             return [
    //                 'id' => $task->id,
    //                 'title' => $task->task_name,
    //                 'description' => $task->task_desc,
    //                 'assignee' => $task->assignedEmployee->emp_fname ?? 'Unassigned',
    //                 'dueDate' => $task->expected_end_date,
    //                 'createdDate' => $task->created_at ? $task->created_at->format('Y-m-d') : null,
    //                 'status' => $task->status,
    //                 'priority' => $task->priority
    //             ];
    //         })->values();

    //         // Add to response array
    //         $data[strtolower($label)] = $filtered;
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'data' => $data
    //     ], 200);
    // }

    public function getProjectTasks($project_id)
    {
        $user = auth('api')->user();

        // Detect if logged-in user is employee
        $employee = Employee::where('emid', $user->emid)
            ->where('emp_code', $user->employee_id)
            ->first();

        // Fetch all labels for the project
        $labels = DB::table('tm_master_labels')
            ->where('project_id', $project_id)
            ->pluck('title');

        // Fetch all tasks with assigned employee + task comments
        $tasks = Task::where('project_id', $project_id)
            ->where('assignedTo', $employee->id)
            ->with([
                'assignedEmployee:id,emp_fname',
                'taskComments' => function ($query) {
                    $query->orderBy('created_at', 'desc');
                }
            ])
            ->get();

        // Prepare response
        $data = [];

        foreach ($labels as $label) {
            $filtered = $tasks->filter(function ($task) use ($label) {
                return strtolower($task->status) === strtolower($label);
            })->map(function ($task) {
                return [
                    'id' => $task->id,
                    'title' => $task->task_name,
                    'description' => $task->task_desc,
                    'assignee' => $task->assignedEmployee->emp_fname ?? 'Unassigned',
                    'dueDate' => $task->expected_end_date,
                    'createdDate' => optional($task->created_at)->format('Y-m-d'),
                    'status' => $task->status,
                    'priority' => $task->priority,
                    'comments' => $task->taskComments->map(function ($comment) {
                        // Determine comment author (employee or organization)
                        $user = DB::table('users')->where('id', $comment->createdBy)->first();
                        $employee = DB::table('employees')->where('id', $comment->createdBy)->first();

                        return [
                            'id' => $comment->id,
                            'comment' => $comment->comment_details,
                            'user' => $user->name ?? $employee->emp_fname ?? '',
                           // 'type' => $user ? 'organization' : 'employee',
                            'timestamp' => $comment->created_at ? $comment->created_at->format('Y-m-d H:i:s') : null,
                        ];
                    })
                ];
            })->values();

            $data[strtolower($label)] = $filtered;
        }

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);
    }


    public function changeTaskStatus(Request $request, $id)
    {
        $user = auth('api')->user();

        // Validate input
        $validated = $request->validate([
            'status' => 'required|string'
        ]);

        // Check if task exists
        $task = Task::find($id);

        if (!$task) {
            return response()->json([
                'success' => false,
                'message' => 'Task not found',
            ], 404);
        }

        // Identify if request came from an employee or organization
        $employee = Employee::where('emid', $user->emid)
            ->where('emp_code', $user->employee_id)
            ->first();

        // Update the task status
        $task->status = $validated['status'];
        $task->updatedBy = $employee ? $employee->id : $user->id;
        $task->updated_at = now();
        $task->save();


        return response()->json([
            'success' => true,
            'message' => 'Task status updated successfully',
        ], 200);
    }



    // public function messageCenter()
    // {
    //     if (!auth()->check()) {
    //         return response()->json([
    //             "status"  => 401,
    //             "message" => "Authentication required",
    //             "data"    => []
    //         ], 401);
    //     }
    //     try {
    //         // ================= AUTH USER =================
    //         $user = auth('api')->user();

    //         // ================= EMPLOYEE =================
    //         $employee = DB::table('employee')
    //             ->where('emid', $user->emid)
    //             ->where('emp_code', $user->employee_id)
    //             ->select('id', 'emp_code')
    //             ->first();

    //         if (!$employee) {
    //             return response()->json([
    //                 'status' => 404,
    //                 'message' => 'Employee not found'
    //             ], 404);
    //         }

    //         // ================= PROJECT IDS =================
    //         $projectIds = DB::table('project_members')
    //             ->where('user_id', $employee->id)
    //             ->pluck('project_id');

    //         if ($projectIds->isEmpty()) {
    //             return response()->json([
    //                 'status' => 200,
    //                 'employee_code' => $employee->emp_code,
    //                 'projects' => []
    //             ]);
    //         }

    //         // ================= PROJECTS =================
    //         $projects = DB::table('projects')
    //             ->where('emid', $user->emid)
    //             ->whereIn('id', $projectIds)
    //             ->select('id', 'title', 'status')
    //             ->get();

    //         // ================= PROJECT MEMBERS =================
    //         $projectMembers = DB::table('project_members as pm')
    //             ->join('employee as e', 'e.id', '=', 'pm.user_id')
    //             ->whereIn('pm.project_id', $projectIds)
    //             ->select([
    //                 'pm.project_id',
    //                 'pm.role',
    //                 'e.emp_code',
    //                 DB::raw("CONCAT(e.emp_fname,' ',COALESCE(e.emp_mname,''),' ',e.emp_lname) as employee_name")
    //             ])
    //             ->get()
    //             ->groupBy('project_id');
    //         //dd($projectIds);      
    //         // ================= PROJECT POSTS =================
    //         $allPosts = DB::table('project_post as p')
    //             ->leftJoin('users as u', function ($join) {
    //                 $join->on('u.employee_id', '=', 'p.employee_code')
    //                     ->on('u.emid', '=', 'p.emid');
    //             })
    //             ->where('p.emid', $user->emid)
    //             ->whereIn('p.project_id', $projectIds)
    //             ->orderBy('p.created_at', 'asc')
    //             ->select([
    //                 'p.id',
    //                 'p.project_id',
    //                 'p.parent_id',
    //                 'p.title',
    //                 'p.file',
    //                 'p.created_at',
    //                 'p.employee_code',
    //                 'u.name as user_name'
    //             ])
    //             ->get()
    //             ->groupBy('project_id');
    //         //dd();       
    //         // ================= FINAL RESPONSE =================
    //         $finalProjects = [];

    //         foreach ($projects as $project) {

    //             $projectPosts = $allPosts->get($project->id, collect());
    //             $postIndex    = $projectPosts->keyBy('id');

    //             $messages = [];

    //             // ---------- MAIN MESSAGES ----------
    //             foreach ($projectPosts as $post) {
    //                 if ($post->parent_id === null) {
    //                     $messages[$post->id] = [
    //                         'id'         => $post->id,
    //                         'message'    => $post->title,
    //                         'file'       => $post->file,
    //                         'created_at' => $post->created_at,
    //                         'employee_code' => $post->employee_code,
    //                         'user_name'  => $post->user_name,
    //                         'replies'    => []
    //                     ];
    //                 }
    //             }

    //             // ---------- REPLIES ----------
    //             foreach ($projectPosts as $post) {
    //                 if ($post->parent_id && isset($messages[$post->parent_id])) {
    //                     $messages[$post->parent_id]['replies'][] = [
    //                         'id'         => $post->id,
    //                         'message'    => $post->title,
    //                         'file'       => $post->file,
    //                         'created_at' => $post->created_at,
    //                         'employee_code' => $post->employee_code,
    //                         'user_name'  => $post->user_name
    //                     ];
    //                 }
    //             }

    //             $finalProjects[] = [
    //                 'project_id'   => $project->id,
    //                 'project_name' => $project->title,
    //                 'status'       => $project->status,
    //                 'members'      => $projectMembers->get($project->id, collect())->values(),
    //                 'messages'     => array_values($messages)
    //             ];
    //         }

    //         return response()->json([
    //             'status' => 200,
    //             'employee_code' => $employee->emp_code,
    //             'projects' => $finalProjects
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 500,
    //             'message' => 'Something went wrong',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    // public function messageCenter()
    // {
    //     if (!auth()->check()) {
    //         return response()->json([
    //             "status"  => 401,
    //             "message" => "Authentication required",
    //             "data"    => []
    //         ], 401);
    //     }
        
    //     try {
    //         // ================= AUTH USER =================
    //         $user = auth('api')->user();
    //         //dd($user);
    //         // ================= EMPLOYEE =================
    //         $employee = DB::table('employee')
    //             ->where('emid', $user->emid)
    //             ->where('emp_code', $user->employee_id)
    //             ->select('id', 'emp_code')
    //             ->first();

    //         if (!$employee) {
    //             return response()->json([
    //                 'status' => 404,
    //                 'message' => 'Employee not found'
    //             ], 404);
    //         }

    //         // ================= PROJECT IDS =================
    //         $projectIds = DB::table('project_members')
    //             ->where('user_id', $employee->id)
    //             ->pluck('project_id');

    //         if ($projectIds->isEmpty()) {
    //             return response()->json([
    //                 'status' => 200,
    //                 'employee_code' => $employee->emp_code,
    //                 'projects' => []
    //             ]);
    //         }

    //         // ================= PROJECTS =================
    //         $projects = DB::table('projects')
    //             ->where('emid', $user->emid)
    //             ->whereIn('id', $projectIds)
    //             ->select('id', 'title', 'status')
    //             ->get();

    //         // ================= PROJECT MEMBERS =================
    //         $projectMembers = DB::table('project_members as pm')
    //             ->join('employee as e', 'e.id', '=', 'pm.user_id')
    //             ->whereIn('pm.project_id', $projectIds)
    //             ->select([
    //                 'pm.project_id',
    //                 'pm.role',
    //                 'e.emp_code',
    //                 DB::raw("CONCAT(e.emp_fname,' ',COALESCE(e.emp_mname,''),' ',e.emp_lname) as employee_name")
    //             ])
    //             ->get()
    //             ->groupBy('project_id');

    //         // ================= PROJECT POSTS =================
    //         $allPosts = DB::table('project_post as p')
    //             ->leftJoin('users as u', function ($join) {
    //                 $join->on('u.employee_id', '=', 'p.employee_code')
    //                     ->where(function($q) {
    //                         $q->where('u.emid', '=', DB::raw('p.emid'))
    //                         ->orWhereNull('p.emid');
    //                     });
    //             })
    //             ->where('p.emid', $user->emid)
    //             ->whereIn('p.project_id', $projectIds)
    //             ->orderBy('p.created_at', 'asc')
    //             ->select([
    //                 'p.id',
    //                 'p.project_id',
    //                 'p.parent_id',
    //                 'p.title',
    //                 'p.file',
    //                 'p.created_at',
    //                 'p.employee_code',
    //                 'u.name as user_name'
    //             ])
    //             ->get()
    //             ->groupBy('project_id');

    //         // ================= FINAL RESPONSE =================
    //         $finalProjects = [];

    //         foreach ($projects as $project) {
    //             $projectPosts = $allPosts->get($project->id, collect());
                
    //             // Create index for posts by ID
    //             $postIndex = $projectPosts->keyBy('id');
                
    //             // Build messages array like in members() function
    //             $messages = $projectPosts->map(function ($post) use ($postIndex) {
    //                 // Convert stdClass to array
    //                 $postArray = (array) $post;
                    
    //                 // Add replies array
    //                 if ($post->parent_id) {
    //                     // reply → attach its parent
    //                     $parent = $postIndex->get($post->parent_id);
    //                     $postArray['replies'] = $parent ? [[
    //                         'id'            => $parent->id,
    //                         'employee_code' => $parent->employee_code,
    //                         'parent_id'     => $parent->parent_id,
    //                         'title'         => $parent->title,
    //                         'file'          => $parent->file,
    //                         'created_at'    => $parent->created_at,
    //                         'user_name'     => $parent->user_name,
    //                     ]] : [];
    //                 } else {
    //                     // top-level post → empty replies
    //                     $postArray['replies'] = [];
    //                 }
                    
    //                 return $postArray;
    //             })->values();

    //             $finalProjects[] = [
    //                 'project_id'   => $project->id,
    //                 'project_name' => $project->title,
    //                 'status'       => $project->status,
    //                 'members'      => $projectMembers->get($project->id, collect())->values(),
    //                 'messages'     => $messages
    //             ];
    //         }

    //         return response()->json([
    //             'status' => 200,
    //             'employee_code' => $employee->emp_code,
    //             'projects' => $finalProjects
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 500,
    //             'message' => 'Something went wrong',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    //   public function messageCenter()
    // {
    //     if (!auth()->check()) {
    //         return response()->json([
    //             "status"  => 401,
    //             "message" => "Authentication required",
    //             "data"    => []
    //         ], 401);
    //     }
        
    //     try {
    //         // ================= AUTH USER =================
    //         $user = auth('api')->user();
    //         //dd($user->user_type);
    //         // $employee_id = '';
    //         // $employee_code = '';
    //         // ================= EMPLOYEE =================
    //         if($user->user_type == "employee"){
    //             $employee = DB::table('employee')
    //                 ->where('emid', $user->emid)
    //                 ->where('emp_code', $user->employee_id)
    //                 ->select('id', 'emp_code')
    //                 ->first();

    //             if (!$employee) {
    //                 return response()->json([
    //                     'status' => 404,
    //                     'message' => 'Employee not found'
    //                 ], 404);
    //             }

    //             $employee_id = $employee->id;
    //             $employee_code = $employee->emp_code;

    //         } elseif($user->user_type == "guest"){
    //             $employee = DB::table('guests')
    //                 ->where('emid', $user->emid)
    //                 ->where('guest_id', $user->employee_id)
    //                 ->select('id', 'guest_id')
    //                 ->first();

    //             if (!$employee) {
    //                 return response()->json([
    //                     'status' => 404,
    //                     'message' => 'Employee not found'
    //                 ], 404);
    //             }

    //             $employee_id = $employee->id;
    //             $employee_code = $employee->guest_id;
    //         }
    //        //dd($employee_id, $employee_code);

    //         // ================= PROJECT IDS =================
    //         $projectIds = DB::table('project_members')
    //             ->where('user_id', $employee_id)
    //             ->pluck('project_id');

    //         if ($projectIds->isEmpty()) {
    //             return response()->json([
    //                 'status' => 200,
    //                 'employee_code' => $employee_code,
    //                 'projects' => []
    //             ]);
    //         }
    //         //dd($projectIds);
    //         // ================= PROJECTS =================
    //         $projects = DB::table('projects')
    //             ->where('emid', $user->emid)
    //             ->whereIn('id', $projectIds)
    //             ->select('id', 'title', 'status')
    //             ->get();
    //         // this line of code is ok but now i need to change remaining code     
    //         //dd($projects);
    //         // ================= PROJECT MEMBERS =================
    //         $projectMembers = DB::table('project_members as pm')
    //             ->join('employee as e', 'e.id', '=', 'pm.user_id')
    //             ->whereIn('pm.project_id', $projectIds)
    //             ->select([
    //                 'pm.project_id',
    //                 'pm.role',
    //                 'e.emp_code',
    //                 DB::raw("CONCAT(e.emp_fname,' ',COALESCE(e.emp_mname,''),' ',e.emp_lname) as employee_name")
    //             ])
    //             ->get()
    //             ->groupBy('project_id');

    //         // ================= PROJECT POSTS =================
    //         $allPosts = DB::table('project_post as p')
    //             ->leftJoin('users as u', function ($join) {
    //                 $join->on('u.employee_id', '=', 'p.employee_code')
    //                     ->where(function($q) {
    //                         $q->where('u.emid', '=', DB::raw('p.emid'))
    //                         ->orWhereNull('p.emid');
    //                     });
    //             })
    //             ->where('p.emid', $user->emid)
    //             ->whereIn('p.project_id', $projectIds)
    //             ->orderBy('p.created_at', 'asc')
    //             ->select([
    //                 'p.id',
    //                 'p.project_id',
    //                 'p.parent_id',
    //                 'p.title',
    //                 'p.file',
    //                 'p.created_at',
    //                 'p.employee_code',
    //                 'u.name as user_name'
    //             ])
    //             ->get()
    //             ->groupBy('project_id');

    //         // ================= FINAL RESPONSE =================
    //         $finalProjects = [];

    //         foreach ($projects as $project) {
    //             $projectPosts = $allPosts->get($project->id, collect());
                
    //             // Create index for posts by ID
    //             $postIndex = $projectPosts->keyBy('id');
                
    //             // Build messages array like in members() function
    //             $messages = $projectPosts->map(function ($post) use ($postIndex) {
    //                 // Convert stdClass to array
    //                 $postArray = (array) $post;
                    
    //                 // Add replies array
    //                 if ($post->parent_id) {
    //                     // reply → attach its parent
    //                     $parent = $postIndex->get($post->parent_id);
    //                     $postArray['replies'] = $parent ? [[
    //                         'id'            => $parent->id,
    //                         'employee_code' => $parent->employee_code,
    //                         'parent_id'     => $parent->parent_id,
    //                         'title'         => $parent->title,
    //                         'file'          => $parent->file,
    //                         'created_at'    => $parent->created_at,
    //                         'user_name'     => $parent->user_name,
    //                     ]] : [];
    //                 } else {
    //                     // top-level post → empty replies
    //                     $postArray['replies'] = [];
    //                 }
                    
    //                 return $postArray;
    //             })->values();

    //             $finalProjects[] = [
    //                 'project_id'   => $project->id,
    //                 'project_name' => $project->title,
    //                 'status'       => $project->status,
    //                 'members'      => $projectMembers->get($project->id, collect())->values(),
    //                 'messages'     => $messages
    //             ];
    //         }

    //         return response()->json([
    //             'status' => 200,
    //             'employee_code' => $employee->emp_code,
    //             'projects' => $finalProjects
    //         ]);

    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 500,
    //             'message' => 'Something went wrong',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    public function messageCenter()
    {
        if (!auth()->check()) {
            return response()->json([
                "status"  => 401,
                "message" => "Authentication required",
                "data"    => []
            ], 401);
        }

        try {
            /* ================= AUTH USER ================= */
            $user = auth('api')->user();

            $memberId   = null;
            $memberCode = null;

            /* ================= IDENTIFY USER ================= */
            if ($user->user_type === 'employee') {

                $emp = DB::table('employee')
                    ->where('emid', $user->emid)
                    ->where('emp_code', $user->employee_id)
                    ->select('id', 'emp_code')
                    ->first();

                if (!$emp) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Employee not found'
                    ], 404);
                }

                $memberId   = $emp->id;
                $memberCode = $emp->emp_code;

            } elseif ($user->user_type === 'guest') {

                $guest = DB::table('guests')
                    ->where('emid', $user->emid)
                    ->where('guest_id', $user->employee_id)
                    ->select('id', 'guest_id')
                    ->first();

                if (!$guest) {
                    return response()->json([
                        'status' => 404,
                        'message' => 'Guest not found'
                    ], 404);
                }

                $memberId   = $guest->id;
                $memberCode = $guest->guest_id;

            } else {
                return response()->json([
                    'status' => 403,
                    'message' => 'Invalid user type'
                ], 403);
            }

            /* ================= PROJECT IDS ================= */
            $projectIds = DB::table('project_members')
                ->where('user_id', $memberId)
                ->where('user_type', $user->user_type)
                ->pluck('project_id');

            if ($projectIds->isEmpty()) {
                return response()->json([
                    'status' => 200,
                    'employee_code' => $memberCode,
                    'projects' => []
                ]);
            }

            /* ================= PROJECTS ================= */
            $projects = DB::table('projects')
                ->where('emid', $user->emid)
                ->whereIn('id', $projectIds)
                ->select('id', 'title', 'status')
                ->get();

            /* ================= PROJECT MEMBERS (EMPLOYEE + GUEST) ================= */
            $projectMembersRaw = DB::table('project_members as pm')

                ->leftJoin('employee as e', function ($join) {
                    $join->on('pm.user_id', '=', 'e.id')
                        ->where('pm.user_type', 'employee');
                })

                ->leftJoin('guests as g', function ($join) {
                    $join->on('pm.user_id', '=', 'g.id')
                        ->where('pm.user_type', 'guest');
                })

                ->whereIn('pm.project_id', $projectIds)
                ->select([
                    'pm.project_id',
                    'pm.role',
                    'pm.user_type',

                    // employee
                    'e.emp_code',
                    DB::raw("CONCAT(e.emp_fname,' ',COALESCE(e.emp_mname,''),' ',e.emp_lname) as employee_name"),

                    // guest
                    'g.guest_id',
                    'g.name as guest_name'
                ])
                ->get();

            $projectMembers = $projectMembersRaw
                ->groupBy('project_id')
                ->map(function ($members) {
                    return $members->map(function ($m) {

                        if ($m->user_type === 'employee') {
                            return [
                                'project_id'    => $m->project_id,
                                'role'          => $m->role,
                                'emp_code'      => $m->emp_code,
                                'employee_name' => $m->employee_name,
                                'user_type'     => 'employee',
                            ];
                        }

                        return [
                            'project_id'    => $m->project_id,
                            'role'          => $m->role,
                            'emp_code'      => $m->guest_id,
                            'employee_name' => $m->guest_name,
                             'user_type'     => 'guest',  
                        ];
                    })->values();
                });

            /* ================= PROJECT POSTS ================= */
            $allPosts = DB::table('project_post as p')
                ->leftJoin('users as u', function ($join) {
                    $join->on('u.employee_id', '=', 'p.employee_code')
                        ->where(function ($q) {
                            $q->where('u.emid', '=', DB::raw('p.emid'))
                            ->orWhereNull('p.emid');
                        });
                })
                ->where('p.emid', $user->emid)
                ->whereIn('p.project_id', $projectIds)
                ->orderBy('p.created_at', 'asc')
                ->select([
                    'p.id',
                    'p.project_id',
                    'p.parent_id',
                    'p.title',
                    'p.file',
                    'p.created_at',
                    'p.employee_code',
                    'u.name as user_name',
                    'u.user_type as user_type'
                ])
                ->get()
                ->groupBy('project_id');

            /* ================= FINAL RESPONSE ================= */
            $finalProjects = [];

            foreach ($projects as $project) {

                $projectPosts = $allPosts->get($project->id, collect());
                $postIndex = $projectPosts->keyBy('id');

                $messages = $projectPosts->map(function ($post) use ($postIndex) {
                    $postArr = (array) $post;

                    if ($post->parent_id) {
                        $parent = $postIndex->get($post->parent_id);
                        $postArr['replies'] = $parent ? [[
                            'id'            => $parent->id,
                            'employee_code' => $parent->employee_code,
                            'parent_id'     => $parent->parent_id,
                            'title'         => $parent->title,
                            'file'          => $parent->file,
                            'created_at'    => $parent->created_at,
                            'user_name'     => $parent->user_name,
                        ]] : [];
                    } else {
                        $postArr['replies'] = [];
                    }

                    return $postArr;
                })->values();

                $finalProjects[] = [
                    'project_id'   => $project->id,
                    'project_name' => $project->title,
                    'status'       => $project->status,
                    'members'      => $projectMembers->get($project->id, collect()),
                    'messages'     => $messages
                ];
            }

            return response()->json([
                'status' => 200,
                'employee_code' => $memberCode,
                'projects' => $finalProjects
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function createProjectTask(Request $request)
    {
        try {

            // ✅ Auth user (API)
            $user = auth()->user();

            if (!$user) {
                return response()->json([
                    'status' => false,
                    'message' => 'Unauthorized'
                ], 401);
            }

            // ✅ Validation
            $validatedData = $request->validate([
                'project_id' => 'required|integer',
                'assignedTo' => 'nullable',
                'task_name'  => 'required|string|max:255',
                'task_desc'  => 'required',
                'priority'   => 'nullable|string',
                'task_file'  => 'nullable|file|max:2048',
                'status' => 'nullable|in:Todo,Pending,Resolved,Complete'
            ]);

            $data = $validatedData;
            $data['createdBy'] = $user->id;

            // ✅ File Upload
            if ($request->hasFile('task_file')) {

                $file = $request->file('task_file');

                $filename = time() . '_' . $file->getClientOriginalName();

                $path = $file->storeAs('tasks', $filename, 'public');

                $data['task_file'] = $path;
            }

            // ✅ Create Task
            $task = Task::create($data);

            return response()->json([
                'status' => true,
                'message' => 'Task created successfully',
                'data' => $task
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {

            return response()->json([
                'status' => false,
                'message' => 'Validation error',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {

            return response()->json([
                'status' => false,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function projectWiseMember($projectId)
    {
        $user = auth('api')->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }

        $members = DB::table('project_members as pm')
            ->join('employee as e', 'e.id', '=', 'pm.user_id')
            ->where('pm.project_id', $projectId)
            ->select(
                'pm.id',
                'pm.project_id',
                'pm.user_id',
                'pm.role',
                'pm.permission',

                // 👇 Employee fields
                'e.emp_fname',
                'e.emp_mname',
                'e.emp_lname',

                // 👇 Full name (important 🔥)
                DB::raw("CONCAT(e.emp_fname, ' ', e.emp_mname, ' ', e.emp_lname) as full_name")
            )
            ->get();

        return response()->json([
            'success' => true,
            'data' => $members
        ], 200);
    }

    public function projectWiseTaskSummary()
    {
        $user = auth('api')->user();
        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized'
            ], 401);
        }
        
        $employee = DB::table('employee')
            ->where('emid', $user->emid)
            ->where('employee_id', $user->employee_id)
            ->select('id')
            ->first();
        
        $data = DB::table('tasks as t')
            ->join('projects as p', 'p.id', '=', 't.project_id')
            ->join('employee as e', 'e.id', '=', 't.assignedTo')
            ->where(e.employee_id, $employee->id)
            ->select(
                'p.id as project_id',
                'p.title as project_name',

                // 👇 employee name
                DB::raw("CONCAT(e.emp_fname,' ',e.emp_mname,' ',e.emp_lname) as employee_name"),

                // 👇 counts
                DB::raw("COUNT(t.id) as total_tasks"),
                DB::raw("SUM(CASE WHEN t.status = 'Todo' THEN 1 ELSE 0 END) as todo_tasks"),
                DB::raw("SUM(CASE WHEN t.status = 'Pending' THEN 1 ELSE 0 END) as pending_tasks"),
                DB::raw("SUM(CASE WHEN t.status = 'Resolved' THEN 1 ELSE 0 END) as resolved_tasks"),
                DB::raw("SUM(CASE WHEN t.status = 'Complete' THEN 1 ELSE 0 END) as complete_tasks")
            )
            ->groupBy(
                'p.id',
                'p.title',
                'e.emp_fname',
                'e.emp_mname',
                'e.emp_lname'
            )
            ->get();

        return response()->json([
            'success' => true,
            'data' => $data
        ], 200);    
    }















}
