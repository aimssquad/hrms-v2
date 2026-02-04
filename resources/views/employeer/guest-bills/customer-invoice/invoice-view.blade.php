@extends('employeer.include.app')

@section('title', \App\Helpers\Helper::cachedTrans('Customer Invoice List'))
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
@endphp

@section('css')
<style>
    .invoice-wrapper {
        background: #fff;
        padding: 30px;
        font-size: 13px;
        color: #000;
    }
    .invoice-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
    }
    .invoice-company {
        text-align: right;
        font-size: 13px;
    }
    .invoice-divider {
        border-top: 2px solid #e5e5e5;
        margin: 15px 0;
    }
    .invoice-info {
        display: flex;
        justify-content: space-between;
        margin-bottom: 20px;
    }
    .invoice-table th {
        font-weight: 600;
        font-size: 13px;
        border-bottom: 2px solid #000;
    }
    .invoice-table td {
        border-bottom: 1px solid #ddd;
    }
    .invoice-summary {
        width: 300px;
        margin-left: auto;
        margin-top: 10px;
    }
    .invoice-summary td {
        padding: 5px 0;
    }
    .grand-total {
        font-size: 15px;
        font-weight: bold;
    }
</style>

@endsection
@section('content')


<!-- Page Content -->
<div class="content container-fluid pb-0">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Customer Invoice')}}</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="#">{{\App\Helpers\Helper::cachedTrans('Dashboard')}} </a></li>
					<li class="breadcrumb-item active"><a href="{{url('organization/customer/invoice')}}">{{\App\Helpers\Helper::cachedTrans('Customer Invoice List')}}</a></li>
                    <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Customer Invoice')}}</li>
				</ul>
			</div>

        </div>    
	</div>
	<!-- /Page Header -->
    @include('employeer.layout.message')
	<div class="row">
		<div class="col-md-12">
            <div class="card custom-card">
                @php
                    $guest = $invoice->guest;
                    $taxLabel = 'GST'; // India
                    $subTotal = 0;
                    $totalTax = 0;
    
                    $currencySymbol = match ($invoice->country) {
                        'India'   => '₹',
                        'England' => '£',
                        'USA'     => '$',
                        default   => ''
                    };

                @endphp

                <div class="invoice-wrapper">

                    <!-- HEADER -->
                    <div class="invoice-header">
                        <img src="{{asset('storage/' . $organization->logo)}}" height="70" style="width: 250px; height: 80px;">
                        <div class="invoice-company">
                            <strong>{{$organization->com_name}}</strong><br>
                            {{$organization->address}}
                            {{-- G21, Unit 3, Triangle Centre<br>
                            399 Uxbridge Road, UB1 3EJ<br> --}}
                            <br>
                            Email: {{$organization->email}}
                             <br>
                            Phone: {{$organization->p_no}}
                             <br>
                            Website: {{$organization->website}}
                        </div>
                    </div>

                    <div class="invoice-divider"></div>

                    <!-- INFO -->
                    <div class="invoice-info">
                        <div>
                            <strong>Invoice To:</strong><br>
                            {{ $guest->name }}<br>
                            {{ $guest->company_name }}<br>
                            {{ $guest->address }}<br>
                            Phone: {{ $guest->phone }}
                            <br>
                            Email: {{ $guest->email }}
                            <br>
                            @if($invoice->country == "India")
                                 GST NO: {{ $guest->tax_no }}
                                @elseif($invoice->country == "England")
                                     VAT NO: {{ $guest->tax_no }}
                                @else
                                     SALE-TAX: {{ $guest->tax_no }}
                                @endif
                           
                        </div>

                        <div style="text-align:right;">
                            <strong>Invoice Date:</strong>
                            {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}<br>
                            <strong>Invoice No:</strong> {{ $invoice->invoice_no }}<br>
                            <strong>Currency:</strong> {{ $invoice->currency }}
                        </div>
                    </div>

                    <!-- ITEMS -->
                    <table class="table invoice-table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Service</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Unit Price</th>
                                <th class="text-end">Discount</th>
                                @if($invoice->country == "India")
                                <th class="text-center">GST %</th>
                                @elseif($invoice->country == "England")
                                    <th class="text-center">VAT %</th>
                                @else
                                    <th class="text-center">SALE-TAX %</th>
                                @endif

                                <th class="text-center">Taxable Price</th>
                                <th class="text-end">Line Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $subTotal = 0;
                                $totalTax = 0;
                            @endphp

                            @foreach($invoice->items as $key => $item)

                                @php
                                    // 1️⃣ BASE PRICE
                                    $basePrice = $item->quantity * $item->unit_price;

                                    // 2️⃣ DISCOUNT
                                    if ($item->discount_type === 'percentage_discount') {
                                        $discountAmount = ($basePrice * $item->discount) / 100;
                                    } else {
                                        $discountAmount = $item->discount;
                                    }

                                    $netAmount = $basePrice - $discountAmount;
                                    if ($netAmount < 0) $netAmount = 0;

                                    // 3️⃣ TAX
                                    if ($item->tax_type === 'inclusive') {
                                        $taxAmount  = $netAmount - ($netAmount / (1 + $item->tax_percent / 100));
                                        $lineTotal  = $netAmount;
                                        $baseAmount = $netAmount - $taxAmount;
                                    } else {
                                        $taxAmount  = ($netAmount * $item->tax_percent) / 100;
                                        $baseAmount = $netAmount;
                                        $lineTotal  = $netAmount + $taxAmount;
                                    }

                                    $subTotal += $baseAmount;
                                    $totalTax += $taxAmount;
                                @endphp

                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->service_name }}</td>
                                    <td class="text-center">{{ $item->quantity }}</td>

                                    <td class="text-end">
                                       {{$currencySymbol}} {{ number_format($item->unit_price, 2) }}
                                    </td>

                                    <!-- SHOW STORED DISCOUNT -->
                                    <td class="text-end">
                                       {{$currencySymbol}} {{ number_format($item->discount, 2) }}<br>
                                        <small>({{ str_replace('_',' ', $item->discount_type) }})</small>
                                    </td>

                                    <td class="text-center">
                                        {{ $item->tax_percent }}%
                                        <br>
                                        <small>({{ ucfirst($item->tax_type) }})</small>
                                    </td>

                                     <td class="text-end">
                                        {{$currencySymbol}} {{ number_format($taxAmount, 2) }}
                                    </td>
                                    <!-- FINAL LINE TOTAL -->
                                    <td class="text-end">
                                        {{$currencySymbol}} {{ number_format($baseAmount, 2) }}
                                    </td>
                                </tr>

                            @endforeach
                        </tbody>

                    </table>

                    <!-- SUMMARY -->
                    <table class="invoice-summary">
                        <tr>
                            <td>Sub Total</td>
                            <td class="text-end">{{$currencySymbol}} {{ number_format($subTotal,2) }}</td>
                        </tr>
                        <tr>
                            <td>GST Total</td>
                            <td class="text-end">{{$currencySymbol}} {{ number_format($invoice->total_tax,2) }}</td>
                        </tr>
                        <tr class="grand-total">
                            <td>Grand Total</td>
                            <td class="text-end">{{$currencySymbol}} {{ number_format($invoice->grand_total,2) }}</td>
                        </tr>
                    </table>

                    <div class="text-center mt-4" style="font-size:11px; margin-top:75px;">
                        <strong>Disclaimer:</strong> This is a system generated invoice and does not require signature.
                    </div>

                </div>

                
            </div>
		</div>
	</div>
</div>
<!-- /Page Content -->


@endsection
