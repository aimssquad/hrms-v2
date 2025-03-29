<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Mail;
use App\Models\Bill;
use App\Models\BillingRule;
use App\Models\Subadmin_bill;
use Session;
use DB;

class BillController extends Controller
{
    // public function billingList(Request $request){
    //     $email = Session::get('empsu_email');
    //     if(!empty($email)){
    //         $billing_list = Subadmin_bill::with('billFor','company')->where('org_code', '')
    //             ->orWhereNull('org_code')
    //             ->get();
    //         //dd($billing_list);    
    //         return view ('admin/billing/new_billing_list',compact('billing_list'));
    //     } else {
    //         redirect('superadmin');
    //     }
    // }

    public function billingList(Request $request){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $billing_list = Subadmin_bill::with('company')->where('org_code', '')
                ->orWhereNull('org_code')
                ->get();
            //dd($billing_list);    
            return view ('admin/billing/new_billing_list',compact('billing_list'));
        } else {
            redirect('superadmin');
        }
    }

    public function partnerOrgInvoiceList(Request $request){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $billing_list = Subadmin_bill::where('org_code', 'admin')
                ->get();
            return view ('admin/billing/partner-org-billing-list',compact('billing_list'));
        } else {
            redirect('superadmin');
        }
    }

    

    public function store(Request $request)
    {
        // return view('subadmin_mail');
        // return view('subadminbillPdf');
        // dd($request->all());
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $validatedData = $request->validate([
                'bill_for' => 'required|string',
                'discount_amount' => 'nullable|string',
                'billing_type' => 'required|string',
                'entity_id' => 'required',
                'amount' => 'nullable|numeric',
                'total_employee' => 'nullable|integer',
                'vat' => 'nullable|numeric', 
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
            $dataToSave = array_merge($validatedData, [
                'invoice_no' => $invoiceNumber, // Add the invoice number to save
            ]);
      
            // Save the data
            $bill = Subadmin_bill::create($dataToSave);
            
        //    if($request->billing_type == "sub-admin"){
        //         $com_dtl = DB::table('sub_admin_registrations')->where('reg',$request->entity_id)->first();
        //    } else {
        //         $com_dtl = DB::table('registration')->where('reg',$request->entity_id)->first();
        //    }
        //    $data = array('com_name' => $com_dtl->com_name, 'f_name' => $com_dtl->f_name, 'l_name' => $com_dtl->l_name, 'p_no' => $com_dtl->p_no, 'email' => $com_dtl->email, 'address' => $com_dtl->address, 'country' => $com_dtl->country, 'city' => $com_dtl->city, 'zip' => $com_dtl->zip,
        //     'invoice_no' => $invoiceNumber, 'amount' => $request->amount, 'item' => $request->bill_for, 'total_amount' => $request->total_amount, 'invoice_date' => $request->date,
        //     'discount_amount' => $request->discount_amount, 'billing_type' => $request->billing_type, 'total_employee' => $request->total_employee, 'vat' => $request->vat, 'payment_mode' => $request->payment_mode,
        //     'description' => $request->description, 'remarks' => $request->remarks);
        //     return view('subadmin_mail',$data);
        //    dd($data);
            //----------------------
            
            // $datap = ['com_name' => $Roledata->com_name, 'com_logo' => $Roledata->logo, 'address' => $Roledata->address . ',' . $Roledata->address2 . ',' . $Roledata->road, 'addresssub' => $Roledata->city . ',' . $Roledata->zip . ',' . $Roledata->country,
            //     'date' => date('Y-m-d'), 'name' => $job->name, 'job_title' => $job->job_title, 'st_date' => date('Y-m-d', strtotime($request->date_jo)), 'em_name' => $job->name, 'em_pos' => $job->job_title];
            // $pdf = Pdf::loadView('subadminbillPdf', $datap);

            // $data = array('name' => $Roleempdata->name, 'com_name' => $Roledata->com_name, 'p_no' => $Roleempdata->phone,
            // 'email' => $Roleempdata->email, 'msg' => $request->msg);
            // $toemail = $request->email;
            
            // Mail::send('subadmin_mail', $data, function ($message) use ($toemail, $sub, $path) {
            //     $message->to($toemail)->subject($sub);
            //     foreach ($path as $filePath) {
            //         $message->attach($filePath);
            //     }
            //     $message->from('noreply@skilledworkerscloud.co.uk');
            // });
            // //-----------------
            Session::flash('message', 'Bill submitted successfully. Invoice Number: ' . $invoiceNumber);
            return redirect('superadmin/billing-list');
        } else {
            redirect('superadmin');
        }
    }



    public function invoiceMailSend(Request $request, $id)
    {
        $email = Session::get('empsu_email');
        if (empty($email)) {
            return redirect('superadmin');
        }
        $invoiceData = Subadmin_bill::where('id', $id)->first();
        if (!$invoiceData) {
            return back()->with('error', 'Invoice not found');
        }
        // Get company details
        $com_dtl = ($invoiceData->billing_type == "sub-admin")
            ? DB::table('sub_admin_registrations')->where('reg', $invoiceData->entity_id)->first()
            : DB::table('registration')->where('reg', $invoiceData->entity_id)->first();

        if (!$com_dtl) {
            return back()->with('error', 'Company details not found');
        }
        // Prepare data for PDF and email
        $data = [
            'com_name' => $com_dtl->com_name,
            'f_name' => $com_dtl->f_name,
            'l_name' => $com_dtl->l_name,
            'p_no' => $com_dtl->p_no,
            'email' => $com_dtl->email,
            'address' => $com_dtl->address,
            'country' => $com_dtl->country,
            'city' => $com_dtl->city,
            'zip' => $com_dtl->zip,
            'road' => $com_dtl->road,
            'invoice_no' => $invoiceData->invoice_no,
            'amount' => $invoiceData->amount,
            'item' => $invoiceData->bill_for,
            'total_amount' => $invoiceData->total_amount,
            'invoice_date' => $invoiceData->date,
            'discount_amount' => $invoiceData->discount_amount,
            'billing_type' => $invoiceData->billing_type,
            'total_employee' => $invoiceData->total_employee,
            'vat' => $invoiceData->vat,
            'payment_mode' => $invoiceData->payment_mode,
            'description' => $invoiceData->description,
            'remarks' => $invoiceData->remarks
        ];

        // Generate PDF
        $pdf = Pdf::loadView('subadminbillPdf', $data);
        // $pdf->save(storage_path('temp/invoice_temp.pdf')); 
        // dd('okk');
        $invoice = $invoiceData->invoice_no;
        // Email details
        $toEmail = "sharmaranjanetc@gmail.com";
        $subject = 'Invoice #' . $invoice . ' - ' . $com_dtl->com_name;
        
        // Send email with PDF attachment
        Mail::send('subadmin_mail', $data, function ($message) use ($toEmail, $subject, $pdf, $invoice) {
            $message->to($toEmail)
                   ->subject($subject)
                   ->from('infoswc@skilledworkerscloud.co.uk', 'Skilled Workers Cloud')
                   ->attachData($pdf->output(), 'Invoice_'.$invoice.'.pdf', [
                       'mime' => 'application/pdf',
                   ]);
        });

        // Mail::send('subadmin_mail', $data, function ($message) use ($toEmail, $subject) {
        //     $message->to($toEmail, 'skilledworkerscloud')->subject
        //         ($subject);
        //    // $message->attach($path);
        //     $message->from('infoswc@skilledworkerscloud.co.uk', 'skilledworkerscloud');
        // });
          

        return back()->with('message', 'Invoice email sent successfully');
    }

    // public function adminBillingPartnerOrg(Request $request){

    //     $email = Session::get('empsu_email');
    //     if(!empty($email)){
    //         $validatedData = $request->validate([
    //             'bill_for' => 'required|string',
    //             'discount_amount' => 'nullable|string',
    //             'billing_type' => 'required|string',
    //             'entity_id' => 'required',
    //             'amount' => 'nullable|numeric',
    //             'total_employee' => 'nullable|integer',
    //             'vat' => 'nullable|numeric', // This is the VAT percentage
    //             'total_amount' => 'nullable|numeric',
    //             'payment_mode' => 'required|string',
    //             'description' => 'nullable|string',
    //             'remarks' => 'nullable|string',
    //             'date' => 'nullable|date',
    //         ]);
    //         $data = [
    //             'bill_for' => $validatedData['bill_for'],
    //             'discount_amount' => $validatedData['discount_amount'] ?? 0,
    //             'billing_type' => 'employer',
    //             'entity_id' => $validatedData['entity_id'],
    //             'amount' => $validatedData['amount'] ?? 0,
    //             'total_employee' => $validatedData['total_employee'] ?? 0,
    //             'vat' => $validatedData['vat'] ?? 0,
    //             'total_amount' => $validatedData['total_amount'] ?? 0,
    //             'payment_mode' => $validatedData['payment_mode'],
    //             'description' => $validatedData['description'] ?? '',
    //             'org_code' => 'admin',
    //             'remarks' => $validatedData['remarks'] ?? '',
    //             'date' => $validatedData['date'] ?? now(),
    //         ];

    //         $pt = 'P';
    //         $monthYear = date('mY', strtotime($request->date));
        
    //         $lastInvoice = Subadmin_bill::latest('id')->first();

    //         if ($lastInvoice) {
    //             $nextInvoiceNumber = $lastInvoice->id + 1; // Accessing the 'id' field
    //         } else {
    //             $nextInvoiceNumber = 1; // If no record exists, start with 1
    //         }
    //         // Generate the next invoice number
    //         $invoiceNumber = "SWC" . $pt . $monthYear . str_pad($nextInvoiceNumber, 2, '0', STR_PAD_LEFT);
    //             $dataToSave = array_merge($data, [
    //                 'invoice_no' => $invoiceNumber, // Add the invoice number to save
    //             ]);
    //         $bill = Subadmin_bill::create($dataToSave);
    //         Session::flash('message', 'Bill submitted successfully. Invoice Number: ' . $invoiceNumber);
    //         return redirect('superadmin/partner-billing-list');
    //     } else {
    //         redirect('superadmin');
    //     }
    // }

    public function adminBillingPartnerOrg(Request $request)
    {
        $email = Session::get('empsu_email');
        if (!empty($email)) {
            $validatedData = $request->validate([
                'bill_for' => 'required|string',
                'discount_amount' => 'nullable|string',
                'billing_type' => 'required|string',
                'entity_id' => 'required',
                'amount' => 'nullable|numeric',
                'total_employee' => 'nullable|integer',
                'vat' => 'nullable|numeric', 
                'total_amount' => 'nullable|numeric',
                'payment_mode' => 'required|string',
                'description' => 'nullable|string',
                'remarks' => 'nullable|string',
                'date' => 'nullable|date',
            ]);

            $entityId = $validatedData['entity_id'];
            $billDate = $validatedData['date'] ?? now();
            $month = date('m', strtotime($billDate));
            $year = date('Y', strtotime($billDate));

            // Check if an invoice already exists for this entity in the same month and year
            $existingInvoice = Subadmin_bill::where('entity_id', $entityId)
                ->whereMonth('date', $month)
                ->whereYear('date', $year)
                ->exists();

            if ($existingInvoice) {
                return redirect()->back()->with('error', 'An invoice for this Organisation already exists for this month.');
            }

            $data = [
                'bill_for' => $validatedData['bill_for'],
                'discount_amount' => $validatedData['discount_amount'] ?? 0,
                'billing_type' => 'employer',
                'entity_id' => $entityId,
                'amount' => $validatedData['amount'] ?? 0,
                'total_employee' => $validatedData['total_employee'] ?? 0,
                'vat' => $validatedData['vat'] ?? 0,
                'total_amount' => $validatedData['total_amount'] ?? 0,
                'payment_mode' => $validatedData['payment_mode'],
                'description' => $validatedData['description'] ?? '',
                'org_code' => 'admin',
                'remarks' => $validatedData['remarks'] ?? '',
                'date' => $billDate,
            ];

            $pt = 'P';
            $monthYear = date('mY', strtotime($billDate));

            $lastInvoice = Subadmin_bill::latest('id')->first();
            $nextInvoiceNumber = $lastInvoice ? $lastInvoice->id + 1 : 1;
            $invoiceNumber = "SWC" . $pt . $monthYear . str_pad($nextInvoiceNumber, 2, '0', STR_PAD_LEFT);

            $dataToSave = array_merge($data, ['invoice_no' => $invoiceNumber]);
            Subadmin_bill::create($dataToSave);

            Session::flash('message', 'Bill submitted successfully. Invoice Number: ' . $invoiceNumber);
            return redirect('superadmin/partner-billing-list');
        } else {
            return redirect('superadmin');
        }
    }


    public function editBill(Request $request,$id){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $bills = DB::table('subadmin_bills')->where('id', $id)->first();
            if (!$bills) {
                return redirect()->back()->with('error', 'Bill not found.');
            }
        
            return view('admin.billing.edit_billing_list', compact('bills'));
        } else {
            redirect('superadmin');
        }
    }

    public function editPartnerBill(Request $request,$id){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $bills = DB::table('subadmin_bills')->where('id', $id)->first();
            if (!$bills) {
                return redirect()->back()->with('error', 'Billing rule not found.');
            }
        
            return view('admin.billing.edit-partner-org-bill', compact('bills'));
        } else {
            redirect('superadmin');
        }
    }

    public function updateBilling(Request $request, $id)
    {
        //dd($request->all());
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
        // Save the updated bill
        $bill->save();
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
            'billing_for' => 'required|in:Organisation Subscription,Number Of Employee',

            'min_organizations' => 'nullable|integer|min:0',
            'max_organizations' => 'nullable|integer|min:0',
            'organization_charge' => 'nullable|numeric',

            'min_employees' => 'nullable|integer|min:0',
            'max_employees' => 'nullable|integer|min:0',
            'employee_charge' => 'nullable|numeric|min:0',
            //'max_organizations' => 'nullable|integer|min:0',
            
            'billing_mode' => 'nullable|string',
            'payment_date_from' => 'nullable',
            'payment_date_to' => 'nullable',
            //'payment_date_range' => 'required|string',
        ]);
        //dd($validatedData);
        // Check if a rule with the same entity_id and payment_date_range already exists
        $existingRule = BillingRule::where('entity_id', $validatedData['entity_id'])
            //->where('payment_date_range', $validatedData['payment_date_range'])
            ->first();
    
        if ($existingRule) {
            // If a match is found, redirect back with an error message
            return redirect()->back()->withErrors([
                'payment_date_range' => 'Rule already exists for this user id.'
            ]);
        }
    
        // Save data to the database
        BillingRule::create([
            'type' => $validatedData['billing_type'],
            'entity_id' => $validatedData['entity_id'],
            'billing_for' => $validatedData['billing_for'] ?? null,

            'min_organizations' => $validatedData['min_organizations'] ?? null,
            'max_organizations' => $validatedData['max_organizations'] ?? null,
            'organization_charge' => $validatedData['organization_charge'] ?? null,

            'min_employees' => $validatedData['min_employees'] ?? null,
            'max_employees' => $validatedData['max_employees'] ?? null,
            'employee_charge' => $validatedData['employee_charge'] ?? null,

            'billing_mode' => $validatedData['billing_mode'] ?? null,
            'payment_date_from' => $validatedData['payment_date_from'] ?? null,
            'payment_date_to' => $validatedData['payment_date_to'] ?? null,

            // 'employee_charge' => $validatedData['employee_charge'] ?? null,
            // 'max_organizations' => $validatedData['max_organizations'] ?? null,
            // 'min_employees' => $validatedData['min_employees'] ?? null,
            // 'max_employees' => $validatedData['max_employees'] ?? null,
            // 'payment_date_range' => $validatedData['payment_date_range'] ?? null,
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
                // 'type' => 'required|string',
                // 'entity_id' => 'required',
                // 'employee_charge' => 'nullable|required',
                // 'max_organizations' => 'nullable|numeric',
                // 'min_employees' => 'nullable|required',
                // 'max_employees' => 'nullable|required',
                // 'payment_date_range' => 'nullable|string|max:50',
                'type' => 'required|in:employer,sub-admin',
                'entity_id' => 'required|string|max:50',
                'billing_for' => 'required|in:Organisation Subscription,Number Of Employee',

                'min_organizations' => 'nullable|integer|min:0',
                'max_organizations' => 'nullable|integer|min:0',
                'organization_charge' => 'nullable|numeric',

                'min_employees' => 'nullable|integer|min:0',
                'max_employees' => 'nullable|integer|min:0',
                'employee_charge' => 'nullable|numeric|min:0',
                //'max_organizations' => 'nullable|integer|min:0',
                
                'billing_mode' => 'nullable|string',
                'payment_date_from' => 'nullable',
                'payment_date_to' => 'nullable',
                
            ]);
            //dd($validated);
            DB::table('rule_table')->where('id', $id)->update($validated);
            Session::flash('message', 'Record Update successfully.');
            return redirect('superadmin/show-rule');
        } else {
            redirect('superadmin');
        }
        
    }

    // public function viewAdminInvoice(Request $request,$id){
    //     $email = Session::get('empsu_email');
    //     if(!empty($email)){
    //        //dd($id);
    //        //$data['bill'] = DB::table('subadmin_bills')->where('id',$id)->first();
    //        $data['bill'] = Subadmin_bill::with('billFor')->where('id',$id)->first();
    //        //dd($data['bill']);
    //        if($data['bill']->billing_type == 'employer'){
    //             $data['org_dtl'] = DB::table('registration')->where('reg',$data['bill']->entity_id)->first();
    //        } else {
    //             $data['org_dtl'] = DB::table('sub_admin_registrations')->where('reg',$data['bill']->entity_id)->first();
    //        }
    //        //dd($data);
    //        return view('admin.billing.invoice',$data);
    //        //return view('new-bill-pdf',$data);
    //     } else {
    //         redirect('superadmin');
    //     }
    // }

    public function viewAdminInvoice(Request $request,$id){
        $email = Session::get('empsu_email');
        if(!empty($email)){
           //dd($id);
           //$data['bill'] = DB::table('subadmin_bills')->where('id',$id)->first();
            $data['bill'] = Subadmin_bill::where('id',$id)
                //->with('billFor')
                ->first();
           //dd($data['bill']);
           if($data['bill']->billing_type == 'employer'){
                $data['org_dtl'] = DB::table('registration')->where('reg',$data['bill']->entity_id)->first();
           } else {
                $data['org_dtl'] = DB::table('sub_admin_registrations')->where('reg',$data['bill']->entity_id)->first();
           }
           //dd($data);
           return view('admin.billing.invoice',$data);
           //return view('new-bill-pdf',$data);
        } else {
            redirect('superadmin');
        }
    }

    public function partnerOrgBilling(Request $request)
    {
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

                //All Bills
                $data['bill_rs'] = DB::Table('billing')->get();
                //dd($data['bill_rs']);
                //organisation details
                $data['or_de'] = DB::Table('registration')
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    //->where('licence', '=', 'yes')
                    ->get();

                // $data['candidate_rs'] = DB::Table('invoice_candidates')
                //     ->where('status', '=', 'A')
                //     ->get();

                //hired candidate list
                $data['candidate_rs'] = DB::Table('candidate')
                    ->where('status', '=', 'Hired')
                    ->get();
                $data['partners'] = DB::Table('sub_admin_registrations')
                    ->where('status', '=', 'active')
                    ->where('verify', '=', 'approved')
                    ->get();    

                //dd($data['or_de']);

                $userlist = array();
                foreach ($data['bill_rs'] as $user) {
                    $userlist[] = $user->emid;
                }

                $data['package_rs'] = DB::Table('package')
                    ->where('status', '=', 'active')
                    ->get();

                $data['tax_rs'] = DB::Table('tax_bill')
                    ->where('status', '=', 'active')
                    ->get(); 
                $data['partner_list'] = DB::table('users')
                    //->where('user_type','=',$billingType)
                    ->where('status', 'active')
                    ->get(['id','employee_id', 'name']); 

                return View('admin/billing/partner-org-billing', $data);

            } else {
                return redirect('superadmin');
            }
        } catch (Exception $e) {
            throw new \App\Exceptions\AdminException($e->getMessage());
        }
    }

    public function getPertnerOrganization(Request $request){
        $organizations = DB::table('registration')
        ->where('org_code', $request->billing_type)
        // ->where('status','active')
        // ->where('verify','approved')
        ->select('id','reg', 'com_name')
        ->get();

        return response()->json($organizations);
    }

    public function updatePartnerBilling(Request $request, $id)
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
            'status' => 'nullable|numeric',
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
        $bill->status = $validated['status'];
        $bill->updated_at = now();
        //dd('After Update:', $bill);
        // Save the updated bill
        $bill->save();

        // Flash success message
        Session::flash('message', 'Bill updated successfully.');

        // Redirect back to the billing list
        return redirect('superadmin/partner-billing-list');
    }

    public function partnerNotIssuedBills(Request $request)
    {
        $email = Session::get('empsu_email');
        if ($email) {
            $from_date = $request->get('from_date');
            $to_date = $request->get('to_date');

            // Extract month and year from from_date and to_date
            $fromMonth = $from_date ? date('m', strtotime($from_date)) : null;
            $fromYear = $from_date ? date('Y', strtotime($from_date)) : null;
            $toMonth = $to_date ? date('m', strtotime($to_date)) : null;
            $toYear = $to_date ? date('Y', strtotime($to_date)) : null;
            //dd($fromYear);
            $partner_orgs = DB::table('registration')
                ->whereNotNull('org_code')
                ->select('com_name', 'org_code', 'reg')
                ->get();

            $missingBills = [];
            $currentMonth = date('m');
            $currentYear = date('Y');

            // Fetch all organization names from sub_admin_registrations at once
            $partnerNames = DB::table('sub_admin_registrations')
                ->pluck('com_name', 'org_code');

            foreach ($partner_orgs as $org) {
                // Apply year and month filters if both from_date and to_date are provided
                $billedQuery = DB::table('subadmin_bills')
                    ->where('entity_id', $org->reg)
                    ->whereYear('date', $currentYear);

                // Apply from_date and to_date filters
                if ($from_date) {
                    $billedQuery->whereDate('date', '>=', $from_date);
                }
                if ($to_date) {
                    $billedQuery->whereDate('date', '<=', $to_date);
                }

                // Get all months where a bill exists for this organization within the date range
                $billedMonths = $billedQuery->pluck(DB::raw('MONTH(date)'))->toArray();

                // Generate an array of months from January to the current month
                $allMonths = range(1, $currentMonth);

                // If from_date is provided, filter months starting from the provided month
                if ($fromMonth && $fromYear == $currentYear) {
                    $allMonths = range($fromMonth, $currentMonth);
                }

                // If to_date is provided, filter months up to the provided month
                if ($toMonth && $toYear == $currentYear) {
                    $allMonths = range($fromMonth ?? 1, $toMonth);
                }

                // Find months where no bill exists
                $notBilledMonths = array_diff($allMonths, $billedMonths);

                if (!empty($notBilledMonths)) {
                    $missingBills[] = [
                        'org_name' => $org->com_name,
                        'partner_name' => $partnerNames[$org->org_code] ?? 'Unknown',
                        'reg' => $org->reg,
                        'org_code' => $org->org_code,
                        'missing_months' => array_map(function ($month) use ($currentYear) {
                            return date("F Y", mktime(0, 0, 0, $month, 1, $currentYear));
                        }, $notBilledMonths),
                    ];
                }
            }

            return view('admin.billing.invoice-not-issued', compact('missingBills'));
        } else {
            return redirect('superadmin');
        }
    }

    public function notIssuedBills(Request $request){
        return view('admin.billing.invoice-not-issued-org');
    }

    public function showItem(Request $request){
        $email = Session::get('empsu_email');
        if(!empty($email)){
            $billing_rule = BillingRule::all();
            return view ('admin/billing/billing_rule_list',compact('billing_rule'));
        } else {
            redirect('superadmin');
        }
    }





    



    

  
    

} // End Class
