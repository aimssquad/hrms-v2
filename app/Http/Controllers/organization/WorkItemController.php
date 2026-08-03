<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TaskManagement\WorkItem;
use App\Models\TaskManagement\WorkItemComment;
use App\Models\TaskManagement\WorkItemReminder;
use DB;
use Session;
use Storage;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Mail\WorkItemReminderMail;

class WorkItemController extends Controller
{
    
    
    public function workItemList(Request $request, $id, $workItem)
    {
        $project_id = decrypt($id);
        //dd($project_id, $workItem);
        $workItems = WorkItem::where('project_id', $project_id)
            ->where('type', $workItem)
            ->latest()
            ->get();
        
      
        if ($workItems->isEmpty()) {
            return view(
                'employeer.task-management.project-controll.work-item-list',
                compact('workItems', 'project_id', 'workItem')
            );
        }        
        
       
        return view(
            'employeer.task-management.project-controll.work-item-list',
            compact('workItems', 'project_id', 'workItem')
        );
    }
    
    // public function createWorkItem($id, $workItem)
    // {
    //     $project_id = decrypt($id);
    
    //     return view(
    //         'employeer.task-management.project-controll.create-work-item',
    //         compact('project_id', 'workItem')
    //     );
    // }
    
    
    public function createWorkItem($id, $workItem)
    {
        $project_id = decrypt($id);
    
        $parents = collect();
    
        if ($workItem == 'submodule') {
    
            $parents = WorkItem::where('project_id', $project_id)
                ->where('type', 'module')
                ->get();
    
        } elseif ($workItem == 'task') {
    
            $parents = WorkItem::where('project_id', $project_id)
                ->whereIn('type', ['module','submodule'])
                ->get();
    
        } elseif ($workItem == 'subtask') {
    
            $parents = WorkItem::where('project_id', $project_id)
                ->where('type', 'task')
                ->get();
        }
    
        return view(
            'employeer.task-management.project-controll.create-work-item',
            compact(
                'project_id',
                'workItem',
                'parents'
            )
        );
    }
    
    
    public function storeWorkItem(Request $request)
    {
        try {
            
            $email = Session::get("emp_email");
            if (empty($email)) {
                return redirect("/");
            }
            
            $currentuser = DB::table('users')->where('email', $email)->first();
            $currentEmployeeId = $currentuser->employee_id;
            
            $request->validate([
                'project_id' => 'required|exists:projects,id',
                'type'       => 'required|in:module,submodule,task,subtask',
                'title'      => 'required|max:255',
                'parent_id'  => 'nullable|exists:work_items,id',
                'priority'   => 'required|in:low,medium,high',
                'start_date' => 'nullable|date',
                'end_date'   => 'nullable|date|after_or_equal:start_date',
               'image' => 'nullable|file|mimes:jpg,jpeg,png,gif,webp,pdf,doc,docx,xls,xlsx|max:10240',
            ]);
    
            /*
            |--------------------------------------------------------------------------
            | Parent Validation
            |--------------------------------------------------------------------------
            */
    
            if ($request->parent_id) {
    
                $parent = WorkItem::find($request->parent_id);
    
                if (
                    $request->type == 'submodule'
                    &&
                    $parent->type != 'module'
                ) {
                    return redirect()->back()
                        ->with('error', 'Submodule must belong to Module');
                }
    
                if (
                    $request->type == 'task'
                    &&
                    !in_array($parent->type, ['module', 'submodule'])
                ) {
                    return redirect()->back()
                        ->with('error', 'Task must belong to Module or Submodule');
                }
    
                if (
                    $request->type == 'subtask'
                    &&
                    $parent->type != 'task'
                ) {
                    return redirect()->back()
                        ->with('error', 'Subtask must belong to Task');
                }
            }
    
            /*
            |--------------------------------------------------------------------------
            | Upload Image
            |--------------------------------------------------------------------------
            */
    
            $image = null;
    
            if ($request->hasFile('image')) {
    
                $image = $request->file('image')
                    ->store('work-items', 'public');
            }
    
            /*
            |--------------------------------------------------------------------------
            | Generate Unique ID
            |--------------------------------------------------------------------------
            */
    
            $uniqueId = strtoupper($request->type)
                . '-'
                . str_pad(
                    WorkItem::count() + 1,
                    5,
                    '0',
                    STR_PAD_LEFT
                );
    
            /*
            |--------------------------------------------------------------------------
            | Create Work Item
            |--------------------------------------------------------------------------
            */
    
            WorkItem::create([
                'unique_id'  => $uniqueId,
                'project_id' => $request->project_id,
                'parent_id'  => $request->parent_id,
                'type'       => $request->type,
                'title'      => $request->title,
                'description'=> $request->description,
                'image'      => $image,
                'priority'   => $request->priority,
                'start_date' => $request->start_date,
                'end_date'   => $request->end_date,
                'created_by' => $currentEmployeeId,
                'status'     => 'open',
                'emid'       => $currentEmployeeId,
            ]);
    
            return redirect()
                ->route('work-item.list', [
                    'id' => encrypt($request->project_id),
                    'workItem' => $request->type
                ])
                ->with(
                    'success',
                    ucfirst($request->type) . ' created successfully.'
                );
    
        } catch (\Exception $e) {
    
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }


    public function editProjectModule($projectId, $moduleId)
    {
        
        $project_id = decrypt($projectId);
        $module_id = decrypt($moduleId);

        $workItem = WorkItem::where('id', $module_id)
            ->where('project_id', $project_id)
            ->firstOrFail();
        //dd($project_id, $module_id, $module);
        return view(
            'employeer.task-management.project-controll.edit-work-item',
            compact('workItem', 'project_id')
        );
    }

    public function updateProjectModule(Request $request, $moduleId)
    {
        try {
            $module_id = decrypt($moduleId);
            $workItem = WorkItem::findOrFail($module_id);

            $request->validate([
                'title' => 'required|max:255',
                'description' => 'nullable|string',
                'priority' => 'required|in:low,medium,high',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
                'status' => 'required|in:open,close',
            ]);
            //dd($request->all());
            $workItem->update([
                'title' => $request->title,
                'description' => $request->description,
                'priority' => $request->priority,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'status' => $request->status,
            ]);

            return redirect()
                ->route('work-item.list', [
                    'id' => encrypt($workItem->project_id),
                    'workItem' => $workItem->type
                ])
                ->with('success', ucfirst($workItem->type) . ' updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->withInput()
                ->with('error', $e->getMessage());
        }
    }

    public function deleteProjectModule($projectId, $moduleId)
    {
        try {
            $project_id = decrypt($projectId);
            $module_id = decrypt($moduleId);

            $workItem = WorkItem::where('id', $module_id)
                ->where('project_id', $project_id)
                ->firstOrFail();

            $workItem->delete();

            return redirect()
                ->route('work-item.list', [
                    'id' => encrypt($project_id),
                    'workItem' => $workItem->type
                ])
                ->with('success', ucfirst($workItem->type) . ' deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
    
    
    
   
   
   
   
   
   
   
   
    public function assignWorkItemRole($projectId, $workItemId)
    {
        
        $email = Session::get("emp_email");
        if (empty($email)) {
            return redirect("/");
        }
        
        $currentuser = DB::table('users')->where('email', $email)->first();
    
        $project_id = decrypt($projectId);
    
        $work_item_id = decrypt($workItemId);
        //dd($project_id, $work_item_id);
        $workItem = WorkItem::findOrFail($work_item_id);
    
        $roles = DB::table('project_roles')
            ->where('emid', $currentuser->employee_id)
            ->get();
    
        $employees = DB::table('users')
            ->whereNotNull('employee_id')
            ->select('employee_id', 'name')
            ->get();
    
        $assignments = DB::table('work_item_user_roles as wur')
            ->leftJoin(
                'users as u',
                'u.employee_id',
                '=',
                'wur.employee_id'
            )
            ->leftJoin(
                'project_roles as pr',
                'pr.id',
                '=',
                'wur.project_role_id'
            )
            ->where('wur.work_item_id', $work_item_id)
            ->where('u.emid', $currentuser->employee_id)
            ->select(
                'wur.*',
                'u.name as employee_name',
                'pr.name as role_name'
            )
            ->get();
        //dd($workItem, $project_id);
        return view(
            'employeer.task-management.project-controll.assignments',
            compact(
                'workItem',
                'roles',
                'employees',
                'assignments',
                'project_id',
                'projectId'
            )
        );
    }
   
    public function assignWorkItemRoleCreate($projectId, $workItemId)
    {
        //dd($projectId, $workItemId);
        $email = Session::get("emp_email");
        if (empty($email)) {
            return redirect("/");
        }
        
        $currentuser = DB::table('users')->where('email', $email)->first();
        
        
        $project_id = decrypt($projectId);
    
        $work_item_id = $workItemId;
    
        $workItem = WorkItem::findOrFail($work_item_id);
    
        $roles = DB::table('project_roles')
            ->where('emid', $currentuser->employee_id)
            ->get();
    
        $employees = DB::table('users')
            ->where('emid', $currentuser->employee_id)
            ->select(
                'employee_id',
                'name'
            )
            ->orderBy('name')
            ->get();
    
        return view(
            'employeer.task-management.project-controll.assign-work-item',
            compact(
                'project_id',
                'workItem',
                'roles',
                'employees'
            )
        );
    }
    
    
    public function storeAssignment(Request $request)
    {
        //dd($request->all());
        $email = Session::get("emp_email");
        if (empty($email)) {
            return redirect("/");
        }
        
        $currentuser = DB::table('users')->where('email', $email)->first();
        
        $request->validate([
            'project_id'      => 'required',
            'work_item_id'    => 'required',
            'employee_id'     => 'required',
            'project_role_id' => 'required',
        ]);
        
        $exists = DB::table('work_item_user_roles')
            ->where('project_id', $request->project_id)
            ->where('work_item_id', $request->work_item_id)
            ->where('employee_id', $request->employee_id)
            ->where('project_role_id', $request->project_role_id)
            ->exists();
        
        if ($exists) {
            return back()->with(
                'error',
                'This employee is already assigned with this role.'
            );
        }
        
        //dd('okk');
        DB::table('work_item_user_roles')->insert([
            'project_id'      => $request->project_id,
            'work_item_id'    => $request->work_item_id,
            'employee_id'     => $request->employee_id,
            'project_role_id' => $request->project_role_id,
            'emid'            => $currentuser->employee_id,    
            'created_by'      => $currentuser->employee_id,
            'created_at'      => now(),
            'updated_at'      => now(),
        ]);

        // work item also assigned
         $module = DB::table('work_item_assignments')
            //->where('project_id', $request->project_id)
            ->where('work_item_id', $request->work_item_id)
            ->where('employee_id', $request->employee_id)
            ->where('emid', $currentuser->employee_id)
            ->exists();
        
        if ($module) {
            return back()->with(
                'error',
                'This employee is already assigned this project label.'
            );
        }
        
        //dd('okk');
        DB::table('work_item_assignments')->insert([
           // 'project_id'      => $request->project_id,
            'work_item_id'    => $request->work_item_id,
            'employee_id'     => $request->employee_id,
            //'project_role_id' => $request->project_role_id,
            'emid'            => $currentuser->employee_id,    
            'assigned_by'      => $currentuser->employee_id,
            'status'          => "assigned",
            'assigned_at'      => now(),
        ]);
    
        return redirect()
            ->route('work-item.assign', [
                'id' => encrypt($request->project_id),
                'workItem' => encrypt($request->work_item_id)
            ])
            ->with(
                'success',
                ucfirst($request->type) . ' created successfully.'
            );
    }
    
    
    public function index($projectId, $workItemId)
    {
        $email = Session::get("emp_email");
        if (empty($email)) {
            return redirect("/");
        }
        
        $currentuser = DB::table('users')->where('email', $email)->first();
        
        $organizationId = $currentuser->employee_id;
        
        $project_id = decrypt($projectId);
        $work_item_id = decrypt($workItemId);
        
        //dd($project_id, $work_item_id);
    
        // $comments = DB::table('work_item_comments as wc')
        //     ->leftJoin('users as u', 'u.employee_id', '=', 'wc.employee_id')
        //     ->where('wc.project_id', $project_id)
        //     ->where('wc.work_item_id', $work_item_id)
        //     ->select(
        //         'wc.*',
        //         'u.name'
        //     )
        //     ->orderBy('wc.id')
        //     ->get();
        
        $comments = WorkItemComment::with([
            'user',
            'replies.user'
        ])
        ->where('project_id', $project_id)
        ->where('work_item_id', $work_item_id)
        ->whereNull('parent_comment_id')
        ->where('is_deleted', 0)
        ->orderBy('id', 'ASC')
        ->get();
        //         dd(
        //     WorkItemComment::whereNotNull('parent_comment_id')->get()
        // );
        //dd($comments);
        return view(
            'employeer.task-management.project-controll.comment',
            compact(
                'project_id',
                'work_item_id',
                'comments',
                'organizationId'
            )
        );
    }
    
    public function store(Request $request)
    {
        //dd($request->all());
        $email = Session::get("emp_email");
    
        $user = DB::table('users')
            ->where('email', $email)
            ->first();
    
        $request->validate([
            'project_id' => 'required',
            'work_item_id' => 'required',
            'parent_comment_id'=> 'nullable|exists:work_item_comments,id',
            'comment' => 'required'
        ]);
    
        $file = null;
    
        if ($request->hasFile('file')) {
    
            $file = $request->file('file')
                ->store('work-item-comments', 'public');
        }
    
        DB::table('work_item_comments')->insert([
            'project_id' => $request->project_id,
            'work_item_id' => $request->work_item_id,
            'parent_comment_id'=> $request->parent_comment_id,
            'employee_id' => $user->employee_id,
            'comment' => $request->comment,
            'file' => $file,
            'emid'       => $user->employee_id,
            'created_at' => now(),
            'updated_at' => now()
        ]);
    
        return back()->with(
            'success',
            'Comment added successfully'
        );
    }

    //workItem Remaindermail set up
    public function workItemremainderMail(Request $request, $id, $workItem)
    {
        $email = Session::get("emp_email");
        if (empty($email)) {
            return redirect("/");
        }

        $organization = DB::table('users')->where('email', $email)->select('employee_id')->first();

        if(empty($organization)){
            return redirect()->back()->with('error', 'Organization not found');
        }

        $emid = $organization->employee_id;

        $projectId = decrypt($id);
        $workItemId = decrypt($workItem);

        $project = DB::table('projects')->where('id', $projectId)->where('emid', $emid)->select('title')->first();
        if(empty($project)){
            return redirect()->back()->with('error', 'Project not found');
        }
        //dd($project->title);

        // Current Work Item
        $workItemData = WorkItem::where('id', $workItemId)
            ->where('project_id', $projectId)
            ->where('emid', $emid)
            ->firstOrFail();
        //dd($workItemData);
        /*
        |--------------------------------------------------------------------------
        | Get Parent Hierarchy
        |--------------------------------------------------------------------------
        */

        $parentIds = [];

        $item = $workItemData;

        while ($item) {

            $parentIds[] = $item->id;

            if (!$item->parent_id) {
                break;
            }

            $item = WorkItem::find($item->parent_id);
        }

        /*
        |--------------------------------------------------------------------------
        | Get All Assigned Employees
        |--------------------------------------------------------------------------
        */
        //dd($parentIds);
        $employees = DB::table('work_item_assignments as wa')

            ->join('users as u', function ($join) {

                $join->on('u.employee_id', '=', 'wa.employee_id');
            })

            ->join('work_items as wi', 'wi.id', '=', 'wa.work_item_id')

            ->whereIn('wa.work_item_id', $parentIds)

            ->where('wa.emid', $emid)
            ->where('u.emid', $emid)

            ->select(
                'u.employee_id',
                'u.name',
                'u.email',
                'wi.title as work_item_name',
                'wi.type as work_item_type',
                'wa.work_item_id'
            )

            ->distinct()

            ->orderBy('wi.id')

            ->get();
        //dd($employees, $workItemData);
        return view(
            'employeer.task-management.project-controll.task-reminder-mail',
            compact(
                'employees',
                'workItemData','project'
            )
        );
    }

    public function remainderMailSettings(Request $request)
    {
        try {

            $email = Session::get("emp_email");
            if (empty($email)) {
                return redirect("/");
            }

            $organization = DB::table('users')->where('email', $email)->select('employee_id')->first();

            if(empty($organization)){
                return redirect()->back()->with('error', 'Organization not found');
            }

            $emid = $organization->employee_id;
            
            $request->validate([

                'work_item_id' => 'required|exists:work_items,id',

                'employee_ids' => 'required|array',

                'employee_ids.*' => 'required',

                'reminder_type' => 'required|in:before_due,due_today,overdue',

                'days_before' => 'required|integer|min:1|max:30',

                //'status' => 'required|in:0,1',

                'sent_at' => 'nullable|date',

            ]);

            foreach ($request->employee_ids as $employeeId) {

                WorkItemReminder::updateOrCreate(

                    [
                        'work_item_id' => $request->work_item_id,
                        'employee_id'  => $employeeId,
                    ],

                    [
                        'reminder_type' => $request->reminder_type,
                        'days_before'   => $request->days_before,
                        'sent_at'       => $request->sent_at
                                                ? Carbon::parse($request->sent_at)
                                                : null,
                        'emid'        => $emid,
                    ]

                );
            }

            return redirect()->back()->with(
                'success',
                'Reminder settings saved successfully.'
            );

        } catch (\Exception $e) {

            return redirect()->back()->with(
                'error',
                $e->getMessage()
            );
        }
    }


    public function testReminderMail()
    {   
        $today = Carbon::today();

        $reminders = DB::table('work_item_reminders as wr')

            ->join('work_items as wi', 'wi.id', '=', 'wr.work_item_id')

            ->join('projects as p', 'p.id', '=', 'wi.project_id')

            ->join('users as u', function ($join) {

                $join->on('u.employee_id', '=', 'wr.employee_id')
                    ->on('u.emid', '=', 'wi.emid');

            })

            ->where('wr.status', 0)

            ->select(
                'wr.id as reminder_id',
                'wr.days_before',
                'wr.reminder_type',

                'u.name',
                'u.email',

                'p.title as project_title',

                'wi.title',
                'wi.description',
                'wi.end_date',
                'wi.id as work_item_id'
            )

            ->get();

        if ($reminders->isEmpty()) {

            return response()->json([
                'status' => 0,
                'message' => 'No reminder records found.'
            ]);
        }
        dd($reminders);
        foreach ($reminders as $reminder) {
            //dd($reminder);
            $send = false;

            switch ($reminder->reminder_type) {

                case 'before_due':

                    if (
                        Carbon::parse($reminder->end_date)
                            ->subDays($reminder->days_before)
                            ->isSameDay($today)
                    ) {
                        $send = true;
                    }
                    //dd($send, $reminder->end_date, $reminder->days_before, $today);
                break;

                case 'due_today':

                    if (
                        Carbon::parse($reminder->end_date)
                            ->isSameDay($today)
                    ) {
                        $send = true;
                    }

                break;

                case 'overdue':

                    if (
                        Carbon::parse($reminder->end_date)
                            ->lt($today)
                    ) {
                        $send = true;
                    }

                break;
            }

            if (!$send) {
                continue;
            }
            
            Mail::to($reminder->email)
                ->send(new WorkItemReminderMail($reminder));

            DB::table('work_item_reminders')
                ->where('id', $reminder->reminder_id)
                ->update([
                    'status' => 1,
                    'sent_at' => now()
                ]);
        }

        return response()->json([
            'status' => 1,
            'message' => 'Reminder mail process completed.'
        ]);
    }


    public function assignWorkItem($projectId, $workItemId)
    {
        
        $email = Session::get("emp_email");
        if (empty($email)) {
            return redirect("/");
        }
        
        $currentuser = DB::table('users')->where('email', $email)->first();
    
        $project_id = decrypt($projectId);
    
        $work_item_id = decrypt($workItemId);
        //dd($project_id, $work_item_id);
        $workItem = WorkItem::findOrFail($work_item_id);
    
        $roles = DB::table('project_roles')
            ->where('emid', $currentuser->employee_id)
            ->get();
    
        $employees = DB::table('users')
            ->whereNotNull('employee_id')
            ->select('employee_id', 'name')
            ->get();
    
        $assignments = DB::table('work_item_assignments as wia')
            ->leftJoin(
                'users as u',
                'u.employee_id',
                '=',
                'wia.employee_id'
            )
            ->where('wia.work_item_id', $work_item_id)
            ->where('u.emid', $currentuser->employee_id)
            ->select(
                'wia.*',
                'u.name as employee_name'
            )
            ->get();
        //dd($assignments, $employees, $roles);    
    
        return view(
            'employeer.task-management.project-controll.work-itam-assign-list',
            compact(
                'workItem',
                'roles',
                'employees',
                'assignments',
                'project_id'
            )
        );
    }

    public function assignWorkItemCreate($projectId, $workItemId)
    {
        //dd($projectId, $workItemId);
        $email = Session::get("emp_email");
        if (empty($email)) {
            return redirect("/");
        }
        
        $currentuser = DB::table('users')->where('email', $email)->first();
        
        
        $project_id = decrypt($projectId);
    
        $work_item_id = $workItemId;
        //dd($project_id, $work_item_id);
        $workItem = WorkItem::findOrFail($work_item_id);
    
        $roles = DB::table('project_roles')
            ->where('emid', $currentuser->employee_id)
            ->get();
    
        $employees = DB::table('users')
            ->where('emid', $currentuser->employee_id)
            ->select(
                'employee_id',
                'name'
            )
            ->orderBy('name')
            ->get();
    
        return view(
            'employeer.task-management.project-controll.employee-assign-workitem',
            compact(
                'project_id',
                'workItem',
                'roles',
                'employees'
            )
        );
    }


    public function employeeAssignWorkItem(Request $request)
    {
        //dd($request->all());
        $email = Session::get("emp_email");
        if (empty($email)) {
            return redirect("/");
        }
        
        $currentuser = DB::table('users')->where('email', $email)->first();
        
        $request->validate([
            'work_item_id'    => 'required',
            'employee_id'     => 'required',
        ]);
        
        $exists = DB::table('work_item_assignments')
            //->where('project_id', $request->project_id)
            ->where('work_item_id', $request->work_item_id)
            ->where('employee_id', $request->employee_id)
            ->where('emid', $currentuser->employee_id)
            ->exists();
        
        if ($exists) {
            return back()->with(
                'error',
                'This employee is already assigned this project label.'
            );
        }
        
        //dd('okk');
        DB::table('work_item_assignments')->insert([
           // 'project_id'      => $request->project_id,
            'work_item_id'    => $request->work_item_id,
            'employee_id'     => $request->employee_id,
            //'project_role_id' => $request->project_role_id,
            'emid'            => $currentuser->employee_id,    
            'assigned_by'      => $currentuser->employee_id,
            'status'          => "assigned",
            'assigned_at'      => now(),
        ]);
    
        return redirect()
            ->route('work-item.assign', [
                'id' => encrypt($request->project_id),
                'workItem' => encrypt($request->work_item_id)
            ])
            ->with(
                'success',
                ucfirst($request->type) . ' created successfully.'
            );
    }
        
    
    
}
