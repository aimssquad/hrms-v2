@extends('sub-admin.include.app')
@section('title', 'Invoice')
@section('content')
<style>
   #invoice-content{
   max-width:900px;
   margin:auto;
   font-size:14px;
   }
   table{
   page-break-inside: avoid;
   }
   .row{
   page-break-inside: avoid;
   }
   .card-body{
   padding:20px;
   }
</style>
<div class="content container-fluid pb-0">
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Subscription Invoice</h3>
         </div>
         <div class="col-auto float-end ms-auto">
            <div class="btn-group btn-group-sm">
               {{-- <button class="btn btn-white" id="download-csv">CSV</button> --}}
               <button class="btn btn-white" id="download-pdf">PDF</button>
               <button class="btn btn-white" id="print-invoice"><i class="fa-solid fa-print"></i> Print</button>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div id="invoice-content">
               <div class="card-body">
                  <!-- Company Header -->
                  <div class="row">
                     <div class="col-sm-6">
                        <img src="{{ asset('assets/img/swch_logo.png') }}"
                           style="height:90px">
                     </div>
                     <div class="col-sm-6 text-end">
                        <h3 class="text-uppercase">Skilled Workers Cloud Ltd</h3>
                        <ul class="list-unstyled">
                           <li>Suite 602, 6th Floor, 252-262 Romford Road</li>
                           <li>London, E7 9HZ United Kingdom</li>
                           <li>Mobile: 07467284718</li>
                           <li>Email: info@skilledworkerscloud.co.uk</li>
                           <li>Website: https://skilledworkerscloud.co.uk</li>
                        </ul>
                     </div>
                  </div>
                  <div style="height:12px;background:#1f4b7a;margin-top:10px;"></div>
                  <!-- Bill To -->
                  <div class="row mt-3">
                     <div class="col-sm-7">
                        <h5>Bill To: {{ strtoupper($com_dtl->com_name ?? 'NA') }}</h5>
                        <ul class="list-unstyled">
                           <li><strong>{{ strtoupper($com_dtl->com_name ?? '') }}</strong></li>
                           <li>{{ strtoupper(($com_dtl->f_name ?? '').' '.($com_dtl->l_name ?? '')) }}</li>
                           <li>{{ strtoupper($com_dtl->address ?? '') }}</li>
                           <li>{{ strtoupper($com_dtl->city ?? '') }}</li>
                           <li>{{ strtoupper(($com_dtl->road ?? '').' '.($com_dtl->zip ?? '')) }}</li>
                           <li>{{ strtoupper($com_dtl->p_no ?? '') }}</li>
                           <li>{{ $com_dtl->email ?? '' }}</li>
                        </ul>
                     </div>
                     <div class="col-sm-5 text-end">
                        <span id="invoice-number">Invoice No: {{ $bill->invoice_no }}</span>
                        <ul class="list-unstyled">
                           <li>
                              Bill Date:
                              {{ isset($bill->created_at) ? \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') : 'NA' }}
                           </li>
                        </ul>
                     </div>
                  </div>
                  <!-- Invoice Table -->
                  <div class="table-responsive mt-3">
                     <table class="table table-bordered">
                        <thead>
                           <tr>
                              <th>#</th>
                              <th>Description</th>
                              <th>Quantity</th>
                              <th>Unit Price Excl VAT</th>
                              <th>Unit Price</th>
                              <th>VAT %</th>
                              <th class="text-end">TOTAL</th>
                           </tr>
                        </thead>
                        <tbody>
                           <tr>
                              <td>1</td>
                              <td>{!! $bill->description !!}</td>
                              <td>{{ $bill->total_employee ?? 1 }}</td>
                              <td>{{ number_format($bill->amount,2) }}</td>
                              <td>
                                 @if(!empty($bill->total_employee) && $bill->total_employee > 0)
                                 {{ number_format($bill->amount / $bill->total_employee ,2) }}
                                 @else
                                 {{ number_format($bill->amount,2) }}
                                 @endif
                              </td>
                              <td>{{ $bill->vat ?? 0 }}</td>
                              <td class="text-end">
                                 @php
                                 $vat = $bill->vat ?? 0;
                                 $total = $bill->amount + ($bill->amount * $vat / 100);
                                 @endphp
                                 {{ number_format($total,2) }}
                              </td>
                           </tr>
                        </tbody>
                     </table>
                  </div>
                  <!-- Payment Section -->
                  <div class="row mt-3">
                     <div class="col-sm-7">
                        <table class="table">
                           <tr>
                              <th>Payment Method :</th>
                              <td>{{ $bill->payment_mode ?? 'NA' }}</td>
                           </tr>
                           <tr>
                              <th>Remarks :</th>
                              <td>{!! $bill->remarks ?? 'NA' !!}</td>
                           </tr>
                        </table>
                     </div>
                     <div class="col-sm-5">
                        <table class="table">
                           <tr>
                              <th>Discount</th>
                              <td class="text-end">{{ $bill->discount_amount ?? 0 }}</td>
                           </tr>
                           <tr>
                              <th>Subtotal</th>
                              <td class="text-end">{{ number_format($bill->amount,2) }}</td>
                           </tr>
                           <tr>
                              <th>Total Paid</th>
                              <td class="text-end">
                                 <strong>£{{ number_format($bill->total_amount,2) }}</strong>
                              </td>
                           </tr>
                           <tr>
                              <th>Status</th>
                              <td class="text-end">
                                 {{ $bill->payment_status == 0 ? 'Not Paid' : 'Paid' }}
                              </td>
                           </tr>
                        </table>
                     </div>
                  </div>
                  <!-- Billing Details -->
                  <div class="row mt-3">
                     <div class="col-sm-6">
                        <h5><strong>Billing Details</strong></h5>
                        <p style="margin:0;"><strong>Bank Name:</strong> Barclays Plc</p>
                        <p style="margin:0;"><strong>Account Name:</strong> Skilled Workers Cloud Ltd</p>
                        <p style="margin:0;"><strong>Sort Code:</strong> 20-41-50</p>
                        <p style="margin:0;"><strong>Account No:</strong> 7303 0849</p>
                        {{-- 
                        <p style="margin:0;"><strong>Payment Method:</strong> Online/Offline</p>
                        --}}
                     </div>
                     <div class="col-sm-6 text-end">
                        <h5><strong>Total Paid</strong></h5>
                        <h5>£{{ number_format($bill->total_amount,2) }}</h5>
                     </div>
                  </div>
                  <div class="text-end mt-3">
                     <i>Thank you for your business!</i>
                  </div>
                  <div class="mt-4">
                     <p>
                        <strong>Disclaimer :</strong>
                        This is a system generated Invoice and does not require any signature or Stamp.
                     </p>
                  </div>
                  <div style="height:12px;background:#1f4b7a;margin-top:10px;"></div>
                  <div class="text-center mt-3">
                     <p style="margin:0;">
                        <strong>Registered Office:</strong>
                        Suite 602, 6th Floor, 252-262 Romford Road, London, E7 9HZ United Kingdom
                     </p>
                     <p style="margin:0;">
                        Landline: +44 0208 129 1655
                        Mobile: +44 (0)7467284718
                     </p>
                     <p style="margin:0;">
                        Email: info@skilledworkerscloud.co.uk
                        Web: www.skilledworkerscloud.co.uk
                     </p>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
   document.getElementById('download-pdf').addEventListener('click', function () {
   
   const element = document.getElementById('invoice-content');
   
   const invoiceNumber = document.getElementById('invoice-number')
   .textContent.trim().split(':')[1]?.trim();
   
   const options = {
   
   margin:3,
   
   filename: invoiceNumber ? `${invoiceNumber}.pdf` : 'invoice.pdf',
   
   image:{type:'jpeg',quality:0.98},
   
   html2canvas:{scale:1},
   
   jsPDF:{
   unit:'mm',
   format:'a4',
   orientation:'portrait'
   }
   
   };
   
   html2pdf().set(options).from(element).save();
   
   });

    // Print Invoice
    document.getElementById('print-invoice').addEventListener('click', function(){

        let printContents = document.getElementById('invoice-content').innerHTML;

        let originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;

        location.reload();

    });
   
</script>
@endsection