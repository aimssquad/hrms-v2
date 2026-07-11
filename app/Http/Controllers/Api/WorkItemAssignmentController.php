<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TaskManagement\WorkItem;
use App\Models\TaskManagement\WorkItemAssignment;
use App\Models\TaskManagement\TaskSubmission;
use App\Models\TaskManagement\WorkItemPermission;
use App\Models\TaskManagement\WorkItemUserRole;
use App\Models\EmpNotificationSetting;
use App\Models\EmpNotificationModule;
use App\Models\EmpNotification;
use Carbon\Carbon;
use Mail;

use DB;

class WorkItemAssignmentController extends Controller
{
    //  Assign employees
   
    
    public function assign(Request $request)
    {
        try {
    
            $currentUser = auth()->user();
    
            if (!$currentUser) {
    
                return response()->json([
                    'status' => 0,
                    'message' => 'Authentication required'
                ], 401);
            }
    
            $assignedBy = $currentUser->employee_id;
    
            $emid = $currentUser->emid;
            $request->validate([
    
                'work_item_id' => 'required|exists:work_items,id',
    
                'employee_ids' => 'required|array',
    
                'employee_ids.*' => 'exists:users,employee_id'
            ]);
    
            $workItem = WorkItem::find($request->work_item_id);
    
            $hasPermission = WorkItemPermission::where(
    
                'employee_id',
                $assignedBy
    
            )->where(
    
                'project_id',
                $workItem->project_id
    
            )->where(function ($q) {
    
                $q->where('role', 'admin')
                  ->orWhere('role', 'manager');
    
            })->exists();
    
            if (!$hasPermission) {
    
                return response()->json([
    
                    'status' => 0,
    
                    'message' => 'You do not have permission to assign tasks'
                ]);
            }
    
            foreach ($request->employee_ids as $empId) {
    
                WorkItemPermission::updateOrCreate(
    
                    [
                        'employee_id' => $empId,
    
                        'project_id' => $workItem->project_id,
    
                        'work_item_id' => $workItem->id
                    ],
    
                    [
                        'emid' => $emid,
    
                        // ✅ dynamic type
                        'access_type' => $workItem->type,
    
                        'role' => 'member',
    
                        'created_by' => $assignedBy
                    ]
                );
    
                /*
                |--------------------------------------------------------------------------
                | CREATE ASSIGNMENT
                |--------------------------------------------------------------------------
                */
    
                WorkItemAssignment::firstOrCreate(
    
                    [
                        'work_item_id' => $workItem->id,
    
                        'employee_id' => $empId
                    ],
    
                    [
                        'assigned_by' => $assignedBy,
    
                        'assigned_at' => now(),
    
                        'status' => 'assigned',
    
                        'emid' => $emid
                    ]
                );
            }
    
            return response()->json([
    
                'status' => 1,
    
                'message'=> 'Employees assigned successfully'
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
    
                'status' => 0,
    
                'message'=> $e->getMessage()
    
            ], 500);
        }
    }
    
    // after creating each lavel project step need to permission employee
    public function employeeGiveProjectAccess(Request $request)
    {
        try { 
    
            $currentUser = auth()->user();
    
            /*
            |--------------------------------------------------------------------------
            | AUTH CHECK
            |--------------------------------------------------------------------------
            */
    
            if (!$currentUser) {
    
                return response()->json([
    
                    'status' => 0,
    
                    'message' => 'Authentication required'
    
                ], 401);
            }
    
            $assignedBy = $currentUser->employee_id;
    
            $emid = $currentUser->emid;
    
            /*
            |--------------------------------------------------------------------------
            | VALIDATION
            |--------------------------------------------------------------------------
            */
    
            $request->validate([
    
                'work_item_id' => 'required|exists:work_items,id',
                'role_id'   => 'required',
    
                'employee_ids' => 'required|array',
    
                'employee_ids.*' => 'exists:users,employee_id'
            ]);
    
            /*
            |--------------------------------------------------------------------------
            | GET WORK ITEM
            |--------------------------------------------------------------------------
            */
    
            $workItem = WorkItem::find($request->work_item_id);
            
            /*
            |--------------------------------------------------------------------------
            | GET ALL PARENTS OF CURRENT WORK ITEM
            |--------------------------------------------------------------------------
            */
            
            $allItems = WorkItem::where(
                    'project_id',
                    $workItem->project_id
                )
                ->where(
                    'emid',
                    $emid
                )
                ->get();
            
            $parentIds = $this->getParentIds(
                $allItems,
                $workItem->id
            );
            
            
    
            /*
            |--------------------------------------------------------------------------
            | CHECK assign_task PERMISSION
            |--------------------------------------------------------------------------
            */
    
            $hasPermission = DB::table('work_item_user_roles as wur')
    
                ->join(
                    'project_role_permissions as prp',
                    'prp.project_role_id',
                    '=',
                    'wur.project_role_id'
                )
    
                ->join(
                    'project_permissions as pp',
                    'pp.id',
                    '=',
                    'prp.project_permission_id'
                )
    
                ->where('wur.employee_id', $assignedBy)
    
                ->where('wur.project_id', $workItem->project_id)
    
                ->where('wur.emid', $emid)
    
                //->where('pp.name', 'assign_task')
    
                ->exists();
    
            /*
            |--------------------------------------------------------------------------
            | PERMISSION DENIED
            |--------------------------------------------------------------------------
            */
    
            if (!$hasPermission) {
    
                return response()->json([
    
                    'status' => 0,
    
                    'message' => 'You do not have permission to assign task'
                ]);
            }
         
            
            $assignedCount = 0;

            $skippedEmployees = [];
    
            foreach ($request->employee_ids as $empId) {
                
                $alreadyAssignedToParent = DB::table('work_item_user_roles')
            
                    ->where('project_id', $workItem->project_id)
                
                    ->where('employee_id', $empId)
                
                    ->where('emid', $emid)
                
                    ->whereIn(
                        'work_item_id',
                        $parentIds
                    )
                
                    ->exists();
                
                if ($alreadyAssignedToParent) {
                
                    continue;
                }
                
                WorkItemUserRole::firstOrCreate(
                
                    [
                
                        'project_id' => $workItem->project_id,
                
                        'work_item_id' => $workItem->id,
                
                        'employee_id' => $empId
                    ],
                
                    [
                
                        'project_role_id' => $request->role_id, // Member Role ID
                
                        'created_by' => $assignedBy,
                
                        'emid' => $emid
                    ]
                );
    
                /*
                |--------------------------------------------------------------------------
                | CREATE TASK ASSIGNMENT
                |--------------------------------------------------------------------------
                */
    
                WorkItemAssignment::firstOrCreate(
    
                    [
    
                        'work_item_id' => $workItem->id,
    
                        'employee_id' => $empId
                    ],
    
                    [
    
                        'assigned_by' => $assignedBy,
    
                        'assigned_at' => now(),
    
                        'status' => 'assigned',
    
                        'emid' => $emid
                    ]
                );
                $assignedCount++;
                
                $user = DB::table('users')
                
                    ->where('employee_id', $empId)
                
                    ->where('emid', $emid)
                
                    ->select('id', 'employee_id')
                
                    ->first();
                
                if ($user) {
                
                    // CHECK MUTE
                    if (
                        EmpNotificationSetting::isMuted(
                            $user->employee_id,
                            EmpNotificationModule::TASK_CONTROLL ?? 8
                        )
                    ) {
                
                        continue;
                    }
                
                    // STORE ONLY ONE RECORD
                    EmpNotification::create([
                
                        'emid' => $emid,
                
                        'employee_id' => $user->employee_id,
                
                        'user_id' => $user->id,
                
                        'type' => strtoupper($workItem->type),
                
                        'title' => $workItem->title,
                
                        'description' => $workItem->description,
                
                        'reference_id' => $workItem->id,
                
                        'reference_type' => $workItem->type,
                
                        'start_date' => now(),
                
                        'end_date' => now()->addDay(),
                
                        'status' => 1,
                    ]);
                
                    // GET TOKENS
                    $tokens = DB::table('user_devices')
                
                        ->where('user_id', $user->id)
                
                        ->pluck('fcm_token');
                
                    // SEND PUSH
                    foreach ($tokens as $token) {
                
                        app(\App\Services\FirebaseService::class)
                
                            ->send(
                                $token,
                                $workItem->title,
                                $workItem->description
                            );
                    }
                }
            }
    
            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */
    
            if ($assignedCount == 0) {

                return response()->json([
            
                    'status' => 0,
            
                    'message' => 'All selected employees already have parent access',
            
                    'skipped_employees' => $skippedEmployees
                ]);
            }
            
            return response()->json([
            
                'status' => 1,
            
                'message' => $assignedCount . ' employee(s) assigned successfully',
            
                'skipped_employees' => $skippedEmployees
            ]);
    
        } catch (\Exception $e) {
            
    
            return response()->json([
    
                'status' => 0,
    
                'message' => $e->getMessage()
    
            ], 500);
        }
    }
    
    
    private function getParentIds($allItems, $itemId)
    {
        $parentIds = [];
    
        $currentItem = $allItems->firstWhere(
            'id',
            $itemId
        );
    
        while (
            $currentItem &&
            $currentItem->parent_id
        ) {
    
            $parentIds[] = $currentItem->parent_id;
    
            $currentItem = $allItems->firstWhere(
                'id',
                $currentItem->parent_id
            );
        }
    
        return $parentIds;
    }

    public function getAssignedEmployees($workItemId)
    {
        $currentUser = auth()->user();
    
        if (!$currentUser) {
            return response()->json([
                'status' => 0,
                'message' => 'Authentication required'
            ], 401);
        }
    
        $emid = $currentUser->emid;
    
        $data = WorkItem::with(['employees' => function ($query) use ($emid) {
            $query->where('users.emid', $emid);
        }])
        ->where('emid', $emid)
        ->where('id', $workItemId)
        ->first();
    
        if (!$data) {
            return response()->json([
                'status' => 0,
                'message' => 'Work item not found'
            ]);
        }
    
        return response()->json([
            'status' => 1,
            'data'   => $data->employees
        ]);
    }

    // ❌ Remove assignment
    public function remove(Request $request)
    {
        $request->validate([
            'work_item_id' => 'required',
            'employee_id'  => 'required'
        ]);
        
        WorkItemAssignment::where([
            'work_item_id' => $request->work_item_id,
            'employee_id'  => $request->employee_id
        ])->delete();

        return response()->json([
            'status' => 1,
            'message'=> 'Assignment removed'
        ]);
    }
    
    public function myTasks()
    {
        $currentUser = auth()->user();
    
        if (!$currentUser) {
            return response()->json([
                'status' => 0,
                'message' => 'Authentication required'
            ], 401);
        }
    
        $employeeId = $currentUser->employee_id;
        $emid       = $currentUser->emid;
    
        $tasks = \DB::table('work_item_assignments as wa')
            ->join('work_items as wi', 'wi.id', '=', 'wa.work_item_id')
            ->where('wa.employee_id', $employeeId)
            ->where('wi.emid', $emid) // 🔥 organization filter
            ->select(
                'wi.id',
                'wi.title',
                'wi.type',
                'wi.parent_id',
                'wi.status',
                'wi.start_date',
                'wi.end_date',
                'wa.status as assignment_status'
            )
            ->get();
    
        return response()->json([
            'status' => 1,
            'data'   => $tasks
        ]);
    }
    
    
    // public function myAssignedWork()
    // {
    //     try {
    //         $currentUser = auth()->user();
    
    //         if (!$currentUser) {
    //             return response()->json([
    //                 'status' => 0,
    //                 'message' => 'Authentication required'
    //             ], 401);
    //         }
    
    //         $employeeId = $currentUser->employee_id;
    //         $emid       = $currentUser->emid;
    
    //         $data = \DB::table('work_item_assignments as wa')
    //             ->join('work_items as wi', 'wi.id', '=', 'wa.work_item_id')
    
    //             // 🔹 Parent (module/submodule)
    //             ->leftJoin('work_items as p1', 'p1.id', '=', 'wi.parent_id')
    
    //             // 🔹 Grand Parent (module if task under submodule)
    //             ->leftJoin('work_items as p2', 'p2.id', '=', 'p1.parent_id')
    
    //             ->where('wa.employee_id', $employeeId)
    //             ->where('wi.emid', $emid)
    
    //             ->select(
    //                 'wi.id',
    //                 'wi.title',
    //                 'wi.type',
    //                 'wi.status',
    //                 'wi.start_date',
    //                 'wi.end_date',
    
    //                 'wa.status as assignment_status',
    //                 'wa.assigned_by',
    //                 'wa.assigned_at',
    
    //                 // 🔥 hierarchy
    //                 'p1.title as parent_title',
    //                 'p1.type as parent_type',
    
    //                 'p2.title as grandparent_title',
    //                 'p2.type as grandparent_type',
    //                 'p2.description as grandparent_description'
    //             )
    //             ->orderBy('wi.id', 'desc')
    //             ->get();
    
    //         return response()->json([
    //             'status' => 1,
    //             'data'   => $data
    //         ]);
    
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 0,
    //             'message'=> $e->getMessage()
    //         ], 500);
    //     }
    // }
    
    public function myAssignedWork($projectId)
    {
        try {
            $currentUser = auth()->user();
    
            if (!$currentUser) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Authentication required'
                ], 401);
            }
            
            // $request->validate([
            //     'project_id' => 'required|exists:projects,id'
            // ]);
    
            $employeeId = $currentUser->employee_id;
            $emid       = $currentUser->emid;
    
            $data = \DB::table('work_item_assignments as wa')
                ->join('work_items as wi', 'wi.id', '=', 'wa.work_item_id')
    
                ->leftJoin('work_items as p1', 'p1.id', '=', 'wi.parent_id')      // task/submodule
                ->leftJoin('work_items as p2', 'p2.id', '=', 'p1.parent_id')      // submodule/module
                ->leftJoin('work_items as p3', 'p3.id', '=', 'p2.parent_id')      // ✅ module
    
                ->where('wa.employee_id', $employeeId)
                ->where('wi.emid', $emid)
                ->where('wi.project_id', $projectId)
    
                ->select(
                    'wi.id',
                    'wi.title',
                    'wi.type',
                    'wi.description',
                    'wi.start_date',
                    'wi.end_date',
    
                    'wa.status as assignment_status',
    
                    // hierarchy
                    'p1.title as parent_title',
                    'p1.type as parent_type',
                    'p1.description as parent_description',
                    'p1.start_date as parent_start_date',
                    'p1.end_date as parent_end_date',
    
                    'p2.title as grant_parent_title',
                    'p2.type as grant_parent_type',
                    'p2.description as grant_parent_description',
                    'p2.start_date as grant_start_date',
                    'p2.end_date as grant_parent_end_date',
    
                    'p3.title as g_g_parent_title',
                    'p3.type as g_g_parent_type'
                )
                ->orderBy('wi.id', 'desc')
                ->get();
    
            return response()->json([
                'status' => 1,
                'data'   => $data
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message'=> $e->getMessage()
            ], 500);
        }
    }
    
    
    public function submitTask(Request $request)
    {
        try {
            $currentUser = auth()->user();
    
            if (!$currentUser) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Authentication required'
                ], 401);
            }
    
            $employeeId = $currentUser->employee_id;
            $emid       = $currentUser->emid;
    
            // ✅ Validation
            $request->validate([
                'work_item_id' => 'required|exists:work_items,id',
                'file'         => 'required|file',
                'remarks'      => 'nullable|string'
            ]);
    
            // ✅ Check assignment exists
            $assignment = WorkItemAssignment::where([
                'work_item_id' => $request->work_item_id,
                'employee_id'  => $employeeId,
                'emid' => $emid
            ])->first();
            //dd($assignment);
            if (!$assignment) {
                return response()->json([
                    'status' => 0,
                    'message' => 'You are not assigned to this task'
                ]);
            }
    
            // ✅ Upload file
            $filePath = null;
            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('task_submissions', 'public');
            }
    
            // ✅ Save submission
            TaskSubmission::create([
                'work_item_id' => $request->work_item_id,
                'employee_id'  => $employeeId,
                'file'         => $filePath,
                'remarks'      => $request->remarks,
                'emid'         => $emid,
                'submitted_at' => now()
            ]);
    
            // ✅ Update assignment status
            $assignment->update([
                'status' => 'completed'
            ]);
    
            return response()->json([
                'status' => 1,
                'message'=> 'Task submitted successfully'
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message'=> $e->getMessage()
            ], 500);
        }
    }
    
    // public function completedTasks()
    // {
    //     try {
    //         $currentUser = auth()->user();
    
    //         if (!$currentUser) {
    //             return response()->json([
    //                 'status' => 0,
    //                 'message' => 'Authentication required'
    //             ], 401);
    //         }
    
    //         $emid = $currentUser->emid;
    
    //         $data = \DB::table('work_item_assignments as wa')
    //             ->join('work_items as wi', 'wi.id', '=', 'wa.work_item_id')
    
    //             // ✅ FIXED JOIN
    //             ->join('users as u', function ($join) use ($emid) {
    //                 $join->on('u.employee_id', '=', 'wa.employee_id')
    //                      ->where('u.emid', '=', $emid);
    //             })
    
    //             ->leftJoin('task_submissions as ts', function ($join) {
    //                 $join->on('ts.work_item_id', '=', 'wa.work_item_id')
    //                      ->on('ts.employee_id', '=', 'wa.employee_id');
    //             })
    
    //             ->where('wa.status', 'completed')
    //             ->where('wi.emid', $emid)
    
    //             ->select(
    //                 'u.name as employee_name',
    //                 'u.employee_id',
    
    //                 'wi.title as task_title',
    //                 'wi.type',
    
    //                 'ts.file',
    //                 'ts.remarks',
    //                 'ts.submitted_at',
    
    //                 'wa.assigned_at'
    //             )
    //             ->orderBy('ts.submitted_at', 'desc')
    //             ->get();
    
    //         return response()->json([
    //             'status' => 1,
    //             'data'   => $data
    //         ]);
    
    //     } catch (\Exception $e) {
    //         return response()->json([
    //             'status' => 0,
    //             'message'=> $e->getMessage()
    //         ], 500);
    //     }
    // }
    
    public function completedTasks($id)
    {
        try {
            $currentUser = auth()->user();
    
            if (!$currentUser) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Authentication required'
                ], 401);
            }
    
            $emid = $currentUser->emid;
    
            $data = DB::table('task_submissions as tasks')
                ->join('users as u', 'u.employee_id', '=', 'tasks.employee_id')
                ->where('work_item_id', $id)
                ->where('u.emid', $emid)
                ->select('tasks.*', 'u.name')  // Fixed: u.name not u,name
                ->get();
    
            return response()->json([
                'status' => 1,
                'data'   => $data
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message'=> $e->getMessage()
            ], 500);
        }
    }
    
 
    
    // public function allTask($projectId)
    // {
    //     try {
    
    //         $currentUser = auth()->user();
    
    //         if (!$currentUser) {
    //             return response()->json([
    //                 'status' => 0,
    //                 'message' => 'Authentication required'
    //             ], 401);
    //         }
    
    //         $emid = $currentUser->emid;
    
    //         $rows = DB::table('work_items as wi')
    
    //             ->leftJoin('work_item_assignments as wa', 'wa.work_item_id', '=', 'wi.id')
    
    //             ->leftJoin('users as u', function ($join) use ($emid) {
    //                 $join->on('u.employee_id', '=', 'wa.employee_id')
    //                      ->where('u.emid', '=', $emid);
    //             })
    
    //             ->leftJoin('work_items as p1', 'p1.id', '=', 'wi.parent_id')
    //             ->leftJoin('work_items as p2', 'p2.id', '=', 'p1.parent_id')
    //             ->leftJoin('work_items as p3', 'p3.id', '=', 'p2.parent_id')
    
    //             ->where('wi.project_id', $projectId)
    //             ->where('wi.type', 'task')
    //             ->where('wi.emid', $emid)
    
    //             ->select(
    
    //                 // task
    //                 'wi.id',
    //                 'wi.title',
    //                 'wi.description',
    //                 'wi.start_date',
    //                 'wi.end_date',
    //                 'wi.status',
    
    //                 // employee
    //                 'u.name as employee_name',
    //                 'u.employee_id',
    
    //                 // assignment
    //                 'wa.status as assignment_status',
    //                 'wa.assigned_at',
    
    //                 // hierarchy
    //                 'p1.title as parent_title',
    //                 'p1.type as parent_type',
    
    //                 'p2.title as grand_parent_title',
    //                 'p2.type as grand_parent_type',
    
    //                 'p3.title as top_parent_title',
    //                 'p3.type as top_parent_type'
    //             )
    
    //             ->orderBy('wi.id', 'desc')
    //             ->get();
    
    //         // GROUP TASKS
    //         $tasks = [];
    
    //         foreach ($rows as $row) {
    
    //             if (!isset($tasks[$row->id])) {
    
    //                 $tasks[$row->id] = [
    
    //                     'id' => $row->id,
    //                     'title' => $row->title,
    //                     'description' => $row->description,
    //                     'start_date' => $row->start_date,
    //                     'end_date' => $row->end_date,
    //                     'status' => $row->status,
    
    //                     // hierarchy
    //                     'parent_title' => $row->parent_title,
    //                     'parent_type' => $row->parent_type,
    
    //                     'grand_parent_title' => $row->grand_parent_title,
    //                     'grand_parent_type' => $row->grand_parent_type,
    
    //                     'top_parent_title' => $row->top_parent_title,
    //                     'top_parent_type' => $row->top_parent_type,
    
    //                     // employees array
    //                     'employees' => []
    //                 ];
    //             }
    
    //             // add employee
    //             if ($row->employee_name) {
    
    //                 $tasks[$row->id]['employees'][] = [
    //                     'employee_name' => $row->employee_name,
    //                     'employee_id' => $row->employee_id,
    //                     'assignment_status' => $row->assignment_status,
    //                     'assigned_at' => $row->assigned_at
    //                 ];
    //             }
    //         }
    
    //         return response()->json([
    //             'status' => 1,
    //             'data' => array_values($tasks)
    //         ]);
    
    //     } catch (\Exception $e) {
    
    //         return response()->json([
    //             'status' => 0,
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    
    
    public function allTask($projectId)
    {
        try {
    
            $currentUser = auth()->user();
    
            if (!$currentUser) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Authentication required'
                ], 401);
            }
    
            $emid = $currentUser->emid;
    
            $rows = DB::table('work_items as wi')
    
                // assignment
                ->leftJoin('work_item_assignments as wa', 'wa.work_item_id', '=', 'wi.id')
    
                // users
                ->leftJoin('users as u', function ($join) use ($emid) {
                    $join->on('u.employee_id', '=', 'wa.employee_id')
                         ->where('u.emid', '=', $emid);
                })
    
                // 🔥 task submissions
                ->leftJoin('task_submissions as ts', function ($join) {
                    $join->on('ts.work_item_id', '=', 'wi.id')
                         ->on('ts.employee_id', '=', 'wa.employee_id');
                })
    
                // hierarchy
                ->leftJoin('work_items as p1', 'p1.id', '=', 'wi.parent_id')
                ->leftJoin('work_items as p2', 'p2.id', '=', 'p1.parent_id')
                ->leftJoin('work_items as p3', 'p3.id', '=', 'p2.parent_id')
    
                ->where('wi.project_id', $projectId)
                ->where('wi.type', 'task')
                ->where('wi.emid', $emid)
    
                ->select(
    
                    // task
                    'wi.id',
                    'wi.title',
                    'wi.description',
                    'wi.start_date',
                    'wi.end_date',
                    'wi.status',
    
                    // employee
                    'u.name as employee_name',
                    'u.employee_id',
    
                    // assignment
                    'wa.status as assignment_status',
                    'wa.assigned_at',
    
                    // 🔥 submission
                    'ts.file as submission_file',
                    'ts.remarks as submission_remarks',
                    'ts.submitted_at',
    
                    // hierarchy
                    'p1.title as parent_title',
                    'p1.type as parent_type',
    
                    'p2.title as grand_parent_title',
                    'p2.type as grand_parent_type',
    
                    'p3.title as top_parent_title',
                    'p3.type as top_parent_type'
                )
    
                ->orderBy('wi.id', 'desc')
                ->get();
    
            // 🔥 GROUP TASKS
            $tasks = [];
    
            foreach ($rows as $row) {
    
                if (!isset($tasks[$row->id])) {
    
                    $tasks[$row->id] = [
    
                        'id' => $row->id,
                        'title' => $row->title,
                        'description' => $row->description,
                        'start_date' => $row->start_date,
                        'end_date' => $row->end_date,
                        'status' => $row->status,
    
                        // hierarchy
                        'parent_title' => $row->parent_title,
                        'parent_type' => $row->parent_type,
    
                        'grand_parent_title' => $row->grand_parent_title,
                        'grand_parent_type' => $row->grand_parent_type,
    
                        'top_parent_title' => $row->top_parent_title,
                        'top_parent_type' => $row->top_parent_type,
    
                        // employees
                        'employees' => []
                    ];
                }
    
                // employee info
                if ($row->employee_name) {
    
                    $tasks[$row->id]['employees'][] = [
    
                        'employee_name' => $row->employee_name,
                        'employee_id' => $row->employee_id,
    
                        'assignment_status' => $row->assignment_status,
                        'assigned_at' => $row->assigned_at,
    
                        // 🔥 submission info
                        'submission_file' => $row->submission_file,
                        'submission_remarks' => $row->submission_remarks,
                        'submitted_at' => $row->submitted_at
                    ];
                }
            }
    
            return response()->json([
                'status' => 1,
                'data' => array_values($tasks)
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // public function allSubTask($projectId)
    // {
    //     try {
    
    //         $currentUser = auth()->user();
    
    //         if (!$currentUser) {
    //             return response()->json([
    //                 'status' => 0,
    //                 'message' => 'Authentication required'
    //             ], 401);
    //         }
    
    //         $emid = $currentUser->emid;
    
    //         $all_task = DB::table('work_items as wi')
    
    //             // assignment table
    //             ->leftJoin('work_item_assignments as wa', 'wa.work_item_id', '=', 'wi.id')
    
    //             //  users table
    //             ->leftJoin('users as u', function ($join) use ($emid) {
    //                 $join->on('u.employee_id', '=', 'wa.employee_id')
    //                      ->where('u.emid', '=', $emid);
    //             })
    
    //             //  hierarchy joins
    //             ->leftJoin('work_items as p1', 'p1.id', '=', 'wi.parent_id')
    //             ->leftJoin('work_items as p2', 'p2.id', '=', 'p1.parent_id')
    //             ->leftJoin('work_items as p3', 'p3.id', '=', 'p2.parent_id')
    
    //             ->where('wi.project_id', $projectId)
    //             ->where('wi.type', 'subtask')
    //             ->where('wi.emid', $emid)
    
    //             ->select(
    
    //                 // task
    //                 'wi.id',
    //                 'wi.title',
    //                 'wi.description',
    //                 'wi.start_date',
    //                 'wi.end_date',
    //                 'wi.status',
    
    //                 // assigned employee
    //                 'u.name as employee_name',
    //                 'u.employee_id',
    
    //                 // assignment info
    //                 'wa.status as assignment_status',
    //                 'wa.assigned_at',
    
    //                 // hierarchy
    //                 'p1.title as parent_title',
    //                 'p1.type as parent_type',
    
    //                 'p2.title as grand_parent_title',
    //                 'p2.type as grand_parent_type',
    
    //                 'p3.title as top_parent_title',
    //                 'p3.type as top_parent_type'
    //             )
    
    //             ->orderBy('wi.id', 'desc')
    //             ->get();
    
    //         return response()->json([
    //             'status' => 1,
    //             'data' => $all_task
    //         ]);
    
    //     } catch (\Exception $e) {
    
    //         return response()->json([
    //             'status' => 0,
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    
    public function allSubTask($projectId)
    {
        try {
    
            $currentUser = auth()->user();
    
            if (!$currentUser) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Authentication required'
                ], 401);
            }
    
            $emid = $currentUser->emid;
    
            $rows = DB::table('work_items as wi')
    
                // assignment
                ->leftJoin('work_item_assignments as wa', 'wa.work_item_id', '=', 'wi.id')
    
                // users
                ->leftJoin('users as u', function ($join) use ($emid) {
                    $join->on('u.employee_id', '=', 'wa.employee_id')
                         ->where('u.emid', '=', $emid);
                })
    
                // 🔥 submissions
                ->leftJoin('task_submissions as ts', function ($join) {
                    $join->on('ts.work_item_id', '=', 'wi.id')
                         ->on('ts.employee_id', '=', 'wa.employee_id');
                })
    
                // hierarchy
                ->leftJoin('work_items as p1', 'p1.id', '=', 'wi.parent_id')
                ->leftJoin('work_items as p2', 'p2.id', '=', 'p1.parent_id')
                ->leftJoin('work_items as p3', 'p3.id', '=', 'p2.parent_id')
    
                ->where('wi.project_id', $projectId)
                ->where('wi.type', 'subtask')
                ->where('wi.emid', $emid)
    
                ->select(
    
                    // subtask
                    'wi.id',
                    'wi.title',
                    'wi.description',
                    'wi.start_date',
                    'wi.end_date',
                    'wi.status',
    
                    // employee
                    'u.name as employee_name',
                    'u.employee_id',
    
                    // assignment
                    'wa.status as assignment_status',
                    'wa.assigned_at',
    
                    // 🔥 submission
                    'ts.file as submission_file',
                    'ts.remarks as submission_remarks',
                    'ts.submitted_at',
    
                    // hierarchy
                    'p1.title as parent_title',
                    'p1.type as parent_type',
    
                    'p2.title as grand_parent_title',
                    'p2.type as grand_parent_type',
    
                    'p3.title as top_parent_title',
                    'p3.type as top_parent_type'
                )
    
                ->orderBy('wi.id', 'desc')
                ->get();
    
            // 🔥 GROUP SUBTASKS
            $subtasks = [];
    
            foreach ($rows as $row) {
    
                if (!isset($subtasks[$row->id])) {
    
                    $subtasks[$row->id] = [
    
                        'id' => $row->id,
                        'title' => $row->title,
                        'description' => $row->description,
                        'start_date' => $row->start_date,
                        'end_date' => $row->end_date,
                        'status' => $row->status,
    
                        // hierarchy
                        'parent_title' => $row->parent_title,
                        'parent_type' => $row->parent_type,
    
                        'grand_parent_title' => $row->grand_parent_title,
                        'grand_parent_type' => $row->grand_parent_type,
    
                        'top_parent_title' => $row->top_parent_title,
                        'top_parent_type' => $row->top_parent_type,
    
                        // employees
                        'employees' => []
                    ];
                }
    
                // employee info
                if ($row->employee_name) {
    
                    $subtasks[$row->id]['employees'][] = [
    
                        'employee_name' => $row->employee_name,
                        'employee_id' => $row->employee_id,
    
                        'assignment_status' => $row->assignment_status,
                        'assigned_at' => $row->assigned_at,
    
                        // submission
                        'submission_file' => $row->submission_file,
                        'submission_remarks' => $row->submission_remarks,
                        'submitted_at' => $row->submitted_at
                    ];
                }
            }
    
            return response()->json([
                'status' => 1,
                'data' => array_values($subtasks)
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    
    
}