<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notice;
use Exception;
use Session;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Validator;

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

    public function index()
    {
        try {
            $email = Session::get('emp_email');
            $user_id = Session::get('users_id');
            //dd($user_id);
            if (!empty($email)) {
                $notices = Notice::where('created_by_type', 'organization')->where('created_by_id',$user_id)->get();
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
            //dd($email);
            if (!empty($email)) {
                return view($this->_routePrefix . '.notice-add');
            } else {
                return redirect('/');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function store(Request $request)
    {
        $data = Session::get('users_id');
        //dd($request->all());
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'notice_for' => 'required|string',
            'created_by_type' => 'required|string',
        ]);
        //dd($validated);
        try {
            // Handle file upload if present
            $imagePath = $request->file('image') ? $request->file('image')->store('notices', 'public') : null;

            // Save notice in the database
            Notice::create([
                'title' => $validated['title'],
                'description' => $validated['description'],
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'image' => $imagePath,
                //'organization_id' => Session::get('users_id'), // Replace this with the actual organization ID logic
                'notice_for' => $validated['notice_for'],
                'created_by_type' => $validated['created_by_type'],
                'created_by_id' => Session::get('users_id'), // Replace this with the actual creator's ID logic
            ]);

            Session::flash('message', 'Notice added successfully.');
            return redirect('notice/org-notice');
        } catch (\Exception $e) {
            Session::flash('message', 'Somthings went wrong.');
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




}
