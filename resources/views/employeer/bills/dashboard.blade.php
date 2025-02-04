
@extends('employeer.include.app')

@section('title', 'Invoice List')
@php 
//dd($bill->total_amount);
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
@endphp
@section('content')
    <div class="content container-fluid pb-0">
        <!-- Page Header -->
        <div class="page-header">
            <div class="row align-items-center">
                <div class="col">
                    <h3 class="page-title">Billing Dashboard</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('organization/employerdashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">Billing Dashboard</li>
                    </ul>
                </div>
            </div>
        </div>
    
        <!-- Modules Section -->
        <div class="row">
            <div class="col-xl-4 col-md-6 col-sm-12">
                <a href="{{ url('organization/billing-show') }}" class="modern-card-link">
                    <div class="modern-card">
                        <div class="modern-card-header">
                            <div class="modern_icon_wrapper">
                                <i class="la la-dashboard modern-icon"></i>
                            </div>
                            <h4 class="modern-card-title">Invoice</h4>
                        </div>
                        <div class="modern-card-body">
                            <div class="modern-status">
                                </div>
                                <div class="modern-arrow">
                                <span class="employee-count">{{ $invoice_count }}</span>
                                <i class="fa fa-arrow-circle-right"></i>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-md-8">
                <div class="card-group m-b-30">                
                    <div class="card" style="border-right: 5px solid rgb(211, 207, 207);">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Due Payment </span>
                                </div>
                                <div>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <h3 class="mb-3">Last Month <i class="fa fa-pound-sign"></i> {{ $last_invoice }}</h3>
                            <div class="progress height-five mb-2">
                                <div class="progress-bar bg-primary w-70" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted"><i class="fa fa-pound-sign"></i> {{ $previous_invoice }}</span></p>
                        </div>
                    </div>
                    
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Paid Amount</span>
                                </div>
                                <div>
                                    <span class="text-danger"></span>
                                </div>
                            </div>
                            <h3 class="mb-3">Total <i class="fa fa-pound-sign"></i> {{ $paid_amount }}</h3>
                            <div class="progress height-five mb-2">
                                <div class="progress-bar bg-primary w-70" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted"><i class="fa fa-pound-sign"></i> {{ $last_paid_amount }}</span></p>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
        {{-- <div class="row">
            <div class="col-md-12">
                <div class="card-group m-b-30">                
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Due Payment</span>
                                </div>
                                <div>
                                    <span class="text-danger">-2.8%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">$8,500</h3>
                            <div class="progress height-five mb-2">
                                <div class="progress-bar bg-primary w-70" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$7,500</span></p>
                        </div>
                    </div>
                
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between mb-3">
                                <div>
                                    <span class="d-block">Paid Amount</span>
                                </div>
                                <div>
                                    <span class="text-danger">-75%</span>
                                </div>
                            </div>
                            <h3 class="mb-3">$1,12,000</h3>
                            <div class="progress height-five mb-2">
                                <div class="progress-bar bg-primary w-70" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <p class="mb-0">Previous Month <span class="text-muted">$1,42,000</span></p>
                        </div>
                    </div>
                </div>
            </div>	
        </div>
        <div class="row">
            <div class="col-md-6 d-flex">
                <div class="card card-table flex-fill">
                    <div class="card-header">
                        <h3 class="card-title mb-0">Invoices</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-nowrap custom-table mb-0">
                                <thead>
                                    <tr>
                                        <th>Invoice ID</th>
                                        <th>Client</th>
                                        <th>Due Date</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><a href="invoice-view.html">#INV-0001</a></td>
                                        <td>
                                            <h2><a href="#">Global Technologies</a></h2>
                                        </td>
                                        <td>11 Mar 2019</td>
                                        <td>$380</td>
                                        <td>
                                            <span class="badge bg-inverse-warning">Partially Paid</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="invoice-view.html">#INV-0002</a></td>
                                        <td>
                                            <h2><a href="#">Delta Infotech</a></h2>
                                        </td>
                                        <td>8 Feb 2019</td>
                                        <td>$500</td>
                                        <td>
                                            <span class="badge bg-inverse-success">Paid</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td><a href="invoice-view.html">#INV-0003</a></td>
                                        <td>
                                            <h2><a href="#">Cream Inc</a></h2>
                                        </td>
                                        <td>23 Jan 2019</td>
                                        <td>$60</td>
                                        <td>
                                            <span class="badge bg-inverse-danger">Unpaid</span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <a href="{{url('organization/billing-show')}}">View all invoices</a>
                    </div>
                </div>
            </div>
         
        </div> --}}
    </div>
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
