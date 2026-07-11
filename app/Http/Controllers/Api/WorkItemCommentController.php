<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Models\TaskManagement\WorkItem;

use App\Models\TaskManagement\WorkItemComment;
use App\Services\FirebaseService;
use App\Services\FirebaseRealtimeService;
use App\Services\ProjectFirebaseRealtimeService;

class WorkItemCommentController extends Controller
{
    

    protected $firebase;

    protected $firebaseRealtime;
    
    protected $projectRealtimeService;
    
    public function __construct(
        FirebaseService $firebase,
        FirebaseRealtimeService $firebaseRealtime,
        ProjectFirebaseRealtimeService $projectRealtimeService
    )
    {
        $this->firebase = $firebase;
    
        $this->firebaseRealtime = $firebaseRealtime;
        
        $this->projectRealtimeService = $projectRealtimeService;
    }
 
    
    // public function store(Request $request)
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
    
    //         $employeeId = $currentUser->employee_id;
    
    //         $emid = $currentUser->emid;
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | VALIDATION
    //         |--------------------------------------------------------------------------
    //         */
    
    //         $request->validate([
    
    //             'project_id' => 'required|exists:projects,id',
    
    //             'work_item_id' => 'required|exists:work_items,id',
    
    //             'parent_comment_id' => 'nullable|exists:work_item_comments,id',
    
    //             'comment' => 'nullable|string',
    
    //             'file' => 'nullable|file|max:10240'
    //         ]);
    
    //         /*
    //         |--------------------------------------------------------------------------
    //         | COMMENT OR FILE REQUIRED
    //         |--------------------------------------------------------------------------
    //         */
    
    //         if (
    //             empty($request->comment)
    //             &&
    //             !$request->hasFile('file')
    //         ) {
    
    //             return response()->json([
    
    //                 'status' => 0,
    
    //                 'message' => 'Comment or file is required'
    //             ]);
    //         }
    
    
    //         $filePath = null;
    
    //         if ($request->hasFile('file')) {
    
    //             $filePath = $request->file('file')
    
    //                 ->store(
    //                     'work_item_comments',
    //                     'public'
    //                 );
    //         }
    
         
    
    //         $comment = WorkItemComment::create([
    
    //             'project_id' => $request->project_id,
    
    //             'work_item_id' => $request->work_item_id,
    
    //             'parent_comment_id' => $request->parent_comment_id,
    
    //             'employee_id' => $employeeId,
    
    //             'comment' => $request->comment,
    
    //             'file' => $filePath,
    
    //             'emid' => $emid,
    
    //             'is_edited' => 0,
    
    //             'is_deleted' => 0
    //         ]);
            
    //         // live message 
    //         $currentRole = DB::table('work_item_user_roles as wur')

    //             ->leftJoin(
    //                 'project_roles as pr',
    //                 'pr.id',
    //                 '=',
    //                 'wur.project_role_id'
    //             )
            
    //             ->where('wur.employee_id', $employeeId)
            
    //             ->where('wur.project_id', $request->project_id)
            
    //             ->where('wur.emid', $emid)
            
    //             ->select('pr.name')
            
    //             ->first();
            
    //         /*
    //         |--------------------------------------------------------------------------
    //         | REPLY DATA
    //         |--------------------------------------------------------------------------
    //         */
            
    //         $replyData = null;
            
    //         if ($request->parent_comment_id) {
            
    //             $parentComment = WorkItemComment::find(
    //                 $request->parent_comment_id
    //             );
            
    //             if ($parentComment) {
            
    //                 $parentUser = DB::table('users')
            
    //                     ->where(
    //                         'employee_id',
    //                         $parentComment->employee_id
    //                     )
            
    //                     ->where('emid', $emid)
            
    //                     ->first();
            
    //                 $replyData = [
            
    //                     'id' => $parentComment->id,
            
    //                     'employee_id' => $parentComment->employee_id,
            
    //                     'user' => $parentUser->name ?? '',
            
    //                     'comment' => $parentComment->comment
    //                 ];
    //             }
    //         }
            
    //         /*
    //         |--------------------------------------------------------------------------
    //         | FIREBASE MESSAGE
    //         |--------------------------------------------------------------------------
    //         */
            
    //         $this->firebaseRealtime->pushMessage(
            
    //             $request->work_item_id,
            
    //             [
            
    //                 'comment_id' => $comment->id,
            
    //                 'project_id' => $request->project_id,
            
    //                 'work_item_id' => $request->work_item_id,
            
    //                 'sender_id' => $employeeId,
            
    //                 'sender_name' => $currentUser->name,
            
    //                 'sender_role' => $currentRole->name ?? '',
            
    //                 'message' => $request->comment,
            
    //                 'file' => $filePath,
            
    //                 'created_at' => now()->toISOString(),
            
    //                 'reply_to' => $replyData
    //             ]
    //         );
            
    //         /*
    //         |--------------------------------------------------------------------------
    //         | SEND FIREBASE NOTIFICATION
    //         |--------------------------------------------------------------------------
    //         */
            
    //         $devices = DB::table('work_item_user_roles as wur')

    //             ->join('users as u', function ($join) {
            
    //                 $join->on('u.employee_id', '=', 'wur.employee_id');
    //                 $join->on('u.emid', '=', 'wur.emid');
    //             })
            
    //             ->join('user_devices as ud', 'ud.user_id', '=', 'u.id')
            
    //             ->where('wur.project_id', $request->project_id)
            
    //             ->where('wur.emid', $emid)
            
    //             ->where(function ($query) use ($request) {
            
    //                 $query->where('wur.work_item_id', $request->work_item_id)
            
    //                       ->orWhereNull('wur.work_item_id');
    //             })
            
    //             ->where('wur.employee_id', '!=', $employeeId)
            
    //             ->whereNotNull('ud.fcm_token')

    //             ->select(
    //                 'u.id',
    //                 'u.employee_id',
    //                 'u.name',
    //                 'ud.fcm_token'
    //             )
                
    //             ->groupBy(
    //                 'u.id',
    //                 'u.employee_id',
    //                 'u.name',
    //                 'ud.fcm_token'
    //             )
            
    //             ->get();
            
    //         $title = 'New Work Item Message';

    //         $body = $currentUser->name . ' sent a message';
            
    //         foreach ($devices as $device) {

    //             $this->firebase->send(
            
    //                 $device->fcm_token,
            
    //                 $title,
            
    //                 $body
    //             );
    //         }
    
      
    
    //         return response()->json([
    
    //             'status' => 1,
    
    //             'message' => 'Comment added successfully',
    
    //             'data' => $comment
    //         ]);
    
    //     } catch (\Exception $e) {
    
    //         return response()->json([
    
    //             'status' => 0,
    
    //             'message' => $e->getMessage()
    
    //         ], 500);
    //     }
    // }
    
    public function store(Request $request)
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
            | VALIDATION
            |--------------------------------------------------------------------------
            */
    
            $request->validate([
    
                'project_id' => 'required|exists:projects,id',
    
                'work_item_id' => 'required|exists:work_items,id',
    
                'parent_comment_id' => 'nullable|exists:work_item_comments,id',
    
                'comment' => 'nullable|string',
    
                'file' => 'nullable|file|max:10240'
            ]);
    
            /*
            |--------------------------------------------------------------------------
            | COMMENT OR FILE REQUIRED
            |--------------------------------------------------------------------------
            */
    
            if (
                empty($request->comment)
                &&
                !$request->hasFile('file')
            ) {
    
                return response()->json([
    
                    'status' => 0,
    
                    'message' => 'Comment or file is required'
                ]);
            }
    
    
            $filePath = null;
    
            if ($request->hasFile('file')) {
    
                $filePath = $request->file('file')
    
                    ->store(
                        'work_item_comments',
                        'public'
                    );
            }
    
         
    
            $comment = WorkItemComment::create([
    
                'project_id' => $request->project_id,
    
                'work_item_id' => $request->work_item_id,
    
                'parent_comment_id' => $request->parent_comment_id,
    
                'employee_id' => $employeeId,
    
                'comment' => $request->comment,
    
                'file' => $filePath,
    
                'emid' => $emid,
    
                'is_edited' => 0,
    
                'is_deleted' => 0
            ]);
            
            $projectWorkItem = DB::table('work_items as w')
                ->join('projects as p', 'p.id', '=', 'w.project_id')
                ->where('w.id', $comment->work_item_id)
                ->select(
                    'p.id as project_id',
                    'p.title as project_name',
                    'w.id as work_item_id',
                    'w.title as work_item_name',
                    'w.type as work_item_type'
                )
                ->first();
            //dd($projectWorkItem);       
            
            // live message 
            $currentRole = DB::table('work_item_user_roles as wur')

                ->leftJoin(
                    'project_roles as pr',
                    'pr.id',
                    '=',
                    'wur.project_role_id'
                )
            
                ->where('wur.employee_id', $employeeId)
            
                ->where('wur.project_id', $request->project_id)
            
                ->where('wur.emid', $emid)
            
                ->select('pr.name')
            
                ->first();
            
            $userData = [
                'employee_id' => $currentUser->employee_id,
                'name'        => $currentUser->name,
                'emid'        => $currentUser->emid,
            ];
            
            /*
            |--------------------------------------------------------------------------
            | REPLY DATA
            |--------------------------------------------------------------------------
            */
            
            $replyData = null;

            if ($request->parent_comment_id) {
            
                $parentComment = WorkItemComment::find(
                    $request->parent_comment_id
                );
            
                if ($parentComment) {
            
                    $parentUser = DB::table('users')
            
                        ->where(
                            'employee_id',
                            $parentComment->employee_id
                        )
            
                        ->where('emid', $emid)
            
                        ->first();
            
                    $replyData = [
            
                        'id'      => $parentComment->id,
            
                        'comment' => $parentComment->comment,
            
                        'user'    => $parentUser->name ?? ''
                    ];
                }
            }
            
         
            
            $firebaseData = [

                'id' => $comment->id,
            
                'project_id' => $comment->project_id,
            
                'project_name' => $projectWorkItem->project_name,
            
                'work_item_id' => $comment->work_item_id,
            
                'work_item_name' => $projectWorkItem->work_item_name,
            
                'work_item_type' => $projectWorkItem->work_item_type,
            
                'parent_comment_id' => $comment->parent_comment_id,
            
                'employee_id' => $comment->employee_id,
            
                'comment' => $comment->comment,
            
                'file' => $comment->file,
            
                'created_at' => $comment->created_at->toISOString(),
            
                'updated_at' => $comment->updated_at->toISOString(),
            
                'employee_role' => $currentRole->name ?? null,
            
                'user' => $userData,
            
                'reply_to_comment' => $replyData
            ];
            
            $this->firebaseRealtime->pushMessage(

                $request->work_item_id,
            
                $firebaseData
            );
            // $this->firebaseRealtime->pushMessage(
            
            //     $request->work_item_id,
            
            //     [
            
            //         'comment_id' => $comment->id,
            
            //         'project_id' => $request->project_id,
            
            //         'work_item_id' => $request->work_item_id,
            
            //         'sender_id' => $employeeId,
            
            //         'sender_name' => $currentUser->name,
            
            //         'sender_role' => $currentRole->name ?? '',
            
            //         'message' => $request->comment,
            
            //         'file' => $filePath,
            
            //         'created_at' => now()->toISOString(),
            
            //         'reply_to' => $replyData
            //     ]
            // );
            
            /*
            |--------------------------------------------------------------------------
            | SEND FIREBASE NOTIFICATION
            |--------------------------------------------------------------------------
            */
            
            $devices = DB::table('work_item_user_roles as wur')

                ->join('users as u', function ($join) {
            
                    $join->on('u.employee_id', '=', 'wur.employee_id');
                    $join->on('u.emid', '=', 'wur.emid');
                })
            
                ->join('user_devices as ud', 'ud.user_id', '=', 'u.id')
            
                ->where('wur.project_id', $request->project_id)
            
                ->where('wur.emid', $emid)
            
                ->where(function ($query) use ($request) {
            
                    $query->where('wur.work_item_id', $request->work_item_id)
            
                          ->orWhereNull('wur.work_item_id');
                })
            
                ->where('wur.employee_id', '!=', $employeeId)
            
                ->whereNotNull('ud.fcm_token')

                ->select(
                    'u.id',
                    'u.employee_id',
                    'u.name',
                    'ud.fcm_token'
                )
                
                ->groupBy(
                    'u.id',
                    'u.employee_id',
                    'u.name',
                    'ud.fcm_token'
                )
            
                ->get();
            
            // $title = 'New Work Item Message';

            // $body = $currentUser->name . ' sent a message';
            
            $title = $projectWorkItem->project_name;

            $body = sprintf(
                '%s sent a message in %s: %s',
                $currentUser->name,
                ucfirst($projectWorkItem->work_item_type),
                $projectWorkItem->work_item_name
            );
            
            foreach ($devices as $device) {

                $this->firebase->send(
            
                    $device->fcm_token,
            
                    $title,
            
                    $body,
                    [
            
                        'project_id'        => $projectWorkItem->project_id,
            
                        'project_name'      => $projectWorkItem->project_name,
            
                        'work_item_id'      => $projectWorkItem->work_item_id,
            
                        'work_item_name'    => $projectWorkItem->work_item_name,
            
                        'work_item_type'    => $projectWorkItem->work_item_type,
            
                        'comment_id'        => $comment->id,
            
                        'sender_id'         => $employeeId,
            
                        'sender_name'       => $currentUser->name,
                    ]
                );
            }
    
      
    
            return response()->json([
    
                'status' => 1,
    
                'message' => 'Comment added successfully',
    
                'data' => $comment
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
    
                'status' => 0,
    
                'message' => $e->getMessage()
    
            ], 500);
        }
    }



    public function index($projectId, $workItemId)
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
            | CHECK ACCESS
            |--------------------------------------------------------------------------
            */

            // $hasAccess = DB::table('work_item_user_roles')

            //     ->where('employee_id', $employeeId)

            //     ->where('project_id', $projectId)

            //     ->where('emid', $emid)

            //     ->where(function ($query) use ($workItemId) {

            //         $query->whereNull('work_item_id')

            //             ->orWhere(
            //                 'work_item_id',
            //                 $workItemId
            //             );
            //     })

            //     ->exists();

            // if (!$hasAccess) {

            //     return response()->json([

            //         'status' => 0,

            //         'message' => 'Permission denied'
            //     ]);
            // }

            /*
            |--------------------------------------------------------------------------
            | GET COMMENTS
            |--------------------------------------------------------------------------
            */

            $comments = WorkItemComment::with([
        
                'user:employee_id,name,emid'
            ])
        
            ->where('project_id', $projectId)
        
            ->where('work_item_id', $workItemId)
        
            ->where('is_deleted', 0)
        
            ->orderBy('id', 'ASC')
        
            ->get()
        
            ->map(function ($comment) use ($projectId, $workItemId, $emid) {
        
                /*
                |--------------------------------------------------------------------------
                | GET EMPLOYEE ROLE
                |--------------------------------------------------------------------------
                */
        
                $role = DB::table('work_item_user_roles as wur')
        
                    ->leftJoin(
                        'project_roles as pr',
                        'pr.id',
                        '=',
                        'wur.project_role_id'
                    )
        
                    ->where('wur.project_id', $projectId)
        
                    ->where('wur.emid', $emid)
        
                    ->where('wur.employee_id', $comment->employee_id)
        
                    ->where(function ($query) use ($workItemId) {
        
                        $query->whereNull('wur.work_item_id')
        
                            ->orWhere(
                                'wur.work_item_id',
                                $workItemId
                            );
                    })
        
                    ->select(
        
                        'pr.id as role_id',
        
                        'pr.name as role_name'
                    )
        
                    ->first();
        
                /*
                |--------------------------------------------------------------------------
                | ATTACH ROLE
                |--------------------------------------------------------------------------
                */
        
                $comment->employee_role = $role;
        
                /*
                |--------------------------------------------------------------------------
                | REPLY COMMENT PREVIEW
                |--------------------------------------------------------------------------
                */
        
                $replyTo = null;
        
                if ($comment->parent_comment_id) {
        
                    $parent = WorkItemComment::with([
                        'user:employee_id,name,emid'
                    ])
        
                    ->where('id', $comment->parent_comment_id)
        
                    ->first();
        
                    if ($parent) {
        
                        $replyTo = [
        
                            'id' => $parent->id,
        
                            'comment' => $parent->comment,
        
                            'user' => $parent->user->name ?? null
                        ];
                    }
                }
        
                /*
                |--------------------------------------------------------------------------
                | FINAL RESPONSE
                |--------------------------------------------------------------------------
                */
        
                return [
        
                    'id' => $comment->id,
        
                    'project_id' => $comment->project_id,
        
                    'work_item_id' => $comment->work_item_id,
        
                    'parent_comment_id' => $comment->parent_comment_id,
        
                    'employee_id' => $comment->employee_id,
        
                    'comment' => $comment->comment,
        
                    'file' => $comment->file,
        
                    //'comment_type' => $comment->comment_type,
        
                    'created_at' => $comment->created_at,
        
                    'updated_at' => $comment->updated_at,
        
                    'employee_role' => $comment->employee_role,
        
                    'user' => $comment->user,
        
                    'reply_to_comment' => $replyTo
                ];
            });
            /*
            |--------------------------------------------------------------------------
            | RESPONSE
            |--------------------------------------------------------------------------
            */

            return response()->json([

                'status' => 1,

                'data' => $comments
            ]);

        } catch (\Exception $e) {

            return response()->json([

                'status' => 0,

                'message' => $e->getMessage()

            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE COMMENT
    |--------------------------------------------------------------------------
    */

    public function delete($id)
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

            $comment = WorkItemComment::find($id);

            if (!$comment) {

                return response()->json([

                    'status' => 0,

                    'message' => 'Comment not found'
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | ONLY OWNER CAN DELETE
            |--------------------------------------------------------------------------
            */

            if ($comment->employee_id != $employeeId) {

                return response()->json([

                    'status' => 0,

                    'message' => 'Unauthorized'
                ]);
            }

            $comment->update([

                'is_deleted' => 1
            ]);

            return response()->json([

                'status' => 1,

                'message' => 'Comment deleted successfully'
            ]);

        } catch (\Exception $e) {

            return response()->json([

                'status' => 0,

                'message' => $e->getMessage()

            ], 500);
        }
    }
    
    
    public function markProjectMessagesAsRead(Request $request)
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
    
            /*
            |--------------------------------------------------------------------------
            | VALIDATION
            |--------------------------------------------------------------------------
            */
    
            $request->validate([
    
                'project_id' => 'required|exists:projects,id',
    
                'employee_id' => 'required|exists:users,employee_id'
    
            ]);
    
            $emid = $currentUser->emid;
    
            /*
            |--------------------------------------------------------------------------
            | GET ALL POSTS OF PROJECT
            |--------------------------------------------------------------------------
            */
    
            $posts = DB::table('project_post')
    
                ->where('project_id', $request->project_id)
    
                ->where('emid', $emid)
    
                ->select('id')
    
                ->get();
    
            $insertData = [];
    
            foreach ($posts as $post) {
    
                $alreadyRead = DB::table('project_post_reads')
    
                    ->where('project_post_id', $post->id)
    
                    ->where('employee_id', $request->employee_id)
    
                    ->where('emid', $emid)
    
                    ->exists();
    
                if (!$alreadyRead) {
    
                    $insertData[] = [
    
                        'project_post_id' => $post->id,
    
                        'project_id'      => $request->project_id,
    
                        'employee_id'     => $request->employee_id,
    
                        'emid'            => $emid,
    
                        'read_at'         => now(),
    
                        'created_at'      => now(),
    
                        'updated_at'      => now(),
    
                    ];
                }
            }
    
            /*
            |--------------------------------------------------------------------------
            | BULK INSERT
            |--------------------------------------------------------------------------
            */
    
            if (!empty($insertData)) {
    
                DB::table('project_post_reads')
    
                    ->insert($insertData);
            }
            
            $unreadCount = DB::table('project_post as pp')
        
            ->leftJoin('project_post_reads as pr', function ($join) use ($request, $emid) {
        
                $join->on('pr.project_post_id', '=', 'pp.id')
                     ->where('pr.employee_id', '=', $request->employee_id)
                     ->where('pr.emid', '=', $emid);
        
            })
        
            ->where('pp.project_id', $request->project_id)
        
            ->where('pp.employee_code', '!=', $request->employee_id)
        
            ->whereNull('pr.id')
        
            ->count();
            
            $this->projectRealtimeService->updateUnreadCount(
            
                $request->project_id,
            
                $request->employee_id,
            
                $unreadCount
            );
    
            return response()->json([
    
                'status' => 1,
    
                'message' => 'Project messages marked as read',
    
                'read_count' => count($insertData)
    
            ]);
    
        } catch (\Exception $e) {
    
            return response()->json([
    
                'status' => 0,
    
                'message' => $e->getMessage()
    
            ], 500);
        }
    }
}