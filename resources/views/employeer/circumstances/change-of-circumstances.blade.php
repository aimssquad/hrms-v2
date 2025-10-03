@extends('employeer.include.app')

@section('title', \App\Helpers\Helper::cachedTrans('Change Notification List'))

@section('content')
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

    <!-- Page Content -->
    <div class="content container-fluid pb-0">

        <!-- Page Header -->
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Change Notification List')}}</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                        <li class="breadcrumb-item"><a href="{{url('organization/circumstances')}}">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
                        <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Change Notification List')}} </li>
                    </ul>
                </div>
                <div class="col-auto float-end ms-auto">
                    @if($user_type == 'employee')
                    @foreach($sidebarItems as $value)
                    @if($value['rights'] == 'Add' && $value['module_name'] == 4 && $value['menu'] == 49)
                    <!--<a href="{{ url('employee/change-of-circumstances-add-new') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Change Notification</a>-->
                    @endif
                    @endforeach
                    @elseif($user_type == 'employer')
                    <!--<a href="{{ url('employee/change-of-circumstances-add-new') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Change Notification</a>-->
                    @endif
                    {{-- <div class="view-icons">
                        <a href="{{url('organization/employeeee')}}" class="grid-view btn btn-link "><i class="fa fa-th"></i></a>
                        <a href="{{url('organization/emplist')}}" class="list-view btn btn-link active"><i class="fa-solid fa-bars"></i></a>
                    </div> --}}
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
                        <i class="far fa-bail" aria-hidden="true" style="color:#ffa318;"></i>&nbsp; {{\App\Helpers\Helper::cachedTrans('Change Notification List')}}
                    </h4>
                    <div class="row">
                       <div class="col-auto">
                           <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                               @csrf
                               <input type="hidden" name="data" id="data">
                               <input type="hidden" name="headings" id="headings">
                               <input type="hidden" name="filename" id="filename">
                               {{-- put the value - that is your file name --}}
                               <input type="hidden" id="filenameInput" value="Change-Of-Circumstances-List">
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
                                    <th>{{\App\Helpers\Helper::cachedTrans('Sl No .')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Joining Date')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Date of Change')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Employee Name')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Designation')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Employment Type')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Phone')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Nationality')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Visa Expiration')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Passport Expiration')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Remarks')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employee_rs as $change)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $change->emp_doj ?? 'NA' }}</td>
                                        <td>{{ date('d/m/Y', strtotime($change->date_confirm)) }}</td>
                                        <td>{{ $change->emp_fname }} {{ $change->emp_mname }} {{ $change->emp_lname }} </td>
                                        <td>{{ $change->emp_designation }}</td>
                                        <td>{{ $change->emp_status }}</td>
                                        <td>{{ $change->emp_ps_phone }}</td>
                                        <td>{{ $change->nationality }}</td>
                                        <td>{{ $change->visa_exp_date != '1970-01-01' ? date('d/m/Y', strtotime($change->visa_exp_date)) : 'N/A' }}</td>
                                        <td>{{ $change->pass_exp_date != '1970-01-01' ? date('d/m/Y', strtotime($change->pass_exp_date)) : 'N/A' }}</td>
                                        <td>{{ $change->remarks ?? 'None' }}</td>
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
