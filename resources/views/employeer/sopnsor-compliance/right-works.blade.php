@extends('employeer.include.app')
@section('title', \App\Helpers\Helper::cachedTrans('Right to Work checks'))
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
            <h3 class="page-title">{{\App\Helpers\Helper::cachedTrans("Right to Work checks")}} </h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans("Home")}}</a></li>
               <li class="breadcrumb-item"><a href="{{url('org-dashboarddetails')}}">{{\App\Helpers\Helper::cachedTrans("Sponsor Compliance Dashboard")}}</a></li>
               <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans("Right to Work checks")}}</li>
            </ul>
         </div>
         <div class="col-auto float-end ms-auto">
            @if($user_type ==="employee")
            @foreach($sidebarItems['Sponsor Compliances'] as $rotaItem)
                @if($rotaItem['submenu_name'] == 'Sponsor Compliances' && $rotaItem['can_add'] == 1)
            <a href="{{ url('org-add-right-works-by-datecheck') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i>{{\App\Helpers\Helper::cachedTrans("Add Right to Work checks")}}  </a>
            @endif
            @endforeach
            @elseif($user_type == 'employer')
            <a href="{{ url('org-add-right-works-by-datecheck') }}" class="btn add-btn"><i class="fa-solid fa-plus"></i>{{\App\Helpers\Helper::cachedTrans("Add Right to Work checks")}} </a>
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
                    <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;{{\App\Helpers\Helper::cachedTrans("Right to Work checks")}}
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
                               <i class="fas fa-file-excel"></i> {{\App\Helpers\Helper::cachedTrans("Export to Excel")}}
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
                             <i class="fas fa-file-pdf"></i> {{\App\Helpers\Helper::cachedTrans("Export to PDF")}}
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
                            <th>{{\App\Helpers\Helper::cachedTrans("Employee ID")}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans("Employee Name")}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans("Date of check")}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans("Type of check")}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans("View")}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans("Download")}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans("Action")}}</th>
                          </tr>
                       </thead>
                       <tbody>
                        @foreach($employee_rs as $employee)
                        <?php
                           $employefgf=DB::table('employee')->where('emid', '=', Session::get('emid') )->where('emp_code', '=', $employee->employee_id )->first();
                           //dd($employee_rs);
                           ?>
                        <tr>
                           <td>{{ $employee->employee_id}}</td>
                           <td>{{ $employefgf->emp_fname }} {{ $employefgf->emp_mname }} {{ $employefgf->emp_lname }}</td>
                           <td>{{ date('d/m/Y',strtotime($employee->date)) }}</td>
                           <td>{{ $employee->type }}</td>
                           <!-- <td> -->
                           <td class="icon"> <a data-toggle="tooltip" data-placement="bottom" title="View" href="{{ url('dashboard/work-view/'.base64_encode($employee->id)) }}" target="_blank" ><img  style="width: 14px;" src="{{ asset('assets/img/view.png')}}"></a></td>
                           <td class="icon"> <a data-toggle="tooltip" data-placement="bottom" title="Download" href="{{ url('dashboard/work-view-download/'.base64_encode($employee->id)) }}" target="_blank" ><img  style="width: 14px;" src="{{ asset('assets/img/download.png')}}"></a></td>
                           {{-- <td class="icon"> <a data-toggle="tooltip" data-placement="bottom" title="Edit" href="{{ url('org-dashboard/edit-work-view/'.base64_encode($employee->id)) }}" ><img  style="width: 15px;" src="{{ asset('assets/img/edit.png')}}"></a>
                           </td> --}}
                           <td class="text-end">
                                <div class="dropdown dropdown-action">
                                    <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{ url('org-dashboard/edit-work-view/'.base64_encode($employee->id)) }}">
                                            <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                        </a>

                                        <a class="dropdown-item" href="{{ url('org-dashboard/delete-work-view/'.base64_encode($employee->id)) }}"
                                             onclick="return confirm('Are you sure you want to delete this record?')">
                                            <i class="fa-solid fa-trash m-r-5"></i> Delete
                                        </a>
                                    </div>
                                </div>
                            
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