
@extends('employeer.include.app')

@section('title', 'Leave Allocation')
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
				<h3 class="page-title">Leave Allocation</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                    <li class="breadcrumb-item"><a href="{{url('leave/dashboard')}}">Dashboard</a></li>
					<li class="breadcrumb-item active">Allocation</li>
				</ul>
			</div>
			<div class="col-auto float-end ms-auto">
				@if($user_type == 'employee')
				@foreach($sidebarItems as $value)
				@if($value['rights'] == 'Add' && $value['module_name'] == 3 && $value['menu'] == 45)
				<a href="{{ url('leave/save-leave-allocation') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Allocation</a>
				@endif
				@endforeach
				@elseif($user_type == 'employer')
				<a href="{{ url('leave/save-leave-allocation') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Allocation</a>
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
                        <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;
                    </h4>
                    <div class="row">
                        <div class="col-auto">
                            <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                                @csrf
                                <input type="hidden" name="data" id="data">
                                <input type="hidden" name="headings" id="headings">
                                <input type="hidden" name="filename" id="filename">
                                {{-- put the value - that is your file name --}}
                                <input type="hidden" id="filenameInput" value="Leave Allocation">
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
                                    <th>Sl.No.</th>
                                    <th>Employee Type</th>
                                    <th>Leave Type</th>
                                    <th>Employee Code</th>
                                    <th>Employee Name</th>
                                    <th>Max. No. of Leave</th>
                                    <th>Leave in Hand</th>
                                    <th>Effective Year</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($leave_allocation as $leave_allo)				 
                                <?php
                                    $leaveemdata = DB::table('employee')      
                                        ->where('emp_code','=', $leave_allo->employee_code)
                                        ->first(); 
                                    //dd($leaveemdata);
                                        $email = Session::get('emp_email'); 
                                    $Roledata = DB::table('registration')      
                                        ->where('email','=',$email) 
                                        ->first();
                                                                
                                    $leaveenamemdata = DB::table('employee')      
                                        ->where('emp_code','=', $leave_allo->employee_code)
                                        ->where('emid', '=', $Roledata->reg)
                                        ->first(); 					     
                                ?>
                                    <tr>
                                        <td>{{$loop->iteration}}</td>
                                        <td>{{$leaveemdata->emp_status}}</td>
                                        <td>{{$leave_allo->leave_type_name}}</td>
                                        <td>{{$leave_allo->employee_code}}</td>
                                        <td>{{$leaveenamemdata->emp_fname}} {{$leaveenamemdata->emp_mname}} {{$leaveenamemdata->emp_lname}}</td>
                                        <td>{{$leave_allo->max_no}}</td>
                                        <td>{{$leave_allo->leave_in_hand}}</td>
                                        <td>{{$leave_allo->month_yr}}</td>
                                        <td class="text-end">
                                            <div class="dropdown dropdown-action">
                                                <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="material-icons">more_vert</i>
                                                </a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    @if($user_type == 'employee')
                                                        @foreach($sidebarItems as $value)
                                                            @if($value['rights'] == 'Add' && $value['module_name'] == 3 && $value['menu'] == 45)
                                                                <a class="dropdown-item" href="{{url('leave/leave-allocation-dtl/$leave_allo->id')}}">
                                                                    <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                                </a>
                                                            @endif
                                                        @endforeach
                                                    @elseif($user_type == 'employer')
                                                        <a class="dropdown-item" href="{{url('leave-management/leave-allocation-dtl/$leave_allo->id')}}">
                                                            <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                        </a>
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
	<!-- Include jQuery and DataTables JS library -->
    
<script>
    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this record?")) {
            window.location.href = url;
        }
    }
</script>

@endsection
