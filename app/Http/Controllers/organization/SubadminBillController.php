<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Subadmin_bill;
use App\Models\BillingRule;
use Session;
use Barryvdh\DomPDF\Facade\Pdf;
use Mail;
use DB;

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
            $data['organization'] = DB::table('registration')->where('verify','approved')->where('status','active')->where('org_code', $data['code']->org_code)->get();
        } else {
            $data['organization'] = [];
        }
        return view('sub-admin.billing.subadmin_billing_rule', $data);
    }


    // public function ruleStore(Request $request)
    // {
    //     // Session::flash('error', 'We are working on It.');
    //     // return redirect()->back();
    //     //dd($request->all());
    //     // Validate incoming data
    //     $validatedData = $request->validate([
    //         'type' => 'required|in:employer,sub-admin',
    //         'org_code' => 'required|string|max:20',
    //         'billing_for' => 'required|in:Number Of Employee',
    //         'entity_id' => 'required|string|max:20',
    //         'min_employees' => 'required|integer|min:1|lt:max_employees',
    //         'max_employees' => 'required|integer|min:1|gt:min_employees',
    //         'employee_charge' => 'required|numeric|min:0',
    //         'billing_mode' => 'required|in:Monthly,Yearly,Quarterly', // Added Quarterly if needed
    //         'payment_date_from' => 'required|date|before_or_equal:payment_date_to',
    //         'payment_date_to' => 'required|date|after_or_equal:payment_date_from',
    //     ]);

    //     //dd($validatedData);
    //     // Check if a rule with the same entity_id and payment_date_range already exists
    //     $existingRule = BillingRule::where('entity_id', $validatedData['entity_id'])
    //         ->where('payment_date_range', $validatedData['payment_date_range'])
    //         ->first();
    
    //     if ($existingRule) {
    //         // If a match is found, redirect back with an error message
    //         return redirect()->back()->withErrors([
    //             'payment_date_range' => 'Payment date range already exists for this user id.'
    //         ]);
    //     }
    
    //     // Save data to the database
    //     BillingRule::create([
    //         'type' => $validatedData['type'],
    //         'entity_id' => $validatedData['entity_id'],
    //         'employee_charge' => $validatedData['employee_charge'] ?? null,
    //         'min_employees' => $validatedData['min_employees'] ?? null,
    //         'max_employees' => $validatedData['max_employees'] ?? null,
    //         'payment_date_range' => $validatedData['payment_date_range'] ?? null,
    //         'org_code' => $validatedData['org_code'] ?? null,
    //     ]);
    
    //     // Redirect with a success message
    //     Session::flash('message', 'Bill rule submitted successfully.');
    //     return redirect('sub-admin/billing-rule-list');
    // }

    public function ruleStore(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'type' => 'required|in:employer,sub-admin',  // Fixed typo (employer vs employer)
            'org_code' => 'required|string|max:20',
            'billing_for' => 'required|in:Number Of Employee',
            'entity_id' => 'required|string|max:20',
            'min_employees' => 'required|integer|min:1|lt:max_employees',
            'max_employees' => 'required|integer|min:1|gt:min_employees',
            'employee_charge' => 'required|numeric|min:0',
            'billing_mode' => 'required|in:Monthly,Yearly,Quarterly',
            'payment_date_from' => 'required|date|before_or_equal:payment_date_to',
            'payment_date_to' => 'required|date|after_or_equal:payment_date_from',
        ]);

        // Check for overlapping date ranges for the same entity
        // STRICT OVERLAP CHECK - Blocks ANY dates within existing ranges
        $conflictExists = BillingRule::where('entity_id', $validatedData['entity_id'])
        ->where(function($query) use ($validatedData) {
            $query->whereBetween('payment_date_from', [
                    $validatedData['payment_date_from'], 
                    $validatedData['payment_date_to']
                ])
                ->orWhereBetween('payment_date_to', [
                    $validatedData['payment_date_from'], 
                    $validatedData['payment_date_to']
                ])
                ->orWhere(function($q) use ($validatedData) {
                    // Catches cases where new range wraps around existing
                    $q->where('payment_date_from', '<', $validatedData['payment_date_from'])
                    ->where('payment_date_to', '>', $validatedData['payment_date_to']);
                });
        })
        ->exists();

        if ($conflictExists) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'payment_date_from' => 'This rule already exists for this organization during the selected month(s).',
                    'payment_date_to' => 'This rule already exists for this organization during the selected month(s).'
                ]);
        }

        // Save data to the database
        BillingRule::create([
            'type' => $validatedData['type'],
            'billing_for' => $validatedData['billing_for'],
            'entity_id' => $validatedData['entity_id'],
            'employee_charge' => $validatedData['employee_charge'],
            'min_employees' => $validatedData['min_employees'],
            'max_employees' => $validatedData['max_employees'],
            'billing_mode' => $validatedData['billing_mode'],
            'payment_date_from' => $validatedData['payment_date_from'],
            'payment_date_to' => $validatedData['payment_date_to'],  // Changed from payment_date_range
            'org_code' => $validatedData['org_code'],
        ]);

        return redirect('sub-admin/billing-rule-list')
            ->with('message', 'Billing rule submitted successfully.');
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

    // public function update(Request $request, $id)
    // {
    //     $email = Session::get('empsu_email');
    //     if(!empty($email)){
    //         //dd($request->all());
    //         $validated = $request->validate([
    //             'entity_id' => 'required',
    //             'employee_charge' => 'nullable|required',
    //             'min_employees' => 'nullable|required',
    //             'max_employees' => 'nullable|required',
    //             'payment_date_range' => 'nullable|string|max:50',
    //         ]);
    //         //dd($validated);
    //         DB::table('rule_table')->where('id', $id)->update($validated);
    //         Session::flash('message', 'Record Update successfully.');
    //         return redirect('sub-admin/billing-rule-list');
    //     } else {
    //         redirect('superadmin');
    //     }
        
    // }



    public function update(Request $request, $id)
    {
        // Validate incoming data
        //dd($request->all());
        $validatedData = $request->validate([
            'type' => 'required|in:employer,sub-admin',
            // 'org_code' => 'required|string|max:20',
            'billing_for' => 'required|in:Number Of Employee',
            'entity_id' => 'required|string|max:20',
            'min_employees' => 'required|integer|min:1|lt:max_employees',
            'max_employees' => 'required|integer|min:1|gt:min_employees',
            'employee_charge' => 'required|numeric|min:0',
            'billing_mode' => 'required|in:Monthly,Quarterly,Half_yearly,Annually',
            'payment_date_from' => 'required|date|before_or_equal:payment_date_to',
            'payment_date_to' => 'required|date|after_or_equal:payment_date_from',
        ]);

        // Find the existing rule
        $rule = BillingRule::findOrFail($id);

        // Check for date range conflicts (excluding current record)
        $conflictExists = BillingRule::where('entity_id', $validatedData['entity_id'])
        ->where('id', '!=', $id) // Exclude current record
        ->where(function($query) use ($validatedData) {
            $query->where(function($q) use ($validatedData) {
                // Case 1: New range starts within existing range
                $q->where('payment_date_from', '<=', $validatedData['payment_date_from'])
                  ->where('payment_date_to', '>=', $validatedData['payment_date_from']);
            })->orWhere(function($q) use ($validatedData) {
                // Case 2: New range ends within existing range
                $q->where('payment_date_from', '<=', $validatedData['payment_date_to'])
                  ->where('payment_date_to', '>=', $validatedData['payment_date_to']);
            })->orWhere(function($q) use ($validatedData) {
                // Case 3: New range completely wraps around existing range
                $q->where('payment_date_from', '>=', $validatedData['payment_date_from'])
                  ->where('payment_date_to', '<=', $validatedData['payment_date_to']);
            })->orWhere(function($q) use ($validatedData) {
                // Case 4: Existing range completely wraps around new range
                $q->where('payment_date_from', '<', $validatedData['payment_date_from'])
                  ->where('payment_date_to', '>', $validatedData['payment_date_to']);
            });
        })
        ->exists();
           dd($conflictExists); 

        if ($conflictExists) {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'payment_date_from' => 'A billing rule already exists for this entity that overlaps with the specified date range.',
                    'payment_date_to' => 'A billing rule already exists for this entity that overlaps with the specified date range.'
                ]);
        }
        dd('okk');
        // Update the billing rule
        DB::transaction(function() use ($rule, $validatedData) {
            $rule->update([
                'type' => $validatedData['type'],
                'billing_for' => $validatedData['billing_for'],
                'entity_id' => $validatedData['entity_id'],
                'employee_charge' => $validatedData['employee_charge'],
                'min_employees' => $validatedData['min_employees'],
                'max_employees' => $validatedData['max_employees'],
                'billing_mode' => $validatedData['billing_mode'],
                'payment_date_from' => $validatedData['payment_date_from'],
                'payment_date_to' => $validatedData['payment_date_to'],
                'org_code' => $validatedData['org_code'],
            ]);
        });

        return redirect()->route('subadmin.rulelist')
            ->with('success', 'Billing rule updated successfully.');
    }

    public function destroy($id)
    {
        //dd('ok');
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $rule = BillingRule::findOrFail($id);
            $rule->delete();
            Session::flash('message', 'Record Deleted successfully.');
            return redirect()->route('subadmin.rulelist');
        } else {
            redirect('subadmin');
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
        // Session::flash('error', 'We are working on it.');
        // return redirect()->back();
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
                //dd($code->org_code);
                $data['organization'] = DB::table('registration')->where('org_code',$code->org_code)->where('verify','approved')->get();
                //dd($data);

                return view('sub-admin/billing/add_new_billing',$data);

            } else {
                return redirect('subadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getEntityDetails(Request $request)
    {
        $entityId = $request->input('entity_id');
        $invoiceDate = $request->input('invoice_date'); // Get the invoice date from request
        $email = Session::get('empsu_email');
        $code = DB::table('sub_admin_registrations')->where('email', $email)->first();

        // Direct employee count
        $totalEmployee = DB::table('employee')
            ->where('emid', $entityId)
            ->count();
        
        // First try to find a rule for the specific entity with date range check
        $amount = DB::table('rule_table')
            ->where('entity_id', $entityId)
            ->where('org_code', $code->org_code)
            ->where(function($query) use ($invoiceDate) {
                $query->whereNull('payment_date_from') // Either no date range is set
                    ->orWhere(function($q) use ($invoiceDate) {
                        $q->where('payment_date_from', '<=', $invoiceDate) // Or invoice date is within range
                        ->where('payment_date_to', '>=', $invoiceDate);
                    });
            })
            ->value('employee_charge');
        //dd($amount)    
        // If no specific rule found, try the DEFAULT rule with date range check
        if ($amount === null) {
            $amount = DB::table('rule_table')
                ->where('entity_id', 'DEFULT')
                ->where('type', 'employer')
                ->where('org_code', $code->org_code)
                ->where(function($query) use ($invoiceDate) {
                    $query->whereNull('payment_date_from')
                        ->orWhere(function($q) use ($invoiceDate) {
                            $q->where('payment_date_from', '<=', $invoiceDate)
                            ->where('payment_date_to', '>=', $invoiceDate);
                        });
                })
                ->value('employee_charge');
        }
        
        if ($amount !== null) {
            $totalAmount = $amount;
            return response()->json([
                'amount' => $totalAmount,
                'total_employee' => $totalEmployee
            ]);
        } else {
            return response()->json([
                'message' => 'No employee charge found for the selected date range because rule are not set',
                'total_employee' => $totalEmployee
            ]);
        }
    }

    public function invoiceExist(Request $request){
        $entityId = $request->input('entity_id');
        $invoiceDate = $request->input('invoice_date'); // Get the invoice date from request
        $email = Session::get('empsu_email');
         // Check if invoice already exists for this month/year
        $invoiceMonth = date('Y-m', strtotime($invoiceDate));
        $existingInvoice = DB::table('subadmin_bills')
            ->where('entity_id', $entityId)
            // ->where('email', $email)
            ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$invoiceMonth])
            ->first();

        if ($existingInvoice) {
            return response()->json([
                'invoice_exists' => true,
                'message' => 'Invoice already exists for ' . date('F Y', strtotime($invoiceDate))
            ]);
        }
    }

    public function store(Request $request)
    {
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
            $invoiceMonth = date('Y-m', strtotime($request->date));
            $existingInvoice = DB::table('subadmin_bills')
                ->where('entity_id', $request->entity_id)
                // ->where('email', $email)
                ->whereRaw("DATE_FORMAT(date, '%Y-%m') = ?", [$invoiceMonth])
                ->first();
            if($existingInvoice){
                Session::flash('message', 'This month invoice allready exist');
                return redirect()->back();
            }    
            //dd($validatedData);
            $date = $request->date;
            $pt = $request->billing_type == 'sub-admin' ? 'p' : '';
            $monthYear = date('mY', strtotime($request->date));
            $subadmin_name = DB::table('registration')->where('reg',$request->entity_id)->first();
            if ($subadmin_name && $subadmin_name->com_name) {
                $firstThreeLetters = substr($subadmin_name->com_name, 0, 3); // Get the first three letters
                $latter = $firstThreeLetters;
            } else {
                //dd('Company name not found');
                redirect('subadmin');
            }
            // get last id from bills table
            $lastInvoice = Subadmin_bill::latest('id')->first();

            if ($lastInvoice) {
                $nextInvoiceNumber = $lastInvoice->id + 1; // Accessing the 'id' field
            } else {
                $nextInvoiceNumber = 1; // If no record exists, start with 1
            }
            $invoiceNumber = strtoupper($latter . $pt . $monthYear . str_pad($nextInvoiceNumber, 2, '0', STR_PAD_LEFT));
            $dataToSave = array_merge($validatedData, [
                'invoice_no' => $invoiceNumber,
                'org_code' => $subadmin_name->org_code // Add the invoice number to save
            ]);
            $bill = Subadmin_bill::create($dataToSave);   
            Session::flash('message', 'Bill submitted successfully. Invoice Number: ' . $invoiceNumber);
            return redirect('sub-admin/billing-list');
        } else {
            redirect('subadmin');
        }
    }

    public function editBill($id){
        $id = base64_decode($id);
        //dd($id);
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $data['bills'] = DB::table('subadmin_bills')->where('id', $id)->first();

            if (!$data['bills']) {
                return redirect()->back()->with('error', 'Invoice not found !');
            }
            
            $data['org_dtl'] = DB::table('registration')->where('reg',$data['bills']->entity_id)->first();
            //dd($data['org_dtl']->com_name);
            return view('sub-admin.billing.edit_new_billing', $data);
        } else {
            redirect('superadmin');
        }
    }


    public function updateBilling(Request $request, $id)
    {
        $id = base64_decode($id);
        //dd($id);
        $request->validate([
            // 'bill_for' => 'required|string',
            //'billing_month' => 'required|string',
            // 'amount' => 'required|numeric',
            // 'total_employee' => 'required|numeric',
            // 'vat' => 'nullable|numeric',
            'payment_mode' => 'required|string',
            'status'    =>  'required|in:2,3',
            'description' => 'nullable|string',
            'remarks' => 'nullable|string',
        ]);

        $bill = Subadmin_bill::findOrFail($id);
        $bill->payment_mode = $request->payment_mode;
        $bill->description = $request->description;
        $bill->remarks = $request->remarks;
        $bill->status = $request->status;
        $bill->save();
        Session::flash('message', 'Bill updated successfully. Invoice Number: ' . $bill->invoice_number);
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
            return redirect('subadmin');
        }
    }

    public function viewInvoice(Request $request,$id){
        $encripted_id = base64_decode($id);
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $data['bill'] = DB::table('subadmin_bills')->where('id',$encripted_id)->first();
            $data['org_dtl'] = DB::table('registration')->where('reg',$data['bill']->entity_id)->first();
            $data['com_dtl'] = DB::table('sub_admin_registrations')->where('org_code',$data['bill']->org_code)->first();
            //dd($data['org_dtl']);
            //return view('subadminbillPdf',$data);
            return view('sub-admin.billing.invoice',$data);
        } else {
            redirect('subadmin');
        } 
    }

    public function downloadPdf(Request $request, $id){
        $encripted_id = base64_decode($id);
        //dd($encripted_id);
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $baseUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://".$_SERVER['HTTP_HOST'];
            $bill = DB::table('subadmin_bills')->where('id',$encripted_id)->first();
            $org_dtl = DB::table('registration')->where('reg',$bill->entity_id)->first();
            $partner = DB::table('sub_admin_registrations')->where('org_code',$bill->org_code)->first();
            //dd($partner);
            //dd($baseUrl.'/storage/app/public/'.$partner->logo);
            $partner_logo = $baseUrl.'/storage/app/public/'.$partner->logo;
            //dd($partner_logo);
            $data = [
                'invoice_no' => $bill->invoice_no,
                'item'  =>  $bill->bill_for,
                'invoice_date'  =>  $bill->date,
                'discount_amount'   =>  $bill->discount_amount,
                'vat'   =>  $bill->vat,
                'billing_type' => $bill->billing_type,
                'entity_id'  =>  $bill->entity_id,
                'amount'  =>  $bill->amount,
                'total_amount' => $bill->total_amount,
                'payment_mode'  =>  $bill->payment_mode,
                'description'  =>  $bill->description,
                'payment_status'   =>  $bill->payment_status,
                'org_code'   =>  $bill->org_code,
                'remarks' => $bill->remarks,
                
                'org_com_name'   =>  $org_dtl->com_name,
                'org_name' => "$org_dtl->f_name $org_dtl->l_name",
                'org_email'   =>  $org_dtl->email,
                'org_phone' => "$org_dtl->p_no",
                'org_address'   =>  $org_dtl->address,
                'org_country' => "$org_dtl->country",
                'org_road' => "$org_dtl->road",
                'org_city'   =>  $org_dtl->city,
                'org_zip' => "$org_dtl->zip",

                'p_logo'  =>  $partner_logo,
                'p_com_name' => $partner->com_name,
                'p_name' => "$org_dtl->f_name $org_dtl->l_name",
                'p_email' => $partner->email,
                'p_phone' => $partner->p_no,
                'p_address' => $partner->address,
                'p_country' => $partner->country,
                'p_road' => $partner->road,
                'p_city' => $partner->city,
                'p_zip' => $partner->zip,
                'p_land' => $partner->land,
                'p_website' => $partner->website,  
            ];
            dd($data);
            //return view('orgInvoicePdf', $data);
            $pdf = Pdf::loadView('orgInvoicePdf', $data);
            return $pdf->download('invoice_'.$bill->invoice_no.'.pdf');
            
        } else {
            return redirect('subadmin');
        }     
    }

    public function invoiceMail(Request $request, $id){
        $encripted_id = base64_decode($id);
        //dd($encripted_id);
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $bill = DB::table('subadmin_bills')->where('id',$encripted_id)->first();
            $org_dtl = DB::table('registration')->where('reg',$bill->entity_id)->first();
            $partner = DB::table('sub_admin_registrations')->where('org_code',$bill->org_code)->first();
            //dd($partner);
            $data = [
                'invoice_no' => $bill->invoice_no,
                'item'  =>  $bill->bill_for,
                'invoice_date'  =>  $bill->date,
                'discount_amount'   =>  $bill->discount_amount,
                'vat'   =>  $bill->vat,
                'billing_type' => $bill->billing_type,
                'entity_id'  =>  $bill->entity_id,
                'amount'  =>  $bill->amount,
                'total_amount' => $bill->total_amount,
                'payment_mode'  =>  $bill->payment_mode,
                'description'  =>  $bill->description,
                'payment_status'   =>  $bill->payment_status,
                'org_code'   =>  $bill->org_code,
                'remarks' => $bill->remarks,
                
                'org_com_name'   =>  $org_dtl->com_name,
                'org_name' => "$org_dtl->f_name $org_dtl->l_name",
                'org_email'   =>  $org_dtl->email,
                'org_phone' => "$org_dtl->p_no",
                'org_address'   =>  $org_dtl->address,
                'org_country' => "$org_dtl->country",
                'org_road' => "$org_dtl->road",
                'org_city'   =>  $org_dtl->city,
                'org_zip' => "$org_dtl->zip",

                'p_logo' => $partner->logo,
                'p_com_name' => $partner->com_name,
                'p_name' => "$partner->f_name $partner->l_name",
                'p_email' => $partner->email,
                'p_phone' => $partner->p_no,
                'p_address' => $partner->address,
                'p_country' => $partner->country,
                'p_road' => $partner->road,
                'p_city' => $partner->city,
                'p_zip' => $partner->zip,
                'p_land' => $partner->land,
                'p_website' => $partner->website  
            ];
            // Generate PDF
            $pdf = Pdf::loadView('orgInvoicePdf', $data);
            $invoice = $bill->invoice_no;
            $toEmail = $org_dtl->email;
            $subject = 'Payment Reminder: Invoice # '. $invoice .' – Due Soon! ' . $org_dtl->com_name;
            // Partner To Organization Email send.
            Mail::send('org-invoice-mail', $data, function ($message) use ($toEmail, $subject, $pdf, $invoice) {
                $message->to($toEmail)
                       ->subject($subject)
                       ->from('infoswc@skilledworkerscloud.co.uk')
                       ->attachData($pdf->output(), 'Invoice_'.$invoice.'.pdf', [
                           'mime' => 'application/pdf',
                       ]);
            });

            $data2 = [
                'com_name' => $org_dtl->com_name,
                'f_name' => $org_dtl->f_name,
                'l_name' => $org_dtl->l_name,
                'invoice_no' => $invoice,
                'invoice_date' => $bill->date,
                'p_com_name' => $partner->com_name,
            ];
            //return view('org-invoice-notify-mail', $data2);
            $toemail = $partner->email;
            Mail::send('org-invoice-notify-mail', $data2, function ($message) use ($toemail, $subject) {
                $message->to($toemail)->subject($subject);
               // $message->attach($path);
                $message->from('infoswc@skilledworkerscloud.co.uk');
            });   
    
            return back()->with('message', "($org_dtl->com_name) Invoice email sent successfully");
        } else {
            return redirect('subadmin');
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
            return redirect('subadmin');
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

    public function subadminOwnBillEdit(Request $request,$id){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            //dd('okk');
            $data['bills'] = DB::table('subadmin_bills')->where('id',$id)->first();
            return view('sub-admin.billing.own_bill_edit',$data);
        } else {
            redirect('superadmin');
        }
    }

    public function subadminOwnBillUpdate (Request $request, $id)
    {
        //dd('okk');
        $request->validate([
            'payment_dtl' => 'required|string|max:255',
            'payment_document' => 'nullable|file|mimes:pdf,jpg,png,jpeg|max:2048', // Adjust mime types as needed
        ]);
        
        $bill = Subadmin_bill::findOrFail($id);
        // Handle file upload
        if ($request->hasFile('payment_document')) {
            $file = $request->file('payment_document');
            $filePath = $file->store('subadmin_payments', 'public'); // this is my file path where save document "storage/app/public/org_payments/demo.png"
            // Update the file path in the database
            $bill->payment_document = $filePath;
        }
        $bill->status = 2;
        // Update other fields
        $bill->payment_dtl = $request->payment_dtl;
        $bill->save();
        //dd('okk');
        Session::flash('message', 'Payment status updated successfully .');
        return redirect('sub-admin/all-bills');
    }

    public function downloadSubInvoice(Request $request, $id)
    {
        ini_set('max_execution_time', '300'); 
        ini_set('memory_limit', '512M');  
        $email = Session::get('empsu_email');
        if (!empty($email)) {
            $bill = DB::table('subadmin_bills')->where('id', $id)->first();
            $com_dtl = DB::table('sub_admin_registrations')->where('reg', $bill->entity_id)->first();
    
            if (!$bill) {
                return back()->with('error', 'Invoice not found.');
            }

            $pdf = PDF::loadView('sub-admin.billing.sub-own-pdf', compact('bill', 'com_dtl'));
    
            // Return the generated PDF as a download
            return $pdf->download('invoice_' . $bill->invoice_no . '.pdf');
        } else {
            return redirect('superadmin')->with('error', 'Unauthorized access.');
        }
    }
    




} // end of class
