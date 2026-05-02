<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskManagement\ProjectPermission;
use App\Models\TaskManagement\ProjectRole;
use App\Models\TaskManagement\ProjectRolePermission;
use App\Models\TaskManagement\ProjectMembers;
use App\Models\TaskManagement\Project;
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
                    ->where('emp_code', $emid) 
                    ->where('status', 'active')
                    ->where('verify_status', 'approved')
                    ->select('emp_code','emp_fname','emp_lname','emid')                  
                    ->get();
            } else {
                $members = DB::table('guests')
                    ->where('emid', $emid)
                    ->where('status', 1)
                    ->select('guest_id','name','email','emid','cmpany_name','designation')
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

            DB::table('project_module_permission')->insert([
                'project_id'         => $validatedData['project_id'],
                'project_module_id'  => $moduleId,
                'employee_id'        => $employee_id,
                'emid'               => $emid,
                'created_by'         => $employee_id,
                'created_at'         => Carbon::now(),
                'updated_at'         => Carbon::now()
            ]);

            return response()->json([
                'status' => 1,
                'message' => 'Module created successfully',
                'module_id' => $moduleId
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
            $isModuleExistinPermission = ProjectModulePermission::where('project_module_id', $moduleId)->where('emid', $emid)->where('project_id', $projectId)->first();
            if ($isModuleExistinPermission) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Cannot delete module allready assigned to members'
                ], 400);
            }

            $deleted = DB::table('project_module')
                ->where('id', $moduleId)
                ->where('project_id', $projectId)
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

    
}
