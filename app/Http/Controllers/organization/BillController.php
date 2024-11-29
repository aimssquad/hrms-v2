<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\BillingRule;
use App\Models\Subadmin_bill;
use Session;
use DB;

class BillController extends Controller
{
    public function billingList(Request $request){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $billing_list = Subadmin_bill::where('sub_code', '')
                ->orWhereNull('sub_code')
                ->get();
            return view ('admin/billing/new_billing_list',compact('billing_list'));
        } else {
            redirect('superadmin');
        }
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $validatedData = $request->validate([
                'bill_for' => 'required|string',
                'discount_amount' => 'nullable|string',
                'billing_type' => 'required|string',
                'entity_id' => 'required',
                'amount' => 'nullable|numeric',
                'total_employee' => 'nullable|integer',
                'vat' => 'nullable|numeric', // This is the VAT percentage
                'total_amount' => 'nullable|numeric',
                'payment_mode' => 'required|string',
                'description' => 'nullable|string',
                'remarks' => 'nullable|string',
                'date' => 'nullable|date',
            ]);
            $pt = $request->billing_type == 'sub-admin' ? 'P' : '';
            $monthYear = date('mY', strtotime($request->date));
        
            $lastInvoice = Subadmin_bill::latest('id')->first();

            if ($lastInvoice) {
                $nextInvoiceNumber = $lastInvoice->id + 1; // Accessing the 'id' field
            } else {
                $nextInvoiceNumber = 1; // If no record exists, start with 1
            }
            // Generate the next invoice number
            $invoiceNumber = "SWC" . $pt . $monthYear . str_pad($nextInvoiceNumber, 2, '0', STR_PAD_LEFT);
        
            // Merge the generated invoice number with other data
           
                $dataToSave = array_merge($validatedData, [
                    'invoice_no' => $invoiceNumber, // Add the invoice number to save
                ]);
           
            //
            //dd($dataToSave);
            // Save the data
            $bill = Subadmin_bill::create($dataToSave);
            Session::flash('message', 'Bill submitted successfully. Invoice Number: ' . $invoiceNumber);
            return redirect('superadmin/billing-list');
        } else {
            redirect('superadmin');
        }
    }

    public function editBill(Request $request,$id){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $bills = DB::table('subadmin_bills')->where('id', $id)->first();
            if (!$bills) {
                return redirect()->back()->with('error', 'Billing rule not found.');
            }
        
            return view('admin.billing.edit_billing_list', compact('bills'));
        } else {
            redirect('superadmin');
        }
    }

    public function updateBilling(Request $request, $id)
    {
        // Debugging
        // dd('okk');
        // dd($request->all());

        // Validation for required fields
        $validated = $request->validate([
            'invoice_no' => 'required|string',
            'bill_for' => 'required|string',
            'date' => 'required|date', // Validate as a date
            'billing_type' => 'required|string', // Changed to string
            'entity_id' => 'required|string', // Changed to string
            'amount' => 'nullable|numeric', // Amount should be numeric
            'total_employee' => 'nullable|numeric', 
            'total_amount' => 'nullable|numeric', // Total employee should be numeric
            'vat' => 'nullable|numeric', // VAT should be numeric
            'discount_amount' => 'nullable|numeric', // Discount should be numeric
            'payment_mode' => 'nullable|string',
            'description' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);
        //dd($validated);
        $bill = Subadmin_bill::findOrFail($id);
        $bill->invoice_no = $validated['invoice_no'];
        $bill->bill_for = $validated['bill_for'];
        $bill->date = $validated['date'];
        $bill->billing_type = $validated['billing_type'];
        $bill->entity_id = $validated['entity_id'];
        $bill->amount = $validated['amount'];
        $bill->total_employee = $validated['total_employee'] ?? 0; // Default to 0 if null
        $bill->vat = $validated['vat'];
        $bill->discount_amount = $validated['discount_amount'];
        $bill->total_amount = $validated['total_amount']; // Save the calculated total amount
        $bill->payment_mode = $validated['payment_mode'];
        $bill->description = $validated['description'];
        $bill->remarks = $validated['remarks'];
        $bill->updated_at = now();
        //dd('After Update:', $bill);
        // Save the updated bill
        $bill->save();

        // Flash success message
        Session::flash('message', 'Bill updated successfully.');

        // Redirect back to the billing list
        return redirect('superadmin/billing-list');
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

   

    public function destroy($id)
    {
        $email = Session::get('empsu_email');
        if(!empty($email)){
            try {
                DB::table('subadmin_bills')->where('id', $id)->delete();
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

  
    

}
