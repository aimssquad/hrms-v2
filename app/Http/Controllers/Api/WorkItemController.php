<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskManagement\WorkItem;
use App\Helpers\PermissionHelper;
use DB;

class WorkItemController extends Controller
{
    public function projectDashboard()
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
            $emid = $currentUser->emid;

            $data = $this->projectSummaryData(
                $employeeId,
                $emid
            );

            return response()->json([

                'status' => 1,

                'message' => 'Dashboard Data',

                'data' => $data

            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'message'=> $e->getMessage()
            ], 500);
        }
    }

    private function projectSummaryData($employeeId, $emid)
    {
        $projects = DB::table('work_item_assignments as wa')

            ->join('work_items as wi', 'wi.id', '=', 'wa.work_item_id')

            ->join('projects as p', 'p.id', '=', 'wi.project_id')

            ->where('wa.employee_id', $employeeId)

            ->where('wa.emid', $emid)

            ->select(
                'p.id',
                'p.status',
                'p.project_end_date'
            )

            ->distinct()

            ->get();

        $today = now()->toDateString();

        $totalProjects = $projects->count();

        $activeProjects = $projects
            ->where('status', 'open')
            ->count();

        $completedProjects = $projects
            ->where('status', 'close')
            ->count();

        $overdueProjects = $projects
            ->filter(function ($project) use ($today) {

                return $project->status == 'open'
                    && !empty($project->project_end_date)
                    && $project->project_end_date < $today;

            })
            ->count();

        $projectIds = $projects->pluck('id');

        $teamMembers = DB::table('work_item_assignments as wa')

            ->join('work_items as wi', 'wi.id', '=', 'wa.work_item_id')

            ->whereIn('wi.project_id', $projectIds)

            ->where('wa.emid', $emid)

            ->distinct('wa.employee_id')

            ->count('wa.employee_id');    

        return [

            'total_projects'      => $totalProjects,

            'active_projects'     => $activeProjects,

            'completed_projects'  => $completedProjects,

            'overdue_projects'    => $overdueProjects,
            
            'team_members'       => $teamMembers,

        ];
    }

    // private function getDashboardData()
    // {
    //     $employeeId = auth()->user()->employee_id;
    //     $emid = auth()->user()->emid;

    //     return [

    //         'attendance'      => $this->attendanceData($employeeId, $emid),

    //         'leave_balance'   => $this->leaveBalanceData($employeeId, $emid),

    //         'project_summary' => $this->projectSummaryData($employeeId, $emid),

    //         'project_details' => $this->projectDetailsData($employeeId, $emid),

    //         'calendar'        => $this->getHolidayCalendarData(),
    //     ];
    // }


    //------------------------------------

    public function store(Request $request)
    {
        try {
            
             $currentUser = auth()->user();

            if (!$currentUser) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Authentication required'
                ], 401);
            }

            $employee_id = $currentUser->employee_id;
            $emid = $currentUser->emid;

            $request->validate([
                'project_id' => 'required|exists:projects,id',
                'type'       => 'required|in:module,submodule,task,subtask',
                'title'      => 'required|max:255',
                'parent_id'  => 'nullable|exists:work_items,id',
                'priority'   => 'required|in:low,medium,high',
                ///'created_by'=> 'nullable|exists:users,employee_id',
                'start_date' => 'nullable|date',
                'end_date'   => 'nullable|date|after_or_equal:start_date',
                'image' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx|max:10240',
                'file'       => 'nullable|file'
            ]);

            // check hierarchy rules
            if ($request->parent_id) {
                $parent = WorkItem::find($request->parent_id);

                if ($request->type === 'submodule' && $parent->type !== 'module') {
                    return response()->json(['error' => 'Submodule must be under module'], 400);
                }

                if ($request->type === 'task' && !in_array($parent->type, ['module','submodule'])) {
                    return response()->json(['error' => 'Task must be under module or submodule'], 400);
                }

                if ($request->type === 'subtask' && $parent->type !== 'task') {
                    return response()->json(['error' => 'Subtask must be under task'], 400);
                }
            }

            // File Upload
            $imagePath = null;
            $filePath  = null;

            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('work_items/images', 'public');
            }

            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('work_items/files', 'public');
            }
            
            $uniqueId = strtoupper($request->type)
                . '-'
                . str_pad(
                    WorkItem::count() + 1,
                    5,
                    '0',
                    STR_PAD_LEFT
                );

            // insert Data
            $data = WorkItem::create([
                'unique_id'=>$uniqueId,
                'project_id' => $request->project_id,
                'parent_id'  => $request->parent_id,
                'type'       => $request->type,
                'title'      => $request->title,
                'description'=> $request->description,
                'image'      => $imagePath,
                'priority'   => $request->priority,
                'file'       => $filePath,
                'start_date' => $request->start_date,
                'end_date'   => $request->end_date,
                'created_by'=> $employee_id,
                'status'     => 'open',
                'emid'       => $emid,
            ]);
            
            $currentRole = DB::table('work_item_user_roles')
                ->where('employee_id',$employee_id)
                ->where('project_id',$request->project_id)
                 ->where('emid', $emid)
                ->orderBy('id')
                ->first();
            // dd($currentRole);
            if ($currentRole) {
            
                $exists = DB::table('work_item_user_roles')
            
                    ->where('project_id', $request->project_id)
            
                    ->where('work_item_id', $data->id)
            
                    ->where('employee_id', $employee_id)
            
                    ->exists();
            
                if (!$exists) {
            
                    DB::table('work_item_user_roles')
            
                        ->insert([
            
                            'project_id'      => $request->project_id,
            
                            'work_item_id'    => $data->id,
            
                            'employee_id'     => $employee_id,
            
                            'project_role_id' => $currentRole->project_role_id,
            
                            'emid'            => $emid,
            
                            'created_by'      => $employee_id,
            
                            'created_at'      => now(),
            
                            'updated_at'      => now()
            
                        ]);
                }
            }

            return response()->json([
                'status' => 1,
                'message'=> 'Work item created successfully',
                'data'   => $data
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message'=> $e->getMessage()
            ], 500);
        }
    }
    
    public function getAllModule($projectId)
    {
       try {
            // Get all items of project
            $items = WorkItem::where('project_id', $projectId)
                ->where('type', 'module')
                ->orderBy('id', 'ASC')
                ->get();
    
    
            return response()->json([
                'status' => 1,
                'data'   => $items
            ]);
    
        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message'=> $e->getMessage()
            ]);
        } 
    }
    
    // project tree code start
    

    
    private function buildTree($items, $parentId = null)
    {
        //dd($items);
        $branch = [];
    
        foreach ($items as $item) {
    
            if ($item->parent_id == $parentId) {
    
                // recursive children
                $children = $this->buildTree($items, $item->id);
    
                // attach children
                $item->children = $children;
    
                $branch[] = $item;
            }
        }
    
        return $branch;
    }
    
 
    
    private function findItemInTree($items, $id)
    {
        foreach ($items as $item) {
    
            if ($item->id == $id) {
                return $item;
            }
    
            if (!empty($item->children)) {
    
                $found = $this->findItemInTree(
                    $item->children,
                    $id
                );
    
                if ($found) {
                    return $found;
                }
            }
        }
    
        return null;
    }

    private function getChildren($parentId, $projectId, $emid)
    {
        $children = WorkItem::where('project_id', $projectId)
            ->where('emid', $emid)
            ->where('parent_id', $parentId)
            ->orderBy('id')
            ->get();

        foreach ($children as $child) {
            $child->children = $this->getChildren(
                $child->id,
                $projectId,
                $emid
            );
        }

        return $children;
    }
    
   
    
    
    public function getProjectTree($projectId)
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
    
            $employeeId = $currentUser->employee_id;
    
            $emid = $currentUser->emid;
    
            /*
            |--------------------------------------------------------------------------
            | GET PROJECT
            |--------------------------------------------------------------------------
            */
    
            $project = DB::table('projects')
    
                ->where('id', $projectId)
    
                ->where('emid', $emid)
    
                ->first();
    
            if (!$project) {
    
                return response()->json([
    
                    'status' => 0,
    
                    'message' => 'Project not found'
                ]);
            }
    
            /*
            |--------------------------------------------------------------------------
            | GET USER ROLES
            |--------------------------------------------------------------------------
            */
    
            $userRoles = DB::table('work_item_user_roles as wur')
    
                ->leftJoin(
                    'project_roles as pr',
                    'pr.id',
                    '=',
                    'wur.project_role_id'
                )
    
                ->where('wur.employee_id', $employeeId)
    
                ->where('wur.project_id', $projectId)
    
                ->where('wur.emid', $emid)
    
                ->select(
    
                    'wur.*',
    
                    'pr.name as role_name'
                )
    
                ->get();
    
            /*
            |--------------------------------------------------------------------------
            | NO ACCESS
            |--------------------------------------------------------------------------
            */
    
            if ($userRoles->isEmpty()) {
    
                return response()->json([
    
                    'status' => 0,
    
                    'message' => 'Permission denied'
                ]);
            }
    
            /*
            |--------------------------------------------------------------------------
            | CURRENT USER ROLES
            |--------------------------------------------------------------------------
            */
    
            // $currentRoles = $userRoles->map(function ($role) {
    
            //     return [
    
            //         'role_id' => $role->project_role_id,
    
            //         'role_name' => $role->role_name,
    
            //         'work_item_id' => $role->work_item_id
            //     ];
            // });
    
            //dd($currentRoles);
            /*
            |--------------------------------------------------------------------------
            | GET ALL PROJECT ITEMS
            |--------------------------------------------------------------------------
            */
    
            $items = WorkItem::where('project_id', $projectId)
    
                ->where('emid', $emid)
    
                ->orderBy('id', 'ASC')
    
                ->get();

            $assignedItems = DB::table('work_item_assignments as wa')
                ->join('work_items as wi', 'wi.id', '=', 'wa.work_item_id')
                ->where('wa.employee_id', $employeeId)
                ->where('wa.emid', $emid)
                ->where('wi.project_id', $projectId)
                ->select('wi.*')
                ->get();
    
            //dd($items);
            /*
            |--------------------------------------------------------------------------
            | BUILD TREE
            |--------------------------------------------------------------------------
            */

            $response = [];

            foreach ($assignedItems as $item) {

                $item->children = $this->getChildren(
                    $item->id,
                    $projectId,
                    $emid
                );

                $response[] = $item;
            }
    
            //$tree = $this->buildTree($items);
            //dd($response);
            /*
            |--------------------------------------------------------------------------
            | PROJECT LEVEL ACCESS
            |--------------------------------------------------------------------------
            */
    
            $hasProjectLevelRole = $userRoles
    
                ->whereNull('work_item_id')
    
                ->count() > 0;
    
            /*
            |--------------------------------------------------------------------------
            | FULL PROJECT ACCESS
            |--------------------------------------------------------------------------
            */
    
            if ($hasProjectLevelRole) {
    
                return response()->json([
    
                    'status' => 1,
    
                    //'current_user_roles' => $currentRoles,
    
                    'data' => [
    
                        'project' => [
    
                            'id' => $project->id,
    
                            'name' => $project->title,
    
                            'modules' => $response
                        ]
                    ]
                ]);
            }
    
            
            $responseData = [];
            
            /*
            |--------------------------------------------------------------------------
            | GET ASSIGNED IDS
            |--------------------------------------------------------------------------
            */
            
            $assignedIds = $userRoles
            
                ->pluck('work_item_id')
            
                ->filter()
            
                ->unique()
            
                ->toArray();
            
            
            $topIds = [];
            
            
            /*
            |--------------------------------------------------------------------------
            | FIND TOP LEVEL ASSIGNED ITEMS
            |--------------------------------------------------------------------------
            */
            
            foreach ($assignedIds as $id) {
            
                $item = WorkItem::find($id);
            
                $hasParent = false;
            
                while ($item && $item->parent_id) {
            
                    if (
            
                        in_array(
            
                            $item->parent_id,
            
                            $assignedIds
            
                        )
            
                    ) {
            
                        $hasParent = true;
            
                        break;
                    }
            
                    $item = WorkItem::find(
            
                        $item->parent_id
            
                    );
                }
            
                if (!$hasParent) {
            
                    $topIds[] = $id;
                }
            }
            
            
            /*
            |--------------------------------------------------------------------------
            | ADD ONLY TOP LEVEL ITEMS
            |--------------------------------------------------------------------------
            */
            
            foreach ($topIds as $id) {
            
                $item = $this->findItemInTree(
            
                    $response,
            
                    $id
            
                );
            
                if ($item) {
            
                    $responseData[] = $item;
                }
            }
    
            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */
    
            return response()->json([
    
                'status' => 1,
    
                //'current_user_roles' => $currentRoles,
    
                'data' => $responseData
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
    
                'status' => 0,
    
                'message' => $e->getMessage()
    
            ], 500);
        }
    }
    
    // project tree code end
   
    
    // public function getChildren($parentId)
    // {
    //     $items = WorkItem::where('parent_id', $parentId)->get();
    
    //     return response()->json([
    //         'status' => 1,
    //         'data'   => $items
    //     ]);
    // }
    
    public function getEmployeeTasks($employeeId)
    {
        $tasks = WorkItem::where('created_by', $employeeId)
            ->whereIn('type', ['task','subtask'])
            ->get();
    
        return response()->json([
            'status' => 1,
            'data'   => $tasks
        ]);
    }
    
    
    
    public function getWorkItemDetails($id, $projectId)
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
    
            $emid = $currentUser->emid;
    
            $employeeId = $currentUser->employee_id;
    
            /*
            |--------------------------------------------------------------------------
            | MAIN ITEM
            |--------------------------------------------------------------------------
            */
    
            $item = WorkItem::where('id', $id)
    
                ->where('project_id', $projectId)
    
                ->where('emid', $emid)
    
                ->first();
                
                
    
            if (!$item) {
    
                return response()->json([
    
                    'status' => 0,
    
                    'message' => 'Item not found'
                ]);
            }
            
            $allItems = WorkItem::where(
                    'project_id',
                    $projectId
                )
                ->where(
                    'emid',
                    $emid
                )
                ->get();
            
            $parentIds = $this->getParentIds(
                $allItems,
                $id
            );
       
            $hasParentAccess = DB::table('work_item_user_roles')

                ->where('employee_id', $employeeId)
            
                ->where('project_id', $projectId)
            
                ->where('emid', $emid)
            
                ->whereIn(
                    'work_item_id',
                    $parentIds
                )
            
                ->exists();
                
                $hasGlobalAccess = DB::table('work_item_user_roles')

                ->where('employee_id', $employeeId)
            
                ->where('project_id', $projectId)
            
                ->where('emid', $emid)
            
                ->whereNull('work_item_id')
            
                ->exists();
              
        
             
    
            /*
            |--------------------------------------------------------------------------
            | CURRENT USER ROLES
            |--------------------------------------------------------------------------
            */
    
            $currentUserRoles = DB::table('work_item_user_roles as wur')
    
                ->leftJoin(
                    'project_roles as pr',
                    'pr.id',
                    '=',
                    'wur.project_role_id'
                )
    
                ->where('wur.employee_id', $employeeId)
    
                ->where('wur.project_id', $projectId)
    
                ->where('wur.emid', $emid)
    
               ->where(function ($query) use ($id, $parentIds) {

                    $query->whereNull('wur.work_item_id')
                
                        ->orWhere('wur.work_item_id', $id)
                
                        ->orWhereIn(
                            'wur.work_item_id',
                            $parentIds
                        );
                })
    
                ->select(
    
                    'wur.*',
    
                    'pr.name as role_name'
                )
    
                ->get();
    
            /*
            |--------------------------------------------------------------------------
            | NO ACCESS
            |--------------------------------------------------------------------------
            */
    
            if ($currentUserRoles->isEmpty()) {
    
                return response()->json([
    
                    'status' => 0,
    
                    'message' => 'Permission denied'
                ]);
            }
    
            /*
            |--------------------------------------------------------------------------
            | CURRENT USER PERMISSIONS
            |--------------------------------------------------------------------------
            */
    
            $currentPermissions = DB::table('work_item_user_roles as wur')
    
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
    
                ->join(
                    'project_roles as pr',
                    'pr.id',
                    '=',
                    'wur.project_role_id'
                )
    
                ->where('wur.employee_id', $employeeId)
    
                ->where('wur.project_id', $projectId)
    
                ->where('wur.emid', $emid)
    
                ->where(function ($query) use ($id, $parentIds) {

                    $query->whereNull('wur.work_item_id')
                
                        ->orWhere('wur.work_item_id', $id)
                
                        ->orWhereIn(
                            'wur.work_item_id',
                            $parentIds
                        );
                })
    
                /*
                |--------------------------------------------------------------------------
                | FILTER BY CURRENT ITEM TYPE
                |--------------------------------------------------------------------------
                */
    
                //->where('pp.group_name', $item->type)
    
                ->select(
    
                    'pr.id as role_id',
    
                    'pr.name as role_name',
    
                    'pp.id as permission_id',
    
                    'pp.name as permission_name',
    
                    'pp.group_name'
                )
    
                ->distinct()
    
                ->get();
                
                //dd($currentPermissions);
    
            /*
            |--------------------------------------------------------------------------
            | CHECK MANAGER / ADMIN
            |--------------------------------------------------------------------------
            */
    
            $canViewSubmission = $currentPermissions
                ->contains(function ($permission) {
            
                    return strtolower(
                        $permission->permission_name
                    ) == 'view_submission_all';
            
            });
            
            //dd($canViewSubmission);
    
            /*
            |--------------------------------------------------------------------------
            | EMPLOYEES
            |--------------------------------------------------------------------------
            */
            
            $allItems = WorkItem::where(
                    'project_id',
                    $projectId
                )
                ->where(
                    'emid',
                    $emid
                )
                ->get();
                
                $childIds = $this->getChildIds(
                    $allItems,
                    $id
                );
                
                $workItemIds = array_merge(
                    [$id],
                    $childIds
                );
            
            $employees = DB::table('work_item_user_roles as wur')

                ->leftJoin('users as u', function ($join) {
            
                    $join->on(
                        'u.employee_id',
                        '=',
                        'wur.employee_id'
                    );
            
                    $join->on(
                        'u.emid',
                        '=',
                        'wur.emid'
                    );
            
                })
                
                ->leftJoin(
            
                    'project_roles as pr',
            
                    'pr.id',
            
                    '=',
            
                    'wur.project_role_id'
            
                )
            
                ->leftJoin(
            
                    'work_item_assignments as wa',
            
                    function ($join) {
            
                        $join->on(
            
                            'wa.work_item_id',
            
                            '=',
            
                            'wur.work_item_id'
            
                        );
            
                        $join->on(
            
                            'wa.employee_id',
            
                            '=',
            
                            'wur.employee_id'
            
                        );
            
                        $join->on(
            
                            'wa.emid',
            
                            '=',
            
                            'wur.emid'
            
                        );
            
                    }
            
                )
            
                ->leftJoin(
            
                    'users as assigned',
            
                    function ($join) {
            
                        $join->on(
            
                            'assigned.employee_id',
            
                            '=',
            
                            'wa.assigned_by'
            
                        );
            
            
                        $join->on(
            
                            'assigned.emid',
            
                            '=',
            
                            'wa.emid'
            
                        );
            
                    }
            
                )
            
                ->where(
                
                    'wur.work_item_id',
                
                    $id
                
                )
                ->where(
            
                    'wur.project_id',
            
                    $projectId
            
                )
                ->where(
            
                    'wur.emid',
            
                    $emid
            
                )
                ->select(
            
            
                    'u.employee_id',
            
            
                    'u.name as employee_name',
            
            
                    'pr.name as role_name',
            
            
                    'wur.project_role_id',
            
            
                    'wur.work_item_id',
            
            
            
                    'wa.status',
            
            
                    'wa.assigned_at',
            
            
            
                    'wa.assigned_by',
            
            
            
                    'assigned.name as assigned_by_name'
            
            
                )
                ->distinct()
                ->get();
            
            // $employees = DB::table('work_item_assignments as wa')
            
            //     ->leftJoin('users as u', function($join){
            
            //         $join->on(
            //             'u.employee_id',
            //             '=',
            //             'wa.employee_id'
            //         );
            
            //         $join->on(
            //             'u.emid',
            //             '=',
            //             'wa.emid'
            //         );
            
            //     })
            
            //     ->leftJoin('users as assigner',function($join){
            
            //         $join->on(
            //             'assigner.employee_id',
            //             '=',
            //             'wa.assigned_by'
            //         );
            
            //         $join->on(
            //             'assigner.emid',
            //             '=',
            //             'wa.emid'
            //         );
            
            //     })
            
            //     ->leftJoin('work_item_user_roles as wur',function($join){
            
            //         $join->on(
            //             'wur.work_item_id',
            //             '=',
            //             'wa.work_item_id'
            //         );
            
            //         $join->on(
            //             'wur.employee_id',
            //             '=',
            //             'wa.employee_id'
            //         );
            
            //         $join->on(
            //             'wur.emid',
            //             '=',
            //             'wa.emid'
            //         );
            
            //     })
            
            //     ->leftJoin(
            //         'project_roles as pr',
            //         'pr.id',
            //         '=',
            //         'wur.project_role_id'
            //     )
            
            //     ->where(
            //         'wa.work_item_id',
            //         $id
            //     )
            
            //     ->where(
            //         'wa.emid',
            //         $emid
            //     )
            
            //     ->select(
            
            //         'u.employee_id',
            
            //         'u.name as employee_name',
            
            //         'pr.name as role_name',
            
            //         'wa.status',
            
            //         'wa.assigned_at',
            
            //         'wa.assigned_by',
            
            //         'assigner.name as assigned_by_name'
            
            //     )
            
            //     ->get();
    
            /*
            |--------------------------------------------------------------------------
            | SUBMISSION QUERY
            |--------------------------------------------------------------------------
            */
          
            $submissionQuery = DB::table('task_submissions as ts')
    
                ->leftJoin('users as u', function ($join) {
    
                    $join->on(
                        'u.employee_id',
                        '=',
                        'ts.employee_id'
                    );
    
                    $join->on(
                        'u.emid',
                        '=',
                        'ts.emid'
                    );
                })
    
                ->where('ts.work_item_id', $id)
    
                ->where('ts.emid', $emid);
    
            /*
            |--------------------------------------------------------------------------
            | MEMBER CAN SEE ONLY OWN SUBMISSION
            |--------------------------------------------------------------------------
            */
              $canViewAllSubmissions =
                $hasGlobalAccess
                ||
                $hasParentAccess
                ||
                $canViewSubmission;
          
            if (
                // !$hasParentAccess
                // &&
                !$canViewSubmission
            ) {
            
                $submissionQuery->where(
                    'ts.employee_id',
                    $employeeId
                );
            }
            
            //dd($canViewAllSubmissions);
    
            /*
            |--------------------------------------------------------------------------
            | GET SUBMISSIONS
            |--------------------------------------------------------------------------
            */
    
            /*
            |--------------------------------------------------------------------------
            | SUBMISSION QUERY
            |--------------------------------------------------------------------------
            */
            
            $submissionQuery = DB::table('task_submissions as ts')
            
                ->leftJoin('users as u', function ($join) {
            
                    $join->on(
                        'u.employee_id',
                        '=',
                        'ts.employee_id'
                    );
            
                    $join->on(
                        'u.emid',
                        '=',
                        'ts.emid'
                    );
                })
            
                ->where('ts.work_item_id', $id)
            
                ->where('ts.emid', $emid);
            
            /*
            |--------------------------------------------------------------------------
            | ONLY OWN SUBMISSION
            |--------------------------------------------------------------------------
            */
            
            if (!$canViewAllSubmissions) {
            
                $submissionQuery->where(
                    'ts.employee_id',
                    $employeeId
                );
            }
            
            /*
            |--------------------------------------------------------------------------
            | GET SUBMISSIONS
            |--------------------------------------------------------------------------
            */
            
            $submissions = $submissionQuery
            
                ->select(
            
                    'ts.id',
            
                    'ts.employee_id',
            
                    'u.name as employee_name',
            
                    'ts.file',
            
                    'ts.remarks',
            
                    'ts.submitted_at'
                )
            
                ->orderBy('ts.id', 'desc')
            
                ->get();
                
            //dd($submissionQuery);        
    
            /*
            |--------------------------------------------------------------------------
            | CURRENT USER ROLE LIST
            |--------------------------------------------------------------------------
            */
    
            $currentRoles = $currentUserRoles->map(function ($role) {
    
                return [
    
                    'role_id' => $role->project_role_id,
    
                    'role_name' => $role->role_name,
    
                    'work_item_id' => $role->work_item_id
                ];
            });
    
            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */
    
            return response()->json([
    
                'status' => 1,
    
                'data' => [
    
                    'details' => $item,
    
                    'employee_count' => $employees->count(),
    
                    'employees' => $employees,
    
                    'submissions' => $submissions,
    
                    'current_user_roles' => $currentRoles,
    
                    'current_user_permissions' => $currentPermissions
                ]
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
    
    private function getChildIds($allItems, $parentId)
    {
        $ids = [];
    
        foreach ($allItems as $item) {
    
            if ($item->parent_id == $parentId) {
    
                $ids[] = $item->id;
    
                $ids = array_merge(
                    $ids,
                    $this->getChildIds(
                        $allItems,
                        $item->id
                    )
                );
            }
        }
    
        return $ids;
    }
    

    
    // public function projectList()
    // {
    //     try {
    
    //         $currentUser = auth()->user();
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | AUTH CHECK
    //         |--------------------------------------------------------------------------
    //         */
    
    //         if (!$currentUser) {
    
    //             return response()->json([
    //                 'status' => 0,
    //                 'message' => 'Authentication required'
    //             ], 401);
    //         }
    
    //         $emid = $currentUser->emid;
    
    //         $employeeId = $currentUser->employee_id;
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | GET USER PROJECT ROLES
    //         |--------------------------------------------------------------------------
    //         */
    
    //         $projectRoles = DB::table('work_item_user_roles as wur')
    
    //             ->leftJoin(
    //                 'project_roles as pr',
    //                 'pr.id',
    //                 '=',
    //                 'wur.project_role_id'
    //             )
    
    //             ->where('wur.employee_id', $employeeId)
    
    //             ->where('wur.emid', $emid)
    
    //             ->select(
    
    //                 'wur.project_id',
    
    //                 'wur.project_role_id',
    
    //                 'pr.name as role_name'
    //             )
    
    //             ->groupBy(
    
    //                 'wur.project_id',
    
    //                 'wur.project_role_id',
    
    //                 'pr.name'
    //             )
    
    //             ->get();
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | PROJECT IDS
    //         |--------------------------------------------------------------------------
    //         */
    
    //         $projectIds = $projectRoles
    
    //             ->pluck('project_id')
    
    //             ->unique()
    
    //             ->toArray();
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | GET PROJECTS
    //         |--------------------------------------------------------------------------
    //         */

            
    
    //         $projects = DB::table('projects')
    
    //             ->whereIn('id', $projectIds)
    
    //             ->where('emid', $emid)
    
    //             ->orderBy('id', 'desc')
    
    //             ->get();

                
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | ATTACH ROLE + PERMISSION
    //         |--------------------------------------------------------------------------
    //         */

    
    //         $projects = $projects->map(function ($project) use ($projectRoles, $emid) {
    
    //             /*
    //             |--------------------------------------------------------------------------
    //             | ROLES OF THIS PROJECT
    //             |--------------------------------------------------------------------------
    //             */
    
    //             $roles = $projectRoles
    
    //                 ->where('project_id', $project->id)
    
    //                 ->values();
    
    //             /*
    //             |--------------------------------------------------------------------------
    //             | ATTACH PERMISSIONS
    //             |--------------------------------------------------------------------------
    //             */
    
    //             $roles = $roles->map(function ($role) use ($emid) {
    
    //             $permissions = DB::table('project_role_permissions as prp')

    //                 ->leftJoin(
    //                     'project_permissions as pp',
    //                     'pp.id',
    //                     '=',
    //                     'prp.project_permission_id'
    //                 )
                
    //                 ->where('prp.project_role_id', $role->project_role_id)
                
    //                 //->where('pp.group_name', 'project')
                
    //                 ->select(
                
    //                     'pp.id',
                
    //                     'pp.name',
                
    //                     'pp.group_name'
    //                 )
                
    //                 ->get();
    
    //                 return [
    
    //                     'project_role_id' => $role->project_role_id,
    
    //                     'role_name' => $role->role_name,
    
    //                     'permissions' => $permissions
    //                 ];
    //             });
    
    //             /*
    //             |--------------------------------------------------------------------------
    //             | FINAL PROJECT RESPONSE
    //             |--------------------------------------------------------------------------
    //             */
    
    //             return [
    
    //                 'project' => $project,
    //                 'roles' => $roles
    //             ];
    //         });
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | RESPONSE
    //         |--------------------------------------------------------------------------
    //         */
    
    //         return response()->json([
    
    //             'status' => 1,
    
    //             'data' => $projects
    //         ]);
    
    //     } catch (\Exception $e) {
    
    //         return response()->json([
    
    //             'status' => 0,
    
    //             'message' => $e->getMessage()
    
    //         ], 500);
    //     }
    // }

    public function projectList()
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

            $employeeId = $currentUser->employee_id;

            /*
            |--------------------------------------------------------------------------
            | USER PROJECT ROLES
            |--------------------------------------------------------------------------
            */

            $projectRoles = DB::table('work_item_user_roles as wur')

                ->leftJoin(
                    'project_roles as pr',
                    'pr.id',
                    '=',
                    'wur.project_role_id'
                )

                ->where('wur.employee_id', $employeeId)

                ->where('wur.emid', $emid)

                ->select(
                    'wur.project_id',
                    'wur.project_role_id',
                    'pr.name as role_name'
                )

                ->groupBy(
                    'wur.project_id',
                    'wur.project_role_id',
                    'pr.name'
                )

                ->get();

            /*
            |--------------------------------------------------------------------------
            | PROJECT IDS
            |--------------------------------------------------------------------------
            */

            $projectIds = $projectRoles

                ->pluck('project_id')

                ->unique()

                ->values()

                ->toArray();

            /*
            |--------------------------------------------------------------------------
            | PROJECTS
            |--------------------------------------------------------------------------
            */

            $projects = DB::table('projects')

                ->whereIn('id', $projectIds)

                ->where('emid', $emid)

                ->orderByDesc('id')

                ->get();

            /*
            |--------------------------------------------------------------------------
            | PROJECT PROGRESS (ONE QUERY)
            |--------------------------------------------------------------------------
            */

            $projectProgress = DB::table('work_item_assignments as wa')

                ->join(
                    'work_items as wi',
                    'wi.id',
                    '=',
                    'wa.work_item_id'
                )

                ->where('wa.employee_id', $employeeId)

                ->where('wa.emid', $emid)

                ->whereIn('wi.project_id', $projectIds)

                ->whereIn('wi.type', ['task', 'subtask'])

                ->select(

                    'wi.project_id',

                    DB::raw('COUNT(*) as total_tasks'),

                    DB::raw("
                        SUM(
                            CASE
                                WHEN wa.status='completed'
                                THEN 1
                                ELSE 0
                            END
                        ) as completed_tasks
                    ")

                )

                ->groupBy('wi.project_id')

                ->get()

                ->keyBy('project_id');

            /*
            |--------------------------------------------------------------------------
            | ATTACH ROLES + PERMISSIONS + PROGRESS
            |--------------------------------------------------------------------------
            */

            $projects = $projects->map(function ($project) use (

                $projectRoles,

                $projectProgress

            ) {

                $roles = $projectRoles

                    ->where('project_id', $project->id)

                    ->values()

                    ->map(function ($role) {

                        $permissions = DB::table('project_role_permissions as prp')

                            ->leftJoin(
                                'project_permissions as pp',
                                'pp.id',
                                '=',
                                'prp.project_permission_id'
                            )

                            ->where(
                                'prp.project_role_id',
                                $role->project_role_id
                            )

                            ->select(
                                'pp.id',
                                'pp.name',
                                'pp.group_name'
                            )

                            ->get();

                        return [

                            'project_role_id' => $role->project_role_id,

                            'role_name' => $role->role_name,

                            'permissions' => $permissions

                        ];
                    });

                /*
                |--------------------------------------------------------------------------
                | PROGRESS
                |--------------------------------------------------------------------------
                */

                $progressData = $projectProgress->get($project->id);

                $totalTasks = $progressData->total_tasks ?? 0;

                $completedTasks = $progressData->completed_tasks ?? 0;

                $pendingTasks = $totalTasks - $completedTasks;

                $progress = $totalTasks > 0

                    ? round(($completedTasks / $totalTasks) * 100)

                    : 0;

                return [

                    'project' => [

                        'id' => $project->id,

                        'title' => $project->title,

                        'description' => $project->description,

                        'status' => $project->status,

                        'priority' => $project->priority ?? null,

                        'project_start_date' => $project->project_start_date,

                        'project_end_date' => $project->project_end_date,

                        'progress' => $progress,

                        'completed_tasks' => $completedTasks,

                        'pending_tasks' => $pendingTasks,

                        'total_tasks' => $totalTasks,

                    ],

                    'roles' => $roles

                ];
            });

            return response()->json([

                'status' => 1,

                'data' => $projects

            ]);

        } catch (\Exception $e) {

            return response()->json([

                'status' => 0,

                'message' => $e->getMessage()

            ], 500);
        }
    }

    public function getProjectModuleSummary(Request $request, $projectId)
    {
        $currentUser = auth()->user();

        if (!$currentUser) {

            return response()->json([
                'status' => 0,
                'message' => 'Authentication required'
            ], 401);
        }

        $emid = $currentUser->emid;

        $employeeId = $currentUser->employee_id;

        $work_items = DB::table('work_item_assignments as wa')
            ->join('work_items as wi', 'wi.id', '=', 'wa.work_item_id')
            ->where('wi.project_id', $projectId)
            ->where('wi.emid', $emid)
            ->where('wa.employee_id', $employeeId)
            ->where('wa.emid', $emid)
            ->select(
                'wi.*',
                'wa.employee_id',
                'wa.status as assignment_status',
                'wa.assigned_by',
                'wa.assigned_at'
            )
            ->get();

        dd($work_items);    
        
    }

  
    
    
}
