@extends('employeer.include.app')
@section('title', \App\Helpers\Helper::cachedTrans('Project Roles'))
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
            <h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Project Roles')}} </h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
               <li class="breadcrumb-item"><a href="{{url('org-task-management/dashboard')}}">{{\App\Helpers\Helper::cachedTrans('Project Control Dashboard')}}</a></li>
               <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Roles')}}</li>
            </ul>
         </div>
         <div class="col-auto float-end ms-auto">
            <a href="{{url('project-controll/add-rolle')}}" class="btn add-btn"><i class="fa-solid fa-plus"></i>{{\App\Helpers\Helper::cachedTrans('Add Role')}} </a>
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
                   <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp; {{\App\Helpers\Helper::cachedTrans('Project List')}}
               </h4>
               <div class="row">
                  <div class="col-auto">
                      <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                          @csrf
                          <input type="hidden" name="data" id="data">
                          <input type="hidden" name="headings" id="headings">
                          <input type="hidden" name="filename" id="filename">
                          {{-- put the value - that is your file name --}}
                          <input type="hidden" id="filenameInput" value="Process-Attendence">
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
                          <th> {{\App\Helpers\Helper::cachedTrans('Sl No.')}}</th>
                          <th> {{\App\Helpers\Helper::cachedTrans('Roles')}}</th>
                          <th> {{\App\Helpers\Helper::cachedTrans('Action')}}</th>
                        </tr>
                     </thead>
                     <tbody>
                        @foreach($roles as $role)
                            <tr>
                                <td>{{$loop->iteration}}</td>
                                <td>{{$role->name}}</td>
                                <td class="text-end">
                                    <div class="dropdown dropdown-action">
                                        <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="material-icons">more_vert</i>
                                        </a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="{{url('/project-controll/rolles-edit/'.encrypt($role->id))}}">
                                            <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                        </a>
                                        <a class="dropdown-item" href="{{url('/project-controll/rolles/delete/'.encrypt($role->id))}}" onclick="return confirm('Are you sure you want to delete this Access?');"><i class="fa-regular fa-trash-can m-r-5"></i> Delete</a> 
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
</script>
@endsection