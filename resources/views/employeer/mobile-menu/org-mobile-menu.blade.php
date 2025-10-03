
@extends('employeer.include.app')

@section('title', \App\Helpers\Helper::cachedTrans('Mobile Menu'))
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
				<h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Mobile Menu')}}</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                    {{-- <li class="breadcrumb-item"><a href="{{url('leave/dashboard')}}">Dashboard</a></li> --}}
					<li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Mobile Menu')}}</li>
				</ul>
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
                        <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp; {{\App\Helpers\Helper::cachedTrans('Mobile Menu')}}
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
                    <form action="{{ route('save.organization.menu') }}" method="POST">
                        @csrf <!-- CSRF Token for security -->
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered custom-table" style="border: 1px solid rgb(204, 200, 200);">
                                <thead>
                                    <tr>
                                        <th width="50">#</th>
                                        <th>{{\App\Helpers\Helper::cachedTrans('Module Permission')}} </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    {{-- @foreach($menus as $menu)
                                        <tr>
                                            <td class="text-center">
                                                <label class="custom_check">
                                                    <input type="checkbox" name="menu_ids[]" value="{{ $menu->id }}"
                                                        {{ in_array($menu->id, $assignedMenus) ? 'checked' : '' }}>													
                                                    <span class="checkmark"></span>
                                                </label>																
                                            </td>
                                            <td>{{ $menu->menu_name ?? 'N/A' }}</td>
                                        </tr>
                                    @endforeach --}}
                                    @foreach($menus as $menu)
                                        <tr>
                                            <td class="text-center">
                                                <label class="custom_check">
                                                    <input type="checkbox" name="menu_ids[]" value="{{ $menu->menu_id }}"
                                                        {{ in_array($menu->menu_id, $assignedMenus) ? 'checked' : '' }}>													
                                                    <span class="checkmark"></span>
                                                </label>																
                                            </td>
                                            <td>{{ \App\Helpers\Helper::cachedTrans($menu->menu->menu_name) ?? 'N/A' }}</td> {{-- Fetch menu_name from related MobileMenu --}}
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    
                        <div class="col-md-6">
                            <label class="col-form-label">Select</label>
                            <select name="status" class="select">
                                <option value="">Select</option>
                                <option value="0" {{ isset($status) && $status == 0 ? 'selected' : '' }}>Active</option>
                                <option value="1" {{ isset($status) && $status == 1 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>
                        <br>
                        <div class="col-md-6">
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>
                    
                       
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
