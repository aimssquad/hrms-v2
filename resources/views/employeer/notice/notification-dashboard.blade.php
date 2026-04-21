@extends('employeer.include.app')

@section('title', \App\Helpers\Helper::cachedTrans('Dashboard'))
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
					<li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- /Page Header -->

    <div class="row">
        <div class="col-xl-4 col-md-6 col-sm-12">
            <a href="{{url('all-notification')}}" class="modern-card-link">
                <div class="modern-card">
                    <div class="modern-card-header">
                        <div class="modern_icon_wrapper">
                            <i class="la la-bell modern-icon"></i>
                        </div>
                        <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans('All Notifications')}}</h4>
                    </div>
                    <div class="modern-card-body">
                        <div class="modern-status">
                            </div>
                            <div class="modern-arrow">
                            <span class="employee-count">{{ $totalNotifications }}</span>
                            <i class="fa fa-arrow-right"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
        <div class="col-xl-4 col-md-6 col-sm-12">
            <a href="" class="modern-card-link">
                <div class="modern-card">
                    <div class="modern-card-header">
                        <div class="modern_icon_wrapper">
                            <i class="la la-list modern-icon"></i>
                        </div>
                        <h4 class="modern-card-title">{{\App\Helpers\Helper::cachedTrans('Notice')}}</h4>
                    </div>
                    <div class="modern-card-body">
                        <div class="modern-status">
                            </div>
                            <div class="modern-arrow">
                            <span class="employee-count">{{$noticeCount}}</span>
                            <i class="fa fa-arrow-right"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>
	<br>
	<!-- Statistics Cards -->
	<div class="row">
		{{-- <div class="col-md-3">
			<div class="card dash-widget">
				<div class="card-body">
					<span class="dash-widget-icon"><i class="fa fa-bell"></i></span>
					<div class="dash-widget-info">
						<h3>{{ $totalNotifications }}</h3>
						<span>Total Notifications</span>
					</div>
				</div>
			</div>
		</div> --}}
		<div class="col-md-4">
			<div class="card dash-widget">
				<div class="card-body">
					<span class="dash-widget-icon" style="background: #fd0202;"><i class="fa fa-envelope"></i></span>
					<div class="dash-widget-info">
						<h3 style="color: #ff0000;">{{ $unreadNotifications }}</h3>
						<span>Unread Notifications</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card dash-widget">
				<div class="card-body">
					<span class="dash-widget-icon" style="background: #28a745;"><i class="fa fa-check-circle"></i></span>
					<div class="dash-widget-info">
						<h3 style="color: #28a745;">{{ $readNotifications }}</h3>
						<span>Read Notifications</span>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4">
			<div class="card dash-widget">
				<div class="card-body">
					<span class="dash-widget-icon" style="background: #17a2b8;"><i class="fa fa-chart-line"></i></span>
					<div class="dash-widget-info">
						<h3 style="color: #17a2b8;">{{ $readPercentage }}%</h3>
						<span>Read Rate</span>
					</div>
				</div>
			</div>
		</div>
	</div>
	
	<!-- Unread Notifications by Employee Section -->
	@if($unreadByEmployee->count() > 0)
	<div class="row">
		<div class="col-md-12">
			<div class="card custom-card">
				<div class="card-header">
					<h4 class="card-title">
						<i class="fa fa-users" aria-hidden="true" style="color:#ffa318;"></i>&nbsp; 
						Employees with Unread Notifications ({{ $unreadByEmployee->count() }} employees)
					</h4>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table class="table table-striped">
							<thead>
								<tr>
									<th>Sl No.</th>
									<th>Employee Name</th>
									<th>Total Notifications</th>
									<th>Unread Notifications</th>
									<th>Read Rate</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody>
								@foreach($unreadByEmployee as $index => $employee)
									@php
										$employeeData = [
											'employee_name' => $employee['employee_name'] ?? 'Unknown',
											'employee_id' => $employee['employee_id'] ?? '',
											'total_count' => $employee['total_count'] ?? 0,
											'unread_count' => $employee['unread_count'] ?? 0,
											'read_count' => $employee['read_count'] ?? 0,
											'read_percentage' => $employee['read_percentage'] ?? 0,
											'notifications' => $employee['notifications'] ?? collect()
										];
									@endphp
									<tr class="employee-row" data-employee-id="{{ $employeeData['employee_id'] }}">
										<td>{{ $loop->iteration }}</td>
										<td>
											<strong>{{ $employeeData['employee_name'] }}</strong>
											@if(empty($employeeData['employee_id']))
												<span class="badge badge-secondary">General</span>
											@endif
										</td>
										<td>
												<span class="badge badge-info" style="font-size: 14px;">
													{{ $employeeData['total_count'] }} total
												</span>
											</td>
											<td>
												<span class="badge badge-warning" style="font-size: 14px;">
													{{ $employeeData['unread_count'] }} unread
												</span>
											</td>
											<td>
												@if($employeeData['read_percentage'] >= 80)
													<span class="badge badge-success">{{ $employeeData['read_percentage'] }}% read</span>
												@elseif($employeeData['read_percentage'] >= 50)
													<span class="badge badge-info">{{ $employeeData['read_percentage'] }}% read</span>
												@elseif($employeeData['read_percentage'] > 0)
													<span class="badge badge-warning">{{ $employeeData['read_percentage'] }}% read</span>
												@else
													<span class="badge badge-danger">0% read</span>
												@endif
											</td>
											<td>
												<button class="btn btn-sm btn-primary toggle-employee-notifications" data-employee-id="{{ $employeeData['employee_id'] }}">
													<i class="fa fa-eye"></i> View Unread
												</button>
												@if($employeeData['unread_count'] > 0)
													{{-- <button class="btn btn-sm btn-success mark-all-read" data-employee-id="{{ $employeeData['employee_id'] }}" data-employee-name="{{ $employeeData['employee_name'] }}">
														<i class="fa fa-check-double"></i> Mark All Read
													</button> --}}
												@endif
											</td>
										</tr>
										<!-- Expanded row for unread notifications -->
										<tr class="employee-notifications-{{ $employeeData['employee_id'] }}" style="display: none;">
											<td colspan="6">
												<div class="card mb-2">
													<div class="card-body">
														<div class="d-flex justify-content-between align-items-center mb-3">
															<h6>Unread Notifications for {{ $employeeData['employee_name'] }}:</h6>
															@if($employeeData['unread_count'] > 0)
																{{-- <button class="btn btn-sm btn-success mark-all-read-inline" data-employee-id="{{ $employeeData['employee_id'] }}">
																	<i class="fa fa-check-double"></i> Mark All as Read
																</button> --}}
															@endif
														</div>
														
														@if($employeeData['notifications']->count() > 0)
															<ul class="list-group">
																@foreach($employeeData['notifications'] as $notification)
																	<li class="list-group-item">
																		<div class="d-flex justify-content-between align-items-center">
																			<div style="flex: 1;">
																				<strong>{{ $notification->title }}</strong>
																				<p class="mb-0 text-muted">{{ Str::limit($notification->description, 100) }}</p>
																				<small class="text-muted">Sent: {{ \Carbon\Carbon::parse($notification->created_at)->format('d M Y, h:i A') }}</small>
																			</div>
																			<div>
																				<span class="badge badge-warning mr-2">Unread</span>
																				{{-- <a href="#" class="btn btn-sm btn-success mark-read-single" data-id="{{ $notification->id }}">
																					<i class="fa fa-check"></i> Mark as Read
																				</a> --}}
																			</div>
																		</div>
																	</li>
																@endforeach
															</ul>
														@else
															<div class="alert alert-success mb-0">
																<i class="fa fa-check-circle"></i> No unread notifications for this employee!
															</div>
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
	@else
	<div class="row">
		<div class="col-md-12">
			<div class="alert alert-success">
				<i class="fa fa-check-circle"></i> Great! All notifications have been read by employees.
			</div>
		</div>
	</div>
	@endif
</div>

<!-- View Notification Modal -->
<div class="modal fade" id="viewNotificationModal" tabindex="-1" role="dialog" aria-labelledby="viewNotificationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="viewNotificationModalLabel">Notification Details</h5>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label><strong>Title:</strong></label>
                    <p id="modal-title"></p>
                </div>
                <div class="form-group">
                    <label><strong>Description:</strong></label>
                    <p id="modal-description"></p>
                </div>
                <div class="form-group">
                    <label><strong>Notification For:</strong></label>
                    <p id="modal-employee"></p>
                </div>
                <div class="form-group">
                    <label><strong>Sent Date:</strong></label>
                    <p id="modal-date"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
    
    $(document).ready(function() {
        // Toggle employee notifications
        $('.toggle-employee-notifications').click(function() {
            var employeeId = $(this).data('employee-id');
            var targetRow = $('.employee-notifications-' + employeeId);
            var $this = $(this);
            
            targetRow.toggle();
            
            // Change button text
            if (targetRow.is(':visible')) {
                $this.html('<i class="fa fa-eye-slash"></i> Hide Notifications');
            } else {
                $this.html('<i class="fa fa-eye"></i> View Unread');
            }
        });
        
     
        
        // View notification details
        $(document).on('click', '.view-notification', function(e) {
            e.preventDefault();
            var title = $(this).data('title');
            var description = $(this).data('description');
            var employee = $(this).data('employee');
            var date = $(this).data('date');
            
            $('#modal-title').text(title);
            $('#modal-description').text(description);
            $('#modal-employee').text(employee);
            $('#modal-date').text(date);
            
            $('#viewNotificationModal').modal('show');
        });
    });
</script>
@endsection