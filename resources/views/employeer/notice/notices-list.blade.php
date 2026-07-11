
@extends('employeer.include.app')

@section('title', \App\Helpers\Helper::cachedTrans('Notice'))
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
				<h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Notice')}}</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
					<li class="breadcrumb-item"><a href="{{url('notification-dashboard')}}">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
					<li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Notice')}}</li>
				</ul>
			</div>
			<div class="col-auto float-end ms-auto">
				@if($user_type == 'employee')
				@foreach($sidebarItems['Rota'] as $rotaItem)
                    @if($rotaItem['submenu_name'] == 'Notice' && $rotaItem['can_add'] == 1)
				<a href="{{ url('notice/add-notice') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> {{\App\Helpers\Helper::cachedTrans('Add Notice')}}</a>
				    @endif
				@endforeach
				@elseif($user_type == 'employer')
				<a href="{{ url('notice/add-notice') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> {{\App\Helpers\Helper::cachedTrans('Add Notice')}}</a>
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
                        <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp; {{\App\Helpers\Helper::cachedTrans('Add Notice')}}
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
                                    <th>{{\App\Helpers\Helper::cachedTrans('Sl No.')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Title')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Start Date')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('End Date')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Notice For')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Status')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($notices as $datas)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $datas->title }}</td>
                                    <td>{{ $datas->start_date }}</td>
                                    <td>{{ $datas->end_date }}</td>
                                    <td>
                                        @if($datas->notice_for == 'all')
                                            <span class="badge badge-info">All Employees</span>
                                        @else
                                            <span class="badge badge-warning">
                                                @if($datas->notice_for)
                                                    @php
                                                        $employeeId = $datas->notice_for;
                                                        //dd($employeeId);
                                                        $emid = \App\Models\UserModel::where('id', $datas->created_by_id)->select('employee_id')->first();
                                                        //dd($emid);
                                                        $employee = \App\Models\Employee::where('emp_code', $employeeId)->where('emid', $emid->employee_id)->first(); 
                                                        //dd($employee);
                                                    @endphp
                                                    {{ $employee->emp_fname }}  {{ $employee->emp_mname }} {{ $employee->emp_lname }}<!-- Adjust field name as needed -->
                                                @else
                                                    Single Employee (ID: {{ $datas->notice_for }})
                                                @endif
                                            </span>
                                        @endif
                                    </td>
                                    <td>
                                        @php
                                            $currentDate = now();
                                            $startDate = \Carbon\Carbon::parse($datas->start_date);
                                            $endDate = \Carbon\Carbon::parse($datas->end_date);
                                        @endphp
                                    
                                        @if ($currentDate->between($startDate, $endDate))
                                            <span class="badge badge-success">Active</span>
                                        @else
                                            <span class="badge badge-danger">Expired</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="material-icons">more_vert</i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                @if($user_type == 'employee')
                                                    @foreach($sidebarItems['Rota'] as $rotaItem)
                                                        @if($rotaItem['submenu_name'] == 'Notice' && $rotaItem['can_edit'] == 1)
                                                            <a class="dropdown-item" href="{{ route('edit.notice', $datas->id) }}">
                                                                <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                @elseif($user_type == 'employer')
                                                    <a class="dropdown-item" href="{{ route('edit.notice', $datas->id) }}">
                                                        <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                    </a>
                                                @endif
                                                @if($user_type == 'employee')
                                                    @foreach($sidebarItems['Rota'] as $rotaItem)
                                                        @if($rotaItem['submenu_name'] == 'Notice' && $rotaItem['can_delete'] == 1)
                                                            <a class="dropdown-item" href="{{ route('delete.notice', $datas->id) }}">
                                                                <i class="fa-solid fa-trash m-r-5"></i> delete
                                                            </a>
                                                        @endif
                                                    @endforeach
                                                @elseif($user_type == 'employer')
                                                    <a class="dropdown-item" href="{{ route('delete.notice', $datas->id) }}">
                                                        <i class="fa-solid fa-trash m-r-5"></i> delete
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
	
<script>
    function confirmDelete(url) {
        if (confirm("Are you sure you want to delete this record?")) {
            window.location.href = url;
        }
    }
</script>

@endsection
