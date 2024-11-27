
@extends('employeer.include.app')

@section('title', 'Billing List')
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
				<h3 class="page-title">Billing List</h3>
				<ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
					<!--<li class="breadcrumb-item"><a href="{{url('organization/settings-dashboard')}}">Settings Dashboard</a></li>-->
					<li class="breadcrumb-item active">Billing List</li>
				</ul>
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
                        <i class="fas fa-bank" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Billing List
                    </h4>
                    <div class="row">
                        <div class="col-auto">
                            <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                                @csrf
                                <input type="hidden" name="data" id="data">
                                <input type="hidden" name="headings" id="headings">
                                <input type="hidden" name="filename" id="filename">
                                {{-- put the value - that is your file name --}}
                                <input type="hidden" id="filenameInput" value="billing-list">
                                <button type="submit" class="btn btn-success btn-sm">
                                    <i class="fas fa-file-excel"></i> Export to Excel
                                </button>
                            </form>
                        </div>
                        <div class="col-auto">
                            <form action="{{ route('exportPDF') }}" method="POST" id="exportPDFForm">
                              @csrf
                              <input type="hidden" name="data" id="pdfData">
                              <input type="hidden" name="headings" id="pdfHeadings">
                              <input type="hidden" name="filename" id="pdfFilename">
                              <button type="submit" class="btn btn-info btn-sm">
                                  <i class="fas fa-file-pdf"></i> Export to PDF
                              </button>
                          </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped custom-table" id="basic-datatables">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>Month</th>
                                    <th>Payment Mode</th>
                                    <th>Net Amount</th>
                                    <th>VAT</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Action</th>
                              </tr>
                            </thead>
                            <tbody>  
                                @foreach($bills as $bill)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $bill->billing_month }}</td>
                                        <td>{{ $bill->payment_mode }}</td>
                                        <td>{{ $bill->amount }}</td>
                                        <td>{{ $bill->vat }}</td>
                                        <td>{{ $bill->total_amount }}</td>
                                        <td>{{ $bill->status }}</td>
                                         <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="material-icons">more_vert</i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                        <a class="dropdown-item" href="{{url('billing/edit/'.$bill->id)}}">
                                                            <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                        </a>
                                                </div>
                                            </div>
                                        </td>
                                        
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
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
