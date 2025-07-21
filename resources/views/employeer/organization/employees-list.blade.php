
@extends('employeer.include.app')

@section('title', 'Employee List')
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
	{{-- <div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">Employee</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
					<li class="breadcrumb-item"><a href="{{url('organization/employee/employerdashboard')}}">Employee Dashboard</a></li>
					<li class="breadcrumb-item active">Employee List</li>
				</ul>
			</div>
			<div class="col-auto float-end ms-auto">
				@if($user_type == 'employee')
				@foreach($sidebarItems['Employee Administration'] as $rotaItem)
				@if($rotaItem['submenu_name'] == 'Employees' && $rotaItem['can_add'] == 1)
				<a href="{{url('organization/view-add-employee')}}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Employee</a>
				@endif
				@endforeach
				@elseif($user_type == 'employer')
				<a href="{{url('organization/view-add-employee')}}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Employee</a>
				@endif
				<div class="view-icons">
					<a href="{{url('organization/employeeee')}}" class="grid-view btn btn-link "><i class="fa fa-th"></i></a>
					<a href="{{url('organization/emplist')}}" class="list-view btn btn-link active"><i class="fa-solid fa-bars"></i></a>
				</div>
			</div>
		</div>
	</div> --}}
	<div class="page-header">
        <div class="row align-items-center">
            <div class="col">
                <h3 class="page-title">Employees</h3>
                <ul class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('organization/employee/employerdashboard')}}">Employee Dashboard</a></li>
                    <li class="breadcrumb-item active">Employee List</li>
                </ul>
            </div>
            <div class="col-auto float-end ms-auto">
                <!-- Search Form - Moved to right side -->
                <form method="GET" action="{{ url()->current() }}" class="d-inline-flex me-3">
                    <div class="input-group search-form">
						<input type="text" name="search" id="searchEmployeeName" 
							class="form-control" 
							value="{{ request('search') }}" 
							placeholder="Search by name or code"
							autocomplete="off">
						<button type="button" class="btn btn-primary" id="searchButton">
							<i class="fa fa-search"></i>
						</button>
						@if(request('search'))
							<a href="{{ url()->current() }}" class="btn btn-secondary" id="clearSearch">
								<i class="fa fa-times"></i>
							</a>
						@endif
					</div>
                </form>
                
                <a href="{{url('organization/view-add-employee')}}" class="btn add-btn me-2"><i class="fa-solid fa-plus"></i> Add Employee</a>
                <div class="view-icons">
                    <a href="{{url('organization/employee')}}" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                    <a href="{{url('organization/emplist')}}" class="list-view btn btn-link"><i class="fa-solid fa-bars"></i></a>
                </div>
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
								<button type="submit" class="btn-download btn-download-excel me-0">
									Export to Excel
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
										Export to PDF
								</button>
						  </form>
						</div>
					</div>
				 </div>
				<div class="card-body">
					<div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
        				<table class="table table-striped custom-table mb-0">
							<thead >
								<tr>
									<th>Employee ID</th>
									<th>Employee Name</th>
									<th>Password</th>
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
									<td>{{$employee->password}}</td>
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
													@foreach($sidebarItems['Employee Administration'] as $rotaItem)
														@if($rotaItem['submenu_name'] == 'Employees' && $rotaItem['can_edit'] == 1)
														<a class="dropdown-item" href="{{ url('organization/view-add-employee') }}?q={{ my_simple_crypt( $employee->emp_code, 'encrypt' )}}"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
														@endif
													@endforeach
												@elseif($user_type == 'employer')
												<a class="dropdown-item" href="{{ url('organization/view-add-employee') }}?q={{ my_simple_crypt( $employee->emp_code, 'encrypt' )}}"><i class="fa-solid fa-pencil m-r-5"></i> Edit</a>
												@endif

												@if($user_type == 'employer')
												  <a class="dropdown-item" href="{{ url('organization/employeeInactive') }}?q={{ my_simple_crypt( $employee->emp_code, 'encrypt' )}}" onclick="return confirmActivation();"><i class="fa-solid fa-pencil m-r-5"></i> Inactive</a>
												@endif
												
												@if($user_type == 'employee')
													@foreach($sidebarItems['Employee Administration'] as $rotaItem)
														@if($rotaItem['submenu_name'] == 'Employees' && $rotaItem['can_edit'] == 1)
														<a class="dropdown-item" href="{{ url('employee-add/employee-report-excel/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code)) }}" ><i class="fas fa-file-excel m-r-5"></i> Downlode Excel</a>
														@endif
													@endforeach
												@elseif($user_type == 'employer')
												<a class="dropdown-item" href="{{ url('employee-add/employee-report-excel/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code)) }}" ><i class="fas fa-file-excel m-r-5"></i> Downlode Excel</a>
												@endif

												@if($user_type == 'employee')
													@foreach($sidebarItems['Employee Administration'] as $rotaItem)
														@if($rotaItem['submenu_name'] == 'Employees' && $rotaItem['can_edit'] == 1)
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
					<div class="row">
						<div class="col-md-12">
							<div class="pagination-container">
								{{ $employee_rs->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-4') }}
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
<script type="text/javascript">
    function confirmActivation() {
        return confirm("Are you sure you want to inactive this employee?");
    }
</script>
<style>
	/* .pagination {
    display: none !important;
} */
</style>
<style>
    /* Custom Pagination Styles */
    .pagination-container {
        margin-top: 20px;
        display: flex;
        justify-content: center;
    }
    
    .pagination {
        display: flex;
        list-style: none;
        padding: 0;
        margin: 0;
    }
    
    .pagination .page-item {
        margin: 0 3px;
    }
    
    .pagination .page-link {
        color: #fc9003;
        background: #fff;
        border: 1px solid #ddd;
        padding: 6px 12px;
        font-size: 14px;
        border-radius: 4px;
        transition: all 0.3s;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #fc9003;
        border-color: #fc9003;
        color: white;
    }
    
    .pagination .page-link:hover {
        background-color: #f1f1f1;
        border-color: #ddd;
    }
    
    /* Make arrow icons more compact */
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        padding: 6px 10px;
    }
    
    /* Hide text labels and show only arrows */
    .pagination .page-item:first-child .page-link span:not(.sr-only),
    .pagination .page-item:last-child .page-link span:not(.sr-only) {
        display: none;
    }
    
    .pagination .page-item:first-child .page-link::before {
        content: "←";
    }
    
    .pagination .page-item:last-child .page-link::after {
        content: "→";
    }
</style>

<style>
    /* Main table container */
    .table-responsive {
        display: block;
        width: 100%;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }
    
    /* Table styling */
    .table {
        width: 100%;
        margin-bottom: 0;
    }
    
    /* Sticky header */
    .sticky-top {
        position: sticky;
        top: 0;
    }
    
    /* Ensure table cells don't collapse */
    table {
        border-collapse: separate;
        border-spacing: 0;
    }
    
    /* Fix for pagination */
    .pagination-container {
        position: sticky;
        bottom: 0;
        background: white;
        padding: 10px 0;
        z-index: 2;
    }
</style>
<script>
	$(document).ready(function() {
		// Debounce function to limit how often the search executes
		function debounce(func, wait, immediate) {
			var timeout;
			return function() {
				var context = this, args = arguments;
				var later = function() {
					timeout = null;
					if (!immediate) func.apply(context, args);
				};
				var callNow = immediate && !timeout;
				clearTimeout(timeout);
				timeout = setTimeout(later, wait);
				if (callNow) func.apply(context, args);
			};
		}

		// Search function
		function performSearch() {
			var searchTerm = $('#searchEmployeeName').val();
			var url = "{{ url()->current() }}";
			
			// Show loading indicator
			$('.table-responsive').html('<div class="text-center py-5"><i class="fas fa-spinner fa-spin fa-2x"></i></div>');
			
			$.ajax({
				url: url,
				type: "GET",
				data: { search: searchTerm },
				success: function(response) {
					// Extract just the table HTML from the response
					var tableHtml = $(response).find('.table-responsive').html();
					$('.table-responsive').html(tableHtml);
					
					// Reinitialize any necessary plugins or event handlers
					initializeTableEvents();
				},
				error: function(xhr) {
					console.log(xhr.responseText);
					$('.table-responsive').html('<div class="text-center py-5 text-danger">Error loading data</div>');
				}
			});
		}

		// Initialize table events (dropdowns, etc.)
		function initializeTableEvents() {
			// Reinitialize any dropdowns or other interactive elements here
			$('.dropdown-toggle').dropdown();
		}

		// Set up event handlers
		$('#searchEmployeeName').on('keyup', debounce(function() {
			performSearch();
		}, 300));

		$('#searchButton').on('click', function() {
			performSearch();
		});

		$('#clearSearch').on('click', function() {
			$('#searchEmployeeName').val('');
			performSearch();
		});

		// Initialize on page load
		initializeTableEvents();
	});
</script>


@endsection
