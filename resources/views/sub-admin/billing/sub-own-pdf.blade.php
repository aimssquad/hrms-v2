@extends('sub-admin.include.app')
@section('title', 'Invoice')

@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <!-- Header Section -->
                    <div class="row">
                        <div class="col-sm-6 m-b-20">
                            <!-- Add company logo dynamically if available -->
                            {{-- <img src="{{ $org_dtl->logo ? asset('storage/' . $org_dtl->logo) : asset('path/to/default-logo.png') }}" class="inv-logo" alt="Logo"> --}}
                            <ul class="list-unstyled">
                                {{-- Example placeholders for company details --}}
                                {{-- <li>{{ strtoupper($com_dtl->com_name) }}</li> --}}
                                {{-- <li>{{ strtoupper($com_dtl->address2) }}</li> --}}
                            </ul>
                        </div>
                        <div class="col-sm-6 m-b-20">
                            <div class="invoice-details">
                                <h3 class="text-uppercase">Skilled Workers Cloud Ltd</h3>
                                <ul class="list-unstyled">
                                    <li><span>Unit A, 103, Braintree Street, London E2 0FT</span></li>
                                    <li>Mobile: <span>07467284718</span></li>
                                    <li>Email: <span>info@skilledworkerscloud.co.uk</span></li>
                                    <li>Website: <span>http://www.skilledworkerscloud.co.uk/</span></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <hr>

                    <!-- Billing Information -->
                    <div class="row">
                        <div class="col-sm-6 col-lg-7 col-xl-8 m-b-20">
                            <h5>Bill To: {{ $com_dtl->com_name ? strtoupper($com_dtl->com_name) : 'NA' }}</h5>
                            <ul class="list-unstyled">
                                <li><strong>{{ strtoupper($com_dtl->com_name ?? 'N/A') }}</strong></li>
                                <li>{{ strtoupper($com_dtl->f_name . ' ' . $com_dtl->l_name ?? 'N/A') }}</li>
                                <li>{{ strtoupper($com_dtl->address ?? 'N/A') }}</li>
                                <li>{{ strtoupper($com_dtl->city ?? 'N/A') }}</li>
                                <li>{{ strtoupper(($com_dtl->road ?? '') . ' ' . ($com_dtl->zip ?? '')) }}</li>
                                <li>{{ strtoupper($com_dtl->p_no ?? 'N/A') }}</li>
                                <li><a href="mailto:{{ $com_dtl->email }}">{{ $com_dtl->email }}</a></li>
                            </ul>
                        </div>
                        <div class="col-sm-6 col-lg-5 col-xl-4 m-b-20">
                            <ul class="list-unstyled invoice-payment-details">
                                <li>Invoice No: <span>{{ $bill->invoice_no }}</span></li>
                                <li>Bill Date: <span>{{ \Carbon\Carbon::parse($bill->created_at)->format('d/m/Y') }}</span></li>
                            </ul>
                        </div>
                    </div>

                    <!-- Invoice Table -->
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
                                    <th class="text-end">Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td class="d-none d-sm-table-cell">{{ $bill->description }}</td>
                                    <td>{{ $bill->total_employee }}</td>
                                    <td>{{ number_format($bill->amount, 2) }}</td>
                                    <td>{{ number_format($bill->amount / $bill->total_employee, 2) }}</td>
                                    <td>{{ number_format($bill->vat, 2) }}</td>
                                    <td class="text-end">{{ number_format($bill->total_amount, 2) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Payment and Summary -->
                    <div class="row invoice-payment">
                        <div class="col-sm-7">
                            <div class="m-b-20">
                                <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <th>Payment Method:</th>
                                            <td class="text-center">{{ $bill->payment_mode ?? 'N/A' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="col-sm-5">
                            <div class="m-b-20">
                                <table class="table mb-0">
                                    <tbody>
                                        <tr>
                                            <th>Discount:</th>
                                            <td class="text-end">{{ $bill->discount_amount ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <th>Subtotal:</th>
                                            <td class="text-end">
                                                {{ $bill->vat ? $bill->total_amount : $bill->amount }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Total Paid:</th>
                                            <td class="text-end text-primary">
                                                <h5>{{ number_format($bill->total_amount, 2) }}</h5>
                                            </td>
                                        </tr>
                                        <tr>
                                            <th>Due:</th>
                                            <td class="text-end">
                                                {{ $bill->payment_status == 0 ? 'Due' : 'Paid' }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Section -->
                    <div class="invoice-info text-center mt-4">
                        <span>Copyright 2024 Skilled Workers Cloud Ltd. All Rights Reserved</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- /Page Content -->
@endsection

@section('script')
<!-- Add custom scripts here if needed -->
@endsection
