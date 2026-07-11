<?php

namespace App\Http\Controllers\organization\ProjectControl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskManagement\MasterRoles;
use App\Models\TaskManagement\ProjectPermission;
use App\Models\TaskManagement\ProjectRole;
use App\Models\TaskManagement\ProjectRolePermission;
use Session;
use Illuminate\Support\Str;
use DB;

class ProjectPermissionController extends Controller
{
    public function index(Request $request)
    {   
        $project_id = decrypt($request->id);
        $email = Session::get("emp_email");
        if(empty($email)){
            return redirect("/");
        }
        $emid = Session::get("emid");
        $permissions = ProjectPermission::where('emid', $emid)->get();
        //dd($permissions);
        return view('employeer.task-management.project-controll.ppm-list', compact('permissions', 'project_id')); 
    }

    public function save(Request $request)
    {
        $project_id = decrypt($request->id);
        $email = Session::get("emp_email");

        if (empty($email)) {
            return redirect("/");
        }
        $emid = Session::get("emid");
        $validatedData = $request->validate([
            'role_name' => 'required|string|max:255',
        ]);

        $formattedName = Str::of($validatedData['role_name'])
            ->replace(' ', '_')
            ->lower();

        // Check duplicate
        $permissionExists = ProjectPermission::where('emid', $emid)
            ->where('name', $formattedName)
            ->exists();

        if ($permissionExists) {
            return redirect()->back()->with('error', 'Permission already exists');
        }

        ProjectPermission::create([
            'emid' => $emid,
            'name' => $formattedName,
        ]);

        return redirect()->back()->with('message', 'Project permission added successfully');
    }

    public function update (Request $request, $role_id,$permission_id)
    {
        $project_id = decrypt($request->id);

        $email = Session::get("emp_email");
     
        if (empty($email)) {
            return redirect("/");
        }
        $emid = Session::get("emid");
        $validatedData = $request->validate([
            'role_name' => 'required|string|max:255',
        ]);

        $formattedName = Str::of($validatedData['role_name'])
            ->replace(' ', '_')
            ->lower();
        
        // Check duplicate
        $permissionExists = ProjectPermission::where('emid', $emid)
            ->where('name', $formattedName)
            ->where('id', '!=', $permission_id)
            ->exists();

        if ($permissionExists) {
            return redirect()->back()->with('error', 'Permission already exists');
        }

        $permission = ProjectPermission::findOrFail($permission_id);

        $permission->update([
            'name' => $formattedName,
        ]);

        return redirect()->back()->with('message', 'Project permission updated successfully');
    }


    public function rolePermissionView()
    {
        $roles = DB::table('project_roles')->get();

        $permissions = DB::table('project_permissions')->get();

        $assignedPermissions = DB::table('project_role_permissions')
            ->pluck('project_permission_id', 'project_role_id')
            ->groupBy(function ($value, $key) {
                return $key;
            });

        return view(
            'employeer.task-management.project-controll.role_permission',
            compact('roles','permissions','assignedPermissions')
        );
    }



    public function rolePermissionList()
    {
        $emid = Session::get('emid');
        $email = Session::get("emp_email");
        if(empty($email)){
            return redirect('/');
        }
        
        $roles = DB::table('project_roles')->where('emid', $emid)->get();

        $permissions = DB::table('project_permissions')->get();

        $rolePermissions = DB::table('project_role_permissions as rp')
            ->join('project_permissions as p','p.id','=','rp.project_permission_id')
            ->where('rp.emid', $emid)
            //->where('p.emid', $emid)
            ->select(
                'rp.project_role_id',
                'p.id as permission_id',
                'p.name'
            )
            ->get()
            ->groupBy('project_role_id');
        //dd($rolePermissions);
        return view(
            'employeer.task-management.project-controll.role-permission-list',
            compact(
                'roles',
                'permissions',
                'rolePermissions'
            )
        );
    }

    public function assignPermissionToRole(Request $request)
    {
        $project_id = decrypt($request->id);
        $email = Session::get("emp_email");
        if (empty($email)) {
            return redirect("/");
        }
        $emid = Session::get("emid");
        $user = DB::table('users')->where('email', $email)->first();
        $createdBy = $user->employee_id;

        //dd($createdBy);
        $validatedData = $request->validate([
            'role_id' => 'required|exists:project_roles,id',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:project_permissions,id',
        ]);
        
        $roleId = $validatedData['role_id'];
        $permissionIds = $validatedData['permissions'];
        //dd($validatedData);
        // Remove existing permissions for the role
        ProjectRolePermission::where('project_role_id', $roleId)->delete();

        // Assign new permissions to the role
        foreach ($permissionIds as $permissionId) {
            ProjectRolePermission::create([
                //'project_id' => $project_id,
                'project_role_id' => $roleId,
                'project_permission_id' => $permissionId,
                'emid' => $emid,
                'created_by' => $createdBy,
            ]);
        }

        return redirect()->back()->with('message', 'Permissions assigned to role successfully');
    }


    public function editPermissions($id, $roleId)
    {
        $email = Session::get('emp_email');
       
        if(empty($email)){
            Session::flash('error','Unauthorized access');
            return redirect('/');
        }
        
        $emid = Session::get('emid');
        
        $project_id = decrypt($id);

        $role = DB::table('project_roles')
                    ->where('emid', $emid)
                    ->where('id',$roleId)
                    ->first();

        $permissions = DB::table('project_role_permissions')
            ->where('project_role_id',$roleId)
            ->where('emid', $emid)
            ->pluck('project_permission_id')
            ->toArray();

        $allPermissions = DB::table('project_permissions')->get();
        //dd($role, $permissions, $allPermissions);
        return view(
            'employeer.task-management.project-controll.edit-role-permission',
            compact(
                'project_id',
                'roleId',
                'role',
                'permissions',
                'allPermissions'
            )
        );
    }

    public function updatePermissions(Request $request, $id)
    {
        $project_id = decrypt($id);

        $email = Session::get("emp_email");
        if(empty($email)){
            return redirect('/');
        }

        $emid = Session::get("emid");

        $user = DB::table('users')
                    ->where('email',$email)
                    ->first();

        $createdBy = $user->employee_id;

        $request->validate([
            'role_id' => 'required|exists:project_roles,id',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:project_permissions,id',
        ]);

        $roleId = $request->role_id;

        // remove old permissions for this role + project
        ProjectRolePermission::where('project_role_id',$roleId)
            //->where('project_id',$project_id)
            ->where('emid', $emid)
            ->delete();

        //dd($request->permissions);
        foreach($request->permissions as $permission){

            ProjectRolePermission::create([
                //'project_id' => $project_id,
                'project_role_id' => $roleId,
                'project_permission_id' => $permission,
                'emid' => $emid,
                'created_by' => $createdBy,
            ]);
        }

        return back()->with('success','Updated Successfully');
    }

    public function deletePermissions($id, $roleId)
    {
        $project_id = decrypt($id);
        $emid = Session::get("emid");
        $email = Session::get("emp_email");
        if(empty($email)){
            return redirect('/');
        }

        // remove old permissions for this role + project
        ProjectRolePermission::where('project_role_id',$roleId)
            ->where('project_id',$project_id)
            ->where('emid', $emid)
            ->delete();

        return back()->with('success','Deleted Successfully');
    }





}
