<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\BillingRule;
use Session;
use DB;

class BillController extends Controller
{
    // public function store(Request $request)
    // {
    //     //dd($request->all());
    //     // Step 1: Validate incoming form data
    //     $validatedData = $request->validate([
    //         'bill_for' => 'required|string',
    //         'billing_month' => 'required|string',
    //         'billing_type' => 'required|string',
    //         'entity_id' => 'required',
    //         'amount' => 'nullable|numeric',
    //         'total_employee' => 'nullable|integer',
    //         'vat' => 'nullable|numeric', // This is the VAT percentage
    //         'payment_mode' => 'required|string',
    //         'description' => 'nullable|string',
    //     ]);
    //     //dd($validatedData);
    //     $vatAmount = isset($validatedData['vat'], $validatedData['amount'])
    //         ? ($validatedData['vat'] / 100) * $validatedData['amount']
    //         : 0;
    //     $total =  $vatAmount+$request->input('amount');  

    //     $dataToSave = array_merge($validatedData, [
    //         'total_amount' => $total, 
    //     ]);
    //     $bill = Bill::create($dataToSave);
    //     Session::flash('message', 'Bill submitted successfully with VAT calculation.');
    //     return redirect()->back();
    // }

    public function store(Request $request)
    {
        //dd($request->all());
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $validatedData = $request->validate([
                'bill_for' => 'required|string',
                'billing_month' => 'required|string',
                'billing_type' => 'required|string',
                'entity_id' => 'required',
                'amount' => 'nullable|numeric',
                'total_employee' => 'nullable|integer',
                'vat' => 'nullable|numeric', // This is the VAT percentage
                'payment_mode' => 'required|string',
                'description' => 'nullable|string',
            ]);

            $vatAmount = isset($validatedData['vat'], $validatedData['amount'])
                ? ($validatedData['vat'] / 100) * $validatedData['amount']
                : 0;
            $total = $vatAmount + $request->input('amount');
            $pt = $request->billing_type == 'sub-admin' ? 'p' : '';
            $month = date('m');
            $year = date('Y');
        
            // Count the existing invoices for the current month and year
            $invoiceCount = Bill::whereYear('created_at', $year)
                ->whereMonth('created_at', $month)
                ->count();
            //dd($invoiceCount);
            // Generate the next invoice number
            $nextInvoiceNumber = $invoiceCount + 1;
            $invoiceNumber = "SWC" . $pt . $month . $year . str_pad($nextInvoiceNumber, 2, '0', STR_PAD_LEFT);
        
            // Merge the generated invoice number with other data
            $dataToSave = array_merge($validatedData, [
                'total_amount' => $total,
                'invoice_no' => $invoiceNumber, // Add the invoice number to save
            ]);
            //dd($dataToSave);
            // Save the data
            $bill = Bill::create($dataToSave);
            Session::flash('message', 'Bill submitted successfully. Invoice Number: ' . $invoiceNumber);
            return redirect('superadmin/billing-list');
        } else {
            redirect('superadmin');
        }
    }

    public function getRule(Request $request){
        //echo "hello bill Rule";
        $isDefaultExists = DB::table('rule_table')->where('is_default', 1)->exists();
        //return view('billing.create', compact('isDefaultExists'));
        return View('admin/billing_rule',compact('isDefaultExists'));
    }

    public function ruleStore(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'billing_type' => 'required|in:employer,sub-admin',
            'entity_id' => 'required|string|max:50',
            'employee_charge' => 'nullable|numeric|min:0',
            'max_organizations' => 'nullable|integer|min:0',
            'min_employees' => 'nullable|integer|min:0',
            'max_employees' => 'nullable|integer|min:0',
            'payment_date_range' => 'required|string',
        ]);
    
        // Check if a rule with the same entity_id and payment_date_range already exists
        $existingRule = BillingRule::where('entity_id', $validatedData['entity_id'])
            ->where('payment_date_range', $validatedData['payment_date_range'])
            ->first();
    
        if ($existingRule) {
            // If a match is found, redirect back with an error message
            return redirect()->back()->withErrors([
                'payment_date_range' => 'Payment date range already exists for this user id.'
            ]);
        }
    
        // Save data to the database
        BillingRule::create([
            'type' => $validatedData['billing_type'],
            'entity_id' => $validatedData['entity_id'],
            'employee_charge' => $validatedData['employee_charge'] ?? null,
            'max_organizations' => $validatedData['max_organizations'] ?? null,
            'min_employees' => $validatedData['min_employees'] ?? null,
            'max_employees' => $validatedData['max_employees'] ?? null,
            'payment_date_range' => $validatedData['payment_date_range'] ?? null,
        ]);
    
        // Redirect with a success message
        Session::flash('message', 'Bill rule submitted successfully.');
        return redirect()->back();
    }

    public function showRule(Request $request){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $billing_rule = BillingRule::all();
            return view ('admin/billing/billing_rule_list',compact('billing_rule'));
        } else {
            redirect('superadmin');
        }
    }

    public function billingList(Request $request){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $billing_list = Bill::all();
            //dd('okk');
            return view ('admin/billing/new_billing_list',compact('billing_list'));
        } else {
            redirect('superadmin');
        }
    }

    public function destroy($id)
    {
        $email = Session::get('empsu_email');
        if(!empty($email)){
            try {
                DB::table('bills')->where('id', $id)->delete();
                Session::flash('message', 'Record deleted successfully.');
                return redirect()->back();
            } catch (\Exception $e) {
                Session::flash('message', 'Failed to delete the record.');
                return redirect()->back();
            }
        } else {
            redirect('superadmin');
        }
       
    }

    public function destroyBillingRule($id)
    {
        $email = Session::get('empsu_email');
        if(!empty($email)){
            try {
                DB::table('rule_table')->where('id', $id)->delete();
                Session::flash('message', 'Record deleted successfully.');
                return redirect()->back();
            } catch (\Exception $e) {
                Session::flash('message', 'Failed to delete the record.');
                return redirect()->back();
            }
        } else {
            redirect('superadmin');
        }
       
    }

    public function edit($id)
    {
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $rule = DB::table('rule_table')->where('id', $id)->first();
            if (!$rule) {
                return redirect()->back()->with('error', 'Billing rule not found.');
            }
        
            return view('admin.billing.edit_billing_rule', compact('rule'));
        } else {
            redirect('superadmin');
        }
        
    }

    public function update(Request $request, $id)
    {
        $email = Session::get('empsu_email');
        if(!empty($email)){
            //dd($request->all());
            $validated = $request->validate([
                'type' => 'required|string',
                'entity_id' => 'required',
                'employee_charge' => 'nullable|required',
                'max_organizations' => 'nullable|numeric',
                'min_employees' => 'nullable|required',
                'max_employees' => 'nullable|required',
                'payment_date_range' => 'nullable|string|max:50',
            ]);
            //dd($validated);
            DB::table('rule_table')->where('id', $id)->update($validated);
            Session::flash('message', 'Record Update successfully.');
            return redirect('superadmin/show-rule');
        } else {
            redirect('superadmin');
        }
        
    }

    public function viewAdminInvoice(Request $request,$id){
        $email = Session::get('empsu_email');
        if(!empty($email)){
           //dd($id);
           $data['bill'] = DB::table('bills')->where('id',$id)->first();
           if($data['bill']->billing_type == 'employer'){
                $data['org_dtl'] = DB::table('registration')->where('reg',$data['bill']->entity_id)->first();
           } else {
                $data['org_dtl'] = DB::table('sub_admin_registrations')->where('reg',$data['bill']->entity_id)->first();
           }
           //dd($data['org_dtl']);
           //$data['com_dtl'] = DB::table('sub_admin_registrations')->where('org_code',$data['bill']->org_code)->first();
           return view('admin.billing.invoice',$data);
           //return view('new-bill-pdf',$data);
        } else {
            redirect('superadmin');
        }
    }

    public function editBill(Request $request,$id){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $bills = DB::table('bills')->where('id', $id)->first();
            if (!$bills) {
                return redirect()->back()->with('error', 'Billing rule not found.');
            }
        
            return view('admin.billing.edit_billing_list', compact('bills'));
        } else {
            redirect('superadmin');
        }
    }
    

}
