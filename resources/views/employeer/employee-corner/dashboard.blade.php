@extends('employeer.employee-corner.main')
@section('title', 'Login Corner')
@section('content')
    <div class="content container-fluid pb-0">
        <div class="card" style="background: linear-gradient(135deg, #7b9af1, #87f1a1);">
            <div class="card-header"> <h1>Login Corner Dashboard</h1></div>
            <div class="card-body"></div>
        </div>
		@if(Session::has('message'))										
			<div class="alert alert-success" style="text-align:center;">{{ Session::get('message') }}</div>
		@endif
        <div class="row">
						<div class="col-xxl-8 col-lg-12 col-md-12">
							<div class="row">

							<!-- Employee Details -->
							<div class="col-lg-6 col-md-12">
								<div class="card employee-welcome-card flex-fill">
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
								</div>
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
										<h4>Upcoming Holidays</h4>
										<div class="holiday-details">
											<div class="holiday-calendar">
												<div class="holiday-calendar-icon">
													<img src="assets/img/icons/holiday-calendar.svg" alt="Icon">
												</div>
												<div class="holiday-calendar-content">
													<h6>Ramzan</h6>
													<p>Mon 20 May 2024</p>
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
