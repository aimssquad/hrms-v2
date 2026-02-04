@extends('employeer.include.app')

@section('title', \App\Helpers\Helper::cachedTrans('Customer Invoice List'))
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
@endphp
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
					<li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Customer Invoice List')}}</li>
				</ul>
			</div>
		   
        	<div class="col-auto float-end ms-auto">
				@if($user_type == 'employee')
				@foreach($sidebarItems['Rota'] as $rotaItem)
                    @if($rotaItem['submenu_name'] == 'Notice' && $rotaItem['can_add'] == 1)
				<a href="{{ url('organization/customer/add-invoice') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> {{\App\Helpers\Helper::cachedTrans('Add Customer Invoice')}}</a>
				    @endif
				@endforeach
				@elseif($user_type == 'employer')
				<a href="{{ url('organization/customer/add-invoice') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> {{\App\Helpers\Helper::cachedTrans('Add Customer Invoice')}}</a>
				@endif
			</div>
        </div>    
	</div>
	<!-- /Page Header -->
    @include('employeer.layout.message')
	<div class="row">
		<div class="col-md-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;{{\App\Helpers\Helper::cachedTrans('Customer Invoice List')}}
                    </h4>
                    <div class="row">
                       <div class="col-auto">
                           <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                               @csrf
                               <input type="hidden" name="data" id="data">
                               <input type="hidden" name="headings" id="headings">
                               <input type="hidden" name="filename" id="filename">
                               {{-- put the value - that is your file name --}}
                               <input type="hidden" id="filenameInput" value="invoice-list">
                               <button type="submit" class="btn-download btn-download-excel me-0">
                                        {{\App\Helpers\Helper::cachedTrans('Export to Excel')}}
                                </button>
                           </form>
                       </div>
                       <div class="col-auto">
                           <form action="{{ route('exportPDF') }}" method="POST" id="exportPDFForm">
                             @csrf
                             <input type="hidden" name="data" id="pdfData">
                             <input type="hidden" name="headings" id="pdfHeadings">
                             <input type="hidden" name="filename" id="pdfFilename">
                             <button type="submit" class="btn-download btn-download-pdf">
                                {{\App\Helpers\Helper::cachedTrans('Export to PDF')}}
                           </button>
                         </form>
                       </div>
                   </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                    <table id="basic-datatables" class="display table table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Sl No.</th>
                                <th>Invoice No</th>
                                <th>Customer</th>
                                <th>Country</th>
                                <th>Currency</th>
                                <th>Invoice Date</th>
                                <th>Total Tax</th>
                                <th>Grand Total</th>
                                <th>Status</th>
                                <th class="text-end">Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($invoices as $key => $invoice)
                                <tr>
                                    <td>{{ $key + 1 }}</td>

                                    <td>
                                        {{$invoice->invoice_no }}
                                    </td>

                                    <td>
                                        {{ $invoice->guest->name ?? 'N/A' }} <br>
                                        <small class="text-muted">
                                            {{ $invoice->guest->company_name ?? '' }}
                                        </small>
                                    </td>

                                    <td>{{ $invoice->country }}</td>
                                    <td>{{ $invoice->currency }}</td>

                                    <td>{{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d M Y') }}</td>

                                    <td>
                                        {{ number_format($invoice->total_tax, 2) }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ number_format($invoice->grand_total, 2) }}
                                        </strong>
                                    </td>

                                    <td>
                                        @php
                                            $statusColors = [
                                                'Generated' => 'bg-info',
                                                'Pending'   => 'bg-warning',
                                                'Paid'      => 'bg-success',
                                                'Cancel'    => 'bg-danger',
                                            ];
                                        @endphp

                                        <span class="badge {{ $statusColors[$invoice->status] ?? 'bg-secondary' }}">
                                            {{ $invoice->status }}
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown">
                                                <i class="material-icons">more_vert</i>
                                            </a>

                                            <div class="dropdown-menu dropdown-menu-right">

                                                <a class="dropdown-item"
                                                href="{{ route('org.customer.invoice.show', base64_encode($invoice->id)) }}">
                                                    <i class="fa fa-eye m-r-5"></i> View
                                                </a>

                                                <a href="{{ route('org.invoice.pdf', $invoice->id) }}"
                                                    class="dropdown-item">
                                                    <i class="fa fa-download"></i> Download PDF
                                                </a>

                                                {{-- <form action="{{ route('org.customer.invoice.send.email', base64_encode($invoice->id)) }}"
                                                    method="POST">
                                                    @csrf
                                                    <button type="submit" class="dropdown-item">
                                                        <i class="fa fa-envelope"></i> Send Email
                                                    </button>
                                                </form> --}}

                                                <a href="javascript:void(0)"
                                                class="dropdown-item send-invoice-btn"
                                                data-id="{{ base64_encode($invoice->id) }}"
                                                data-email="{{ $invoice->guest->email }}"
                                                data-name="{{ $invoice->guest->name }}"
                                                data-company="{{ $invoice->guest->company_name }}"
                                                data-bs-toggle="modal"
                                                data-bs-target="#sendInvoiceModal">
                                                    <i class="fa fa-envelope"></i> Send Email
                                                </a>





                                                
                                                @if($invoice->status !== 'Paid')

                                                    <a class="dropdown-item"
                                                    href="{{ route('org.customer.invoice.edit', base64_encode($invoice->id)) }}">
                                                        <i class="fa fa-pencil m-r-5"></i> Edit
                                                    </a>
                                                    <form action="{{ route('org.customer.invoice.delete', base64_encode($invoice->id)) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Delete this invoice?');">
                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="dropdown-item">
                                                            <i class="fa fa-trash m-r-5"></i> Delete
                                                        </button>
                                                    </form>
                                                @endif

                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div class="modal fade" id="sendInvoiceModal" tabindex="-1">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">

                                <form id="sendInvoiceForm" method="POST">
                                    @csrf

                                    <div class="modal-header">
                                        <h5 class="modal-title">Send Invoice To Email</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>

                                    <div class="modal-body">

                                        <div class="mb-3">
                                            <label class="form-label">Customer Name</label>
                                            <input type="text" id="customerName" class="form-control" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Company Name</label>
                                            <input type="text" id="companyName" class="form-control" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">To</label>
                                            <input type="text" id="toEmail" class="form-control" readonly>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">
                                                CC Emails <small class="text-muted">(optional)</small>
                                            </label>
                                            <input type="text"
                                                name="cc_emails"
                                                class="form-control"
                                                placeholder="accounts@company.com, manager@company.com">
                                        </div>

                                        <small class="text-muted">
                                            Use comma ( , ) to add multiple CC emails
                                        </small>

                                    </div>


                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fa fa-paper-plane"></i> Send Invoice
                                        </button>
                                    </div>

                                </form>

                            </div>
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
<script>
    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this holiday type?")) {
            window.location.href = url;
        }
    }
</script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.send-invoice-btn').forEach(btn => {

        btn.addEventListener('click', function () {

            let invoiceId = this.dataset.id;
            let email     = this.dataset.email;
            let name      = this.dataset.name;
            let company   = this.dataset.company;

            document.getElementById('customerName').value = name ?? '';
            document.getElementById('companyName').value  = company ?? '';
            document.getElementById('toEmail').value      = email ?? '';

            document.getElementById('sendInvoiceForm').action =
                "{{ url('organization/customer/send-email') }}/" + invoiceId;
        });
    });

});
</script>

@endsection


