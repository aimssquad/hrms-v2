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
                    <button class="btn btn-white">CSV</button>
                    <button class="btn btn-white" id="download-pdf">PDF</button>
                    <button class="btn btn-white"><i class="fa-solid fa-print fa-lg"></i> Print</button>
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
                                <ul class="list-unstyled">
                                </ul>
                            </div>
                            <div class="col-sm-6 m-b-20">
                                <div class="invoice-details">
                                    <h3 class="text-uppercase"style="white-space: nowrap;">Skilled Workers Cloud Ltd</h3>
                                    <ul class="list-unstyled" style="text-align: left;">
                                        <li><span>Unit A, 103, Braintree Street London E2 0FT</span></li>
                                        <li>Mobile: <span>07467284718</span></li>
                                        <li>Email: <span>info@skilledworkerscloud.co.uk</span></li>
                                        <li>Website: <span>https://skilledworkerscloud.co.uk</span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div>
                            <hr>
                        </div>
                        <div class="row">
                            <div class="col-sm-6 col-lg-7 col-xl-8 m-b-20">
                                <h5>Bill To: {{ !empty($com_dtl->com_name) ? strtoupper($com_dtl->com_name) : 'NA' }}</h5>
                                <br>
                                <ul class="list-unstyled">
                                    <li><h5><strong>{{ strtoupper($com_dtl->com_name) }}</strong></h5></li>
                                    <li><span>{{ strtoupper($com_dtl->f_name) }} {{ strtoupper($com_dtl->l_name) }}</span></li>
                                    <li>{{strtoupper($com_dtl->address)}}</li>
                                    <li>{{strtoupper($com_dtl->city)}}</li>
                                    <li>{{strtoupper($com_dtl->road)}} {{strtoupper($com_dtl->zip)}}</li>
                                    <li>{{strtoupper($com_dtl->p_no)}}</li>
                                    <li><a href="#">{{$com_dtl->email}}</a></li>
                                </ul>
                            </div>
                            <div class="col-sm-6 col-lg-5 col-xl-4 m-b-20">
                                <span class="text-muted" id="invoice-number">Invoice No: {{$bill->invoice_no}}</span>
                                <ul class="list-unstyled invoice-payment-details">
                                    <li>Bill Date: <span>{{ isset($bill->created_at) ? \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') : 'NA' }}</span></li> 
                                </ul>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th class="d-none d-sm-table-cell">Description</th>
                                        <th>Quantity</th>
                                        <th>Unit Price Excluding VAT</th>
                                        <th>Unit Price</th>
                                        <th>VAT</th>
                                        <th class="text-end">TOTAL</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>1</td>
                                        <td class="d-none d-sm-table-cell">{{$bill->description}}</td>
                                        <td>{{$bill->total_employee}}</td>
                                        <td>{{$bill->amount}}</td>
                                        <td>@php $perEmployee_charge = $bill->amount/$bill->total_employee; echo $perEmployee_charge; @endphp</td>
                                        <td>{{$bill->vat}}</td>
                                        <td class="text-end">
                                            @if($bill->vat == null)
                                                {{$bill->amount}}
                                            @else
                                                {{$bill->total_amount}}
                                            @endif
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
                                                        <th>Payment Method :</th>
                                                        <td class="text-center">{{$bill->payment_mode}}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-5">
                                    <div class="m-b-20">
                                        <div class="table-responsive no-border">
                                            <table class="table mb-0">
                                                <tbody>
                                                    <tr>
                                                        <th>Discount:</th>
                                                        <td></td>
                                                        <td class="text-end">
                                                            {{ $bill->discount_amount ? $bill->discount_amount : 'NA' }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Subtotal:</th>
                                                        <td></td>
                                                        <td class="text-end">
                                                            @if($bill->vat == null && $bill->discount_amount ==null)
                                                            {{$bill->amount}}
                                                            @else
                                                            {{$bill->total_amount}}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <th>Total Paid:</th>
                                                        <td></td>
                                                        <td class="text-end text-primary"><h5>{{$bill->total_amount}}</h5></td>
                                                    </tr>
                                                    <tr>
                                                        <th>Due: <span class="text-regular"></span></th>
                                                        <td></td>
                                                        <td class="text-end"> {{ $bill->payment_status == 0 ? 'Due' : 'Paid' }}</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="invoice-info" style="text-align: center; margin-top: 20px;">
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
