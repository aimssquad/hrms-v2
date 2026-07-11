<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Exception;
use Session;
use Carbon\Carbon;

class NoticeController extends Controller
{
    public function empNotice(){
         try {
            // Use API auth instead of Session
            $currentUser = auth()->user();

            if (!$currentUser) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Authentication required'
                ], 401);
            }

            $employee_id = $currentUser->employee_id;
            $emid = $currentUser->emid;
            $notifications = Notification::where('emid', $emid)
                ->where(function ($q) use ($employee_id) {
                    $q->where('employee_id', 'all')
                    ->orWhere('employee_id', $employee_id);
                })
                ->whereDate('start_date', '>=', now()->subDays(2))  // start_date + 2 days logic
                ->orderBy('id', 'desc')
                ->get();
  
            //dd($employee_id, $emid);            

            return response()->json([
                'status' => 1,
                'message' => 'Employee notification fetched successfully',
                'data' => $notifications,
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function status($id)
    {
        //dd($id);
        try {
            $currentUser = auth()->user();

            if (!$currentUser) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Authentication required'
                ], 401);
            }

            // Update only if notification belongs to the same emid
            $notification = Notification::where('id', $id)
                ->where('emid', $currentUser->emid)
                ->first();

            if (!$notification) {
                return response()->json([
                    'status' => 0,
                    'message' => 'Notification not found'
                ], 404);
            }

            $notification->status = 1;  // mark as seen
            $notification->save();

            return response()->json([
                'status' => 1,
                'message' => 'Notification marked as seen'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 0,
                'message' => 'Something went wrong',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
