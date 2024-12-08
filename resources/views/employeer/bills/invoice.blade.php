
@extends('employeer.include.app')

@section('title', 'Invoice List')
@php 
//dd($bill->total_amount);
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
@endphp
@section('content')


<!-- Page Content -->
<div class="content container-fluid pb-0">
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
                            @if($bill->org_code == null)
                                <img src="{{ asset('storage/' . $org_dtl->logo) }}" class="inv-logo"  alt="Logo" 
                                style="width: 470px; height: 50px;">
                            @else
                                <img src="{{ asset('storage/' . $com_dtl->logo) }}" class="inv-logo"  alt="User Image" 
                                style="width: 70px; height: 50px;">
                            @endif
                            <ul class="list-unstyled">
                                {{-- <li>{{ strtoupper($com_dtl->com_name) }}</li>
                                <li>{{strtoupper($com_dtl->address2)}}</li> --}}
                                
                                {{-- <li>GST No:</li> --}}
                            </ul>
                        </div>
                        <div class="col-sm-6 m-b-20">
                            <div class="invoice-details">
                                @if($bill->org_code == null)
                                    <h3 class="text-uppercase">Skilled Workers Cloud Ltd</h3>
                                    <ul class="list-unstyled">
                                        <li><span>Unit A, 103, Braintree Street London E2 0FT</span></li>
                                        <li>{{strtoupper($com_dtl->city)}} {{strtoupper($com_dtl->road)}} {{strtoupper($com_dtl->zip)}}</li>
                                        {{-- <li>Date: <span>{{ isset($bill->created_at) ? \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') : 'NA' }}</span></li> --}} 
                                        <li>Mobile: <span>07467284718</span></li>
                                        <li>Email: <span>info@skilledworkerscloud.co.uk</span></li>
                                        <li>Website: <span>http://www.skilledworkerscloud.co.uk/</span></li>
                                    </ul>
                                @else 
                                    <h3 class="text-uppercase">{{ strtoupper($com_dtl->com_name) }}</h3>
                                    <ul class="list-unstyled">
                                        <li><span>{{strtoupper($com_dtl->address2)}} </span></li>
                                        <li>{{strtoupper($com_dtl->city)}} {{strtoupper($com_dtl->road)}} {{strtoupper($com_dtl->zip)}}</li>
                                        {{-- <li>Date: <span>{{ isset($bill->created_at) ? \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') : 'NA' }}</span></li> --}} 
                                        <li>Mobile: <span>{{strtoupper($com_dtl->p_no)}}</span></li>
                                        <li>Email: <span>{{strtoupper($com_dtl->email)}}</span></li>
                                        <li>Website: <span>April 25, 2019</span></li>
                                    </ul>
                                @endif
                                
                            </div>
                        </div>
                    </div>
                    <div>
                        <hr>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-lg-7 col-xl-8 m-b-20">
                            <h5>Bill To: {{ strtoupper($org_dtl->com_name) }}</h5>
                            <br>
                            <ul class="list-unstyled">
                                {{-- <li><h5><strong>{{ strtoupper($org_dtl->com_name) }}</strong></h5></li> --}}
                                <li><span>{{ strtoupper($org_dtl->f_name) }} {{ strtoupper($org_dtl->l_name) }}</span></li>
                                <li>{{strtoupper($org_dtl->address)}}</li>
                                <li>{{strtoupper($org_dtl->city)}}</li>
                                <li>{{strtoupper($org_dtl->road)}} {{strtoupper($org_dtl->zip)}}</li>
                                <li>{{strtoupper($org_dtl->p_no)}}</li>
                                <li><a href="#">{{$org_dtl->email}}</a></li>
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
                                    <th>VAT (%)</th>
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
                                    <td>{{ !empty($bill->vat) ? $bill->vat : 'NA' }}</td>
                                    <td class="text-end">
                                        @if($bill->vat !== null) 
                                        {{-- {{$bill->total_amount}} --}}
                                            @php
                                                $total = $bill->amount*$bill->vat/100;
                                                echo $total+$bill->amount;
                                            @endphp
                                        @else 
                                            {{$bill->amount}}
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
                                                    <td class="text-end text-primary"><h5>{{ !empty($bill->discount_amount) ? $bill->discount_amount : 'NA' }}</h5></td>
                                                </tr>
                                                <tr>
                                                    <th>Subtotal:</th>
                                                    <td></td>
                                                    <td class="text-end">
                                                        @if($bill->total_amount==0)
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
<script>
    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this holiday type?")) {
            window.location.href = url;
        }
    }
</script>

@endsection
