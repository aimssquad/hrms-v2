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
                {{-- <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                    <li class="breadcrumb-item active">Invoice</li>
                </ul> --}}
            </div>
            <div class="col-auto float-end ms-auto">
                <div class="btn-group btn-group-sm">
                    <button class="btn btn-white">CSV</button>
                    <button class="btn btn-white">PDF</button>
                    <button class="btn btn-white"><i class="fa-solid fa-print fa-lg"></i> Print</button>
                </div>
            </div>
        </div>
    </div>    
<!-- /Page Header -->

    <div class="row">
        <div class="col-md-12">
            <div class="card">
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
                                <h3 class="text-uppercase">Skilled Workers Cloud Ltd</h3>
                                <ul class="list-unstyled">
                                    <li><span>Unit A, 103, Braintree Street London E2 0FT</span></li>
                                    {{-- <li>{{strtoupper($com_dtl->city)}} {{strtoupper($com_dtl->road)}} {{strtoupper($com_dtl->zip)}}</li> --}}
                                    {{-- <li>Date: <span>{{ isset($bill->created_at) ? \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') : 'NA' }}</span></li> --}} 
                                    <li>Mobile: <span>07467284718</span></li>
                                    <li>Email: <span>info@skilledworkerscloud.co.uk</span></li>
                                    <li>Website: <span>http://www.skilledworkerscloud.co.uk/</span></li>
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
                            <span class="text-muted">Invoice No: {{$bill->invoice_no}}</span>
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
                                    <th >Quantity</th>
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
                                                {{-- <tr>
                                                    <th>Tax: <span class="text-regular">({{$bill->vat}} %)</span></th>
                                                    <td>{{$bill->vat}}</td>
                                                    <td class="text-end">@php $vat = $bill->total_amount-$bill->amount; echo $vat; @endphp</td>
                                                </tr> --}}
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
                            {{-- <img src="{{ asset('storage/uploads/1730006517_swch_logo (2).png') }}" 
                                alt="Logo" 
                                style="height: 100px; width: auto; display: inline-block;"><span>Copyright 2024 Skilled Workers Cloud Ltd. All Rights Reserved</span> --}}
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

@endsection