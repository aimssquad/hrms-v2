
@extends('employeer.include.app')

@section('title', 'Inactive Employee List')
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
				<h3 class="page-title">Inactive Employee</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
					<li class="breadcrumb-item"><a href="{{url('organization/employee/employerdashboard')}}">Employee Dashboard</a></li>
					<li class="breadcrumb-item active">Inactive Employee List</li>
				</ul>
			</div>
			
		</div>
	</div>
	<!-- /Page Header -->
	<div class="row">
		<div class="col-md-12">
			<div class="card custom-card">
				<div class="card-header d-flex justify-content-between align-items-center">
					<h4 class="card-title">
						<i class="far fa-user" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Employee List
					</h4>
					<div class="row">
						<div class="col-auto">
							<form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
								@csrf
								<input type="hidden" name="data" id="data">
								<input type="hidden" name="headings" id="headings">
								<input type="hidden" name="filename" id="filename">
								{{-- put the value - that is your file name --}}
								<input type="hidden" id="filenameInput" value="Employee-list">
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
									<th>Employee ID</th>
									<th>Employee Name</th>
									<th>DOB</th>
									<th>Mobile</th>
									<th class="text-nowrap">Email</th>
									<th>Department</th>
									<th>Designation</th>
									<th>Address</th>
									<th>Status</th>
									<th class="text-end no-sort">Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($employee_rs as $employee)
								<tr>
									<td>{{ $employee->emp_code}}</td>
									<td>{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }}</td>
									<td>@if( $employee->emp_dob!='1970-01-01' &&  $employee->emp_dob!=''  &&  $employee->emp_dob!='E11') {{ date('d/m/Y',strtotime($employee->emp_dob)) }} @elseif($employee->emp_dob=='E11')   {{ date('d/m/Y',strtotime($employee->emp_dob)) }}  @endif</td>
									<td>{{ $employee->emp_ps_phone }}</td>
									<td>{{ $employee->emp_ps_email }}</td>
									<td>{{ $employee->emp_department }}</td>
									<td>{{ $employee->emp_designation }}</td>
									<td>{{ $employee->emp_pr_street_no}} @if( $employee->emp_per_village) ,{{ $employee->emp_per_village}} @endif @if( $employee->emp_pr_state) ,{{ $employee->emp_pr_state}} @endif @if( $employee->emp_pr_city) ,{{ $employee->emp_pr_city}} @endif @if( $employee->emp_pr_pincode) ,{{ $employee->emp_pr_pincode}} @endif  @if( $employee->emp_pr_country) ,{{ $employee->emp_pr_country}} @endif</td>
									<td>{{ $employee->status }}</td>
									<td class="text-end">
										<div class="dropdown dropdown-action">
											<a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false"><i class="material-icons">more_vert</i></a>
											<div class="dropdown-menu dropdown-menu-right">
												@if($user_type == 'employee')
													@foreach($sidebarItems as $value)
														@if($value['rights'] == 'Add' && $value['module_name'] == 1 && $value['menu'] == 1)
														<a class="dropdown-item" href="{{ url('organization/view-add-employee') }}?q={{ my_simple_crypt( $employee->emp_code, 'encrypt' )}}"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
														@endif
													@endforeach
												@elseif($user_type == 'employer')
												<a class="dropdown-item" href="{{ url('organization/view-add-employee') }}?q={{ my_simple_crypt( $employee->emp_code, 'encrypt' )}}"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
												@endif

												@if($user_type == 'employer')
													<a class="dropdown-item" href="{{ url('organization/employee_active') }}?q={{ my_simple_crypt( $employee->emp_code, 'encrypt' ) }}"
													onclick="return confirmActivation();">
													<i class="fa-solid fa-check-circle m-r-5"></i> Active
													</a>
												@endif
											
												
												@if($user_type == 'employee')
													@foreach($sidebarItems as $value)
														@if($value['rights'] == 'Add' && $value['module_name'] == 1 && $value['menu'] == 1)
														<a class="dropdown-item" href="{{ url('employee-add/employee-report-excel/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code)) }}" ><i class="fas fa-file-excel m-r-5"></i> Downlode Excel</a>
														@endif
													@endforeach
												@elseif($user_type == 'employer')
												<a class="dropdown-item" href="{{ url('employee-add/employee-report-excel/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code)) }}" ><i class="fas fa-file-excel m-r-5"></i> Downlode Excel</a>
												@endif

												@if($user_type == 'employee')
													@foreach($sidebarItems as $value)
														@if($value['rights'] == 'Add' && $value['module_name'] == 1 && $value['menu'] == 1)
														<a class="dropdown-item" href="{{ url('employee-add/employee-report/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code)) }}" ><i class="fas fa-file-pdf m-r-5"></i> Downlode PDF</a>
														@endif
													@endforeach
												@elseif($user_type == 'employer')
												<a class="dropdown-item" href="{{ url('employee-add/employee-report/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code)) }}" ><i class="fas fa-file-pdf m-r-5"></i> Downlode PDF</a>
												@endif
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
<script type="text/javascript">
    function confirmActivation() {
        return confirm("Are you sure you want to activate this employee?");
    }
</script>

@endsection
