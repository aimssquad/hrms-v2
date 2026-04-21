@extends('employeer.include.app')

@section('title', \App\Helpers\Helper::cachedTrans('Notifications'))
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
@endphp

@section('content')
@php
	function my_simple_crypt( $string, $action = 'encrypt' ) {
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
				<h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Notifications')}}</h3>
				<ul class="breadcrumb">
					<li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                    <li class="breadcrumb-item"><a href="{{url('notification-dashboard')}}">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
					<li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Notifications')}}</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /Page Header -->	
	
	<!-- Main Notifications Table -->
	<div class="row">
		<div class="col-md-12">
            <div class="card custom-card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="card-title">
                        <i class="far fa-bell" aria-hidden="true" style="color:#ffa318;"></i>&nbsp; {{\App\Helpers\Helper::cachedTrans('All Notifications')}}
                    </h4>
                    <div class="row">
                        <div class="col-auto">
                            <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                                @csrf
                                <input type="hidden" name="data" id="data">
                                <input type="hidden" name="headings" id="headings">
                                <input type="hidden" name="filename" id="filename">
                                <input type="hidden" id="filenameInput" value="Notification_Report">
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
                                    <th>{{\App\Helpers\Helper::cachedTrans('Notification Type')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Title')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Description')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Notification For')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Is Read')}}</th>
                                    <th>{{\App\Helpers\Helper::cachedTrans('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    // Sort collection: unread first, then read
                                    $sortedNotices = $notices->sortBy('is_read');
                                    // Or use: $sortedNotices = $notices->sortBy('is_read');
                                @endphp
                                
                                @foreach($sortedNotices as $index => $datas)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $datas->type }}</td>
                                    <td>{{ $datas->title }}</td>
                                    <td>{{ Str::limit($datas->description, 100) }}</td>
                                    <td>
                                        @if($datas->employee_full_name)
                                            <span class="badge badge-info">
                                                {{ $datas->employee_full_name }}
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">All Employees</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($datas->is_read == 1)
                                            <span class="badge badge-success">Read</span>
                                        @else
                                            <span class="badge badge-warning">Unread</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <div class="dropdown dropdown-action">
                                            <a href="#" class="action-icon dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="material-icons">more_vert</i>
                                            </a>
                                            <div class="dropdown-menu dropdown-menu-right">
                                                <a class="dropdown-item view-notification" href="#" 
                                                   data-title="{{ $datas->title }}" 
                                                   data-description="{{ $datas->description }}" 
                                                   data-employee="{{ $datas->employee_full_name ?: 'All Employees' }}" 
                                                   data-start-date="{{ $datas->start_date ? \Carbon\Carbon::parse($datas->start_date)->format('d M Y') : 'N/A' }}"
                                                   data-end-date="{{ $datas->end_date ? \Carbon\Carbon::parse($datas->end_date)->format('d M Y') : 'N/A' }}"
                                                   data-created-date="{{ \Carbon\Carbon::parse($datas->created_at)->format('d M Y, h:i A') }}"
                                                   data-type="{{ $datas->type }}">
                                                    <i class="fa-solid fa-eye m-r-5"></i> View Details
                                                </a>
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

<!-- Beautiful Modal Design -->
<div class="modal fade" id="viewNotificationModal" tabindex="-1" role="dialog" aria-labelledby="viewNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content" style="border-radius: 15px; overflow: hidden;">
            <div class="modal-header" style="background: #FF902F; color: white; border: none;">
                <h5 class="modal-title" id="viewNotificationModalLabel">
                    <i class="fa fa-bell" style="margin-right: 10px;"></i> Notification Details
                </h5>
                {{-- <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close" style="color: white; opacity: 1;">
                    <span aria-hidden="true">&times;</span>
                </button> --}}
            </div>
            <div class="modal-body" style="padding: 30px;">
                <!-- Notification Type Badge -->
                <div class="text-center mb-4">
                    <span id="modal-type-badge" class="badge" style="font-size: 14px; padding: 8px 20px; border-radius: 20px; background: #FF902F;"></span>
                </div>
                
                <!-- Title Section -->
                <div class="form-group mb-4">
                    <label style="font-weight: 600; color: #080808; margin-bottom: 10px; display: block;">
                        <i class="fa fa-tag" style="margin-right: 8px;"></i> Title
                    </label>
                    <div style="background: #FFF8F0; padding: 15px; border-radius: 10px; border-left: 4px solid #FF902F;">
                        <p id="modal-title" style="margin: 0; font-size: 16px; font-weight: 500; color: #333;"></p>
                    </div>
                </div>
                
                <!-- Description Section -->
                <div class="form-group mb-4">
                    <label style="font-weight: 600; color: #FF902F; margin-bottom: 10px; display: block;">
                        <i class="fa fa-align-left" style="margin-right: 8px;"></i> Description
                    </label>
                    <div style="background-color: #FFF8F0; padding: 15px; border-radius: 10px; border-left: 4px solid #FF902F;">
                        <p id="modal-description" style="margin: 0; white-space: pre-wrap; line-height: 1.6; color: #555;"></p>
                    </div>
                </div>
                
                <!-- Two Column Grid for Details -->
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="info-card" style="background: #FFF8F0; padding: 12px; border-radius: 8px; border: 1px solid #FFE0B5;">
                            <label style="font-size: 12px; color: #FF902F; margin-bottom: 5px; display: block;">
                                <i class="fa fa-users"></i> Notification For
                            </label>
                            <p id="modal-employee" style="margin: 0; font-weight: 500; color: #333;"></p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-card" style="background: #FFF8F0; padding: 12px; border-radius: 8px; border: 1px solid #FFE0B5;">
                            <label style="font-size: 12px; color: #FF902F; margin-bottom: 5px; display: block;">
                                <i class="fa fa-calendar"></i> Sent Date & Time
                            </label>
                            <p id="modal-date" style="margin: 0; font-weight: 500; color: #333;"></p>
                        </div>
                    </div>
                </div>
                
                <!-- Start and End Date Row -->
                {{-- <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="info-card" style="background: #FFF8F0; padding: 12px; border-radius: 8px; border: 1px solid #FFE0B5;">
                            <label style="font-size: 12px; color: #FF902F; margin-bottom: 5px; display: block;">
                                <i class="fa fa-calendar-check"></i> Start Date
                            </label>
                            <p id="modal-start-date" style="margin: 0; font-weight: 500; color: #28a745;"></p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="info-card" style="background: #FFF8F0; padding: 12px; border-radius: 8px; border: 1px solid #FFE0B5;">
                            <label style="font-size: 12px; color: #FF902F; margin-bottom: 5px; display: block;">
                                <i class="fa fa-calendar-times"></i> End Date
                            </label>
                            <p id="modal-end-date" style="margin: 0; font-weight: 500; color: #dc3545;"></p>
                        </div>
                    </div>
                </div> --}}
            </div>
            <div class="modal-footer" style="border-top: 1px solid #FFE0B5; padding: 15px 30px;">
                <button type="button" class="btn" data-bs-dismiss="modal" style="border-radius: 20px; padding: 8px 25px; background: #FF902F; color: white; border: none;">
                    <i class="fa fa-times"></i> Close
                </button>
            </div>
        </div>
    </div>
</div>

<!-- /Page Content -->
@endsection

@section('script')
<script>
$(document).ready(function() {
    // View notification details
    $(document).on('click', '.view-notification', function(e) {
        e.preventDefault();
        
        // Get data from the clicked link
        var title = $(this).data('title');
        var description = $(this).data('description');
        var employee = $(this).data('employee');
        var startDate = $(this).data('start-date');
        var endDate = $(this).data('end-date');
        var createdDate = $(this).data('created-date');
        var type = $(this).data('type');
        
        // Set values in modal
        $('#modal-title').text(title);
        $('#modal-description').text(description);
        $('#modal-employee').html('<span style="color: #667eea;">' + employee + '</span>');
        $('#modal-date').html('<span style="color: #764ba2;">' + createdDate + '</span>');
        // $('#modal-start-date').html('<span>' + (startDate || 'N/A') + '</span>');
        // $('#modal-end-date').html('<span>' + type + '</span>');
        
        // Set notification type badge
        var typeBadge = $('#modal-type-badge');
        if (type == 'NOTICE') {
            typeBadge.text('📢 NOTICE');
            typeBadge.css('background', 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)');
            typeBadge.css('color', 'white');
        } else {
            typeBadge.text(type);
            typeBadge.css('background', '#6c757d');
            typeBadge.css('color', 'white');
        }
        
        // Show modal
        $('#viewNotificationModal').modal('show');
    });
});
</script>

<style>
    #modal-title, #modal-description {
        word-wrap: break-word;
        white-space: pre-wrap;
    }
    .modal-body p {
        margin-bottom: 0;
        font-size: 14px;
    }
    .modal-body label {
        font-weight: 600;
        margin-bottom: 8px;
        color: #333;
    }
    .info-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .info-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
    }
    .table-striped tbody tr:nth-of-type(odd) {
        background-color: rgba(0,0,0,.02);
    }
    .badge {
        font-size: 12px;
        padding: 5px 10px;
    }
    .dropdown-menu {
        border-radius: 8px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
    /* .dropdown-item:hover {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
    } */
</style>
@endsection