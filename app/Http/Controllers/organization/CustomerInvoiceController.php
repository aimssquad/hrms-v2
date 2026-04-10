<?php

namespace App\Http\Controllers\organization;

use App\Http\Controllers\Controller;
use App\Models\Guest;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Mail;
use Carbon\Carbon;

class CustomerInvoiceController extends Controller
{
    protected $_module;
    protected $_routePrefix;
    protected $_model;

    public function __construct()
    {
        $this->_module      = 'Organization';
        $this->_routePrefix = 'employeer.guest-bills.customer-invoice';
        $this->_model       = new Guest();
    }

    public function dashboard(){
        dd('okk');
    }

    public function addCustomer(Request $request){
       // dd('okkk');
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
            ->route('org.customer.invoice.create')
            ->with('message', 'Customer created successfully.');
    }

    //  public function store(Request $request)
    // {
    //     //dd('okk');
       
    // }

    public function index()
    {
        $email = Session::get("emp_email");
        $emid = Session::get("emid");
        $invoices = Invoice::with(['items', 'guest'])
            ->where('emid', $emid)
            ->latest()
            ->get();
        //dd($invoices);    
        return view($this->_routePrefix . '.index', compact('invoices'));
        //return view('guests.index', compact('guests'));
    }

    /**
     * Show the form for creating a new guest
     */
    public function create()
    {
        $email = Session::get("emp_email");
        $emid = Session::get("emid");
        //dd($emid);

        $data['guests'] = Guest::where('emid',$emid)->orderBy('id', 'desc')->get();
        return view($this->_routePrefix . '.create', $data);
        //return view('guests.create');
    }

    // public function store(Request $request)
    // {
    //     $email = Session::get("emp_email");
    //     $emid  = Session::get("emid");
    //     $com_name = DB::table('registration')->where('reg', $emid)->select('com_name')->first();
    //     //dd($request->all());
    //     $companyName = $com_name->com_name ?? '';

    //     if (!empty(trim($companyName))) {
    //         // Remove spaces and take first 2 letters
    //         $companyPrefix = strtoupper(
    //             substr(preg_replace('/\s+/', '', $companyName), 0, 2)
    //         );
    //     } else {
    //         $companyPrefix = 'IN'; 
    //     }
        
    //     DB::beginTransaction();

    //     try {

    //         /* =======================
    //         | 1. CREATE INVOICE
    //         ======================= */

    //         $invoice = Invoice::create([
    //             'emid'         => $emid,
    //             'guest_id'     => $request->guest_id,
    //             'country'      => $request->country,
    //             'currency'     => $request->currency,
    //             'invoice_date' => $request->date,
    //             'invoice_send' => $request->invoice_send,
    //             'total_tax'    => 0,
    //             'grand_total'  => 0,
    //         ]);

    //         $randomNumber = rand(10000, 99999);
    //         $invoiceNo = $companyPrefix . $randomNumber . $invoice->id;
    //         $invoice->update([
    //             'invoice_no' => $invoiceNo
    //         ]);

    //         $totalTax   = 0;
    //         $grandTotal = 0;

    //         /* =======================
    //         | 2. LOOP ITEMS
    //         ======================= */

    //         foreach ($request->service_name as $index => $serviceName) {

    //             $qty        = (float) $request->quantity[$index];
    //             $unitPrice  = (float) $request->unit_price[$index];
    //             $discount   = (float) ($request->discount[$index] ?? 0);
    //             $discType   = $request->discount_type[$index] ?? null;
    //             $taxPercent = (float) ($request->tax_percent[$index] ?? 0);
    //             $taxType    = $request->tax_type[$index] ?? 'exclusive';

    //             /* -----------------------
    //             | BASE AMOUNT
    //             ----------------------- */
    //             $baseAmount = $qty * $unitPrice;

    //             /* -----------------------
    //             | DISCOUNT CALCULATION
    //             ----------------------- */
    //             if ($discType === 'percentage_discount' && $discount > 0) {
    //                 $discountAmount = ($baseAmount * $discount) / 100;
    //             } elseif ($discType === 'flat_discount') {
    //                 $discountAmount = $discount;
    //             } else {
    //                 $discountAmount = 0;
    //             }

    //             $amountAfterDiscount = max($baseAmount - $discountAmount, 0);

    //             /* -----------------------
    //             | TAX CALCULATION
    //             ----------------------- */
    //             if ($taxPercent > 0) {

    //                 if ($taxType === 'inclusive') {
    //                     // tax included in price
    //                     $taxAmount = $amountAfterDiscount - ($amountAfterDiscount / (1 + $taxPercent / 100));
    //                     $subTotal  = $amountAfterDiscount;

    //                 } else {
    //                     // exclusive tax
    //                     $taxAmount = ($amountAfterDiscount * $taxPercent) / 100;
    //                     $subTotal  = $amountAfterDiscount + $taxAmount;
    //                 }

    //             } else {
    //                 $taxAmount = 0;
    //                 $subTotal  = $amountAfterDiscount;
    //             }

    //             /* -----------------------
    //             | SAVE ITEM
    //             ----------------------- */
    //             InvoiceItem::create([
    //                 'emid'          => $emid,
    //                 'invoice_id'    => $invoice->id,
    //                 'service_name'  => $serviceName,
    //                 'quantity'      => $qty,
    //                 'unit_price'    => $unitPrice,
    //                 'discount'      => $discountAmount,
    //                 'discount_type' => $discType,
    //                 'tax_percent'   => $taxPercent,
    //                 'tax_type'      => $taxType,
    //                 'sub_total'     => round($subTotal, 2),
    //             ]);

    //             $totalTax   += $taxAmount;
    //             $grandTotal += $subTotal;
    //         }

    //         /* =======================
    //         | 3. UPDATE INVOICE TOTALS
    //         ======================= */

    //         $invoice->update([
    //             'total_tax'  => round($totalTax, 2),
    //             'grand_total'=> round($grandTotal, 2),
    //         ]);

    //         DB::commit();

    //         return redirect('organization/customer/invoice')
    //             //->back()
    //             ->with('message', 'Invoice created successfully');

    //     } catch (\Exception $e) {

    //         DB::rollBack();

    //         return redirect()
    //             ->back()
    //             ->with('error', $e->getMessage());
    //     }
    // }

    public function store(Request $request)
    {
        $emid  = Session::get("emid");

        DB::beginTransaction();

        try {

            /* =======================
            | 1. CREATE INVOICE
            ======================= */
            $invoice = Invoice::create([
                'emid'         => $emid,
                'guest_id'     => $request->guest_id,
                'country'      => $request->country,
                'currency'     => $request->currency,
                'invoice_date' => $request->date,
                'invoice_send' => $request->invoice_send,
                'referance_no' => $request->referance_no,
                'remarks' => $request->remarks,
                'total_tax'    => 0,
                'grand_total'  => 0,
            ]);

            /* =======================
            | 2. GENERATE INVOICE NO
            ======================= */
            $companyName = DB::table('registration')
                ->where('reg', $emid)
                ->value('com_name');

            $prefix = $companyName
                ? strtoupper(substr(preg_replace('/\s+/', '', $companyName), 0, 2))
                : 'IN';

            $emidLastTwo = substr(preg_replace('/\D/', '', $emid), -2);

            $month = Carbon::parse($invoice->invoice_date)->format('m'); 
            $year  = Carbon::parse($invoice->invoice_date)->format('y'); 

            $invoiceId = $invoice->id; 

            $invoiceNo = $prefix . $emidLastTwo . $month . $year . $invoiceId;

            $invoice->update([
                'invoice_no' => $invoiceNo
            ]);

            /* =======================
            | 3. LOOP ITEMS
            ======================= */
            $totalTax   = 0;
            $grandTotal = 0;

            foreach ($request->service_name as $index => $serviceName) {

                $qty        = (float) $request->quantity[$index];
                $unitPrice  = (float) $request->unit_price[$index];
                $discount   = (float) ($request->discount[$index] ?? 0); // 10 OR 1000
                $discType   = $request->discount_type[$index] ?? null;
                $taxPercent = (float) ($request->tax_percent[$index] ?? 0);
                $taxType    = $request->tax_type[$index] ?? 'exclusive';

                /* -----------------------
                | BASE PRICE
                ----------------------- */
                $basePrice = $qty * $unitPrice;

                /* -----------------------
                | DISCOUNT CALCULATION
                ----------------------- */
                if ($discType === 'percentage_discount' && $discount > 0) {
                    $discountAmount = ($basePrice * $discount) / 100;
                } elseif ($discType === 'flat_discount') {
                    $discountAmount = $discount;
                } else {
                    $discountAmount = 0;
                }

                $netAmount = max($basePrice - $discountAmount, 0);

                /* -----------------------
                | TAX CALCULATION
                ----------------------- */
                if ($taxPercent > 0) {

                    if ($taxType === 'inclusive') {
                        $taxAmount = $netAmount - ($netAmount / (1 + $taxPercent / 100));
                        $lineTotal = $netAmount;
                        $taxable   = $netAmount - $taxAmount;
                    } else {
                        $taxAmount = ($netAmount * $taxPercent) / 100;
                        $taxable   = $netAmount;
                        $lineTotal = $netAmount + $taxAmount;
                    }

                } else {
                    $taxAmount = 0;
                    $taxable   = $netAmount;
                    $lineTotal = $netAmount;
                }

                /* -----------------------
                | SAVE ITEM (IMPORTANT)
                ----------------------- */
                InvoiceItem::create([
                    'emid'          => $emid,
                    'invoice_id'    => $invoice->id,
                    'service_name'  => $serviceName,
                    'quantity'      => $qty,
                    'unit_price'    => $unitPrice,

                    // ✅ STORE RAW DISCOUNT VALUE
                    'discount'      => $discount,
                    'discount_type' => $discType,

                    'tax_percent'   => $taxPercent,
                    'tax_type'      => $taxType,
                    'sub_total'     => round($lineTotal, 2),
                ]);

                $totalTax   += $taxAmount;
                $grandTotal += $lineTotal;
            }

            /* =======================
            | 4. UPDATE TOTALS
            ======================= */
            $invoice->update([
                'total_tax'   => round($totalTax, 2),
                'grand_total' => round($grandTotal, 2),
            ]);

            DB::commit();

            return redirect('organization/customer/invoice')
                ->with('message', 'Invoice created successfully');

        } catch (\Exception $e) {

            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', $e->getMessage());
        }
    }


    // Edit Invoice 
    public function edit($encodedId)
    {
        // Decode ID
        $invoiceId = base64_decode($encodedId);

        // Logged-in organization
        $emid = Session::get('emid');

        // Fetch invoice with relations
        $invoice = Invoice::with(['items', 'guest'])
            ->where('id', $invoiceId)
            ->where('emid', $emid)
            ->firstOrFail();

        // Organization details (for logo, name, etc.)
        $organization = DB::table('registration')->where('reg', $emid)->first();

        // Guests list (if you want to change customer)
        $guests = Guest::where('emid', $emid)->get();

        return view('employeer.guest-bills.customer-invoice.edit', compact(
            'invoice',
            'organization',
            'guests'
        ));
    }

    // update Invoice 
    // public function update(Request $request, $encodedId)
    // {
    //     $id   = base64_decode($encodedId);
    //     $emid = Session::get('emid');

    //     DB::beginTransaction();

    //     try {

    //         /* =========================
    //            UPDATE INVOICE HEADER
    //         ========================== */
    //         $invoice = Invoice::where('id', $id)
    //             ->where('emid', $emid)
    //             ->firstOrFail();

    //         $invoice->update([
    //             'guest_id'     => $request->guest_id,
    //             'country'      => $request->country,
    //             'currency'     => $request->currency,
    //             'invoice_date' => $request->date,
    //             'invoice_send' => $request->invoice_send,
    //         ]);

    //         /* =========================
    //            DELETE OLD ITEMS
    //         ========================== */
    //         InvoiceItem::where('invoice_id', $invoice->id)->delete();

    //         /* =========================
    //            REINSERT ITEMS
    //         ========================== */
    //         $totalTax   = 0;
    //         $grandTotal = 0;

    //         foreach ($request->service_name as $index => $service) {

    //             $qty        = (float) $request->quantity[$index];
    //             $unitPrice  = (float) $request->unit_price[$index];
    //             $discount   = (float) ($request->discount[$index] ?? 0);
    //             $discType   = $request->discount_type[$index];
    //             $taxPct     = (float) ($request->tax_percent[$index] ?? 0);
    //             $taxType    = $request->tax_type[$index];

    //             /* BASE */
    //             $base = $qty * $unitPrice;

    //             /* DISCOUNT */
    //             if ($discType === 'percentage_discount') {
    //                 $discountAmount = ($base * $discount) / 100;
    //             } else {
    //                 $discountAmount = $discount;
    //             }

    //             $afterDiscount = max($base - $discountAmount, 0);

    //             /* TAX */
    //             if ($taxPct > 0) {
    //                 if ($taxType === 'inclusive') {
    //                     $taxAmount = $afterDiscount - ($afterDiscount / (1 + $taxPct / 100));
    //                     $subTotal  = $afterDiscount;
    //                 } else {
    //                     $taxAmount = ($afterDiscount * $taxPct) / 100;
    //                     $subTotal  = $afterDiscount + $taxAmount;
    //                 }
    //             } else {
    //                 $taxAmount = 0;
    //                 $subTotal  = $afterDiscount;
    //             }

    //             /* SAVE ITEM */
    //             InvoiceItem::create([
    //                 'invoice_id'   => $invoice->id,
    //                 'emid'         => $emid,
    //                 'service_name' => $service,
    //                 'quantity'     => $qty,
    //                 'unit_price'   => $unitPrice,
    //                 'discount'     => $discount,
    //                 'discount_type'=> $discType,
    //                 'tax_percent'  => $taxPct,
    //                 'tax_type'     => $taxType,
    //                 'sub_total'    => $subTotal,
    //             ]);

    //             $totalTax   += $taxAmount;
    //             $grandTotal += $subTotal;
    //         }

    //         /* =========================
    //            UPDATE TOTALS
    //         ========================== */
    //         $invoice->update([
    //             'total_tax'   => $totalTax,
    //             'grand_total' => $grandTotal,
    //         ]);

    //         DB::commit();

    //         return redirect()
    //             ->route('org.customer.invoice.show', base64_encode($invoice->id))
    //             ->with('success', 'Invoice updated successfully');

    //     } catch (\Exception $e) {

    //         DB::rollBack();

    //         return back()->with(
    //             'error',
    //             'Something went wrong: ' . $e->getMessage()
    //         );
    //     }
    // }

    public function update(Request $request, $encodedId)
    {
        $id   = base64_decode($encodedId);
        $emid = Session::get('emid');

        DB::beginTransaction();

        try {

            /* =========================
            1. UPDATE INVOICE HEADER
            ========================== */
            $invoice = Invoice::where('id', $id)
                ->where('emid', $emid)
                ->firstOrFail();

            $invoice->update([
                'guest_id'     => $request->guest_id,
                'country'      => $request->country,
                'currency'     => $request->currency,
                'invoice_date' => $request->date,
                'invoice_send' => $request->invoice_send,
                'referance_no' => $request->referance_no,
                'remarks' => $request->remarks,
            ]);

            /* =========================
            2. DELETE OLD ITEMS
            ========================== */
            InvoiceItem::where('invoice_id', $invoice->id)->delete();

            /* =========================
            3. REINSERT ITEMS
            ========================== */
            $totalTax   = 0;
            $grandTotal = 0;

            foreach ($request->service_name as $index => $serviceName) {

                $qty        = (float) $request->quantity[$index];
                $unitPrice  = (float) $request->unit_price[$index];

                // ✅ RAW DISCOUNT VALUE
                $discount   = (float) ($request->discount[$index] ?? 0);
                $discType   = $request->discount_type[$index] ?? null;

                $taxPercent = (float) ($request->tax_percent[$index] ?? 0);
                $taxType    = $request->tax_type[$index] ?? 'exclusive';

                /* -----------------------
                BASE PRICE
                ----------------------- */
                $basePrice = $qty * $unitPrice;

                /* -----------------------
                DISCOUNT CALCULATION
                ----------------------- */
                if ($discType === 'percentage_discount' && $discount > 0) {
                    $discountAmount = ($basePrice * $discount) / 100;
                } elseif ($discType === 'flat_discount') {
                    $discountAmount = $discount;
                } else {
                    $discountAmount = 0;
                }

                $netAmount = max($basePrice - $discountAmount, 0);

                /* -----------------------
                TAX CALCULATION
                ----------------------- */
                if ($taxPercent > 0) {

                    if ($taxType === 'inclusive') {
                        $taxAmount = $netAmount - ($netAmount / (1 + $taxPercent / 100));
                        $lineTotal = $netAmount;
                    } else {
                        $taxAmount = ($netAmount * $taxPercent) / 100;
                        $lineTotal = $netAmount + $taxAmount;
                    }

                } else {
                    $taxAmount = 0;
                    $lineTotal = $netAmount;
                }

                /* -----------------------
                SAVE ITEM (IMPORTANT)
                ----------------------- */
                InvoiceItem::create([
                    'invoice_id'    => $invoice->id,
                    'emid'          => $emid,
                    'service_name'  => $serviceName,
                    'quantity'      => $qty,
                    'unit_price'    => $unitPrice,

                    // ✅ STORE RAW VALUE (NOT CALCULATED)
                    'discount'      => $discount,
                    'discount_type' => $discType,

                    'tax_percent'   => $taxPercent,
                    'tax_type'      => $taxType,
                    'sub_total'     => round($lineTotal, 2),
                ]);

                $totalTax   += $taxAmount;
                $grandTotal += $lineTotal;
            }

            /* =========================
            4. UPDATE TOTALS
            ========================== */
            $invoice->update([
                'total_tax'   => round($totalTax, 2),
                'grand_total' => round($grandTotal, 2),
            ]);

            DB::commit();

            return redirect()
                ->route('org.customer.invoice.show', base64_encode($invoice->id))
                ->with('success', 'Invoice updated successfully');

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->with(
                'error',
                'Something went wrong: ' . $e->getMessage()
            );
        }
    }


    // Delete Invoice
    public function destroy($id)
    {
        //dd('okk');
        try {
            $invoiceId = base64_decode($id);

            DB::beginTransaction();

            $invoice = Invoice::with('items')->findOrFail($invoiceId);
            if ($invoice->status === 'Paid') {
                return redirect()->back()->with('error', 'Paid invoice cannot be deleted.');
            }
            $invoice->items()->delete();
            $invoice->delete();
            DB::commit();
            return redirect()
                ->back()
                ->with('success', 'Invoice deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()
                ->back()
                ->with('error', 'Failed to delete invoice');
        }
    }


    // Show Invoice
    public function show($id)
    {
        $emid = Session::get('emid');
        $invoiceId = base64_decode($id);
        $organization = DB::table('registration')
            ->where('reg', $emid)
            ->where('status', 'active')
            ->where('verify', 'approved')
            ->first();
        
        $invoice = Invoice::with(['items', 'guest'])
            ->where('id', $invoiceId)
            ->where('emid', $emid)
            ->firstOrFail();

        // Decide tax label
        $taxLabel = match ($invoice->country) {
            'India'   => 'GST',
            'England' => 'VAT',
            'USA'     => 'Sales Tax',
            default   => 'Tax',
        };    
        //dd($invoice, $taxLabel);
        return view($this->_routePrefix . '.invoice-view', compact('invoice', 'taxLabel', 'organization'));    
        //return view('organization.invoice.show', compact('invoice'));
    }

    public function downloadInvoicePdf($id)
    {
        $email = Session::get("emp_email");
        if(empty($email)){
            redirect('/');
        }
        $emid = Session::get('emid');
        

        $invoice = Invoice::with(['items', 'guest'])
            ->where('id', $id)
            ->where('emid', $emid)
            ->firstOrFail();

        $organization = DB::table('registration')
            ->where('reg', $emid)
            ->where('status', 'active')
            ->where('verify', 'approved')
            ->first();

        $pdf = Pdf::loadView(
            'employeer.guest-bills.customer-invoice.invoice-pdf',
            compact('invoice', 'organization')
        )->setPaper('A4', 'portrait');

        return $pdf->download('Invoice-'.$invoice->id.'.pdf');
    }

    // Send invoice through Email
    public function sendInvoieToMail(Request $request, $id)
    {
        $email = Session::get("emp_email");
        if (empty($email)) {
            return redirect('/');
        }

        $emid = Session::get('emid');

        $invoiceId = base64_decode($id);

        $invoice = Invoice::with(['items', 'guest'])
            ->where('id', $invoiceId)
            ->where('emid', $emid)
            ->firstOrFail();

        $organization = DB::table('registration')
            ->where('reg', $emid)
            ->where('status', 'active')
            ->where('verify', 'approved')
            ->first();

        /* ---------------- PDF ---------------- */
        $pdf = Pdf::loadView(
            'employeer.guest-bills.customer-invoice.invoice-pdf',
            compact('invoice', 'organization')
        );

        /* ---------------- EMAIL TO + CC ---------------- */
        $toEmail = $invoice->guest->email;

        $ccEmails = [];
        if (!empty($request->cc_emails)) {
            $ccEmails = array_map('trim', explode(',', $request->cc_emails));
        }

        /* ---------------- EMAIL DATA FOR TEMPLATE ---------------- */

        $items = $invoice->items->pluck('service_name')->implode(', ');

        $data = [
            'name'          => $invoice->guest->name,
            'invoice_no'      => $invoice->invoice_no,
            'item'            => $items,
            'invoice_date'    => \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y'),
            'amount'          => number_format($invoice->grand_total, 2),
            'total_amount'    => number_format($invoice->grand_total, 2),
            'vat'             => $invoice->total_tax,
            'discount_amount' => $invoice->items->sum('discount'),
            'org_logo'        => $organization->logo,  
            'org_com_name'        => $organization->com_name, 
            'org_email'        => $organization->email, 
            'org_phone'        => $organization->p_no, 
            'org_website'        => $organization->website, 
        ];
        //dd($data);
        /* ---------------- SEND EMAIL ---------------- */

        Mail::send('organization-email-template/invoice-mail', $data, function ($message) use (
            $toEmail,
            $ccEmails,
            $pdf,
            $invoice,
            $organization
        ) {
            $message->to($toEmail)
                ->subject('Invoice ' . $invoice->invoice_no)
                ->from('infoswc@skilledworkerscloud.co.uk', $organization->com_name ?? 'Billing Invoice');

            if (!empty($ccEmails)) {
                $message->cc($ccEmails);
            }

            $message->attachData(
                $pdf->output(),
                'Invoice-' . $invoice->invoice_no . '.pdf',
                ['mime' => 'application/pdf']
            );
        });

        return back()->with('message', 'Invoice email sent successfully.');
    }



}
