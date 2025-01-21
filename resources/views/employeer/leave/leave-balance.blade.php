@extends('employeer.include.app')
@section('title', 'Leave Accrued')
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
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Leave Accrued</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('leave/dashboard')}}">Dashboard</a></li>
               <li class="breadcrumb-item active">Leave Accrued</li>
            </ul>
         </div>
      </div>
   </div>
   <!-- Page Header -->
   <div class="page-header">
      @if(Session::has('message'))										
      <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
      @endif
   </div>
   <!-- /Page Header -->
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-header d-flex justify-content-between align-items-center">
               <h4 class="card-title">
                  <i class="far fa-hourglass" aria-hidden="true" style="color:#ffa318;"></i>&nbsp; Leave Accrued
               </h4>
               <?php
                  if(count($leave_balance_rs)!=0  ){
               ?>
                  <div class="d-flex align-items-center">
                     <form  method="post" action="{{ url('leave-management/leave-balance') }}" enctype="multipart/form-data" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button data-toggle="tooltip" data-placement="bottom" title="Download PDF" 
                           class="btn btn-download btn-download-pdf me-3" type="submit">
                        Export to PDF
                        </button>
                     </form>
                     <form  method="post" action="{{ url('leave-management/leave-balance-excel') }}" enctype="multipart/form-data" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <button data-toggle="tooltip" data-placement="bottom" title="Download Excel" 
                           class="btn btn-download btn-download-excel" type="submit">
                        Export to Excel
                        </button>
                     </form>
                  </div>
               <?php
                  }?>
            </div>
         </div>
         <div class="card-body">
            <div class="table-responsive">
               <table class="table table-striped custom-table " id="basic-datatables">
                  <thead>
                     <tr>
                        <th>Sl.No.</th>
                        <th>Employee Code</th>
                        <th>Employee Name</th>
                        <th>Leave Type</th>
                        <th>Leave Balance</th>
                     </tr>
                  </thead>
                  <tbody>
                     @foreach($leave_balance_rs as $leave_balance)
                     <tr>
                        <td>{{$loop->iteration}}</td>
                        <td>{{ $leave_balance->emp_code }}</td>
                        <td>{{ $leave_balance->emp_fname.' '.$leave_balance->emp_mname.' '.$leave_balance->emp_lname }}</td>
                        <td>{{ $leave_balance->leave_type_name }}</td>
                        <td>{{ $leave_balance->leave_in_hand }}</td>
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

@endsection