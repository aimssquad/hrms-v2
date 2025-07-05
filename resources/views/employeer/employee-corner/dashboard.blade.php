@extends('employeer.employee-corner.main')
@section('title', 'Login Corner')
@section('content')
    <div class="content container-fluid pb-0">
        
            {{-- <div class="card-header"> <h3>Welcome {{ $Roledata->name }} !</h3></div> --}}
		@if(Session::has('message'))										
			<div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
		@endif
		<div class="row">
			<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
				<div class="card dash-widget overflow-visible">
					<a href="{{ url('org-employee-corner-organisation/user-profile') }}">
						<div class="card-body modern-card">
							<div class="dash-widget-info">
								<span>Profile</span>
								{{-- <h3>5</h3> --}}
							</div>
							<div class="modern_icon_wrapper">
								<i class="fa-solid fa-user fa-2x modern-icon"></i>
							</div>
							<div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
								<span style="font-size: 13px;">View</span>
								<i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
				<div class="card dash-widget overflow-visible">
					<a href="{{ url('org-employee-corner/holiday') }}">
						<div class="card-body modern-card">
							<div class="dash-widget-info">
								<span>Holiday Calender</span>
								{{-- <h3>5</h3> --}}
							</div>
							<div class="modern_icon_wrapper">
								<i class="fa-solid fa-calendar-days fa-2x modern-icon"></i>
							</div>
							<div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
								<span style="font-size: 13px;">View</span>
								<i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
							</div>
						</div>
					</a>
				</div>
			</div>
			<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
				<div class="card dash-widget overflow-visible">
					<a href="{{ url('org-employee-corner/work-update') }}">
						<div class="card-body modern-card">
							<div class="dash-widget-info">
								<span>Daily Work Update</span>
								{{-- <h3>5</h3> --}}
							</div>
							<div class="modern_icon_wrapper">
								<i class="fa-solid fa-list-check fa-2x modern-icon"></i>
							</div>
							<div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
								<span style="font-size: 13px;">View</span>
								<i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
							</div>
						</div>
					</a>
				</div>
			</div>
			@if($Roledata->user_type == "employee")
			<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
				<div class="card dash-widget overflow-visible">
					<a href="{{ url('org-employee-corner/leave-apply') }}">
						<div class="card-body modern-card">
							<div class="dash-widget-info">
								<span>Leave Apply</span>
								{{-- <h3>5</h3> --}}
							</div>
							<div class="modern_icon_wrapper">
								<i class="fa-solid fa-file-signature fa-2x modern-icon"></i>
							</div>
							<div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
								<span style="font-size: 13px;">View</span>
								<i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
							</div>
						</div>
					</a>
				</div>
			</div>
			@endif
			<div class="col-md-6 col-sm-6 col-lg-6 col-xl-3">
				<div class="card dash-widget overflow-visible">
					<a href="{{ url('org-employee-corner/attendance-status') }}">
						<div class="card-body modern-card">
							<div class="dash-widget-info">
								<span>Attendance Status</span>
								{{-- <h3>5</h3> --}}
							</div>
							<div class="modern_icon_wrapper">
								<i class="fa-solid fa-fingerprint fa-2x modern-icon"></i>
							</div>
							<div class="modern-arrow pt-2" style="text-align: center; margin-top: -10px;">
								<span style="font-size: 13px;">View</span>
								<i class="fa-solid fa-arrow-right" style="font-size: 13px;"></i>
							</div>
						</div>
					</a>
				</div>
			</div>
		</div>
        <div class="row">
			<div class="col-xxl-8 col-lg-12 col-md-12">
				<div class="row">

				<!-- Employee Details -->
				<div class="col-lg-6 col-md-12">
					{{-- <div class="card employee-welcome-card flex-fill">
						<div class="card-body">
							<div class="welcome-info">
								<div class="welcome-content">
									<h4>Welcome Back, Darlee</h4>
									<p>You have <span>4 meetings</span> today,</p>
								</div>
								<div class="welcome-img">
									<img src="assets/img/avatar/avatar-19.jpg" class="img-fluid" alt="User">
								</div>
							</div>
							<div class="welcome-btn">
								<a href="{{url('org-employee-corner-organisation/user-profile')}}" class="btn">View Profile</a>
							</div>
						</div>
					</div> --}}
					<div class="card flex-fill">
						<div class="card-body">
							<div class="statistic-header">
								<h4>Statistics</h4>
								<div class="dropdown statistic-dropdown">
									<a class="dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);">
										Today
									</a>
									<div class="dropdown-menu dropdown-menu-end">
										<a href="javascript:void(0);" class="dropdown-item">
											Week
										</a>
										<a href="javascript:void(0);" class="dropdown-item">
											Month
										</a>
										<a href="javascript:void(0);" class="dropdown-item">
											Year
										</a>
									</div>
								</div>
							</div>
							<div class="clock-in-info">
								<div class="clock-in-content">
									<p>Work Time</p>
									<h4>6 Hrs : 54 Min</h4>
								</div>
								<div class="clock-in-btn">
									<a href="javascript:void(0);" class="btn btn-primary">
										<img src="assets/img/icons/clock-in.svg" alt="Icon"> Clock-In
									</a>
								</div>
							</div>
							<div class="clock-in-list">
								<ul class="nav">
									<li>
										<p>Remaining</p>
										<h6>2 Hrs 36 Min</h6>
									</li>
									<li>
										<p>Overtime</p>
										<h6>0 Hrs 00 Min</h6>
									</li>
									<li>
										<p>Break</p>
										<h6>1 Hrs 20 Min</h6>
									</li>
								</ul>
							</div>
							<div class="view-attendance">
								<a href="attendance.html">
									View Attendance <i class="fe fe-arrow-right-circle"></i>
								</a>
							</div>
						</div>
					</div>
				</div>
				<!-- /Employee Details -->

				<!-- Attendance & Leaves -->
				<div class="col-lg-6 col-md-12">
					<div class="card info-card flex-fill">
						<div class="card-body">
							<h4>This Month Holidays</h4>
							<div class="holiday-details">
								<div class="holiday-calendar">
									<div class="holiday-calendar-icon" style="max-height: 60px; width:60px;">
										<img src="{{ asset('assets/img/holiday.jpg') }}" alt="Holiday image">
									</div>
									<div class="holiday-calendar-content">
										@if($holidays)
										@foreach($holidays as $holiday) 
										<h6>{{strtoupper($holiday->name) }}</h6>
										@if($holiday->from_date)  
											<p class="holiday-date">
												{{ \Carbon\Carbon::parse($holiday->from_date)->format('d M Y') }}
											</p>
										@else
											<p class="text-warning">Date not specified</p>
										@endif
										@endforeach
										@else
										<h6>This month have no holiday</h6>
										@endif
									</div>
								</div>
								<div class="holiday-btn">
									<a href="{{url('org-employee-corner/holiday')}}" class="btn">View All</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /Attendance & Leaves -->

				</div>
			</div>
		</div>
    </div>    
@endsection
