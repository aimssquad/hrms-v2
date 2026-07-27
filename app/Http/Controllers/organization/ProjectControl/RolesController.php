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

    public function roleStore(Request $request)
    {   //dd($request->all());
        //$project_id = decrypt($request->id);
        $email = Session::get("emp_email");

        if (empty($email)) {
            return redirect("/");
        }

        $emid = Session::get("emid");

        $validatedData = $request->validate([
            'name' => 'required',
        ]);

        // ✅ Check if role already exists for this emid
        $roleExists = ProjectRole::where('emid', $emid)
            ->where('name', $request->name)
            ->exists();

        if ($roleExists) {
            return redirect()->back()->with('error', 'Role already exists');
        }

        // Prepare data
        $validatedData['emid'] = $emid;
        $validatedData['name'] = $validatedData['name'];
        
        //dd($validatedData);
        ProjectRole::create($validatedData);

        return redirect('project-controll/rolles')->with('message', 'Project role added successfully');
    }

    public function roleEdit(Request $request, $role_id)
    {
        //dd('okk');
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
        //dd('okkk');
        //return view('employeer.task-management.project-controll.project-role-edit-form', compact('role', 'project_id'));
        return view('employeer.task-management.project-role-add', compact('role'));
    }
    
    public function roleList()
    {   //dd('okk');
        $email = Session::get("emp_email");
        if(empty($email)){
            return redirect("/");
        }
        $emid = Session::get("emid");
        $roles = ProjectRole::where('emid', $emid)->get();
        //dd($roles);
        return view('employeer.task-management.project-role', compact('roles'));
    }

    public function addRole()
    { 
        $email = Session::get("emp_email");
        if(empty($email)){
            return redirect("/");
        }
        //dd('kokkk');
        return view('employeer.task-management.project-role-add');

    }


    public function roleUpdate(Request $request, $id)
    {
        $email = Session::get("emp_email");

        if (empty($email)) {
            return redirect("/");
        }

        $emid = Session::get("emid");

        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
        ]);

        // Find the role
        $role = ProjectRole::where('id', $id)
            ->where('emid', $emid)
            ->firstOrFail();

        // Check duplicate name except current role
        $roleExists = ProjectRole::where('emid', $emid)
            ->where('name', $request->name)
            ->where('id', '!=', $id)
            ->exists();

        if ($roleExists) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Role already exists');
        }

        // Update
        $role->update([
            'name' => $validatedData['name'],
        ]);

        return redirect('project-controll/rolles')
            ->with('message', 'Project role updated successfully');
    }

    public function roleDelete($id)
    {
        $email = Session::get("emp_email");

        if (empty($email)) {
            return redirect("/");
        }

        $emid = Session::get("emid");
        $id = decrypt($id);

        $role = ProjectRole::where('id', $id)
            ->where('emid', $emid)
            ->first();

        if (!$role) {
            return redirect()->back()->with('error', 'Project role not found.');
        }

        $role->delete();

        return redirect('project-controll/rolles')
            ->with('message', 'Project role deleted successfully.');
    }



}
