
@extends('employeer.include.app')

@section('title', \App\Helpers\Helper::cachedTrans('Technical Support'))
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
//dd($sidebarItems);
@endphp
@section('content')
@php
	function my_simple_crypt( $string, $action = 'encrypt' ) {
		// you may change these values to your own
		$secret_key = 'bopt_saltlake_kolkata_secret_key';
		$secret_iv = 'bopt_saltlake_kolkata_secret_iv';
	
		$output = false;
		$encrypt_method = "AES-256-CBC";
		$key = hash( 'sha256', $secret_key );
		$iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
	
		if( $action == 'encrypt' ) {
			$output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
		}
		else if( $action == 'decrypt' ){
			$output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
		}
	
		return $output;
	}

@endphp

<!-- Page Content -->
<div class="content container-fluid pb-0">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Technical Support')}}</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{route('organization.home')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
					<li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Technical Support')}}</li>
				</ul>
			</div>
			<div class="col-auto float-end ms-auto">
				@if($user_type == 'employee')
				@foreach($sidebarItems['Rota'] as $rotaItem)
                    @if($rotaItem['submenu_name'] == 'Notice' && $rotaItem['can_add'] == 1)
				<a href="{{ url('add-helpdesk') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> {{\App\Helpers\Helper::cachedTrans('Technical Support')}}</a>
				    @endif
				@endforeach
				@elseif($user_type == 'employer')
				<a href="{{ url('add-helpdesk') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> {{\App\Helpers\Helper::cachedTrans('Technical Support')}}</a>
				@endif
				{{-- <div class="view-icons">
					<a href="{{url('organization/employeeee')}}" class="grid-view btn btn-link "><i class="fa fa-th"></i></a>
					<a href="{{url('organization/emplist')}}" class="list-view btn btn-link active"><i class="fa-solid fa-bars"></i></a>
				</div> --}}
			</div>
            @include('employeer.layout.message')
		</div>
	</div>
	<!-- /Page Header -->
	<div class="row">
		<div class="col-md-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp; {{\App\Helpers\Helper::cachedTrans('Add Technical Support')}}
                    </h4>
                    <div class="row">
                        <div class="col-auto">
                            <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                                @csrf
                                <input type="hidden" name="data" id="data">
                                <input type="hidden" name="headings" id="headings">
                                <input type="hidden" name="filename" id="filename">
                                {{-- put the value - that is your file name --}}
                                <input type="hidden" id="filenameInput" value="Notice">
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
                        <table class="table table-striped custom-table" id="basic-datatables">
                            <thead>
                                <tr>
                                    <th>{{ \App\Helpers\Helper::cachedTrans('Sl No.') }}</th>
                                    <th>{{ \App\Helpers\Helper::cachedTrans('Ticket No') }}</th>
                                    <th>{{ \App\Helpers\Helper::cachedTrans('Ticket Raise') }}</th>
                                    <th>{{ \App\Helpers\Helper::cachedTrans('Name') }}</th>
                                    <th>{{ \App\Helpers\Helper::cachedTrans('Email') }}</th>
                                    <th>{{ \App\Helpers\Helper::cachedTrans('Message') }}</th>
                                    <th>{{ \App\Helpers\Helper::cachedTrans('Image') }}</th>
                                    <th>{{ \App\Helpers\Helper::cachedTrans('Date') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($tech_support as $datas)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $datas->ticket_no }}</td>

                                    {{-- Ticket Raise --}}
                                    <td>
                                        {{ empty($datas->employee_id) ? 'Organization' : 'Employee' }}
                                    </td>

                                    <td>{{ $datas->name }}</td>
                                    <td>{{ $datas->email }}</td>
                                    <td>{{ ucwords($datas->message) }}</td>

                                    {{-- Image --}}
                                    <td>
                                        @if(!empty($datas->image))
                                            <a href="{{ asset('storage/'.$datas->image) }}" target="_blank">
                                                <img src="{{ asset('storage/'.$datas->image) }}"
                                                    style="max-width:80px; cursor:pointer;">
                                            </a>
                                        @else
                                            <span class="text-muted">No Image</span>
                                        @endif
                                    </td>

                                    {{-- Date --}}
                                    <td>{{ \Carbon\Carbon::parse($datas->created_at)->format('d-m-Y') }}</td>
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
        if (confirm("Are you sure you want to delete this record?")) {
            window.location.href = url;
        }
    }
</script>

@endsection


