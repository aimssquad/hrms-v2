@extends('employeer.include.app')
@section('title', \App\Helpers\Helper::cachedTrans('Search'))
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
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
	<!-- Page Header -->
	<div class="page-header">
		<div class="row align-items-center">
			<div class="col">
				<h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Search')}}</h3>
				<ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
               <li class="breadcrumb-item"><a href="{{url('recruitment/dashboard')}}">{{\App\Helpers\Helper::cachedTrans('Recruitment Dashboard')}}</a></li>
					<li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Search')}}</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /Page Header -->
   @include('employeer.layout.message')
    <div class="row">
        <div class="col-md-12">
           <div class="card custom-card">
              <div class="card-body">
                 <form  method="post" action="{{ url('org-recruitment/search') }}" enctype="multipart/form-data" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row form-group">
                       <div class="col-md-3">
                          <div class=" form-group current-stage">
                             <label for="inputFloatingLabel-recruitment" class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Current Stage of Recruitment')}}</label>
                             <select id="inputFloatingLabel-recruitment" name="status" class="select" required=""  style="">
                                <option value="">Select</option>
                                <option value="Application Received"  <?php if(isset($status) && $status=='Application Received') { echo 'selected';}?>>{{\App\Helpers\Helper::cachedTrans('Application Received')}}</option>
                                <option value="Short listed" <?php if(isset($status) && $status=='Short listed') { echo 'selected';}?>>{{\App\Helpers\Helper::cachedTrans('Short listed')}}</option>
                                <option value="Interview" <?php if(isset($status) && $status=='Interview') { echo 'selected';}?>>{{\App\Helpers\Helper::cachedTrans('Interview')}}</option>
                                <option value="Online Screen Test"  <?php if(isset($status) && $status=='Online Screen Test') { echo 'selected';}?> >{{\App\Helpers\Helper::cachedTrans('Online Screen Test')}}</option>
                                <option value="Written Test"   <?php if(isset($status) && $status=='Written Test') { echo 'selected';}?> >{{\App\Helpers\Helper::cachedTrans('Written Test')}}</option>
                                <option value="Telephone Interview"   <?php if(isset($status) && $status=='Telephone Interview') { echo 'selected';}?> >{{\App\Helpers\Helper::cachedTrans('Telephone Interview')}}</option>
                                <option value="Face to Face Interview"   <?php if(isset($status) && $status=='Face to Face Interview') { echo 'selected';}?> >{{\App\Helpers\Helper::cachedTrans('Face to Face Interview')}}</option>
                                <option value="Job Offered" <?php if(isset($status) && $status=='Job Offered') { echo 'selected';}?>>{{\App\Helpers\Helper::cachedTrans('Job Offered')}}</option>
                                <option  value="Hired" <?php if(isset($status) && $status=='Hired') { echo 'selected';}?>>{{\App\Helpers\Helper::cachedTrans('Hired')}}</option>
                                <option value="Hold"  <?php if(isset($status) && $status=='Hold') { echo 'selected';}?>>{{\App\Helpers\Helper::cachedTrans('Hold')}}</option>
                                <option value="Rejected" <?php if(isset($status) && $status=='Rejected') { echo 'selected';}?>>{{\App\Helpers\Helper::cachedTrans('Rejected')}}</option>
                             </select>
                          </div>
                       </div>
                       <div class="col-md-3">
                          <div class=" form-group current-stage">
                             <label for="inputFloatingLabel-recruitment" class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Job Title')}} </label>
                             <select id="job_id" name="job_id" class="select"  style="">
                                <option value="">Select</option>
                                @foreach($company_job_rs as $dept)
                                <option value="{{$dept->id}}">{{\App\Helpers\Helper::cachedTrans($dept->title)}}  (Job Code :{{$dept->job_code}} )</option>
                                @endforeach
                             </select>
                          </div>
                       </div>
                       <div class="col-md-3">
                          <div class=" form-group">
                             <label for="inputFloatingLabel-select-date"  class="col-form-label">{{\App\Helpers\Helper::cachedTrans('From Date')}}</label>
                             <input id="inputFloatingLabel-select-date" value="<?php if(isset($start_date) && $start_date) { echo $start_date;}?>"  name="start_date" type="date" class="form-control input-border-bottom" required="" style="">
                          </div>
                       </div>
                       <div class="col-md-3">
                          <div class=" form-group">
                             <label for="inputFloatingLabel-select-date"  class="col-form-label">{{\App\Helpers\Helper::cachedTrans('To Date')}}</label>
                             <input id="inputFloatingLabel-select-date" name="end_date" value="<?php if(isset($end_date) && $end_date) { echo $end_date;}?>"  type="date" class="form-control input-border-bottom" required="" style="">
                          </div>
                       </div>
                       <div class="col-md-3">
                          <button class="btn btn-primary" style="margin-top: 25px;" type="submit">{{\App\Helpers\Helper::cachedTrans('Submit')}}</button>
                       </div>
                    </div>
                 </form>
              </div>
           </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
           <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
               <h4 class="card-title">
                  <i class="far fa-file" aria-hidden="true" style="color:#ffa318;"></i>&nbsp;{{\App\Helpers\Helper::cachedTrans('Search')}}
              </h4>
              <div class="row">
                 <div class="col-auto">
                     <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                         @csrf
                         <input type="hidden" name="data" id="data">
                         <input type="hidden" name="headings" id="headings">
                         <input type="hidden" name="filename" id="filename">
                         {{-- put the value - that is your file name --}}
                         <input type="hidden" id="filenameInput" value="Search">
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
                 <?php
                    if(isset($result) && $result!=''  ){
                                                                ?>
                 <form  method="post" action="{{ url('recruitment/search-result') }}" enctype="multipart/form-data" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input id="inputFloatingLabel-select-date" value="<?php if(isset($status) && $status) { echo $status;}?>"  name="status" type="hidden" class="form-control input-border-bottom" required="" >
                    <input id="inputFloatingLabel-select-date" value="<?php if(isset($start_date) && $start_date) { echo $start_date;}?>"  name="start_date" type="hidden" class="form-control input-border-bottom" required="" >
                    <input id="inputFloatingLabel-select-date" name="end_date" value="<?php if(isset($end_date) && $end_date) { echo $end_date;}?>"  type="hidden" class="form-control input-border-bottom" required="" >					
                    <input id="inputFloatingLabel-select-date" name="job_id" value="<?php if(isset($job_id) && $job_id) { echo $job_id;}?>"  type="hidden" class="form-control input-border-bottom" required="" >					
                    <button class="btn btn-default" style="margin-top: -30px;float:right;" type="submit">{{\App\Helpers\Helper::cachedTrans('Download Pdf')}}</button>	
                 </form>
                 <?php
                    }?>
                 <?php
                    if(isset($result) && $result!=''  ){
                                                                ?>
                 <form  method="post" action="{{ url('recruitment/search-result-excel') }}" enctype="multipart/form-data" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input id="inputFloatingLabel-select-date" value="<?php if(isset($status) && $status) { echo $status;}?>"  name="status" type="hidden" class="form-control input-border-bottom" required="" >
                    <input id="inputFloatingLabel-select-date" value="<?php if(isset($start_date) && $start_date) { echo $start_date;}?>"  name="start_date" type="hidden" class="form-control input-border-bottom" required="" >
                    <input id="inputFloatingLabel-select-date" name="end_date" value="<?php if(isset($end_date) && $end_date) { echo $end_date;}?>"  type="hidden" class="form-control input-border-bottom" required="" >					
                    <input id="inputFloatingLabel-select-date" name="job_id" value="<?php if(isset($job_id) && $job_id) { echo $job_id;}?>"  type="hidden" class="form-control input-border-bottom" required="" >					
                    <button class="btn btn-default" style="margin-top: -30px;float:right;margin-right: 15px;" type="submit">{{\App\Helpers\Helper::cachedTrans('Download Excel')}}</button>	
                 </form>
                 <?php
                    }?>
              </div>
              <div class="card-body">
                 <div class="table-responsive">
                    <table id="basic-datatables" class="display table table-striped table-hover" >
                       <thead>
                          <tr>
                             <th>{{\App\Helpers\Helper::cachedTrans('Job Code')}}</th>
                             <th>{{\App\Helpers\Helper::cachedTrans('Job Title')}}</th>
                             <th>{{\App\Helpers\Helper::cachedTrans('Candidate')}}</th>
                             <th>{{\App\Helpers\Helper::cachedTrans('Email')}}</th>
                             <th>{{\App\Helpers\Helper::cachedTrans('Contact Number')}}</th>
                             <th>{{\App\Helpers\Helper::cachedTrans('Status')}}</th>
                             <th>{{\App\Helpers\Helper::cachedTrans('Date')}}</th>
                             <th>{{\App\Helpers\Helper::cachedTrans('Action')}}</th>
                          </tr>
                       </thead>
                       <tbody>
                          <?php
                             if(isset($result) && $result!=''  ){
                                                                              print_r($result); 
                             }?>
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

