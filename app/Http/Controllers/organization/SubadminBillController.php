<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Subadmin_bill;
use App\Models\BillingRule;
use Session;
use DB;
use Mail;

class SubadminBillController extends Controller
{

    public function dashboard(Request $reauest){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $code = DB::table('sub_admin_registrations')->where('email',$email)->first();
            if(!empty($code)){
               $total_amount = DB::table('subadmin_bills')->where('org_code',$code->org_code)->sum('total_amount'); 
               dd($total_amount);
            }

        } else {
            redirect('superadmin');
        }
    }
    public function showRule(Request $request){
        
        $email = Session::get('empsu_email');
        $data['code'] = DB::table('sub_admin_registrations')->where('email', $email)->first();
        //dd($data->org_code);
        if ($data['code']) {
            $data['organization'] = DB::table('registration')->where('org_code', $data['code']->org_code)->get();
        } else {
            $data['organization'] = [];
        }
        return view('sub-admin.billing.subadmin_billing_rule', $data);
    }


    public function ruleStore(Request $request)
    {
        // dd($request->all());
        // Validate incoming data
        $validatedData = $request->validate([
            'type' => 'required|in:employer,sub-admin',
            'entity_id' => 'required|string|max:50',
            'employee_charge' => 'nullable|numeric|min:0',
            'min_employees' => 'nullable|integer|min:0',
            'max_employees' => 'nullable|integer|min:0',
            'payment_date_range' => 'required|string',
            'org_code' => 'required|string',

        ]);
        //dd($validatedData);
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
            'type' => $validatedData['type'],
            'entity_id' => $validatedData['entity_id'],
            'employee_charge' => $validatedData['employee_charge'] ?? null,
            'min_employees' => $validatedData['min_employees'] ?? null,
            'max_employees' => $validatedData['max_employees'] ?? null,
            'payment_date_range' => $validatedData['payment_date_range'] ?? null,
            'org_code' => $validatedData['org_code'] ?? null,
        ]);
    
        // Redirect with a success message
        Session::flash('message', 'Bill rule submitted successfully.');
        return redirect('sub-admin/billing-rule-list');
    }

    public function showRuleList(Request $request){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $email = Session::get('empsu_email');
            $data['code'] = DB::table('sub_admin_registrations')->where('email', $email)->first();
            $billing_rule = BillingRule::where('org_code', $data['code']->org_code)->get();
            //dd($billing_rule );
            return view ('sub-admin/billing/subadmin_rule_list',compact('billing_rule'));
        } else {
            redirect('superadmin');
        }
    }

    public function edit($id)
    {
        //dd($id);
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $rule = DB::table('rule_table')->where('id', $id)->first();
            if (!$rule) {
                return redirect()->back()->with('error', 'Billing rule not found.');
            }
        
            return view('sub-admin.billing.edit_subadmin_billing_rule', compact('rule'));
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
                'entity_id' => 'required',
                'employee_charge' => 'nullable|required',
                'min_employees' => 'nullable|required',
                'max_employees' => 'nullable|required',
                'payment_date_range' => 'nullable|string|max:50',
            ]);
            //dd($validated);
            DB::table('rule_table')->where('id', $id)->update($validated);
            Session::flash('message', 'Record Update successfully.');
            return redirect('sub-admin/billing-rule-list');
        } else {
            redirect('superadmin');
        }
        
    }

    public function billingList(Request $request){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $data['code'] = DB::table('sub_admin_registrations')->where('email', $email)->first();
            $billing_list = Subadmin_bill::where('org_code', $data['code']->org_code)->get();
           // dd($billing_list);
            return view ('sub-admin/billing/new_billing_list',compact('billing_list'));
        } else {
            redirect('superadmin');
        }
    }

    public function addbillng(Request $request)
    {
        //dd('okk');
        try {
            $email = Session::get('empsu_email');
            $userType = Session::get('usersu_type');

            if (!empty($email)) {

                if ($userType == 'user') {
                    $arrrole = Session::get('empsu_role');
                    if (!in_array('4', $arrrole)) {
                        throw new \App\Exceptions\AdminException('You are not authorized to access this section.');
                    }
                }
                $code = DB::table('sub_admin_registrations')->where('email',$email)->first();
                $data['organization'] = DB::table('registration')->where('org_code',$code->org_code)->get();
                //dd($data);

                return view('sub-admin/billing/add_new_billing',$data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getEntityDetails(Request $request)
    {
        $entityId = $request->input('entity_id');
        $email = Session::get('empsu_email');
        $code = DB::table('sub_admin_registrations')->where('email',$email)->first();
        //dd($entityId);
        // // Fetch the amount from the rule_table
        // $rule = DB::table('rule_table')->where('entity_id', $entityId)->first();

        // // Count the total employees from the employee table
        // $totalEmployees = DB::table('employees')->where('entity_id', $entityId)->count();

        // // Return the data as JSON
        // return response()->json([
        //     'amount' => $rule->amount ?? null,
        //     'total_employee' => $totalEmployees,
        // ]);

            // Direct employee count for non sub-admins
            $totalEmployee = DB::table('employee')
            ->where('emid', $entityId)
            //->where('org_code',$code->org_code)
            ->count();
            //dd($code->org_code);
            $amount = DB::table('rule_table')
                ->where('entity_id', $entityId)
                ->where('org_code',$code->org_code)
                ->value('employee_charge');
                //dd($amount);
            if ($amount === null) {
                //dd($code->org_code);
                $amount = DB::table('rule_table')
                    ->where('entity_id', 'DEFULT') // Replace 'default' with your actual default entity_id value
                    ->where('type', 'employer')
                    ->where('org_code',$code->org_code)
                    ->value('employee_charge');
            }    
            //
            //
            //dd($amount);
            if ($amount !== null) {
                $totalAmount = $amount * $totalEmployee;
                return response()->json([
                    'amount' => $totalAmount,
                    'total_employee' => $totalEmployee
                ]);
            } else {
                return response()->json([
                    'message' => 'No employee charge found',
                    'total_employee' => $totalEmployee
                ]);
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
            //dd($validatedData);
            $date = $request->date;
            // //dd($date);
            // $vatAmount = isset($validatedData['vat'], $validatedData['amount'])
            //     ? ($validatedData['vat'] / 100) * $validatedData['amount']
            //     : 0;
            // $total = $vatAmount + $request->input('amount');
            $pt = $request->billing_type == 'sub-admin' ? 'p' : '';
            // $month = date('m');
            // $year = date('Y');
            $monthYear = date('mY', strtotime($request->date));
            $subadmin_name = DB::table('sub_admin_registrations')->where('email',$email)->first();
            if ($subadmin_name && $subadmin_name->com_name) {
                $firstThreeLetters = substr($subadmin_name->com_name, 0, 3); // Get the first three letters
                $latter = $firstThreeLetters;
            } else {
                dd('Company name not found');
            }
            // get last id from bills table
            $lastInvoice = Subadmin_bill::latest('id')->first();

            if ($lastInvoice) {
                $nextInvoiceNumber = $lastInvoice->id + 1; // Accessing the 'id' field
            } else {
                $nextInvoiceNumber = 1; // If no record exists, start with 1
            }
            $invoiceNumber = strtoupper($latter . $pt . $monthYear . str_pad($nextInvoiceNumber, 2, '0', STR_PAD_LEFT));
            //dd($invoiceNumber);
            // Merge the generated invoice number with other data
            $dataToSave = array_merge($validatedData, [
                'invoice_no' => $invoiceNumber,
                'org_code' => $subadmin_name->org_code // Add the invoice number to save
            ]);
           //dd($dataToSave);
            $bill = Subadmin_bill::create($dataToSave);
            
                // send email
                if($bill){
                    $org_email = DB::table('registration')->where('reg',$request->entity_id)->first();
                    
                    $toemail = $org_email->email;
                    //dd($toemail);
                    // Prepare data for the email template
                    $mailData = [
                        'subadmin_name' => $subadmin_name->com_name,
                        'subadmin_email' => $subadmin_name->email,
                        'organization_name' => $org_email->com_name,
                        'Invoice_no' => $invoiceNumber,
                        'Billing_date' => $request->date,
                        'Billing_for' => $request->bill_for,
                        'Total_amount' => $request->total_amount,
                        'Vat' => $request->vat,
                        'Discount' => $request->discount_amount,
                    ];
                    //dd($mailData);
                    // Send the email
                    Mail::send('subadmin_mail', $mailData, function ($message) use ($toemail) {
                        $message
                            ->to($toemail, env('MAIL_FROM_NAME'))
                            ->subject("Your Billing Invoice");
                        $message->from(env('MAIL_USERNAME'), env('MAIL_FROM_NAME'));
                    });
                }    
        
            Session::flash('message', 'Bill submitted successfully. Invoice Number: ' . $invoiceNumber);
            return redirect('sub-admin/billing-list');
        } else {
            redirect('superadmin');
        }
    }

    public function editBill($id){
        //dd($id);
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $bills = DB::table('subadmin_bills')->where('id', $id)->first();
            if (!$bills) {
                return redirect()->back()->with('error', 'Billing rule not found.');
            }
        
            return view('sub-admin.billing.edit_new_billing', compact('bills'));
        } else {
            redirect('superadmin');
        }
    }


    public function updateBilling(Request $request, $id)
    {
        // For debugging purposes
        //dd('okk');
        
        // Validation for required fields
        $request->validate([
            'bill_for' => 'required|string',
            'billing_month' => 'required|string',
            'amount' => 'required|numeric',
            'total_employee' => 'required|numeric',
            'vat' => 'nullable|numeric',
            'payment_mode' => 'required|string',
            'description' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        // Fetch the Bill by ID
        $bill = Subadmin_bill::findOrFail($id);

        // Get the amount and vat from the request
        $amount = $request->amount;
        $vat = $request->vat ?? 0; // Default to 0 if vat is not provided

        // Calculate the VAT amount
        $vat_amount = ($amount * $vat) / 100;  // VAT percentage calculation

        // Calculate the total amount (original amount + VAT)
        $total_amount = $amount + $vat_amount;

        // Update the fields with the new values
        $bill->bill_for = $request->bill_for;
        $bill->billing_month = $request->billing_month;
        $bill->amount = $amount;
        $bill->total_employee = $request->total_employee;
        $bill->vat = $vat;  // Update VAT if provided
        $bill->total_amount = $total_amount;  // Store the total amount (amount + VAT)
        $bill->payment_mode = $request->payment_mode;
        $bill->description = $request->description ?? $bill->description;
        $bill->remarks = $request->remarks ?? $bill->remarks;

        // Save the updated bill
        $bill->save();

        // Flash a success message (optionally include the invoice number if available)
        Session::flash('message', 'Bill updated successfully. Invoice Number: ' . $bill->invoice_number);

        // Redirect back with success message
        return redirect('sub-admin/billing-list');
    }

    public function destroyBilling($id)
    {
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $bill = Subadmin_bill::findOrFail($id);
            $bill->delete();
            Session::flash('message', 'Bill deleted successfully.');
            return redirect('sub-admin/billing-list');
        } else {
            redirect('superadmin');
        }
    }

    public function viewInvoice(Request $request,$id){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $data['bill'] = DB::table('subadmin_bills')->where('id',$id)->first();
            $data['org_dtl'] = DB::table('registration')->where('reg',$data['bill']->entity_id)->first();
            $data['com_dtl'] = DB::table('sub_admin_registrations')->where('org_code',$data['bill']->org_code)->first();
            //dd('subadmin bills');
            return view('sub-admin.billing.invoice',$data);
        } else {
            redirect('superadmin');
        } 
    }
    
    public function showBills(Request $request){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $data = DB::table('sub_admin_registrations')->where('email',$email)->first();
            dd($data->reg);
            $data['bill'] = DB::table('bills')->where('entity_id',$data->reg)->get();
            dd($data['bill']);
            // $data['org_dtl'] = DB::table('registration')->where('reg',$data['bill']->entity_id)->first();
            // $data['com_dtl'] = DB::table('sub_admin_registrations')->where('org_code',$data['bill']->org_code)->first();
            //dd($data['bill']);
            return view('sub-admin.billing.invoice',$data);
        } else {
            redirect('superadmin');
        } 
    }

    public function viewBillList(Request $request){
        //dd('okk');
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $subadmin = DB::table('sub_admin_registrations')->where('email',$email)->first();
            $data['bill_list'] = DB::table('subadmin_bills')->where('entity_id',$subadmin->reg)->get();
            //dd($data['bill_list']);
            return view('sub-admin.billing.own_bill',$data);
        } else {
            redirect('superadmin');
        }  
    }

    public function viewOwnInvoice(Request $request,$id){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $data['bill'] = DB::table('subadmin_bills')->where('id',$id)->first();
            //$data['org_dtl'] = DB::table('registration')->where('reg',$data['bill']->entity_id)->first();
            //dd($data['bill']->sub_code);
            $data['com_dtl'] = DB::table('sub_admin_registrations')->where('reg',$data['bill']->entity_id)->first();
            //dd('subadmin bills');
            return view('sub-admin.billing.own_invoice',$data);
        } else {
            redirect('superadmin');
        } 
    }




} // end of class
