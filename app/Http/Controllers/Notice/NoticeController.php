<?php

namespace App\Http\Controllers\Notice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notice;
use Exception;
use Session;
use Carbon\Carbon;
use Validator;
class NoticeController extends Controller
{
    protected $_module;
    protected $_routePrefix;
    protected $_model;

    public function __construct()
    {
        $this->_module      = 'Notice';
        $this->_routePrefix = 'admin.notices';
        $this->_model       = new Notice();
    }

    public function index()
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $notices = Notice::where('created_by_type', 'admin')->get();
                return view($this->_routePrefix . '.index', compact('notices'));
        } else {
            return redirect('superadmin');
        }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function create(Request $request)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                return view($this->_routePrefix . '.create'); 
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }
    public function store(Request $request)
    {
        //dd($request->all());
        try {

            // $allSessionData = Session::all();
            // dd($allSessionData); 
           
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                // $request->validate([
                //     'title' => 'required|string|max:255',
                //     'description' => 'required|string',
                //     'start_date' => 'required|date|before_or_equal:end_date',
                //     'end_date' => 'required|date|after_or_equal:start_date',
                //     'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
                // ]);

                $notice = new Notice();
                $notice->title = $request->title;
                $notice->description = $request->description;
                $notice->start_date = $request->start_date;
                $notice->end_date = $request->end_date;
                $notice->created_by_type = $request->created_by; 
                $notice->notice_for = $request->notice_for;
                $notice->created_by_id = Session::get('users_id');

                // Handle image upload
                if ($request->hasFile('image')) {
                    $imagePath = $request->file('image')->store('notices', 'public');
                    $notice->image = $imagePath;
                }

                $notice->save();
                Session::flash('message', 'Notice added successfully.');
                return redirect('superadmin/notices');

            } else {
                Session::flash('error', 'Notice added failed.');
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function edit($id)
    {
        try {
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $notice = Notice::findOrFail($id);
                return view($this->_routePrefix . '.edit', compact('notice'));
            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function update(Request $request, $id)
    {
        try {
           
            $email = Session::get('empsu_email');
            if (!empty($email)) {
                $notice = Notice::findOrFail($id);
                $notice->title = $request->title;
                $notice->description = $request->description;
                $notice->start_date = $request->start_date;
                $notice->end_date = $request->end_date;
                $notice->created_by_type = $request->created_by; 
                $notice->notice_for = $request->notice_for;
                $notice->created_by_id = Session::get('users_id');

                // Handle image upload
                if ($request->hasFile('image')) {
                    // Delete the old image if it exists
                    if ($notice->image) {
                        \Storage::disk('public')->delete($notice->image);
                    }
                    $imagePath = $request->file('image')->store('notices', 'public');
                    $notice->image = $imagePath;
                }

                $notice->save();

                Session::flash('message', 'Notice updated successfully.');
                return redirect('superadmin/notices');

            } else {
                Session::flash('error', 'Notice added failed.');
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function destroy($id)
    {
        $notice = Notice::findOrFail($id);

        if ($notice->delete()) {
            Session::flash('message', 'Notice Deleted successfully.');
            return redirect('superadmin/notices');
        } else {

            Session::flash('error', 'Failed to delete notice..');
            return redirect('superadmin/notices');
        }
    }
}