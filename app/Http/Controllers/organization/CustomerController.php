<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    protected $_module;
    protected $_routePrefix;
    protected $_model;

    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.guest-bills.customer';
        $this->_model       = new Guest();
    }

    public function dashboard(){
        dd('okk');
    }

    public function index()
    {
        $email = Session::get("emp_email");
        $emid = Session::get("emid");
        //dd($emid);

        $data['guests'] = Guest::where('emid',$emid)->orderBy('id', 'desc')->get();
        //dd($data);
        return view($this->_routePrefix . '.index', $data);
        //return view('guests.index', compact('guests'));
    }

    /**
     * Show the form for creating a new guest
     */
    public function create()
    {
        return view($this->_routePrefix . '.create');
        //return view('guests.create');
    }

    /**
     * Store a newly created guest
     */
    public function store(Request $request)
    {
        //dd('okk');
        $emid = Session::get("emid");
        $validated = $request->validate([
            //'emid'         => 'required|string|max:50',
            //'guest_id'     => 'required|string|max:50|unique:guests,guest_id',
            'company_name' => 'required|string|max:255',
            'designation'  => 'nullable|string|max:255',
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'required|string|max:20',
            'address'      => 'nullable|string',
            'tax_no'      => 'nullable|string',
            'status'       => 'required|in:0,1',
        ]);
        $validated['emid'] = $emid;
        //dd($validated);
        Guest::create($validated);

        return redirect()
            ->route('org.customer.list')
            ->with('message', 'Customer created successfully.');
    }

    /**
     * Show the form for editing the guest
     */
    public function edit($id)
    {
        $id = base64_decode($id);
        //dd($id);
        $data['customer'] = Guest::find($id);
        if(!$data){
            return redirect()
                ->route('org.customer.list')
                ->with('error', 'Customer not found.');
        }
        return view($this->_routePrefix . '.edit', $data);
        //return view('guests.edit', compact('guest'));
    }

    /**
     * Update the specified guest
     */
    public function update(Request $request, $id)
    {
        $id = base64_decode($id);

        $guest = Guest::findOrFail($id);

        if(!$guest){
            return redirect()
            ->route('org.customer.list')
            ->with('error', 'Customer not found.');
        }

        // Validate request
        $validated = $request->validate([
            'emid'         => 'required|string|max:50',
            'company_name' => 'required|string|max:255',
            'designation'  => 'nullable|string|max:255',
            'name'         => 'required|string|max:255',
            'email'        => 'required|email|max:255',
            'phone'        => 'required|string|max:20',
            'address'      => 'nullable|string',
            'tax_no'      => 'nullable|string',
            'status'       => 'required|in:0,1',
        ]);

        // Update guest
        $guest->update($validated);

        return redirect()
            ->route('org.customer.list')
            ->with('message', 'Customer updated successfully.');
    }


    /**
     * Remove the specified guest
     */
    public function destroy($id)
    {
        $id = base64_decode($id);
        $guest = Guest::findOrFail($id);
        //dd($guest);
        $guest->delete();

        return redirect()
            ->route('org.customer.list')
            ->with('message', 'Customer deleted successfully.');
    }
}
