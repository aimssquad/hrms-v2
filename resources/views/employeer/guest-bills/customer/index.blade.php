@extends('employeer.include.app')

@section('title', \App\Helpers\Helper::cachedTrans('Customer'))
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
				<h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Customer')}}</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="#">{{\App\Helpers\Helper::cachedTrans('Dashboard')}} </a></li>
					<li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Customer')}}</li>
				</ul>
			</div>
		   
        	<div class="col-auto float-end ms-auto">
				@if($user_type == 'employee')
				@foreach($sidebarItems['Rota'] as $rotaItem)
                    @if($rotaItem['submenu_name'] == 'Notice' && $rotaItem['can_add'] == 1)
				<a href="{{ url('organization/add-customer') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> {{\App\Helpers\Helper::cachedTrans('Add Customer')}}</a>
				    @endif
				@endforeach
				@elseif($user_type == 'employer')
				<a href="{{ url('organization/add-customer') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> {{\App\Helpers\Helper::cachedTrans('Add Customer')}}</a>
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
                        <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;{{\App\Helpers\Helper::cachedTrans('Customer')}}
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
                        <table id="basic-datatables" class="display table table-striped table-hover" >
                            <thead>
                               <tr>
                                  <th>{{\App\Helpers\Helper::cachedTrans('Sl No.')}}</th>
                                  <th>{{\App\Helpers\Helper::cachedTrans('Company Name')}}</th>
                                  <th>{{\App\Helpers\Helper::cachedTrans('Name')}}</th>
                                  <th>{{\App\Helpers\Helper::cachedTrans('Designation')}}</th>
                                  <th>{{\App\Helpers\Helper::cachedTrans('Email')}}</th>
                                  <th>{{\App\Helpers\Helper::cachedTrans('Phone')}}</th>
                                  <th>{{\App\Helpers\Helper::cachedTrans('Address')}}</th>
                                  <th>{{\App\Helpers\Helper::cachedTrans('Status')}}</th>
                                  <th>{{\App\Helpers\Helper::cachedTrans('Action')}}</th>
                               </tr>
                            </thead>
                            <tbody>
                              @foreach($guests as $customer)
                               <tr>
                                    <td>{{$loop->iteration}}</td>
                                    <td>{{$customer->company_name}}</td>
                                    <td>{{$customer->name}}</td>
                                    <td>{{$customer->designation}}</td>
                                    <td>{{$customer->email}}</td>
                                    <td>{{$customer->phone}}</td>
                                    <td>{{$customer->address}}</td>
                                    <td>
                                        @if($customer->status == 1) <span class="badge bg-inverse-success">Active</span> @else<span class="badge bg-inverse-danger">Inactive</span>@endif
                                    </td>
                                   <td class="text-end">
                                      <div class="dropdown dropdown-action">
                                         <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                               <i class="material-icons">more_vert</i>
                                         </a>
                                         <div class="dropdown-menu dropdown-menu-right">
                                            <a class="dropdown-item" href="{{ route('org.customer.edit', base64_encode($customer->id)) }}">
                                                <i class="fa-solid fas fa-pencil m-r-5"></i> edit
                                            </a>
                                            <form action="{{ route('org.customer.delete', base64_encode($customer->id)) }}"
                                                method="POST"
                                                onsubmit="return confirm('Are you sure you want to delete this customer?');"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="dropdown-item">
                                                    <i class="fa-solid fas fa-trash-can m-r-5"></i> Delete
                                                </button>
                                            </form>

                                              
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
