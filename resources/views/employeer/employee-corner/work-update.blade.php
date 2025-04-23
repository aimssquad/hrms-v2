
@extends('employeer.employee-corner.main')

@section('title', 'Daily Work Update')
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
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
				<h3 class="page-title"> Daily Work Update</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active"> Daily Work Update</li>
				</ul>
			</div>
			<div class="col-auto float-end ms-auto">
				@if($user_type !== 'employer')
				<a href="{{url('org-employee-corner/add-work-update')}}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Daily Work Update </a>
				@endif
			</div>
		</div>
	</div>
	<!-- /Page Header -->
    @if(Session::has('message'))										
        <div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
    @endif
	<div class="row">
		<div class="col-md-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Daily Work Update
                    </h4>
                    <div class="row">
                        <div class="col-auto">
                            <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                                @csrf
                                <input type="hidden" name="data" id="data">
                                <input type="hidden" name="headings" id="headings">
                                <input type="hidden" name="filename" id="filename">
                                {{-- put the value - that is your file name --}}
                                <input type="hidden" id="filenameInput" value="Lavel-1user">
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
                                    <th>Sl No.</th>
                                    <th>Date</th>
                                    <th>From Time</th>
                                    <th>To Time</th>
                                    <th>Time</th>
                                    <th>Remarks</th>
                                    <th>Comment</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>  
                                @foreach($employee_workupdate as $candidate)
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{ date('d/m/Y',strtotime($candidate->date)) }} </td>
                                        <td>{{ date('h:i A',strtotime($candidate->in_time)) }} </td>
                                        <td>{{ date('h:i A',strtotime($candidate->out_time)) }} </td>
                                        <td>{{ $candidate->w_hours }} Hours {{ $candidate->w_min }} Minutes</td>
                                        <td> {{ $candidate->remarks }}</td>
                                        <td> {{ $candidate->cmd }}</td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="material-icons">more_vert</i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if($user_type == 'employee')
                                                        {{-- @foreach($sidebarItems as $value) --}}
                                                            {{-- @if($value['rights'] == 'Add' && $value['module_name'] == 4 && $value['menu'] == 49) --}}
                                                                <a class="dropdown-item" href="{{url('org-employee-corner/work-edit/'.$candidate->id)}}">
                                                                    <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                                </a>
                                                            {{-- @endif --}}
                                                        {{-- @endforeach --}}
                                                    @elseif($user_type == 'employer')
                                                        <a class="dropdown-item" href="{{url('org-employee-corner/work-edit/'.$candidate->id)}}">
                                                            <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                        </a>
                                                    @endif
                                                    {{-- @if($user_type == 'employee')
                                                        @foreach($sidebarItems as $value)
                                                            @if($value['rights'] == 'Add' && $value['module_name'] == 4 && $value['menu'] == 49)
                                                            <a class="dropdown-item" href='{{url("user-accessrole/view-users-role/$role->id")}}' onclick="return confirm('Are you sure you want to delete this Access?');"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                                            @endif
                                                        @endforeach
                                                    @elseif($user_type == 'employer')
                                                        <a class="dropdown-item" href='{{url("user-accessrole/view-users-role/$role->id")}}' onclick="return confirm('Are you sure you want to delete this Access?');"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                                    @endif --}}
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
