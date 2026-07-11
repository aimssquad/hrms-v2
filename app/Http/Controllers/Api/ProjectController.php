<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskManagement\ProjectPermission;
use App\Models\TaskManagement\ProjectRole;
use App\Models\TaskManagement\ProjectRolePermission;
use App\Models\TaskManagement\ProjectMembers;
use App\Models\TaskManagement\Project;
use App\Models\TaskManagement\ProjectModule;
use App\Models\TaskManagement\ProjectModulePermission;
use Session;
use Illuminate\Support\Str;
use DB;
use Validator;
use Exception;
use Carbon\Carbon;

class ProjectController extends Controller
{
    
    public function allPermissions(Request $request)
    {
        try {

            $currentUser = auth()->user();

            if (!$currentUser) {
                return response()->json([
                    'status'=>0,
                    'message'=>'Authentication required'
                ],401);
            }

            $employee_id = $currentUser->employee_id;
            $emid = $currentUser->emid;

            $projects = DB::table('project_members as pm')
                ->join('projects as p','p.id','=','pm.project_id')
                ->join('project_roles as pr','pr.id','=','pm.role')

                ->leftJoin('project_role_permissions as prp', function($join) use($emid){
                    $join->on('prp.project_role_id','=','pm.role')
                        ->where('prp.emid',$emid);
                })

                ->leftJoin('project_permissions as pp', function($join) use($emid){
                    $join->on('pp.id','=','prp.project_permission_id')
                        ->where('pp.emid',$emid);
                })

                ->where('pm.user_id',$employee_id)
                ->where('pm.user_type','employee')
                ->where('p.status','open')

                ->select(
                    'p.id as project_id',
                    'p.title as project_name',
                    'p.description as project_description',
                    'p.status as project_status',
                    'pr.name as role_name',

                    DB::raw("
                        MAX(
                        CASE 
                            WHEN pp.name='view_module' 
                            THEN 1 ELSE 0 
                        END
                        ) as view_module
                    ")
                )

                ->groupBy(
                    'p.id',
                    'p.title',
                    'p.description',
                    'p.status',
                    'pr.name'
                )
                ->get();

            return response()->json([
                'status'=>1,
                'total_projects'=>count($projects),
                'projects'=>$projects
            ]);

        } catch(\Exception $e){

            return response()->json([
                'status'=>0,
                'message'=>$e->getMessage()
            ],500);
        }
    }

  
    public function getEmployeePermissions(Request $request)
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

            $permissions = DB::table('project_members as pm')

                ->join('project_roles as pr', 'pr.id', '=', 'pm.role')

                ->join('project_role_permissions as prp', function ($join) use ($emid) {
                    $join->on('prp.project_role_id', '=', 'pm.role')
                        ->where('prp.emid', $emid);
                })

                ->join('project_permissions as pp', function ($join) use ($emid) {
                    $join->on('pp.id', '=', 'prp.project_permission_id')
                        ->where('pp.emid', $emid);
                })

                ->where('pm.user_id', $employee_id)
                ->where('pm.user_type', 'employee')

                ->select(
                    'pm.project_id',
                    'pr.name as role_name',
                    'pp.name as permission_name'
                )

                ->get();

            return response()->json([
                'status' => 1,
                'total_permissions' => count($permissions),
                'permissions' => $permissions
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function allMembersForProject(Request $request, $userType)
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

            $user_type = $userType;

            if($user_type == 'employee') {
                $members = DB::table('employee')
                    ->where('emid', $emid) 
                    ->where('status', 'active')
                    //->where('verify_status', 'approved')
                    ->select('emp_code','emp_fname','emp_lname','emid')                  
                    ->get();
            } else {
                $members = DB::table('guests')
                    ->where('emid', $emid)
                    ->where('status', 1)
                    ->select('guest_id','name','email','emid','company_name','designation')
                    ->get();
            }

            return response()->json([
                'status' => 1,
                'members' => $members
            ]);


        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    //master Module
    public function allModules(Request $request, $projectId)
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

            $modules = DB::table('project_module_permission as pmp')
                ->join('project_module as pm', 'pm.id', '=', 'pmp.project_module_id')
                ->where('pmp.emid', $emid)
                ->where('pmp.employee_id', $employee_id)
                ->where('pm.project_id', $projectId)
                ->select(
                    'pm.id',
                    'pm.project_id',
                    'pm.module_name',
                    'pm.description',
                    'pm.order_by',
                    'pm.start_date',
                    'pm.end_date',
                    //'pm.created_by',
                    'pm.status',
                )
                ->orderBy('pm.order_by', 'asc')
                ->get();

            return response()->json([
                'status' => 1,
                'total_modules' => count($modules),
                'modules' => $modules
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }  

    // public function createModule(Request $request)
    // {
    //     try {

    //         $currentUser = auth()->user();

    //         if (!$currentUser) {
    //             return response()->json([
    //                 'status' => 0,
    //                 'message' => 'Authentication required'
    //             ], 401);
    //         }

    //         $employee_id = $currentUser->employee_id;
    //         $emid = $currentUser->emid;

    //         $validatedData = $request->validate([
    //             'project_id'   => 'required|exists:projects,id',
    //             'module_name'  => 'required|string|max:255',
    //             'description'  => 'nullable|string',
    //             'order_by'     => 'nullable|integer',
    //             'start_date'   => 'nullable|date',
    //             'end_date'     => 'nullable|date|after_or_equal:start_date',
    //             'status'       => 'required|in:pending,in_progress,completed'
    //         ]);

    //         $moduleId = DB::table('project_module')->create([
    //             'project_id'   => $validatedData['project_id'],
    //             'module_name'  => $validatedData['module_name'],
    //             'description'  => $validatedData['description'] ?? null,
    //             'order_by'     => $validatedData['order_by'] ?? null,
    //             'start_date'   => $validatedData['start_date'] ?? null,
    //             'end_date'     => $validatedData['end_date'] ?? null,
    //             'status'       => $validatedData['status'],
    //             'emid'         => $emid,
    //             'created_by'   => $employee_id,
    //             'created_at'   => Carbon::now(),
    //             'updated_at'   => Carbon::now()
    //         ]);

    //         DB::table('project_module_permission')->insert([
    //             'project_id'         => $validatedData['project_id'],
    //             'project_module_id'  => $moduleId['id'],
    //             'employee_id'        => $employee_id,
    //             'emid'               => $emid,
    //             'created_by'         => $employee_id,
    //             'created_at'         => Carbon::now(),
    //             'updated_at'         => Carbon::now()
    //         ]);

        
                
    //         return response()->json([
    //             'status' => 1,
    //             'message' => 'Module created successfully',
    //             'module_id' => $moduleId
    //         ]);

    //     } catch (\Exception $e) {

    //         return response()->json([
    //             'status' => 0,
    //             'message' => $e->getMessage()
    //         ], 500);
    //     }
    // }
    
    public function createModule(Request $request)
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
    
            $validatedData = $request->validate([
                'project_id'   => 'required|exists:projects,id',
                'module_name'  => 'required|string|max:255',
                'description'  => 'nullable|string',
                'order_by'     => 'nullable|integer',
                'start_date'   => 'nullable|date',
                'end_date'     => 'nullable|date|after_or_equal:start_date',
                'status'       => 'required|in:pending,in_progress,completed'
            ]);
    
            
            $moduleId = DB::table('project_module')->insertGetId([
                'project_id'   => $validatedData['project_id'],
                'module_name'  => $validatedData['module_name'],
                'description'  => $validatedData['description'] ?? null,
                'order_by'     => $validatedData['order_by'] ?? null,
                'start_date'   => $validatedData['start_date'] ?? null,
                'end_date'     => $validatedData['end_date'] ?? null,
                'status'       => $validatedData['status'],
                'emid'         => $emid,
                'created_by'   => $employee_id,
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now()
            ]);
    
            // Insert permission
            DB::table('project_module_permission')->insert([
                'project_id'         => $validatedData['project_id'],
                'project_module_id'  => $moduleId,
                'employee_id'        => $employee_id,
                'emid'               => $emid,
                'created_by'         => $employee_id,
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now()
            ]);
    
            // 
            $module = DB::table('project_module')
                ->where('id', $moduleId)
                ->select(
                    'id',
                    'project_id',
                    'module_name',
                    'description',
                    'order_by',
                    'start_date',
                    'end_date',
                    'status'
                )
                ->first();
    
            return response()->json([
                'status' => 1,
                'message' => 'Module created successfully',
                'data' => $module
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function editModule(Request $request, $moduleId)
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

            $module = DB::table('project_module')
                ->where('id', $moduleId)
                ->first();

            if (!$module) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Module not found'
                ], 404);
            }

            return response()->json([
                'status' => 1,
                'module' => $module
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function updateModule(Request $request, $moduleId)
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

            $validatedData = $request->validate([
                'module_name'  => 'required|string|max:255',
                'description'  => 'nullable|string',
                'order_by'     => 'nullable|integer',
                'start_date'   => 'nullable|date',
                'end_date'     => 'nullable|date|after_or_equal:start_date',
                'status'       => 'required|in:pending,in_progress,completed'
            ]);

            $updated = DB::table('project_module')
                ->where('id', $moduleId)
                ->update([
                    'module_name'  => $validatedData['module_name'],
                    'description'  => $validatedData['description'] ?? null,
                    'order_by'     => $validatedData['order_by'] ?? null,
                    'start_date'   => $validatedData['start_date'] ?? null,
                    'end_date'     => $validatedData['end_date'] ?? null,
                    'status'       => $validatedData['status'],
                    'updated_at'   => Carbon::now()
                ]);

            if ($updated) {
                return response()->json([
                    'status' => 1,
                    'message' => 'Module updated successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => 'No changes made or module not found'
                ], 404);
            }

        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function deleteModule(Request $request, $moduleId,$projectId)
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
            $isModuleExistinPermission = ProjectModulePermission::where('project_module_id', $moduleId)->where('emid', $emid)->where('project_id', $projectId)->delete();
          

            $deleted = DB::table('project_module')
                ->where('id', $moduleId)
                ->where('project_id', $projectId)
                ->where('emid', $emid)
                ->delete();

            if ($deleted) {
                return response()->json([
                    'status' => 1,
                    'message' => 'Module deleted successfully'
                ]);
            } else {
                return response()->json([
                    'status' => 0,
                    'message' => 'Module not found'
                ], 404);
            }

        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);    
        }
    }    
    
        
    // Module Permission to employee or guest 

    public function projectModulePermissionList(Request $request, $moduleId)
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

            $permissions = DB::table('project_module_permission as pmp')
                ->join('project_module as pm', 'pm.id', '=', 'pmp.project_module_id')
                ->join('users as u', 'u.employee_id', '=', 'pmp.employee_id') // ✅ FIX
                ->where('pmp.project_module_id', $moduleId)
                ->where('pmp.emid', $emid)
                ->where(function ($query) use ($emid) {
                    $query->where('u.emid', $emid)
                          ->orWhereNull('u.emid'); // ✅ allow NULL
                })
                ->select(
                    'pmp.id',
                    'pmp.project_id',
                    'pmp.project_module_id',
                    'pmp.employee_id',
                    'u.name as employee_name', // ✅ employee name
                    'pm.module_name',
                    'pm.description',
                    'pm.start_date',
                    'pm.end_date',
                    'pm.status'
                )
                ->get();

            return response()->json([
                'status' => 1,
                'total_permissions' => count($permissions),
                'permissions' => $permissions
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function projectModulePermissionAdd(Request $request)
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

            // Validation for array
            $validatedData = $request->validate([
                'project_id'         => 'required|exists:projects,id',
                'project_module_id'  => 'required|exists:project_module,id',
                'employee_id'        => 'required|array',
                'employee_id.*'      => 'required|exists:users,employee_id',
            ]);

            $insertData = [];

            foreach ($validatedData['employee_id'] as $empId) {

                // Check duplicate per employee
                $exists = ProjectModulePermission::where('project_id', $validatedData['project_id'])
                    ->where('project_module_id', $validatedData['project_module_id'])
                    ->where('employee_id', $empId)
                    ->where('emid', $emid)
                    ->exists();

                if (!$exists) {
                    $insertData[] = [
                        'project_id'         => $validatedData['project_id'],
                        'project_module_id'  => $validatedData['project_module_id'],
                        'employee_id'        => $empId,
                        'emid'               => $emid,
                        'created_by'         => $employee_id,
                        'created_at'         => Carbon::now(),
                        'updated_at'         => Carbon::now(),
                    ];
                }
            }

            // Bulk insert
            if (!empty($insertData)) {
                ProjectModulePermission::insert($insertData);
            }

            return response()->json([
                'status' => 1,
                'message' => 'Module permission assigned successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function projectModulePermissionEdit(Request $request, $permissionId)
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

            // $permission = ProjectModulePermission::where('id', $permissionId)->where('emid', $emid)->first();
            $permission = DB::table('project_module_permission as pmp')
                ->join('project_module as pm', 'pm.id', '=', 'pmp.project_module_id')
                ->leftJoin('users as u', 'u.employee_id', '=', 'pmp.employee_id') // left join because emid can be null
                ->where('pmp.id', $permissionId)
                ->where('pmp.emid', $emid)
                ->where(function ($query) use ($emid) {
                    $query->where('u.emid', $emid)
                          ->orWhereNull('u.emid'); // ✅ allow NULL
                })
                ->select(
                    'pmp.id',
                    'pmp.project_id',
                    'pmp.project_module_id',
                    'pmp.employee_id',
                    'pm.module_name',
                    'u.name as employee_name',
                    'pm.description',
                    'pm.start_date',
                    'pm.end_date',
                    'pm.status'
                )
                ->first();

            if (!$permission) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Permission not found'
                ], 404);
            }

            return response()->json([
                'status' => 1,
                'permission' => $permission
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function projectModulePermissionUpdate(Request $request, $permissionId)
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

            $validatedData = $request->validate([
                'project_id'         => 'required|exists:projects,id',
                'project_module_id'  => 'required|exists:project_module,id',
                'employee_id'        => 'required|exists:users,employee_id',
            ]);

            $permission = ProjectModulePermission::where('id', $permissionId)->where('emid', $emid)->first();

            if (!$permission) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Permission not found'
                ], 404);
            }

            // Check for duplicate
            $exists = ProjectModulePermission::where('project_id', $validatedData['project_id'])
                ->where('project_module_id', $validatedData['project_module_id'])
                ->where('employee_id', $validatedData['employee_id'])
                ->where('emid', $emid)
                ->where('id', '!=', $permissionId)
                ->exists();

            if ($exists) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Permission already exists for this employee'
                ], 409);
            }

            $permission->project_id = $validatedData['project_id'];
            $permission->project_module_id = $validatedData['project_module_id'];
            $permission->employee_id = $validatedData['employee_id'];
            $permission->updated_at = Carbon::now();
            $permission->save();

            return response()->json([
                'status' => 1,
                'message' => 'Module permission updated successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function projectModulePermissionDelete(Request $request, $permissionId)
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

            $permission = ProjectModulePermission::where('id', $permissionId)->where('emid', $emid)->first();

            if (!$permission) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Permission not found'
                ], 404);
            }

            $permission->delete();

            return response()->json([
                'status' => 1,
                'message' => 'Module permission deleted successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }

    }   

    // role master in project

    public function roleList(){
        $currentUser = auth()->user();

        if (!$currentUser) {
            return response()->json([
                'status' => 0,
                'message' => 'Authentication required'
            ], 401);
        }

        $employee_id = $currentUser->employee_id;
        $emid = $currentUser->emid;

        $roles = ProjectRole::where('emid', $emid)->get();
        if(empty($roles)){
            return response()->json([
                'status' => 0,
                'message' => 'No roles found'
            ], 404);
        }
        return response()->json([
            'status' => 1,
            'roles' => $roles
        ]);
    }

    public function createRole(Request $request){
        $currentUser = auth()->user();

        if (!$currentUser) {
            return response()->json([
                'status' => 0,
                'message' => 'Authentication required'
            ], 401);
        }

        $employee_id = $currentUser->employee_id;
        $emid = $currentUser->emid;

        $validatedData = $request->validate([
            'role_name' => 'required|string|max:255',
        ]);

        // Check if role already exists for this emid
        $roleExists = ProjectRole::where('emid', $emid)
            ->where('name', $validatedData['role_name'])
            ->exists();

        if ($roleExists) {
            return response()->json([
                'status' => 0,
                'message' => 'Role already exists'
            ], 409);
        }

        $newRole = new ProjectRole();
        $newRole->emid = $emid;
        $newRole->name = $validatedData['role_name'];
        $newRole->save();

        return response()->json([
            'status' => 1,
            'message' => 'Project role added successfully',
            'role' => $newRole
        ]);
    }

    public function editRole(Request $request, $roleId){
        $currentUser = auth()->user();

        if (!$currentUser) {
            return response()->json([
                'status' => 0,
                'message' => 'Authentication required'
            ], 401);
        }

        $employee_id = $currentUser->employee_id;
        $emid = $currentUser->emid;

        $role = ProjectRole::where('emid', $emid)->where('id', $roleId)->first();

        if (!$role) {
            return response()->json([
                'status' => 0,
                'message' => 'Role not found'
            ], 404);
        }

        return response()->json([
            'status' => 1,
            'role' => $role
        ]);
    }

    public function updateRole(Request $request, $roleId){
        $currentUser = auth()->user();

        if (!$currentUser) {
            return response()->json([
                'status' => 0,
                'message' => 'Authentication required'
            ], 401);
        }

        $employee_id = $currentUser->employee_id;
        $emid = $currentUser->emid;

        $validatedData = $request->validate([
            'role_name' => 'required|string|max:255',
        ]);

        // Check if role already exists for this emid
        $roleExists = ProjectRole::where('emid', $emid)
            ->where('name', $validatedData['role_name'])
            ->where('id', '!=', $roleId)
            ->exists();

        if ($roleExists) {
            return response()->json([
                'status' => 0,
                'message' => 'Role already exists'
            ], 409);
        }

        $role = ProjectRole::where('emid', $emid)->where('id', $roleId)->first();

        if (!$role) {
            return response()->json([
                'status' => 0,
                'message' => 'Role not found'
            ], 404);
        }

        $role->name = $validatedData['role_name'];
        $role->save();

        return response()->json([
            'status' => 1,
            'message' => 'Project role updated successfully',
            'role' => $role
        ]);
    }    

    public function deleteRole(Request $request, $roleId){
        $currentUser = auth()->user();

        if (!$currentUser) {
            return response()->json([
                'status' => 0,
                'message' => 'Authentication required'
            ], 401);
        }

        $employee_id = $currentUser->employee_id;
        $emid = $currentUser->emid;

        $role = ProjectRole::where('emid', $emid)->where('id', $roleId)->first();

        if (!$role) {
            return response()->json([
                'status' => 0,
                'message' => 'Role not found'
            ], 404);
        }

        // Check if any members are assigned to this role
        $membersWithRole = ProjectMembers::where('role', $roleId)->exists();

        if ($membersWithRole) {
            return response()->json([
                'status' => 0,
                'message' => 'Cannot delete role already assigned to members'
            ], 400);
        }

        // Delete associated permissions
        ProjectRolePermission::where('project_role_id', $roleId)->where('emid',$emid)->delete();

        // Delete the role
        $role->delete();

        return response()->json([
            'status' => 1,
            'message' => 'Project role deleted successfully'
        ]);
    }    


    // employee project role 
    public function projectStore(Request $request)
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
        
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'identifier' => 'nullable',
            'project_start_date' => 'nullable|date',
            'project_end_date' => 'nullable|date',
        ]);
        
        $projectRoles = DB::table('project_role_permissions')
            ->select('project_role_id')
            ->whereIn('project_permission_id', [1, 2, 3])
            ->where('emid', $emid)
            ->groupBy('project_role_id')
            //->havingRaw('COUNT(DISTINCT project_permission_id) = 3')
            ->get();
        //dd($projectRoles[0]->project_role_id);        
        
        if (!$projectRoles) {

            return response()->json([

                'status' => 0,

                'message' => 'employee permission not found not found'
            ]);
        }

        $project = Project::create([
            'title' => $request->title,
            'emid' => $emid,
            'description' => $request->description,
            'identifier' => $request->identifier,
            'createdBy' => $employeeId,
            'status' => 'open',
            'project_start_date' => $request->project_start_date,
            'project_end_date' => $request->project_end_date,
        ]);
        
        
        
        DB::table('work_item_user_roles')->insert([
            'project_id'=>$project->id,
            'project_role_id'=> $projectRoles[0]->project_role_id,
            'employee_id'=> $employeeId,
            'created_by'=> $employeeId,
            'emid'=> $emid
            ]);

        return response()->json([
            'success' => 1,
            'message' => 'Project created successfully',
            'data' => $project
        ], 201);
    }
    
    
    public function editProject($id)
    {
        $currentUser = auth()->user();
    
        if (!$currentUser) {
    
            return response()->json([
                'status' => 0,
                'message' => 'Authentication required'
            ], 401);
        }
    
        $project = Project::find($id);
    
        if (!$project) {
    
            return response()->json([
                'status' => 0,
                'message' => 'Project not found'
            ], 404);
        }
    
        return response()->json([
            'status' => 1,
            'message' => 'Project details',
            'data' => $project
        ]);
    }
    
    public function updateProject(Request $request, $id)
    {
        $currentUser = auth()->user();
    
        if (!$currentUser) {
    
            return response()->json([
                'status' => 0,
                'message' => 'Authentication required'
            ], 401);
        }
    
        $project = Project::find($id);
    
        if (!$project) {
    
            return response()->json([
                'status' => 0,
                'message' => 'Project not found'
            ], 404);
        }
    
        $request->validate([
            'title' => 'required',
            'description' => 'nullable',
            'identifier' => 'nullable',
            'project_start_date' => 'nullable|date',
            'project_end_date' => 'nullable|date',
            'status' => 'nullable'
        ]);
    
        $project->update([
    
            'title' => $request->title,
            'description' => $request->description,
            'identifier' => $request->identifier,
            'project_start_date' => $request->project_start_date,
            'project_end_date' => $request->project_end_date,
            'status' => $request->status ?? $project->status,
        ]);
    
        return response()->json([
            'status' => 1,
            'message' => 'Project updated successfully',
            'data' => $project
        ]);
    }
    
    
    
    public function masterPermissionList()
    {
        $currentUser = auth()->user();

        if (!$currentUser) {

            return response()->json([
                'status' => 0,
                'message' => 'Authentication required'
            ], 401);
        }
        
        $permissionMaster = DB::table('project_permissions')->get();
        
        if(!$permissionMaster){
            return response()->json([
                'status' => 0,
                'message' => 'Authentication required'
            ], 401); 
        }
        
        return response()->json([
                'status' => 1,
                'data' => $permissionMaster,
                ], 200);
    }

    
    public function getRolePermissions($roleId)
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
            $role = DB::table('project_roles')
    
                ->where('id', $roleId)
    
                ->where('emid', $emid)
    
                ->first();
                
                //dd($role);
    
            if (!$role) {
    
                return response()->json([
    
                    'status' => 0,
    
                    'message' => 'Role not found'
                ]);
            }
    
            $permissions = DB::table('project_role_permissions as prp')
    
                ->join(
                    'project_permissions as pp',
                    'pp.id',
                    '=',
                    'prp.project_permission_id'
                )
    
                ->where('prp.project_role_id', $roleId)
    
                ->where('prp.emid', $emid)
    
                ->select(
    
                    'pp.id',
    
                    'pp.name',
    
                    'pp.group_name'
                )
    
                ->orderBy('pp.id')
    
                ->get();
    
                //->groupBy('group_name');
   
    
            return response()->json([
    
                'status' => 1,
    
                'data' => [
    
                    'role' => $role,
    
                    'permissions' => $permissions
                ]
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
    
                'status' => 0,
    
                'message' => $e->getMessage()
    
            ], 500);
        }
    }
    
    
    public function createUpdateRolePermissions(Request $request)
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
  
            $request->validate([
    
                'project_role_id' => 'required|exists:project_roles,id',
    
                'permission_ids' => 'required|array',
    
                'permission_ids.*' => 'exists:project_permissions,id'
            ]);
    
            /*
            |--------------------------------------------------------------------------
            | CHECK ROLE
            |--------------------------------------------------------------------------
            */
    
            $role = DB::table('project_roles')
    
                ->where('id', $request->project_role_id)
    
                ->where('emid', $emid)
    
                ->first();
    
            if (!$role) {
    
                return response()->json([
    
                    'status' => 0,
    
                    'message' => 'Role not found'
                ]);
            }

    
            DB::table('project_role_permissions')
    
                ->where('project_role_id', $request->project_role_id)
    
                ->where('emid', $emid)
    
                ->delete();
    
    
            $insertData = [];
    
            foreach ($request->permission_ids as $permissionId) {
    
                $insertData[] = [
    
                    'project_role_id' => $request->project_role_id,
    
                    'project_permission_id' => $permissionId,
    
                    'emid' => $emid,
    
                    'created_by' => $employeeId,
    
                    'created_at' => now(),
    
                    'updated_at' => now()
                ];
            }
    
            DB::table('project_role_permissions')
    
                ->insert($insertData);
    
            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */
    
            return response()->json([
    
                'status' => 1,
    
                'message' => 'Role permissions updated successfully'
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
    
                'status' => 0,
    
                'message' => $e->getMessage()
    
            ], 500);
        }
    }
        
}
