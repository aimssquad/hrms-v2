<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\TaskManagement\WorkItem;
use App\Models\TaskManagement\WorkItemPermission;

// notificaition model
use App\Models\EmpNotification;
use App\Models\EmpNotificationSetting;
use App\Models\EmpNotificationModule;
use App\Services\FirebaseService;

class WorkItemPermissionController extends Controller
{

 

    public function givePermission(Request $request)
    {
        try {

            $currentUser = auth()->user();

            if (!$currentUser) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Authentication required'
                ], 401);
            }

            $createdBy = $currentUser->employee_id;
            $emid      = $currentUser->emid;

            $request->validate([

                'employee_id' => 'required',

                'access_type' => 'required|in:project,module,submodule,task,subtask',

                'role' => 'required|in:admin,manager,member,guest',

                'project_id' => 'nullable|exists:projects,id',

                'work_item_id' => 'nullable|exists:work_items,id'
            ]);
            //dd($request->all());
            // Create Permission
            $permission = WorkItemPermission::updateOrCreate(

                [
                    'employee_id' => $request->employee_id,
                    'project_id'  => $request->project_id,
                    'work_item_id'=> $request->work_item_id,
                    'access_type' => $request->access_type
                ],

                [
                    'role'       => $request->role,
                    'emid'       => $emid,
                    'created_by' => $createdBy
                ]
            );

            return response()->json([
                'status' => 1,
                'message'=> 'Permission granted successfully',
                'data'   => $permission
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'message'=> $e->getMessage()
            ], 500);
        }
    }

  

    public function employeePermissions($employeeId)
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

            $permissions = WorkItemPermission::with('workItem')

                ->where('employee_id', $employeeId)
                ->where('emid', $emid)

                ->get();

            return response()->json([
                'status' => 1,
                'data' => $permissions
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function removePermission(Request $request)
    {
        try {

            $request->validate([
                'id' => 'required|exists:work_item_permissions,id'
            ]);

            WorkItemPermission::where('id', $request->id)->delete();

            return response()->json([
                'status' => 1,
                'message'=> 'Permission removed successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'status' => 0,
                'message'=> $e->getMessage()
            ], 500);
        }
    }
}