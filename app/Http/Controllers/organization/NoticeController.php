<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notice;
use App\Models\Notification;
use App\Models\UserModel;
use App\Events\NoticeCreated;
use Exception;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use App\Services\FirebaseService;
use Validator;
use App\Models\EmpNotification;
use App\Models\EmpNotificationSetting;
use App\Models\EmpNotificationModule;
use DB;

class NoticeController extends Controller
{
    protected $_module;
    protected $_routePrefix;
    protected $_model;

    public function __construct()
    {
        $this->_module      = 'Notice';
        $this->_routePrefix = 'employeer.notice';
        $this->_model       = new Notice();
    }

    public function dashbaord()
    {
        $email = Session::get('emp_email');
        $user_id = Session::get('users_id');
        $emid = Session::get('emid');
        
        if (!empty($email)) {
            // Get all notifications with employee details
            $notices = DB::table('emp_notifications')
                ->leftJoin('employee', 'emp_notifications.employee_id', '=', 'employee.emp_code')
                // ->where('emp_notifications.type', 'NOTICE')
                ->where('emp_notifications.emid', $emid)
                ->select(
                    'emp_notifications.*',
                    'employee.emp_fname',
                    'employee.emp_mname',
                    'employee.emp_lname',
                    DB::raw("CONCAT(COALESCE(employee.emp_fname, ''), ' ', COALESCE(employee.emp_mname, ''), ' ', COALESCE(employee.emp_lname, '')) as employee_full_name")
                )
                ->orderBy('emp_notifications.id', 'desc')
                ->get();
            
            // Statistics calculations
            $totalNotifications = $notices->count();
            $unreadNotifications = $notices->where('is_read', 0)->count();
            $readNotifications = $notices->where('is_read', 1)->count();
            $readPercentage = $totalNotifications > 0 ? round(($readNotifications / $totalNotifications) * 100) : 0;
            
            // Get notifications grouped by employee with both total and unread counts
            $unreadByEmployee = $notices->groupBy('employee_id')
                ->map(function ($items, $employeeId) {
                    $firstItem = $items->first();
                    $totalCount = $items->count();
                    $unreadCount = $items->where('is_read', 0)->count();
                    $readCount = $items->where('is_read', 1)->count();
                    
                    return [
                        'employee_name' => $firstItem->employee_full_name ?: 'All Employees',
                        'employee_id' => $employeeId,
                        'total_count' => $totalCount,
                        'unread_count' => $unreadCount,
                        'read_count' => $readCount,
                        'read_percentage' => $totalCount > 0 ? round(($readCount / $totalCount) * 100) : 0,
                        'notifications' => $items->where('is_read', 0) // Only unread for details
                    ];
                })
                ->sortByDesc('unread_count')
                ->values();

            $noticeCount = DB::table('notices')
                ->where('organization_id', $emid)
                ->where('created_by_type', 'organization')
                ->where('created_by_id', $user_id)
                ->count();
            
            return view($this->_routePrefix . '.notification-dashboard', compact('notices', 'totalNotifications', 'unreadNotifications', 'readNotifications', 'readPercentage', 'unreadByEmployee','noticeCount'));
        } else {
            return redirect('/');
        }
    }

    public function allNotification()
    {
        $email = Session::get('emp_email');
        $user_id = Session::get('users_id');
        $emid = Session::get('emid');
        
        if (!empty($email)) {
            // Get all notifications with employee details
            $notices = DB::table('emp_notifications')
                ->leftJoin('employee', 'emp_notifications.employee_id', '=', 'employee.emp_code')
                ->where('emp_notifications.emid', $emid)
                ->select(
                    'emp_notifications.*',
                    'employee.emp_fname',
                    'employee.emp_mname',
                    'employee.emp_lname',
                    DB::raw("CONCAT(COALESCE(employee.emp_fname, ''), ' ', COALESCE(employee.emp_mname, ''), ' ', COALESCE(employee.emp_lname, '')) as employee_full_name")
                )
                ->orderBy('emp_notifications.id', 'desc')
                ->get();
            //dd($notices);
            return view($this->_routePrefix . '.notification-list', compact('notices'));
        } else {
            return redirect('/');
        }
    }

    public function index()
    {   
        try {
            $email = Session::get('emp_email');
            $user_id = Session::get('users_id');
            
            if (!empty($email)) {
                $notices = Notice::where('created_by_type', 'organization')
                    ->where('created_by_id', $user_id)
                    ->orderBy('id', 'desc')
                    ->get();

                //dd($notices);    
                return view($this->_routePrefix . '.notices-list', compact('notices'));
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function create(Request $request){
        try {
            $email = Session::get('emp_email');
            $emid = Session::get('emid');
            //dd($emid);
            //dd($email);
            if (!empty($email)) {
                $employees = DB::table('employee')->where('emid',$emid)->select('emp_code','emp_fname','emp_mname','emp_lname')->get();
                return view($this->_routePrefix . '.notice-add', compact('employees'));
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }


    public function store(Request $request)
    {
        $userId = Session::get('users_id');
        $emid = Session::get('emid');
        //dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'notice_for' => 'required|string', // ALL / SINGLE
            'created_by_type' => 'required|string',
            'employee_id' => 'nullable' // for single user
        ]);
        
        try {

            // Upload image
            $imagePath = $request->file('image')
                ? $request->file('image')->store('notices', 'public')
                : null;

            // Save notice
            $notice = Notice::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'image' => $imagePath,
                'notice_for' => $validated['notice_for'],
                'created_by_type' => $validated['created_by_type'],
                'created_by_id' => $userId,
                'organization_id' => $emid
            ]);

            $title = $validated['title'];
            $message = $validated['description'];

            //  SEND TO ALL EMPLOYEES
            if ($validated['notice_for'] == 'all') {

                $users = DB::table('users')
                    ->join('user_devices', 'user_devices.user_id', '=', 'users.id')
                    ->where('users.emid', $emid)
                    ->select('users.employee_id', 'users.id', 'user_devices.fcm_token')
                    ->get();
                //dd($users);
                foreach ($users as $user) {

                    // MUTE CHECK
                    if (EmpNotificationSetting::isMuted(
                        $user->employee_id,
                        EmpNotificationModule::NOTICE ?? 7 
                    )) {
                        continue;
                    }

                    // STORE NOTIFICATION
                    EmpNotification::create([
                        'emid' => $emid,
                        'employee_id' => $user->employee_id,
                        'user_id' => $user->id,
                        'type' => 'NOTICE',
                        'title' => $title,
                        'description' => $message,
                        'reference_id' => $notice->id,
                        'reference_type' => 'notice',
                        'start_date' => $validated['start_date'],
                        'end_date' => $validated['end_date'],
                        'status' => 1,
                    ]);

                    //FIREBASE SEND
                    app(\App\Services\FirebaseService::class)
                        ->send($user->fcm_token, $title, $message);
                }
            }

            // SEND TO SINGLE EMPLOYEE
            if ($validated['notice_for'] != 'all') {

                $employeeId = $validated['notice_for'];

                $users = DB::table('user_devices')
                    ->join('users', 'users.id', '=', 'user_devices.user_id')
                    ->where('users.employee_id', $employeeId)
                    ->select('users.id as user_id', 'user_devices.fcm_token')
                    ->get();

                // MUTE CHECK
                if (!EmpNotificationSetting::isMuted(
                    $employeeId,
                    EmpNotificationModule::NOTICE ?? 7
                )) {
                    foreach ($users as $user) {
                        EmpNotification::create([
                            'emid' => $emid,
                            'employee_id' => $employeeId,
                            'user_id' => $user->user_id, 
                            'type' => 'NOTICE',
                            'title' => $title,
                            'description' => $message,
                            'reference_id' => $notice->id,
                            'reference_type' => 'notice',
                            'start_date' => $validated['start_date'],
                            'end_date' => $validated['end_date'],
                            'status' => 1,
                        ]);

                        // FIREBASE SEND
                        app(\App\Services\FirebaseService::class)
                            ->send($user->fcm_token, $title, $message);
                    }
                }
            }

            Session::flash('message', 'Notice added successfully.');
            return redirect('notice/org-notice');

        } catch (\Exception $e) {

            \Log::error($e->getMessage());

            Session::flash('error', 'Something went wrong.');
            return redirect('notice/add-notice');
        }
    }

    public function edit(Request $request,$id){
        try {
            $email = Session::get('emp_email');
            if (!empty($email)) {
                $notice = Notice::findOrFail($id);
                //dd($notice);
                return view($this->_routePrefix . '.notice-edit',compact('notice'));
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        $email = Session::get('emp_email');
        if (!empty($email)) {
            $request->validate([
                'title' => 'required|string|max:255',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after_or_equal:start_date',
                'description' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
    
            $notice = Notice::findOrFail($id);
    
            // Update fields
            $notice->title = $request->input('title');
            $notice->start_date = $request->input('start_date');
            $notice->end_date = $request->input('end_date');
            $notice->description = $request->input('description');
    
            // Handle file upload
            if ($request->hasFile('image')) {
                // Delete the old image if it exists
                if ($notice->image && Storage::exists($notice->image)) {
                    Storage::delete($notice->image);
                }
    
                // Store the new image
                $path = $request->file('image')->store('notices', 'public');
                $notice->image = $path;
            }
    
            $notice->save();
            Session::flash('message', 'Notice update successfully.');
            return redirect('notice/org-notice');
        } else {
            return redirect('/');
        }
        
    }

    public function destroy($id)
    {
        //dd($id);
        $notice = Notice::findOrFail($id); 
        if ($notice->image && Storage::exists($notice->image)) {
            Storage::delete($notice->image);
        }
        $notice->delete();
        Session::flash('message', 'Notice deleted successfully.');
        return redirect('notice/org-notice');
    }

    public function helpdesk()
    {
        $data = [
            "ticket_no"      => "ABB80526",
            "organization"   => "Abbas Cos",
            "employee_name"  => "Souman Akther",
            "email"          => "souman@yopmail.com",
            "message"        => "When I submit Work report, I face an issue.",
            "image"          => asset('storage/helpdesk/OFtr4uBCUM4fKl1PRt6nmHMhpvaFP3BcMo1i73bh.jpg'), // or null
            "date"           => "11-12-2025",
        ];

        return view('email-template.helpdesk_ticket', $data);
    }





}
