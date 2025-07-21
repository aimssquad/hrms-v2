@extends('employeer.include.app')

@section('title', 'Employee List')
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();

function my_simple_crypt( $string, $action = 'encrypt' ) {
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

@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
    <!-- Page Header -->
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

    <!-- Search Filter -->
    {{-- <form method="GET" action="{{ url()->current() }}">
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3">
                <div class="input-block mb-3 form-focus">
                    <input type="text" name="search" id="searchEmployeeName" class="form-control floating" value="{{ request('search') }}" placeholder="Search by name or code">
                    <label class="focus-label">Employee Name/Code</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <button type="submit" class="btn btn-success btn-block"> Search </button>
            </div>
        </div>
    </form> --}}
    {{-- <form method="GET" action="{{ url()->current() }}" class="d-inline-flex align-items-center">
        <div class="input-group">
            <input type="text" name="search" id="searchEmployeeName" 
                    class="form-control floating-search" 
                    value="{{ request('search') }}" 
                    placeholder="Search by name or code"
                    style="width: 200px;">
            <button type="submit" class="btn btn-success">
                <i class="fa fa-search"></i>
            </button>
            @if(request('search'))
                <a href="{{ url()->current() }}" class="btn btn-secondary">
                    <i class="fa fa-times"></i>
                </a>
            @endif
        </div>
    </form> --}}
    <!-- /Search Filter -->

    <div class="row staff-grid-row" id="employeeGrid">
        @forelse($employee_rs as $employee)
        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3 employee-card" data-emp-name="{{ $employee->emp_fname.' '.$employee->emp_mname.' '.$employee->emp_lname }}" data-emp-code="{{ $employee->emp_code }}">
            <div class="profile-widget">
                <div class="profile-img">
                    <a href="{{ asset(\App\Helpers\Helper::getImageUrl($employee->emp_image)) }}" class="avatar">
                        <img src="{{ asset(\App\Helpers\Helper::getImageUrl($employee->emp_image)) }}" alt="User Image">
                    </a>
                </div>
                <div class="dropdown profile-action">
                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="material-icons">more_vert</i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @if($user_type == 'employee')
                            @foreach($sidebarItems['Employee Administration'] as $rotaItem)
                                @if($rotaItem['submenu_name'] == 'Employees' && $rotaItem['can_edit'] == 1)
                                <a class="dropdown-item" href="{{ url('organization/view-add-employee') }}?q={{ my_simple_crypt( $employee->emp_code, 'encrypt' )}}">
                                    <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                </a>
                                @endif
                            @endforeach
                        @elseif($user_type == 'employer')
                        <a class="dropdown-item" href="{{ url('organization/view-add-employee') }}?q={{ my_simple_crypt( $employee->emp_code, 'encrypt' )}}">
                            <i class="fa-solid fa-pencil m-r-5"></i> Edit
                        </a>
                        @endif
                        
                        @if($user_type == 'employer')
                            <a class="dropdown-item" href="{{ url('organization/employeeInactive') }}?q={{ my_simple_crypt( $employee->emp_code, 'encrypt' )}}" onclick="return confirmActivation();">
                                <i class="fa-solid fa-trash-can m-r-5"></i> Inactive
                            </a>
                        @endif
                        
                        @if($user_type == 'employee')
                            @foreach($sidebarItems['Employee Administration'] as $rotaItem)
                                @if($rotaItem['submenu_name'] == 'Employees' && $rotaItem['can_edit'] == 1)
                                <a class="dropdown-item" href="{{ url('employee-add/employee-report/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code)) }}">
                                    <i class="fas fa-file-pdf m-r-5"></i> Download PDF
                                </a>
                                @endif
                            @endforeach
                        @elseif($user_type == 'employer')
                        <a class="dropdown-item" href="{{ url('employee-add/employee-report/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code)) }}">
                            <i class="fas fa-file-pdf m-r-5"></i> Download PDF
                        </a>
                        @endif
                        
                        @if($user_type == 'employee')
                            @foreach($sidebarItems['Employee Administration'] as $rotaItem)
                                @if($rotaItem['submenu_name'] == 'Employees' && $rotaItem['can_edit'] == 1)
                                <a class="dropdown-item" href="{{ url('employee-add/employee-report-excel/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code)) }}">
                                    <i class="fas fa-file-excel m-r-5"></i> Download Excel
                                </a>
                                @endif
                            @endforeach
                        @elseif($user_type == 'employer')
                        <a class="dropdown-item" href="{{ url('employee-add/employee-report-excel/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code)) }}">
                            <i class="fas fa-file-excel m-r-5"></i> Download Excel
                        </a>
                        @endif
                    </div>
                </div>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis">
                    <a href="{{ url('organization/view-add-employee') }}?q={{ my_simple_crypt( $employee->emp_code, 'encrypt' )}}">
                        {{ $employee->emp_fname.' '.$employee->emp_mname.' '.$employee->emp_lname }}
                    </a>
                </h4>
                <div class="small text-muted">{{ $employee->emp_designation ?? 'NA' }}</div>
                <div class="small text-muted">{{ $employee->emp_code }}</div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info">No employees found.</div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    {{-- <div class="row">
        <div class="col-md-12">
            <div class="pagination-container">
                {{ $employee_rs->appends(request()->query())->links() }}
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-md-12">
            <div class="pagination-container">
                {{ $employee_rs->appends(request()->query())->onEachSide(1)->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </div>
</div>
<!-- /Page Content -->
@endsection

@section('script')
<script>
    // Client-side search function (optional - works on currently loaded page only)
    function searchEmployee() {
        var input = document.getElementById('searchEmployeeName').value.toLowerCase();
        var cards = document.getElementsByClassName('employee-card');
        
        for (var i = 0; i < cards.length; i++) {
            var name = cards[i].getAttribute('data-emp-name').toLowerCase();
            var code = cards[i].getAttribute('data-emp-code').toLowerCase();
            
            if (name.includes(input) || code.includes(input)) {
                cards[i].style.display = "";
            } else {
                cards[i].style.display = "none";
            }
        }
        
        // Hide pagination during client-side search
        document.querySelector('.pagination-container').style.display = input ? 'none' : 'block';
    }

    // Initialize search on page load if there's a search term
    document.addEventListener('DOMContentLoaded', function() {
        var searchInput = document.getElementById('searchEmployeeName');
        if (searchInput.value) {
            searchEmployee();
        }
        
        // Add event listener for search input
        searchInput.addEventListener('keyup', searchEmployee);
    });

    function confirmActivation() {
        return confirm("Are you sure you want to inactive this employee?");
    }
</script>

<style>
    /* Optional: Add some styling for pagination */
    .pagination-container {
        margin-top: 20px;
    }
    .pagination .page-item.active .page-link {
        background-color: #55ce63;
        border-color: #55ce63;
    }
    .pagination .page-link {
        color: #55ce63;
    }
</style>
<style>
    /* Custom Pagination Styles */
    .pagination {
        display: flex;
        justify-content: center;
        margin-top: 20px;
    }
    
    .pagination .page-item {
        margin: 0 3px;
    }
    
    .pagination .page-link {
        color: #55ce63;
        border: 1px solid #dee2e6;
        padding: 6px 12px;
        font-size: 14px;
        border-radius: 4px;
    }
    
    .pagination .page-item.active .page-link {
        background-color: #55ce63;
        border-color: #55ce63;
        color: white;
    }
    
    .pagination .page-link:hover {
        background-color: #f1f1f1;
    }
    
    /* Make arrow icons smaller */
    .pagination .page-link .fa {
        font-size: 12px;
    }
    
    /* Specifically target the arrow links */
    .pagination .page-item:first-child .page-link,
    .pagination .page-item:last-child .page-link {
        padding: 6px 10px;
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