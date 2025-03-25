<?php

namespace App\Http\Controllers;

use App\Models\LeaveType2;
use Illuminate\Http\Request;
use Session;

class LeaveType2Controller extends Controller
{
    // public function __construct()
    // {
    //     //$this->_module      = 'Organization';
    //     $this->_routePrefix = 'admin.leave-type';
    //     $this->_model       = new LeaveType2();
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $leaveTypes = LeaveType2::all();
        return view('admin.leave-type.index', compact('leaveTypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.leave-type.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'leave_type_name' => 'required|string|max:100',
            'alies' => 'required|string|max:100',
            'remarks' => 'nullable|string',
            'color_code' => 'required|string|max:50',
            //'leave_type_status' => 'nullable|boolean',
        ]);

        LeaveType2::create($validated);
        Session::flash('message', 'Leave type created successfully.');
        return redirect()->route('leave-types.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(LeaveType2 $leaveType)
    {
        return view('admin.leave-type.show', compact('leaveType'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LeaveType2 $leaveType)
    {
        return view('admin.leave-type.edit', compact('leaveType'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, LeaveType2 $leaveType)
    {
        $validated = $request->validate([
            'leave_type_name' => 'required|string|max:100',
            'alies' => 'required|string|max:100',
            'remarks' => 'nullable|string',
            'color_code' => 'required|string|max:50',
            //'leave_type_status' => 'nullable|boolean',
        ]);

        $leaveType->update($validated);
        Session::flash('message', 'Leave type updated successfully.');
        return redirect()->route('leave-types.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(LeaveType2 $leaveType)
    {
        $leaveType->delete();
        Session::flash('message', 'Leave type deleted successfully.');
        return redirect()->route('leave-types.index');
    }
}