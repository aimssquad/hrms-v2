@extends('employeer.include.app')
@section('title', \App\Helpers\Helper::cachedTrans('Visitor List'))
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
            <h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Visitor List')}} </h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
               <li class="breadcrumb-item"><a href="{{url('rota-org/visitor-dashboard')}}">{{\App\Helpers\Helper::cachedTrans('Dashboard')}} </a></li>
               <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Visitor List')}}</li>
            </ul>
         </div>
      </div>
   </div>
   @include('employeer.layout.message')
   <!-- /Page Header -->
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h4 class="card-title">
                    <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;{{\App\Helpers\Helper::cachedTrans('Visitor List')}} 
                </h4>
                <div class="row">
                   <div class="col-auto">
                       <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                           @csrf
                           <input type="hidden" name="data" id="data">
                           <input type="hidden" name="headings" id="headings">
                           <input type="hidden" name="filename" id="filename">
                           {{-- put the value - that is your file name --}}
                           <input type="hidden" id="filenameInput" value="Vesitor-List">
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
                  <table id="basic-datatables" class="display table table-striped table-hover">
                     <thead>
                        <tr>
                            <th>{{\App\Helpers\Helper::cachedTrans('Sl No')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Name')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Designation')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Email ID')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Contact No')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Address')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Description')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Date')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Time')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Reference')}}</th>
                            <th>{{\App\Helpers\Helper::cachedTrans('Action')}}</th>
                        
                                </tr>
                     </thead>
                     <tbody>
                        <?php $i = 1; ?>
									@foreach($employee_type_rs as $candidate)
                                        <tr>
                                            
                                            <td>{{ $i}}</td>
											<td>{{ $candidate->name }}</td>
                                 <td>{{ $candidate->desig }}</td>
											<td>{{ $candidate->email }}</td>
											<td>{{ $candidate->phone_number }}</td>
											<td>{{ $candidate->address }}</td>
											<td>{{ $candidate->purpose }}</td>
											<td>{{ date('d/m/Y',strtotime($candidate->date)) }}</td>
											<td>{{ date('h:i a',strtotime($candidate->time)) }}</td>
											<td>{{ $candidate->reff }}</td>
											   
											{{-- <td>
											    <a href="{{url('rota-org/visitor-regis-edit/'.$candidate->id)}}" data-toggle="tooltip" data-placement="bottom" title="Edit"  ><img  style="width: 14px;" src="{{ asset('assets/img/edit.png')}}"></a>
											    <a href="{{url('rota-org/visitor-regis-deleted/'.$candidate->id)}}" data-toggle="tooltip" data-placement="bottom" title="Edit"  ><i class="fa fa-trash" aria-hidden="true"></i></a>
											</td> --}}
                                 <td class="text-end">
                                    
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="material-icons">more_vert</i>
                                            </a>
                                            
                                            <div class="dropdown-menu dropdown-menu-right">
                                                
                                                @if($user_type == 'employee')
                                                    @foreach($sidebarItems['Visitor Register'] as $rotaItem)
                                                        @if($rotaItem['submenu_name'] == 'Visitor List' && $rotaItem['can_edit'] == 1)
                                                                <a class="dropdown-item" href="{{url('rota-org/visitor-regis-edit/'.$candidate->id)}}">
                                                                    <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                                </a> 
                                                        @endif
                                                        @if($rotaItem['submenu_name'] == 'Visitor List' && $rotaItem['can_edit'] == 1)
                                                                <a class="dropdown-item" href="{{url('rota-org/visitor-regis-deleted/'.$candidate->id)}}">
                                                                    <i class="fa-regular fa-trash-can m-r-5"></i> Delete
                                                                </a> 
                                                        @endif
                                                    @endforeach
                                                @elseif($user_type == 'employer')
                                                        <a class="dropdown-item" href="{{url('rota-org/visitor-regis-edit/'.$candidate->id)}}">
                                                            <i class="fa-solid fa-pencil m-r-5"></i> Edit
                                                        </a>
                                                        <a class="dropdown-item" href="{{url('rota-org/visitor-regis-deleted/'.$candidate->id)}}">
                                                         <i class="fa-regular fa-trash-can m-r-5"></i> Delete
                                                     </a>
                                                @endif
                                            </div>
                                        </div>
                                    
                                </td>

						
											
                                        </tr>
                                        <?php
                                         $i++;?>
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
   
    </script>
@endsection