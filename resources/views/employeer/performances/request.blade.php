@extends('employeer.include.app')
@section('title', 'Appraisal Request List')
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
            <h3 class="page-title">Appraisal Request List</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{ url('org-performances/dashboard') }}">Performance Control Dashboard</a></li>
               <li class="breadcrumb-item active">Appraisal Request List</li>
            </ul>
         </div>
         <div class="col-auto float-end ms-auto">
            @if($user_type == 'employee')
            @foreach($sidebarItems as $value)
            @if($value['rights'] == 'Add' && $value['module_name'] == 4 && $value['menu'] == 49)
            <a href="{{url('org-performances/request')}}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Appraisal Request List</a>
            @endif
            @endforeach
            @elseif($user_type == 'employer')
            <a href="{{url('org-performances/request')}}" class="btn add-btn"><i class="fa-solid fa-plus"></i> Add Appraisal Request List</a>
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
   <?php $status = request()->get('status');
    ?>
   <div class="row">
    <div class="col-md-12">
        <div class="card custom-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">
                    <i class="far fa-user" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;Appraisal Request List
                </h4>
                <div>
                    <!-- Excel Link -->
                    <a href="path_to_excel_export" class="btn btn-success btn-sm">
                        <i class="fas fa-file-excel"></i> Export to Excel
                    </a>
                    
                    <!-- PDF Link -->
                    <a href="path_to_pdf_export" class="btn btn-info btn-sm">
                        <i class="fas fa-file-pdf"></i> Export to PDF
                    </a>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="basic-datatables" class="table table-striped custom-table">
                        <thead>
                            <tr>
                                <th>Sl. No.</th>
                                <th>Employee</th>
                                @if($currentUserType=='employer')
                                <th>Reporting Auth</th>
                                @endif
                                <!-- <th>Joing Date</th> -->
                                <th>Department</th>
                                <th>Apprisal Period Start </th>
                                <th>Apprisal Period End </th>
                                <th>Rating</th>
                                <th>Status</th>
                                <!-- <th>End Date</th> -->
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @foreach($performances as $k=>$p)
                            <tr>
                                <td>{{$k+1}}</td>
                                <td>{{$p->emp_fname}} {{$p->emp_mname?' '.$p->emp_mname:''}} {{$p->emp_lname?' '.$p->emp_lname:''}}</td>
                                @if($currentUserType=='employer')
                                <td>{{$p->rep_fname}} {{$p->rep_mname?' '.$p->rep_mname:''}} {{$p->rep_lname?' '.$p->rep_lname:''}}</td>
                                @endif
                                <td>{{$p->emp_department}}</td>
                                <td>{{date('d-m-Y', strtotime($p->apprisal_period_start))}}</td>
                                <td>{{date('d-m-Y', strtotime($p->apprisal_period_end))}}</td>
                                <td>{{ $p->rating}}</td>
                                <td>{{ ucfirst($p->status)}}</td>
                                <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                       <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                       <i class="material-icons">more_vert</i>
                                       </a>
                                       <div class="dropdown-menu dropdown-menu-right">
                                          @if($user_type == 'employee')
                                          @foreach($sidebarItems as $value)
                                          @if($value['rights'] == 'Add' && $value['module_name'] == 4 && $value['menu'] == 49)
                                          <a class="dropdown-item" href="{{url('/org-performances/request/'.encrypt($p->id))}}">
                                          <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                          </a>
                                          @endif
                                          @endforeach
                                          @elseif($user_type == 'employer')
                                          <a class="dropdown-item" href="{{url('/org-performances/request/'.encrypt($p->id))}}">
                                          <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                          </a>
                                          @endif
                                          @if($user_type == 'employee')
                                          @foreach($sidebarItems as $value)
                                          @if($value['rights'] == 'Add' && $value['module_name'] == 4 && $value['menu'] == 49)
                                          <a class="dropdown-item" href='{{url('org-performances/del/'.encrypt($p->id))}}' onclick="return confirm('Are you sure you want to delete this Access?');"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
                                          @endif
                                          @endforeach
                                          @elseif($user_type == 'employer')
                                          <a class="dropdown-item" href='{{url('org-performances/del/'.encrypt($p->id))}}' onclick="return confirm('Are you sure you want to delete this Access?');"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a>
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

@endsection