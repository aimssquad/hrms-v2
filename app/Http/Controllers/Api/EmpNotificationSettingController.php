<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmpNotificationSetting;
use App\Models\EmpNotificationModule;
use App\Models\EmpNotification;
use DB;

class EmpNotificationSettingController extends Controller
{
    //

    public function index(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $employeeId = auth()->user()->employee_id;
        $emid = auth()->user()->emid;

        if (!$employeeId) {
            return response()->json(['error' => 'Employee ID is required'], 400);
        }

        $modules = DB::table('notification_modules as nm')
            ->leftJoin('emp_notification_settings as ens', function ($join) use ($employeeId) {
                $join->on('nm.id', '=', 'ens.notification_module_id')
                    ->where('ens.employee_id', '=', $employeeId);
            })
            ->select(
                'nm.id',
                'nm.name',
                DB::raw('IFNULL(ens.is_enabled, 1) as is_enabled')
            )
            ->get();

        return response()->json($modules);
    }

    // public function isMuted($moduleId)
    // {
    //     if (!auth()->check()) {
    //         return response()->json(['error' => 'Unauthorized'], 401);
    //     }

    //     $employeeId = auth()->user()->employee_id;
    //     $emid = auth()->user()->emid;

    //     if (!$employeeId) {
    //         return response()->json(['error' => 'Employee ID is required'], 400);
    //     }

    //     $setting = EmpNotificationSetting::where('employee_id', $employeeId)
    //         ->where('notification_module_id', $moduleId)
    //         ->where('emid', $emid)
    //         ->first();

    //     if ($setting) {
    //         $setting->is_enabled = $setting->is_enabled == 1 ? 0 : 1;
    //         $setting->save();
    //     } else {
    //         $setting = EmpNotificationSetting::create([
    //             'employee_id' => $employeeId,
    //             'emid' => $emid,
    //             'notification_module_id' => $moduleId,
    //             'is_enabled' => 0, // default mute
    //         ]);
    //     }

    //     return response()->json([
    //         'success' => true,
    //         'module_id' => $moduleId,
    //         'is_enabled' => $setting->is_enabled
    //     ]);
    // }

    public function isMuted(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $employeeId = auth()->user()->employee_id;
        $emid = auth()->user()->emid;

        if (!$employeeId) {
            return response()->json(['error' => 'Employee ID is required'], 400);
        }

        $moduleIds = $request->module_id;

        // Ensure array
        if (!is_array($moduleIds)) {
            return response()->json(['error' => 'module_id must be an array'], 400);
        }

        $response = [];

        foreach ($moduleIds as $moduleId) {

            $setting = EmpNotificationSetting::where('employee_id', $employeeId)
                ->where('notification_module_id', $moduleId)
                ->where('emid', $emid)
                ->first();

            if ($setting) {
                // Toggle
                $setting->is_enabled = $setting->is_enabled == 1 ? 0 : 1;
                $setting->save();
            } else {
                // Create (mute)
                $setting = EmpNotificationSetting::create([
                    'employee_id' => $employeeId,
                    'emid' => $emid,
                    'notification_module_id' => $moduleId,
                    'is_enabled' => 0,
                ]);
            }

            $response[] = [
                'module_id' => $moduleId,
                'is_enabled' => $setting->is_enabled
            ];
        }

        return response()->json([
            'success' => true,
            'data' => $response
        ]);
    }

    public function allNotifications(Request $request)
    {
      
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
        $employeeId = auth()->user()->employee_id;
        $emid = auth()->user()->emid;

        if (!$employeeId) {
            return response()->json(['error' => 'Employee ID is required'], 400);
        }

        $settings = EmpNotification::where('employee_id', $employeeId)
            ->where('emid', $emid)
            ->orderBy('is_read', 'asc')   // 🔥 unread (0) first
            ->orderBy('created_at', 'desc') // latest on top
            ->get();
        
        return response()->json($settings);
    }

    public function markAsRead($id)
    {
        if (!auth()->check()) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $employeeId = auth()->user()->employee_id;
        $emid = auth()->user()->emid;

        if (!$employeeId) {
            return response()->json(['error' => 'Employee ID is required'], 400);
        }

        $notification = EmpNotification::where('id', $id)
            ->where('employee_id', $employeeId)
            ->where('emid', $emid)
            ->first();

        if (!$notification) {
            return response()->json(['error' => 'Notification not found'], 404);
        }

        $notification->is_read = 1;
        $notification->read_at = now();
        $notification->save();

        return response()->json(['success' => true]);

    }

}
