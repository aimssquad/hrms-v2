@extends('employeer.include.app')
@section('title', 'Right to Work checks')
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
            <h3 class="page-title"> Right to Work checks</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('org-dashboarddetails')}}">Sponsor Compliance Dashboard</a></li>
               <li class="breadcrumb-item active">Right to Work checks</li>
            </ul>
         </div>
         <div class="col-auto float-end ms-auto">
            @if($user_type == 'employee')
            @foreach($sidebarItems as $value)
            @if($value['rights'] == 'Add' && $value['module_name'] == 4 && $value['menu'] == 49)
            <a href="{{ url('org-add-right-works-by-datecheck') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Right to Work checks </a>
            @endif
            @endforeach
            @elseif($user_type == 'employer')
            <a href="{{ url('org-add-right-works-by-datecheck') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Right to Work checks</a>
            @endif
            {{-- 
            <div class="view-icons">
               <a href="{{url('organization/employeeee')}}" class="grid-view btn btn-link "><i class="fa fa-th"></i></a>
               <a href="{{url('organization/emplist')}}" class="list-view btn btn-link active"><i class="fa-solid fa-bars"></i></a>
            </div>
            --}}
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
                    <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Right to Work checks
                </h4>
                <div class="row">
                   <div class="col-auto">
                       <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                           @csrf
                           <input type="hidden" name="data" id="data">
                           <input type="hidden" name="headings" id="headings">
                           <input type="hidden" name="filename" id="filename">
                           {{-- put the value - that is your file name --}}
                           <input type="hidden" id="filenameInput" value="Right-to-Work-checks">
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
                    <table id="basic-datatables" class="display table table-striped table-hover">
                       <thead>
                          <tr>
                            <th>Employee ID</th>
                            <th>Employee Name</th>
                            <th>Date of check</th>
                            <th>Type of check</th>
                            <th>View</th>
                            <th>Download</th>
                            <th>Edit</th>
                          </tr>
                       </thead>
                       <tbody>
                        @foreach($employee_rs as $employee)
                        <?php
                           $employefgf=DB::table('employee')->where('emid', '=', $Roledata->reg )->where('emp_code', '=', $employee->employee_id )->first();
                           //dd($employee_rs);
                           ?>
                        <tr>
                           <td>{{ $employee->employee_id}}</td>
                           <td>{{ $employefgf->emp_fname }} {{ $employefgf->emp_mname }} {{ $employefgf->emp_lname }}</td>
                           <td>   {{ date('d/m/Y',strtotime($employee->date)) }} </td>
                           <td>{{ $employee->type }}</td>
                           <!-- <td> -->
                           <td class="icon"> <a data-toggle="tooltip" data-placement="bottom" title="View" href="{{ url('dashboard/work-view/'.base64_encode($employee->id)) }}" target="_blank" ><img  style="width: 14px;" src="{{ asset('assets/img/view.png')}}"></a></td>
                           <td class="icon"> <a data-toggle="tooltip" data-placement="bottom" title="Download" href="{{ url('dashboard/work-view-download/'.base64_encode($employee->id)) }}" target="_blank" ><img  style="width: 14px;" src="{{ asset('assets/img/download.png')}}"></a></td>
                           <td class="icon"> <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ url('org-dashboard/edit-work-view/'.base64_encode($employee->id)) }}" ><img  style="width: 15px;" src="{{ asset('assets/img/edit.png')}}"></a>
                           </td>
                           <!-- </td> -->
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
@endsection