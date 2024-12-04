
@extends('employeer.include.app')

@section('title', 'Invoice List')
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
				<h3 class="page-title">Invoice List</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="#">Billing Dashboard</a></li>
					<li class="breadcrumb-item active">Invoice List</li>
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
                        <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Invoice List
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
                        <table id="basic-datatables" class="display table table-striped table-hover" >
                            <thead>
                               <tr>
                                  <th>Sl.No.</th>
                                  <th>Invoice.No.</th>
                                  <th>Invoice For</th>
                                  
                                  {{-- <th>Billing Type</th> --}}
                                  <th>Company Name</th>
                                  <th>Amount</th>
                                  <th>Total Employee</th>
                                  <th>Vat(%)</th>
                                  <th>Discount Amount</th>
                                  <th>Total Amount</th>
                                  <th>Payment Mode</th>
                                  <th>Description</th>
                                  <th>Remarks</th>
                                  <th>Action</th>
                               </tr>
                            </thead>
                            <tbody>
                              @foreach($bills as $billing)
                                  {{-- @php
                                     DB::table('registration')->where('') 
                                  @endphp --}}
                               <tr>
                                  <td>{{$loop->iteration}}</td>
                                  
                                  <td>{{$billing->invoice_no}}</td>
                                  <td>{{$billing->bill_for}}</td>
                                  
                                  {{-- <td>{{$billing->billing_type}}</td> --}}
                                  @php
                                    $data = DB::table('registration')->where('reg',$billing->entity_id)->first();
                                  @endphp
                                  <!--<td>{{$billing->entity_id}}</td>-->
                                  <td>{{$data->com_name ?? 'NA'}}</td>
                                  <td>{{$billing->amount ?? 'NA'}}</td>
                                  <td>{{$billing->total_employee ?? 'NA'}}</td>
                                  <td>{{$billing->vat ?? 'NA'}}</td>
                                  <td>{{$billing->discount_amount ?? 'NA'}}</td>
                                  <td>{{$billing->total_amount ?? 'NA'}}</td>
                                  <td>{{$billing->payment_mode ?? 'NA'}}</td>
                                  <td>{{$billing->description ?? 'NA'}}</td>
                                  <td>{{$billing->remarks ?? 'NA'}}</td>
                                   <td class="text-end">
                                      <div class="dropdown dropdown-action">
                                         <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                               <i class="material-icons">more_vert</i>
                                         </a>
                                         <div class="dropdown-menu dropdown-menu-right">
                                            {{-- @if($billing->payment_status == 1) --}}
                                               {{-- <a class="dropdown-item" href="{{ route('subadmin.billing.edit', $billing->id) }}">
                                                  <i class=" fas fa-pencil m-r-5"></i> Edit
                                               </a> --}}
                                            {{-- @endif    --}}
                                               <a class="dropdown-item" href="{{ route('organization.billing.invoice', $billing->id) }}">
                                                  <i class=" fas fa-eye m-r-5"></i> View Invoice
                                               </a>
                                               <a class="dropdown-item" href="{{ route('subadmin.billing.delete', $billing->id) }}">
                                                  <i class="fa-solid fa-trash-can m-r-5"></i> Delete
                                               </a>
                                               {{-- <a class="dropdown-item" href="{{ route('subadmin.billing-rule.edit', $billing->id) }}">
                                                  <i class="fas fa-download m-r-5"></i> Download Invoice
                                               </a>
                                               <a class="dropdown-item" href="{{ route('subadmin.billing-rule.edit', $billing->id) }}">
                                                  <i class="fas fa-paper-plane m-r-5"></i> Send Email
                                               </a>
                                               <a class="dropdown-item" href="{{ route('subadmin.billing-rule.edit', $billing->id) }}">
                                                  <i class="fa fa-comments m-r-5"></i> Remarks
                                               </a> --}}
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
<script>
    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this holiday type?")) {
            window.location.href = url;
        }
    }
</script>

@endsection
