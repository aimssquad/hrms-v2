<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\TaskManagement\Project;
use App\Models\TaskManagement\ProjectMembers;
use App\Models\TaskManagement\MasterLabels;
use App\Models\TaskManagement\Task;
use App\Models\User;
use App\Models\Employee;
use App\Models\ProjectPost;
use DB;
use Session;
use Storage;
use ZipArchive;

class ChatController extends Controller
{
    // public function chat(Request $request)
    // {
    //     $email = Session::get("emp_email");
    //     if (empty($email)) {
    //         return redirect("/");
    //     }

    //     $id = decrypt($request->id);
    //     $empData = User::where('email', $email)->first();
    //     $emid = $empData->emid;
    //     $employee_code = $empData->employee_id;
    //     //dd($empData);
    //     // 🔹 Project details with members & tasks
    //     $projectData = DB::table('projects as p')
    //         ->leftJoin('project_members as pm', 'p.id', '=', 'pm.project_id')
    //         ->leftJoin('tasks as t', 'p.id', '=', 't.project_id')
    //         ->leftJoin('employee as e', 'pm.user_id', '=', 'e.id')
    //         ->where('p.id', $id)
    //         ->select([
    //             'p.id as project_id',
    //             'p.title as project_title',
    //             'p.description as project_description',
    //             'p.status as project_status',
    //             'pm.role as member_role',
    //             't.task_name',
    //             't.task_desc',
    //             't.start_date',
    //             't.expected_end_date',
    //             DB::raw("CONCAT(e.emp_fname, ' ', COALESCE(e.emp_mname, ''), ' ', e.emp_lname) as employee_name"),
    //             'e.emp_code as employee_code'
    //         ])
    //         ->orderBy('employee_name')
    //         ->orderBy('t.start_date')
    //         ->get();
    //     //dd($projectData);        
    //     $groupedData = [
    //         'project' => null,
    //         'members' => [],
    //         'tasks'   => []
    //     ];

    //     foreach ($projectData as $item) {
    //         if (!$groupedData['project']) {
    //             $groupedData['project'] = [
    //                 'id'          => $item->project_id,
    //                 'title'       => $item->project_title,
    //                 'description' => $item->project_description,
    //                 'status'      => $item->project_status
    //             ];
    //         }

    //         if ($item->employee_name && !isset($groupedData['members'][$item->employee_code])) {
    //             $groupedData['members'][$item->employee_code] = [
    //                 'name'          => $item->employee_name,
    //                 'employee_code' => $item->employee_code,
    //                 'role'          => $item->member_role
    //             ];
    //         }

    //         if ($item->task_name && !isset($groupedData['tasks'][$item->task_name])) {
    //             $groupedData['tasks'][$item->task_name] = [
    //                 'task_name'         => $item->task_name,
    //                 'task_desc'         => $item->task_desc,
    //                 'start_date'        => $item->start_date,
    //                 'expected_end_date' => $item->expected_end_date
    //             ];
    //         }
    //     }

    //     $groupedData['members'] = array_values($groupedData['members']);
    //     $groupedData['tasks']   = array_values($groupedData['tasks']);

    //     // 🔥 Fetch all posts & replies from one table
    //     $allPosts = DB::table('project_post as p')
    //         ->leftJoin('users as u', function($join) {
    //             $join->on('u.employee_id', '=', 'p.employee_code')
    //                 ->where(function($q) {
    //                     $q->on('u.emid', '=', 'p.emid')
    //                     ->orWhereNull('p.emid');
    //                 });
    //         })
    //         ->where('p.project_id', $id)
    //         ->orderBy('p.created_at', 'desc')
    //         ->orderBy('p.id', 'asc') // 🔑 ensures id 1 before id 2 if timestamps same
    //         ->select([
    //             'p.id',
    //             'p.parent_id',
    //             'p.title',
    //             'p.file',
    //             'p.created_at',
    //             'p.employee_code', 
    //             'u.name as user_name'
    //         ])
    //         ->get();

    //     // Index posts by id for lookup
    //     $postIndex = $allPosts->keyBy('id');

    //     // Build replies into each post
    //     $posts = $allPosts->map(function ($post) use ($postIndex) {
    //         if ($post->parent_id) {
    //             // reply → attach its parent
    //             $parent = $postIndex->get($post->parent_id);

    //             $post->replies = $parent ? [[
    //                 'id'         => $parent->id,
    //                 'parent_id'  => $parent->parent_id,
    //                 'title'      => $parent->title,
    //                 'file'       => $parent->file,
    //                 'created_at' => $parent->created_at,
    //                 'user_name'  => $parent->user_name,
    //             ]] : [];
    //         } else {
    //             $post->replies = [];
    //         }
    //         return $post;
    //     })->values();

    //     // $projects = DB::table('projects as pr')
    //     //     ->leftJoin('project_post as pp', 'pp.project_id', '=', 'pr.id')
    //     //     ->where('pr.emid', $employee_code)
    //     //     ->select(
    //     //         'pr.id as project_id',
    //     //         'pr.title as project_name',
    //     //         DB::raw('MAX(pp.created_at) as last_time'),
    //     //         DB::raw('SUBSTRING_INDEX(GROUP_CONCAT(pp.title ORDER BY pp.created_at DESC), ",", 1) as last_title')
    //     //     )
    //     //     ->groupBy('pr.id', 'pr.title')
    //     //     ->orderByDesc('last_time')
    //     //     ->get();

    //     //dd($projects);        
    //     $data['id']        = $id;
    //     $data['post_data'] = $posts;
    //     //dd($emid);

    //         $projects = DB::table('projects as pr')
    //             ->leftJoin('project_post as pp', function ($join) {
    //                 $join->on('pp.project_id', '=', 'pr.id')
    //                     ->whereNull('pp.parent_id');
    //             })
    //             ->where('pr.emid', $employee_code)
    //             ->select(
    //                 'pr.id as project_id',
    //                 'pr.title as project_name',
    //                 DB::raw('MAX(pp.created_at) as last_time')
    //             )
    //             ->groupBy('pr.id', 'pr.title')
    //             ->orderByRaw('MAX(pp.created_at) DESC')
    //             ->get();



    //             // Get last post details
    //         $data['projectData'] = [];

    //         foreach ($projects as $project) {

    //             $lastPost = DB::table('project_post as p')
    //                 ->leftJoin('employee as e', 'e.emp_code', '=', 'p.employee_code')
    //                 ->where('p.project_id', $project->project_id)
    //                 ->whereNull('p.parent_id')
    //                 ->orderBy('p.created_at', 'DESC')
    //                 ->select(
    //                     'p.title',
    //                     'p.created_at',
    //                     DB::raw("CONCAT(e.emp_fname,' ',e.emp_lname) as employee_name")
    //                 )
    //                 ->first();

    //             $data['projectData'][] = [
    //                 'project_id'   => $project->project_id,
    //                 'project_name' => $project->project_name,
    //                 'last_message' => $lastPost->title ?? 'No messages yet',
    //                 'employee'     => $lastPost->employee_name ?? '',
    //                 'time'         => $lastPost
    //                     ? \Carbon\Carbon::parse($lastPost->created_at)->diffForHumans()
    //                     : ''
    //             ];
    //         }
    //         $projectData = $data['projectData'];
    //          dd($groupedData);
    //     return view(
    //         'employeer/task-management/project-management/project-chat',
    //         compact('data','projectData', 'employee_code', 'groupedData', 'projects')
    //     );
    // }
    
    public function chat(Request $request)
    {
        $email = Session::get("emp_email");
    
        if (empty($email)) {
            return redirect("/");
        }
    
        $id = decrypt($request->id);
    
        $empData = User::where('email', $email)->first();
    
        $emid = $empData->employee_id;
        $employee_code = $empData->employee_id;
    
        /*
        |--------------------------------------------------------------------------
        | GET PROJECTS FOR LEFT SIDEBAR
        |--------------------------------------------------------------------------
        */
    
        $projects = DB::table('projects')
            ->where('emid', $emid)
            ->get();
        //dd($projects);
        $projectData = [];
    
        $selectedProject = null;
    
        foreach ($projects as $project) {
    
            /*
            |--------------------------------------------------------------------------
            | MEMBERS
            |--------------------------------------------------------------------------
            */
    
            $members = DB::table('work_item_user_roles as wur')
                ->leftJoin('users as u', function ($join) {
                    $join->on('u.employee_id', '=', 'wur.employee_id')
                         ->on('u.emid', '=', 'wur.emid');
                })
                ->leftJoin(
                    'project_roles as pr',
                    'pr.id',
                    '=',
                    'wur.project_role_id'
                )
                ->where('wur.project_id', $project->id)
                ->where('wur.emid', $emid)
                ->select(
                    'u.employee_id',
                    'u.name',
                    'pr.name as role_name'
                )
                ->distinct()
                ->get();
    
            /*
            |--------------------------------------------------------------------------
            | POSTS
            |--------------------------------------------------------------------------
            */
    
            $allPosts = DB::table('project_post as p')
                ->leftJoin('users as u', function ($join) {
                    $join->on('u.employee_id', '=', 'p.employee_code')
                         ->on('u.emid', '=', 'p.emid');
                })
                ->where('p.project_id', $project->id)
                ->select(
                    'p.id',
                    'p.parent_id',
                    'p.title',
                    'p.file',
                    'p.created_at',
                    'p.employee_code',
                    'u.name as employee_name'
                )
                ->orderBy('p.created_at', 'ASC')
                ->get();
    
            $postIndex = $allPosts->keyBy('id');
    
            $messages = $allPosts->map(function ($post) use ($postIndex) {
    
                $reply = [];
    
                if (!empty($post->parent_id)) {
    
                    $parent = $postIndex->get($post->parent_id);
    
                    if ($parent) {
    
                        $reply = [[
                            'id'            => $parent->id,
                            'parent_id'     => $parent->parent_id,
                            'title'         => $parent->title,
                            'file'          => $parent->file,
                            'created_at'    => $parent->created_at,
                            'user_name'     => $parent->employee_name,
                            'employee_code' => $parent->employee_code,
                        ]];
                    }
                }
    
                return [
                    'id'            => $post->id,
                    'employee_code' => $post->employee_code,
                    'employee_name' => $post->employee_name,
                    'message'       => $post->title,
                    'file'          => $post->file,
                    'parent_id'     => $post->parent_id,
                    'replies'       => $reply,
                    'created_at'    => $post->created_at
                ];
            });
    
            /*
            |--------------------------------------------------------------------------
            | LAST MESSAGE FOR SIDEBAR
            |--------------------------------------------------------------------------
            */
    
            $lastPost = $allPosts->sortByDesc('created_at')->first();
    
            $projectData[] = [
                'project_id'   => $project->id,
                'project_name' => $project->title,
                'last_message' => $lastPost->title ?? 'No messages yet',
                'employee'     => $lastPost->employee_name ?? '',
                'time'         => $lastPost
                    ? \Carbon\Carbon::parse($lastPost->created_at)->diffForHumans()
                    : ''
            ];
    
            /*
            |--------------------------------------------------------------------------
            | SELECTED PROJECT
            |--------------------------------------------------------------------------
            */
    
            if ($project->id == $id) {
    
                $selectedProject = [
                    'project' => [
                        'id'                 => $project->id,
                        'title'              => $project->title,
                        'description'        => $project->description,
                        'status'             => $project->status,
                        'project_start_date' => $project->project_start_date,
                        'project_end_date'   => $project->project_end_date
                    ],
                    'members' => $members,
                    'messages' => $messages
                ];
            }
        }
    
        /*
        |--------------------------------------------------------------------------
        | GROUPED DATA (OLD FORMAT)
        |--------------------------------------------------------------------------
        */
    
        $groupedData = [
            'project' => $selectedProject['project'] ?? null,
            'members' => [],
            'tasks'   => []
        ];
    
        if (!empty($selectedProject['members'])) {
    
            foreach ($selectedProject['members'] as $member) {
    
                $groupedData['members'][] = [
                    'name'          => $member->name,
                    'employee_code' => $member->employee_id,
                    'role'          => $member->role_name
                ];
            }
        }
    
        /*
        |--------------------------------------------------------------------------
        | POST DATA (OLD FORMAT FOR BLADE)
        |--------------------------------------------------------------------------
        */
    
        $data['id'] = $id;
    
        $data['post_data'] = collect(
            $selectedProject['messages'] ?? []
        )->map(function ($item) {
    
            return (object)[
                'id'            => $item['id'],
                'parent_id'     => $item['parent_id'],
                'title'         => $item['message'],
                'user_name'     => $item['employee_name'],
                'employee_code' => $item['employee_code'],
                'created_at'    => $item['created_at'],
                'replies'       => $item['replies'],
                'file'          => $item['file']
            ];
        });
        //dd($projectData);
        return view(
            'employeer/task-management/project-controll/group-chat',
            compact(
                'data',
                'projectData',
                'employee_code',
                'groupedData',
                'projects'
            )
        );
    }

    public function downloadChatZip(Request $request)
    {   //dd('okk');
        $request->validate([
            'project_id' => 'required',
            'from_date' => 'required|date',
            'to_date' => 'required|date|after_or_equal:from_date',
        ]);

        try {
            $projectId = decrypt($request->project_id);
            $fromDate = $request->from_date . ' 00:00:00';
            $toDate = $request->to_date . ' 23:59:59';

            // Fetch project info
            $project = DB::table('projects')
                ->where('id', $projectId)
                ->first();

            if (!$project) {
                return back()->with('error', 'Project not found');
            }

            // Get all posts with their replies
            $parentPosts = DB::table('project_post as p')
                ->leftJoin('users as u', function($join) {
                    $join->on('u.employee_id', '=', 'p.employee_code')
                        ->where(function($q) {
                            $q->on('u.emid', '=', 'p.emid')
                            ->orWhereNull('p.emid');
                        });
                })
                ->leftJoin('employee as e', 'e.emp_code', '=', 'p.employee_code')
                ->where('p.project_id', $projectId)
                ->whereNull('p.parent_id')
                ->whereBetween('p.created_at', [$fromDate, $toDate])
                ->orderBy('p.created_at', 'asc')
                ->select([
                    'p.id',
                    'p.title',
                    'p.file',
                    'p.created_at',
                    DB::raw("COALESCE(u.name, CONCAT(e.emp_fname, ' ', e.emp_lname)) as sender_name")
                ])
                ->get();

            // Create temporary directory
            $tempDir = storage_path('app/temp/chat_export_' . time());
            if (!file_exists($tempDir)) {
                mkdir($tempDir, 0777, true);
            }

            // Create folder structure
            $chatFolder = $tempDir . '/Chat with ' . str_replace(['/', '\\'], '_', $project->title);
            mkdir($chatFolder, 0777, true);
            
            // Create media folder for attachments
            $mediaFolder = $chatFolder . '/Media';
            mkdir($mediaFolder, 0777, true);

            // Generate HTML file (WhatsApp-like format)
            $htmlContent = $this->generateWhatsAppHTML($project, $parentPosts, $projectId, $fromDate, $toDate, $mediaFolder);
            file_put_contents($chatFolder . '/chat.html', $htmlContent);

            // Generate JSON file
            $jsonContent = $this->generateWhatsAppJSON($project, $parentPosts, $projectId, $fromDate, $toDate);
            file_put_contents($chatFolder . '/chat.json', json_encode($jsonContent, JSON_PRETTY_PRINT));

            // Generate TXT file (simple format)
            $txtContent = $this->generateWhatsAppTXT($project, $parentPosts, $projectId, $fromDate, $toDate);
            file_put_contents($chatFolder . '/chat.txt', $txtContent);

            // Copy media files
            $this->copyMediaFiles($parentPosts, $projectId, $fromDate, $toDate, $mediaFolder);

            // Create ZIP file
            $zipFileName = 'WhatsApp Chat - ' . $project->title . ' - ' . $fromDate . ' to ' . $toDate . '.zip';
            $zipPath = storage_path('app/' . $zipFileName);
            
            $zip = new ZipArchive;
            if ($zip->open($zipPath, ZipArchive::CREATE | ZipArchive::OVERWRITE) === TRUE) {
                // Add files recursively
                $this->addFolderToZip($chatFolder, $zip, strlen($tempDir . '/'));
                $zip->close();
            }

            // Clean up temp directory
            $this->deleteDirectory($tempDir);

            // Return ZIP file for download
            return response()->download($zipPath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            // Clean up on error
            if (isset($tempDir) && file_exists($tempDir)) {
                $this->deleteDirectory($tempDir);
            }
            if (isset($zipPath) && file_exists($zipPath)) {
                @unlink($zipPath);
            }
            
            return back()->with('error', 'Failed to download: ' . $e->getMessage());
        }
    }

    private function generateWhatsAppHTML($project, $parentPosts, $projectId, $fromDate, $toDate, $mediaFolder)
    {
        $html = '<!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Chat Export - ' . htmlspecialchars($project->title) . '</title>
            <style>
                body {
                    font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
                    background-color: #e5ddd5;
                    margin: 0;
                    padding: 20px;
                    background-image: url("data:image/svg+xml,%3Csvg width=\'100\' height=\'100\' viewBox=\'0 0 100 100\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cpath d=\'M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z\' fill=\'%239C92AC\' fill-opacity=\'0.05\' fill-rule=\'evenodd\'/%3E%3C/svg%3E");
                }
                .chat-container {
                    max-width: 800px;
                    margin: 0 auto;
                    background: white;
                    border-radius: 10px;
                    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
                    overflow: hidden;
                }
                .chat-header {
                    background: #075e54;
                    color: white;
                    padding: 20px;
                    text-align: center;
                }
                .chat-header h1 {
                    margin: 0;
                    font-size: 20px;
                }
                .chat-header .subtitle {
                    opacity: 0.9;
                    font-size: 14px;
                    margin-top: 5px;
                }
                .chat-messages {
                    padding: 20px;
                    max-height: 600px;
                    overflow-y: auto;
                }
                .message {
                    margin-bottom: 15px;
                    clear: both;
                }
                .message.sent {
                    text-align: right;
                }
                .message.received {
                    text-align: left;
                }
                .message-bubble {
                    display: inline-block;
                    max-width: 70%;
                    padding: 10px 15px;
                    border-radius: 18px;
                    position: relative;
                    word-wrap: break-word;
                }
                .sent .message-bubble {
                    background: #dcf8c6;
                    color: #000;
                    border-bottom-right-radius: 5px;
                    float: right;
                }
                .received .message-bubble {
                    background: white;
                    color: #000;
                    border: 1px solid #e5e5ea;
                    border-bottom-left-radius: 5px;
                    float: left;
                }
                .message-sender {
                    font-weight: bold;
                    font-size: 12px;
                    margin-bottom: 3px;
                    color: #666;
                }
                .message-time {
                    font-size: 11px;
                    color: #999;
                    margin-top: 5px;
                    text-align: right;
                }
                .attachment {
                    margin-top: 10px;
                }
                .attachment img {
                    max-width: 200px;
                    border-radius: 5px;
                }
                .attachment a {
                    display: inline-block;
                    padding: 8px 12px;
                    background: #f0f0f0;
                    border-radius: 5px;
                    text-decoration: none;
                    color: #075e54;
                    font-size: 14px;
                }
                .reply-indicator {
                    font-size: 12px;
                    color: #666;
                    background: #f9f9f9;
                    padding: 5px 10px;
                    border-radius: 5px;
                    margin-bottom: 5px;
                    border-left: 3px solid #075e54;
                }
                .system-message {
                    text-align: center;
                    color: #666;
                    font-size: 12px;
                    padding: 10px;
                    background: #f0f0f0;
                    border-radius: 10px;
                    margin: 10px 0;
                }
                .date-separator {
                    text-align: center;
                    margin: 20px 0;
                    position: relative;
                }
                .date-separator span {
                    background: #e5ddd5;
                    padding: 5px 15px;
                    border-radius: 15px;
                    font-size: 12px;
                    color: #666;
                }
            </style>
        </head>
        <body>
            <div class="chat-container">
                <div class="chat-header">
                    <h1>' . htmlspecialchars($project->title) . '</h1>
                    <div class="subtitle">Project Chat Export</div>
                    <div class="subtitle">' . date('F j, Y', strtotime($fromDate)) . ' - ' . date('F j, Y', strtotime($toDate)) . '</div>
                </div>
                <div class="chat-messages">';

        // Add system message
        $html .= '<div class="system-message">
                    💬 Chat exported on ' . now()->format('F j, Y \a\t g:i A') . '
                </div>';

        $currentDate = null;
        
        foreach ($parentPosts as $parent) {
            $messageDate = \Carbon\Carbon::parse($parent->created_at)->format('Y-m-d');
            
            // Add date separator
            if ($currentDate !== $messageDate) {
                $currentDate = $messageDate;
                $html .= '<div class="date-separator">
                            <span>' . \Carbon\Carbon::parse($parent->created_at)->format('l, F j, Y') . '</span>
                        </div>';
            }
            
            // Get replies for this parent
            $replies = DB::table('project_post as p')
                ->leftJoin('users as u', function($join) {
                    $join->on('u.employee_id', '=', 'p.employee_code')
                        ->where(function($q) {
                            $q->on('u.emid', '=', 'p.emid')
                            ->orWhereNull('p.emid');
                        });
                })
                ->leftJoin('employee as e', 'e.emp_code', '=', 'p.employee_code')
                ->where('p.parent_id', $parent->id)
                ->whereBetween('p.created_at', [$fromDate, $toDate])
                ->orderBy('p.created_at', 'asc')
                ->select([
                    'p.id',
                    'p.title',
                    'p.file',
                    'p.created_at',
                    DB::raw("COALESCE(u.name, CONCAT(e.emp_fname, ' ', e.emp_lname)) as sender_name")
                ])
                ->get();

            // Parent message
            $parentTime = \Carbon\Carbon::parse($parent->created_at);
            $html .= '<div class="message received">
                        <div class="message-sender">' . htmlspecialchars($parent->sender_name) . '</div>
                        <div class="message-bubble">';
            
            $html .= htmlspecialchars($parent->title);
            
            // Add attachment if exists
            if ($parent->file) {
                $filePath = 'Media/' . basename($parent->file);
                $extension = strtolower(pathinfo($parent->file, PATHINFO_EXTENSION));
                
                if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                    $html .= '<div class="attachment">
                                <img src="' . $filePath . '" alt="Attachment">
                            </div>';
                } else {
                    $html .= '<div class="attachment">
                                <a href="' . $filePath . '" download>📎 ' . basename($parent->file) . '</a>
                            </div>';
                }
            }
            
            $html .= '<div class="message-time">' . $parentTime->format('g:i A') . '</div>
                        </div>
                    </div>';

            // Replies
            foreach ($replies as $reply) {
                $replyTime = \Carbon\Carbon::parse($reply->created_at);
                $html .= '<div class="message sent">
                            <div class="reply-indicator">↪️ Reply to ' . htmlspecialchars($parent->sender_name) . '</div>
                            <div class="message-bubble">';
                
                $html .= htmlspecialchars($reply->title);
                
                // Add attachment if exists
                if ($reply->file) {
                    $filePath = 'Media/' . basename($reply->file);
                    $extension = strtolower(pathinfo($reply->file, PATHINFO_EXTENSION));
                    
                    if (in_array($extension, ['jpg', 'jpeg', 'png', 'gif', 'webp'])) {
                        $html .= '<div class="attachment">
                                    <img src="' . $filePath . '" alt="Attachment">
                                </div>';
                    } else {
                        $html .= '<div class="attachment">
                                    <a href="' . $filePath . '" download>📎 ' . basename($reply->file) . '</a>
                                </div>';
                    }
                }
                
                $html .= '<div class="message-time">' . $replyTime->format('g:i A') . '</div>
                            </div>
                        </div>';
            }
        }

        $html .= '</div>
            </div>
        </body>
        </html>';

        return $html;
    }

    private function generateWhatsAppJSON($project, $parentPosts, $projectId, $fromDate, $toDate)
    {
        $conversation = [
            'project' => [
                'name' => $project->title,
                'description' => $project->description,
                'export_date' => now()->toISOString(),
                'period' => [
                    'from' => $fromDate,
                    'to' => $toDate
                ]
            ],
            'messages' => []
        ];

        foreach ($parentPosts as $parent) {
            // Get replies
            $replies = DB::table('project_post as p')
                ->leftJoin('users as u', function($join) {
                    $join->on('u.employee_id', '=', 'p.employee_code')
                        ->where(function($q) {
                            $q->on('u.emid', '=', 'p.emid')
                            ->orWhereNull('p.emid');
                        });
                })
                ->leftJoin('employee as e', 'e.emp_code', '=', 'p.employee_code')
                ->where('p.parent_id', $parent->id)
                ->whereBetween('p.created_at', [$fromDate, $toDate])
                ->orderBy('p.created_at', 'asc')
                ->get();

            // Add parent message
            $conversation['messages'][] = [
                'id' => $parent->id,
                'type' => 'parent',
                'sender' => $parent->sender_name,
                'message' => $parent->title,
                'timestamp' => $parent->created_at,
                'has_attachment' => !empty($parent->file),
                'attachment' => $parent->file,
                'replies_count' => $replies->count()
            ];

            // Add replies
            foreach ($replies as $reply) {
                $conversation['messages'][] = [
                    'id' => $reply->id,
                    'type' => 'reply',
                    'parent_id' => $parent->id,
                    'sender' => $reply->sender_name ?? 'Unknown',
                    'message' => $reply->title,
                    'timestamp' => $reply->created_at,
                    'has_attachment' => !empty($reply->file),
                    'attachment' => $reply->file
                ];
            }
        }

        return $conversation;
    }

    private function generateWhatsAppTXT($project, $parentPosts, $projectId, $fromDate, $toDate)
    {
        $txt = "================================\n";
        $txt .= "CHAT EXPORT - " . strtoupper($project->title) . "\n";
        $txt .= "================================\n\n";
        $txt .= "Project: " . $project->title . "\n";
        $txt .= "Export Period: " . date('F j, Y', strtotime($fromDate)) . " to " . date('F j, Y', strtotime($toDate)) . "\n";
        $txt .= "Exported: " . now()->format('F j, Y \a\t g:i A') . "\n";
        $txt .= "================================\n\n";

        foreach ($parentPosts as $parent) {
            $parentTime = \Carbon\Carbon::parse($parent->created_at);
            
            $txt .= "[" . $parentTime->format('M j, Y g:i A') . "]\n";
            $txt .= $parent->sender_name . ":\n";
            $txt .= $parent->title . "\n";
            
            if ($parent->file) {
                $txt .= "[Attachment: " . basename($parent->file) . "]\n";
            }
            
            $txt .= "─" . str_repeat("─", 50) . "\n";

            // Get replies
            $replies = DB::table('project_post as p')
                ->leftJoin('users as u', function($join) {
                    $join->on('u.employee_id', '=', 'p.employee_code')
                        ->where(function($q) {
                            $q->on('u.emid', '=', 'p.emid')
                            ->orWhereNull('p.emid');
                        });
                })
                ->leftJoin('employee as e', 'e.emp_code', '=', 'p.employee_code')
                ->where('p.parent_id', $parent->id)
                ->whereBetween('p.created_at', [$fromDate, $toDate])
                ->orderBy('p.created_at', 'asc')
                ->get();

            foreach ($replies as $reply) {
                $replyTime = \Carbon\Carbon::parse($reply->created_at);
                
                $txt .= "   ↳ [" . $replyTime->format('g:i A') . "] " . ($reply->sender_name ?? 'Unknown') . " (reply):\n";
                $txt .= "      " . $reply->title . "\n";
                
                if ($reply->file) {
                    $txt .= "      [Attachment: " . basename($reply->file) . "]\n";
                }
            }
            
            $txt .= "\n" . str_repeat("=", 60) . "\n\n";
        }

        $txt .= "\nTotal Messages: " . count($parentPosts) . "\n";
        $txt .= "Export completed successfully.\n";

        return $txt;
    }

    private function copyMediaFiles($parentPosts, $projectId, $fromDate, $toDate, $mediaFolder)
    {
        // Get all files from posts and replies
        $allFiles = [];
        
        foreach ($parentPosts as $parent) {
            if ($parent->file) {
                $allFiles[] = $parent->file;
            }
            
            // Get replies for this parent
            $replies = DB::table('project_post')
                ->where('parent_id', $parent->id)
                ->whereBetween('created_at', [$fromDate, $toDate])
                ->whereNotNull('file')
                ->pluck('file')
                ->toArray();
            
            $allFiles = array_merge($allFiles, $replies);
        }
        
        // Copy each file
        foreach (array_unique($allFiles) as $file) {
            if (!empty($file)) {
                $sourcePath = storage_path('app/public/' . $file);
                if (file_exists($sourcePath)) {
                    $destPath = $mediaFolder . '/' . basename($file);
                    copy($sourcePath, $destPath);
                }
            }
        }
    }

    private function addFolderToZip($folder, &$zip, $exclusiveLength)
    {
        $handle = opendir($folder);
        while (false !== $f = readdir($handle)) {
            if ($f != '.' && $f != '..') {
                $filePath = "$folder/$f";
                $localPath = substr($filePath, $exclusiveLength);
                
                if (is_file($filePath)) {
                    $zip->addFile($filePath, $localPath);
                } elseif (is_dir($filePath)) {
                    $zip->addEmptyDir($localPath);
                    $this->addFolderToZip($filePath, $zip, $exclusiveLength);
                }
            }
        }
        closedir($handle);
    }

    private function deleteDirectory($dir)
    {
        if (!file_exists($dir)) {
            return true;
        }
        
        if (!is_dir($dir)) {
            return unlink($dir);
        }
        
        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            
            if (!$this->deleteDirectory($dir . DIRECTORY_SEPARATOR . $item)) {
                return false;
            }
        }
        
        return rmdir($dir);
    }


    // public function projectAnalitics($id)
    // {
    //     $id = decrypt($id);
    //     dd($id);
    //     $email = Session::get("emp_email");
    //     $emid = Session::get("emid");
    //     //dd($emid);
    //     if (empty($email)) {
    //         return redirect("/");
    //     }
    //     return view('employeer/task-management/project-management/project-analitics-dashboard');
    // }

    public function projectAnalitics($id)
    {
        $id = decrypt($id);
        //dd(encrypt($id));
        $emid = Session::get("emid");
        $email = Session::get("emp_email");
        if (empty($email)) {
            return redirect("/");
        }

        // ✅ Total Members
        // $totalMembers = DB::table('project_members')
        //     ->where('project_id', $id)
        //     ->distinct('user_id')
        //     ->count('user_id');

        $totalMembers = DB::table('work_items as w')
            ->join('work_item_assignments as wia', 'w.id', '=', 'wia.work_item_id')
            ->where('w.project_id', $id)
            ->where('w.emid', $emid)
            ->count(DB::raw('DISTINCT wia.employee_id'));

        //$totalMembers = 10;

        $projects = DB::table('projects')
            ->where('id', $id)
            ->where('emid', $emid)
            ->first();    

        $activeProject = DB::table('projects')
            ->where('id', $id)
            ->where('emid', $emid)
            ->where('status', 'open')
            ->count('id');
            
        $closedProject = DB::table('projects')
            ->where('id', $id)
            ->where('emid', $emid)
            ->where('status', 'closed')
            ->count('id');

        //dd($activeProject, $closedProject);
        //  Total Tasks
        $totalTasks = DB::table('work_items')
            ->where('type', 'task')
            ->where('project_id', $id)
            ->count();

        $totalModule = DB::table('work_items')
            ->where('type', 'module')
            ->where('project_id', $id)
            ->count();  
            
        $totalSubmodule = DB::table('work_items')
            ->where('type', 'submodule')
            ->where('project_id', $id)
            ->count();
            
        $totalSubtask = DB::table('work_items')
            ->where('type', 'subtask')
            ->where('project_id', $id)
            ->count();    
        //dd($totalTasks);
        //  Member Roles Count


        $memberRoles = DB::table('work_item_user_roles')
            ->where('project_id', $id)
            ->where('emid', $emid)
            ->count(DB::raw('DISTINCT employee_id'));
        //dd('total Role ='.$memberRoles);
        //  Member Labels Count (assuming column = label)
        $memberLabels = DB::table('tm_master_labels')
            ->where('project_id', $id)
            ->select('title', DB::raw('COUNT(*) as total'))
            ->groupBy('title')
            ->get();
        
        // ✅ Project Status Chart
        $projectStatus = [
            'completed' => $closedProject,
            'running' => $activeProject,
            'pending' => 0 // if you have pending status, update here
        ];

        // ✅ Task Analytics
        $completedTasks = DB::table('tasks')
            ->where('project_id', $id)
            ->where('status', 'completed')
            ->count();

        $pendingTasks = DB::table('tasks')
            ->where('project_id', $id)
            ->where('status', 'pending')
            ->count();

        // ✅ Member Growth (Monthly)
        $memberGrowth = DB::table('project_members')
            ->select(
                DB::raw("MONTH(created_at) as month"),
                DB::raw("COUNT(*) as total")
            )
            ->where('project_id', $id)
            ->groupBy(DB::raw("MONTH(created_at)"))
            ->orderBy('month')
            ->get();
         //dd('total Label ='.$memberGrowth);

         $employeeTasks = DB::table('tasks as t')
            ->join('employee as e', 'e.id', '=', 't.assignedTo')
            ->select(
                DB::raw("CONCAT(e.emp_fname, ' ', e.emp_lname) as name"),
                't.status',
                DB::raw("COUNT(*) as total")
            )
            ->where('t.project_id', $id)
            ->groupBy('t.assignedTo', 't.status', 'e.emp_fname', 'e.emp_lname')
            ->get();

        $labels = DB::table('tm_master_labels')
            ->where('project_id', $id)
            ->pluck('title')
            ->unique()
            ->values();    
        //dd($employeeTasks);
        return view('employeer/task-management/project-controll/project-analitics-dashboard', compact(
        // return view('employeer/task-management/project-management/project-analitics-dashboard', compact(
            'totalMembers',
            'totalModule',
            'totalSubmodule',
            'totalTasks',
            'totalSubtask',
            'memberRoles',
            'memberLabels',
            'activeProject',
            'closedProject',
            'id',
            'projectStatus',
            'completedTasks',
            'pendingTasks',
            'memberGrowth',
            'projects',
            'employeeTasks',
            'labels'
        ));
    }

    

}
