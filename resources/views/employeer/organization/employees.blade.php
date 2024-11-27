@extends('employeer.include.app')

@section('title', 'Employee List')
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
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
                <a href="{{url('organization/view-add-employee')}}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Employee</a>
                <div class="view-icons">
                    <a href="{{url('organization/employeeee')}}" class="grid-view btn btn-link active"><i class="fa fa-th"></i></a>
                    <a href="{{url('organization/emplist')}}" class="list-view btn btn-link"><i class="fa-solid fa-bars"></i></a>
                </div>
            </div>
        </div>
    </div>
    <!-- /Page Header -->

    <!-- Search Filter -->
    <div class="row filter-row">
        <div class="col-sm-6 col-md-3">
            <div class="input-block mb-3 form-focus">
                <!-- Empty for future additional filters -->
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="input-block mb-3 form-focus">
                <!-- Empty for future additional filters -->
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="input-block mb-3 form-focus select-focus">
                <!-- Empty for future additional filters -->
            </div>
        </div>
        <div class="col-sm-6 col-md-3">
            <div class="input-block mb-3 form-focus">
                <input type="text" id="searchEmployeeName" class="form-control floating" onkeyup="searchEmployee()">
                <label class="focus-label">Employee Name</label>
            </div>
        </div>
    </div>
    <!-- /Search Filter -->

    <div class="row staff-grid-row" id="employeeGrid">
        @foreach($employee_rs as $employee)
        <div class="col-md-4 col-sm-6 col-12 col-lg-4 col-xl-3 employee-card" data-emp-name="{{ $employee->emp_fname.' '.$employee->emp_mname.' '.$employee->emp_lname }}">
            <div class="profile-widget">
                <div class="profile-img">
                    @if(!empty($employee->emp_image))
                        <a href="#" class="avatar"><img src="{{asset('storage/app/public/' . $employee->emp_image)}}" alt="User Image"></a>
                    @elseif($employee->emp_gender=="Male")
                        <a href="#" class="avatar"><img src="{{asset('assets/img/user.png')}}" alt="User Image"></a>
                    @else
                        <a href="#" class="avatar"><img src="{{asset('assets/img/female.jpg')}}" alt="User Image"></a>
                    @endif
                    <!--<a href="profile.html" class="avatar"><img src="{{asset('assets/img/chadengle.jpg')}}" alt="User Image"></a>-->
                </div>
                <div class="dropdown profile-action">
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
                            <a class="dropdown-item" href="{{ url('organization/employeeInactive') }}?q={{ my_simple_crypt( $employee->emp_code, 'encrypt' )}}" onclick="return confirmActivation();"><i class="fa-solid fa-trash-can m-r-5"></i> Inactive</a>
                        @endif
                        
                       	@if($user_type == 'employee')
							@foreach($sidebarItems as $value)
								@if($value['rights'] == 'Add' && $value['module_name'] == 1 && $value['menu'] == 1)
								<a class="dropdown-item" href="{{ url('employee-add/employee-report/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code)) }}" ><i class="fas fa-file-pdf-can m-r-5"></i> Downlode PDF</a>
								@endif
							@endforeach
						@elseif($user_type == 'employer')
						<a class="dropdown-item" href="{{ url('employee-add/employee-report/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code)) }}"><i class="fas fa-file-pdf m-r-5"></i> Downlode PDF</a>
						@endif
						
						@if($user_type == 'employee')
							@foreach($sidebarItems as $value)
								@if($value['rights'] == 'Add' && $value['module_name'] == 1 && $value['menu'] == 1)
								<a class="dropdown-item" href="{{ url('employee-add/employee-report-excel/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code)) }}" ><i class="fas fa-file-excel m-r-5"></i> Downlode Excel</a>
								@endif
							@endforeach
						@elseif($user_type == 'employer')
						<a class="dropdown-item" href="{{ url('employee-add/employee-report-excel/'.base64_encode($employee->emid).'/'.base64_encode($employee->emp_code)) }}"><i class="fas fa-file-excel m-r-5"></i> Downlode Excel</a>
						@endif
                    </div>
                </div>
                <h4 class="user-name m-t-10 mb-0 text-ellipsis"><a href="{{ url('organization/view-add-employee') }}?q={{ my_simple_crypt( $employee->emp_code, 'encrypt' )}}">{{ $employee->emp_fname.' '.$employee->emp_mname.' '.$employee->emp_lname }}</a></h4>
                <div class="small text-muted">{{$employee->emp_designation ?? 'NA'}}</div>
            </div>
        </div>
        @endforeach
    </div>
</div>
<!-- /Page Content -->

@endsection

@section('script')
{{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}

<script>
    function searchEmployee() {
        var inputName = document.getElementById('searchEmployeeName').value.toLowerCase();
        var employees = document.getElementsByClassName('employee-card');
        var searchTerms = inputName.split(" ");

        for (var i = 0; i < employees.length; i++) {
            var empName = employees[i].getAttribute('data-emp-name').toLowerCase();
            var match = true;

            for (var j = 0; j < searchTerms.length; j++) {
                if (!empName.includes(searchTerms[j])) {
                    match = false;
                    break;
                }
            }

            if (match) {
                employees[i].style.display = "";
            } else {
                employees[i].style.display = "none";
            }
        }
    }


    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this holiday type?")) {
            window.location.href = url;
        }
    }
    function confirmActivation() {
        return confirm("Are you sure you want to inactive this employee?");
    }
</script>
@endsection
