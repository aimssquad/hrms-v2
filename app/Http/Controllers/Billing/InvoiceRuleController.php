<?php

namespace App\Http\Controllers\Billing;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvoiceRule;
use App\Models\BillingItem;
use Session;
use Exception;
use DB;

class InvoiceRuleController extends Controller
{
    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'admin.billing-rule';
        $this->_model       = new BillingItem();
    }

    public function index()
    {
        // $rules = InvoiceRule::all();
        // return view($this->_routePrefix . '.index', compact('rules'));
        $rules = InvoiceRule::with('billingItem','user')->get();
        //dd($rules);
        return view($this->_routePrefix . '.index', compact('rules'));
    }

    public function create()
    {
        $items = BillingItem::all();
        return view($this->_routePrefix . '.rule', compact('items'));
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $data = $request->validate([
            'item_id'           => 'required',
            'type'              => 'required',
            'entity_id'              => 'required',
            'employee_charge'   => 'required',
            'payment_start_date'=> 'nullable|date',
            'payment_end_date'  => 'nullable|date',
        ]);
        //dd($data);
        InvoiceRule::create($request->all());
        Session::flash('message', 'Billing Item created successfully');
        return redirect()->route('admin.rule.index');
    }

    public function edit($id)
    {
        // $rule = InvoiceRule::findOrFail($id);
        // return view($this->_routePrefix . '.edit', compact('rule'));
        $rule = InvoiceRule::with('billingItem')->findOrFail($id);
        $billingItems = BillingItem::all(); // Fetch all items for dropdown
        return view($this->_routePrefix . '.edit', compact('rule', 'billingItems'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'item_id'           => 'required',
            'type'              => 'required',
            'employee_charge'   => 'required|numeric',
            'payment_start_date'=> 'required|date',
            'payment_end_date'  => 'nullable|date|after_or_equal:payment_start_date',
        ]);

        $rule = InvoiceRule::findOrFail($id);
        $rule->update($request->all());
        Session::flash('message', 'Billing Item updated successfully.');
        return redirect()->route('admin.rule.index');
    }

    public function destroy($id)
    {
        InvoiceRule::findOrFail($id)->delete();
        Session::flash('message', 'Billing Item deleted successfully.');
        return redirect()->route('admin.rule.index');
    }
}
