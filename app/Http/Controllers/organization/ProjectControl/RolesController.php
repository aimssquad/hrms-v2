<?php

namespace App\Http\Controllers\organization\ProjectControl;

use App\Http\Controllers\Controller;
use App\Models\TaskManagement\MasterRoles;
use App\Models\TaskManagement\ProjectPermission;
use App\Models\TaskManagement\ProjectRole;
use App\Models\TaskManagement\ProjectRolePermission;
use Illuminate\Http\Request;
use Session;

class RolesController extends Controller
{
    public function index(Request $request)
    {   
        
        $project_id = decrypt($request->id);
        $email = Session::get("emp_email");
        if(empty($email)){
            return redirect("/");
        }
        $emid = Session::get("emid");
        $roles = ProjectRole::where('emid', $emid)->get();
        return view('employeer.task-management.project-controll.project-roles-list', compact('roles', 'project_id')); 
    }

    public function store(Request $request)
    {   //dd($request->all());
        $project_id = decrypt($request->id);
        $email = Session::get("emp_email");

        if (empty($email)) {
            return redirect("/");
        }

        $emid = Session::get("emid");

        $validatedData = $request->validate([
            'role_name' => 'required',
        ]);

        // ✅ Check if role already exists for this emid
        $roleExists = ProjectRole::where('emid', $emid)
            ->where('name', $request->role_name)
            ->exists();

        if ($roleExists) {
            return redirect()->back()->with('error', 'Role already exists');
        }

        // Prepare data
        $validatedData['emid'] = $emid;
        $validatedData['name'] = $validatedData['role_name'];
        unset($validatedData['role_name']);

        ProjectRole::create($validatedData);

        return redirect()->back()->with('message', 'Project role added successfully');
    }

    public function edit(Request $request, $role_id)
    {
        dd('okk');
        $project_id = decrypt($request->id);
        $email = Session::get("emp_email");

        if (empty($email)) {
            return redirect("/");
        }

        $emid = Session::get("emid");
        $role = ProjectRole::where('emid', $emid)->where('id', decrypt($role_id))->first();

        if (!$role) {
            return redirect()->back()->with('error', 'Role not found');
        }

        return view('employeer.task-management.project-controll.project-role-edit-form', compact('role', 'project_id'));
    }



}
