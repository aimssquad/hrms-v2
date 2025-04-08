@extends('sub-admin.include.app')
@section('title', 'Invoice')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
    <div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Invoice</h3>
            </div>
            <div class="col-auto float-end ms-auto">
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-white" id="download-pdf">Download PDF</button>   
                </div>
            </div>
        </div>
    </div>    
<!-- /Page Header -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div id="invoice-content">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-6 m-b-20">
                                {{-- <img src="{{ asset('storage/' . $org_dtl->logo) }}" class="inv-logo" alt="Logo"> --}}
                                {{-- <img src="{{ $org_dtl->logo ? asset('storage/' . $org_dtl->logo) : asset('path/to/default-logo.png') }}" class="inv-logo" alt="Logo"> --}}
                                <ul class="list-unstyled">
                                    {{-- <li>{{ strtoupper($com_dtl->com_name) }}</li>
                                    <li>{{strtoupper($com_dtl->address2)}}</li> --}}
                                    
                                    {{-- <li>GST No:</li> --}}
                                </ul>
                            </div>
                            <div class="col-sm-6 m-b-20">
                                <div class="invoice-details">
                                    <h3 class="text-uppercase" style="white-space: nowrap; text-align: left;">{{ strtoupper($com_dtl->com_name) }}</h3>
                                    <ul class="list-unstyled" style="text-align: left;">
                                        <li><span>{{strtoupper($com_dtl->address)}}</span></li>
                                        <li>{{strtoupper("$com_dtl->city $com_dtl->road $com_dtl->zip")}} </li>
                                        {{-- <li>Date: <span>{{ isset($bill->created_at) ? \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') : 'NA' }}</span></li> --}} 
                                        <li>Mobile: <span>{{strtoupper($com_dtl->p_no)}}</span></li>
                                        <li>Landline: <span>{{strtoupper($com_dtl->land)}}</span></li>
                                        <li>Email: <span>{{strtoupper($com_dtl->email)}}</span></li>
                                        <li>Website: <span>{{strtoupper($com_dtl->website)}}</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div>
                            {{-- <hr> --}}
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-lg-7 col-xl-8 m-b-20">
                                <h5>Invoice To: {{ !empty($org_dtl->com_name) ? strtoupper($org_dtl->com_name) : 'NA' }}</h5>
                                <br>
                                <ul class="list-unstyled">
                                    <li><span>{{ strtoupper($org_dtl->f_name) }} {{ strtoupper($org_dtl->l_name) }}</span></li>
                                    <li>{{strtoupper($org_dtl->address)}}</li>
                                    <li>{{strtoupper($org_dtl->city)}}</li>
                                    <li>{{strtoupper($org_dtl->road)}} {{strtoupper($org_dtl->zip)}}</li>
                                    <li>{{strtoupper($org_dtl->p_no)}}</li>
                                    <li><a href="#">{{$org_dtl->email}}</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-6 col-lg-5 col-xl-4 m-b-20">
                                <ul class="list-unstyled invoice-payment-details">
                                    <li>Date: <span>{{ isset($bill->created_at) ? \Carbon\Carbon::parse($bill->date)->format('d/m/Y') : 'NA' }}</span></li> 
                                </ul>
                                <span class="text-muted" id="invoice-number">Invoice No: {{$bill->invoice_no}}</span>
                               
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="d-none d-sm-table-cell">Item Name</th>
                                        <th >Quantity</th>
                                        <th>Unit Price</th>
                                        <th>Unit Price Exc.VAT</th>
                                        <th>Discount</th>
                                        <th class="text-end">Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td class="d-none d-sm-table-cell">{{$bill->bill_for}}</td>
                                        <td >1</td>
                                        <td></td>
                                        <td>{{$bill->amount}}</td>
                                        <td> {{$bill->discount_amount ?? '0.00'}} </td>
                                        <td class="text-end">
                                            @php
                                                $subtotal = $bill->discount_amount ? ($bill->amount - $bill->discount_amount) : $bill->amount;
                                                echo number_format($subtotal, 2);
                                            @endphp
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div>
                            <div class="row invoice-payment">
                                <div class="col-sm-7">
                                    <div class="m-b-20">
                                        <div class="table-responsive no-border">
                                            <table class="table mb-0">
                                                <tbody>
                                                    <tr>
                                                        {{-- <th>Payment Method :</th>
                                                        <td class="text-center">{{$bill->payment_mode}}</td> --}}
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                @php
                                    $vat_amount = $bill->vat ? ($subtotal * $bill->vat / 100) : 0;
                                    $grand_total = $bill->total_amount;
                                @endphp
                                <div class="col-sm-5">
                                    <div class="m-b-20">
                                        <div class="table-responsive no-border">
                                            <table class="table mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th>Vat({{$bill->vat ?? '0.00'}} %):</th>
                                                        <td></td>
                                                        {{-- <td class="text-end">{{ !empty($bill->discount_amount) ? $bill->discount_amount : 'NA' }}</td> --}}
                                                        <td class="text-end">
                                                            {{ number_format($vat_amount, 2) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Subtotal:</th>
                                                        <td></td>
                                                        <td class="text-end">{{ number_format($subtotal, 2) }}</td>
                                                    </tr>
                                                    {{-- <tr>
                                                        <th>Tax: <span class="text-regular">({{$bill->vat}} %)</span></th>
                                                        <td>{{$bill->vat}}</td>
                                                        <td class="text-end">@php $vat = $bill->total_amount-$bill->amount; echo $vat; @endphp</td>
                                                    </tr> --}}
                                                    <tr>
                                                        <th>Total Paid:</th>
                                                        <td></td>
                                                        @if(empty($bill->vat) && empty($bill->discount_amount))
                                                            <td class="text-end text-primary"><h5>{{ number_format($bill->amount, 2) }}</h5></td>
                                                        @else
                                                            <td class="text-end text-primary"><h5>{{$bill->total_amount}}</h5></td>
                                                        @endif
                                                        
                                                    </tr>
                                                    {{-- <tr>
                                                        <th>Due: <span class="text-regular"></span></th>
                                                        <td></td>
                                                        <td class="text-end"> {{ $bill->payment_status == 0 ? 'Due' : 'Paid' }}</td>
                                                    </tr> --}}
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row invoice-payment">
                                <div class="col-sm-12">
                                    <div class="m-b-20">
                                        <div class="table-responsive no-border">
                                            <table class="table mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th style="border:0;padding-bottom: 0px;">Payment Method : {{$bill->payment_mode}}</th>
                                                        {{-- <td class="text-center">{{$bill->payment_mode}}</td> --}}
                                                    </tr>
                                                    <tr>
                                                        <th style="border:0;padding-top: 0px;">Disclaimer : <i>This is a system generated Invoice and does not
                                                            require any signature or Stamp.
                                                            </i></th>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="7" style="border:0; height: 45px;"></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="7" style=" border:0; height: 45px;" class="text-end">Thank you for your customs !</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>    
                            <div class="invoice-info" style="text-align: center; margin-top: 20px;">
                            <span>Website: <a href="{{strtoupper($com_dtl->website)}}">{{$com_dtl->website ?? ''}}</a></span>
                            </div>
                        </div>
                    </div>
                </div>    
            </div>
        </div>
    </div>
</div>
<!-- /Page Content -->
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
<script>
    document.getElementById('download-pdf').addEventListener('click', function () {
        // Select the content to convert
        const invoiceContent = document.getElementById('invoice-content');

        // Retrieve the invoice number dynamically from the element with id 'invoice-number'
        const invoiceNumber = document.getElementById('invoice-number').textContent.trim().split(':')[1]?.trim();

        // Configuration options for html2pdf
        const options = {
            margin: 10,
            filename: invoiceNumber ? `${invoiceNumber}.pdf` : 'invoice.pdf', // Use invoice number if available
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2 },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
        };

        // Generate and download the PDF
        html2pdf().set(options).from(invoiceContent).save();
    });
</script>
@endsection