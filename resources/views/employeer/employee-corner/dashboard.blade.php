@extends('employeer.employee-corner.main')
@section('title', 'Login Corner')
<style>
	/* Main Container */
	.post-container {
		background: #f5f7fa;
		border-radius: 12px;
		box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05);
		overflow: hidden;
		height: 100%;
		display: flex;
		flex-direction: column;
	}

	/* Fixed Header */
	.post-header-container {
		background: #ffffff;
		padding: 16px 20px;
		border-bottom: 1px solid #e4e6eb;
		position: sticky;
		top: 0;
		z-index: 10;
	}

	.post-add {
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.post-title {
		font-size: 18px;
		font-weight: 600;
		color: #050505;
		margin: 0;
	}

	.add-post-btn {
		display: flex;
		align-items: center;
		gap: 8px;
		color: #1877f2;
		text-decoration: none;
		font-weight: 500;
		padding: 8px 12px;
		border-radius: 6px;
		transition: background 0.2s;
	}

	.add-post-btn:hover {
		background: rgba(24, 119, 242, 0.1);
	}

	.add-post-btn i {
		font-size: 16px;
	}

	/* Scrollable Content */
	/* .post-scroll-container {
		flex: 1;
		overflow-y: auto;
		padding: 0 16px;
	} */

	#post-scroll-container {
	max-height: 90vh; 
	overflow-y: auto;
	padding-right: 2px; 
	scrollbar-width: thin;
	scrollbar-color: #ff9900 #fcfcfb;
	}



	/* Post Card */
	.post-card {
		background: #ffffff;
		border-radius: 8px;
		margin: 16px 0;
		box-shadow: 0 1px 2px rgba(0, 0, 0, 0.1);
	}

	/* Post Header */
	.post-header {
		display: flex;
		justify-content: space-between;
		align-items: center;
		padding: 12px 16px;
	}

	.user-info {
		display: flex;
		align-items: center;
		gap: 12px;
	}

	.post-avatar {
		width: 40px;
		height: 40px;
		border-radius: 50%;
		object-fit: cover;
		border: 2px solid #e4e6eb;
	}

	.user-details {
		display: flex;
		flex-direction: column;
	}

	.post-username {
		font-size: 15px;
		font-weight: 600;
		margin: 0;
		color: #050505;
	}

	.post-timestamp {
		font-size: 12px;
		color: #65676b;
		margin-top: 2px;
	}

	.post-options {
		background: none;
		border: none;
		color: #65676b;
		font-size: 16px;
		cursor: pointer;
		padding: 8px;
		border-radius: 50%;
		transition: background 0.2s;
	}

	.post-options:hover {
		background: rgba(0, 0, 0, 0.05);
	}

	/* Post Content */
	.post-content-container {
		padding: 0 16px 12px;
	}

	.post-content {
		font-size: 15px;
		line-height: 1.4;
		color: #050505;
		margin: 0 0 12px 0;
	}

	.post-image-container {
		border-radius: 8px;
		overflow: hidden;
		margin-top: 12px;
	}

	.post-image {
		width: 100%;
		max-height: 500px;
		object-fit: cover;
		display: block;
	}

	/* Post Stats */
	.post-stats {
		padding: 10px 16px;
		border-top: 1px solid #e4e6eb;
		border-bottom: 1px solid #e4e6eb;
	}

	.stats-content {
		display: flex;
		justify-content: space-between;
		align-items: center;
		font-size: 14px;
		color: #65676b;
	}

	.likes-count, .comments-count {
		display: flex;
		align-items: center;
		gap: 6px;
	}

	.like-count-badge {
		background: #1877f2;
		color: white;
		width: 18px;
		height: 18px;
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		font-size: 10px;
	}

	/* Action Buttons */
	.post-actions {
		padding: 8px 0;
		display: flex;
		border-bottom: 1px solid #e4e6eb;
	}

	.btn-action {
		flex: 1;
		background: none;
		border: none;
		padding: 8px 0;
		font-size: 14px;
		color: #65676b;
		cursor: pointer;
		display: flex;
		align-items: center;
		justify-content: center;
		gap: 8px;
		border-radius: 4px;
		transition: background 0.2s;
	}

	.btn-action:hover {
		background: rgba(0, 0, 0, 0.05);
	}

	.btn-action i {
		font-size: 16px;
	}

	.like-btn.liked {
		color: #1877f2;
	}

	.like-btn.liked i {
		font-weight: 900;
	}

	/* Comments Section */
	.post-comments {
		padding: 12px 16px;
		display: none; /* Initially hidden */
	}

	.comment-item {
		display: flex;
		gap: 8px;
		margin-bottom: 12px;
	}

	.comment-avatar {
		width: 32px;
		height: 32px;
		border-radius: 50%;
		object-fit: cover;
		flex-shrink: 0;
	}

	.comment-bubble {
		flex: 1;
	}

	.comment-header {
		display: flex;
		align-items: center;
		gap: 8px;
		margin-bottom: 4px;
	}

	.comment-username {
		font-size: 13px;
		font-weight: 600;
		margin: 0;
		color: #050505;
	}

	.comment-time {
		font-size: 11px;
		color: #65676b;
	}

	.comment-text {
		font-size: 14px;
		color: #050505;
		margin: 0;
		line-height: 1.4;
	}

	/* Add Comment */
	.add-comment {
		padding: 12px 16px;
		border-top: 1px solid #e4e6eb;
		display: flex;
		gap: 8px;
		align-items: center;
	}

	.comment-form {
		flex: 1;
		display: flex;
		gap: 8px;
	}

	.comment-input {
		flex: 1;
		border: 1px solid #e4e6eb;
		border-radius: 18px;
		padding: 8px 12px;
		font-size: 14px;
		outline: none;
		transition: border 0.2s;
	}

	.comment-input:focus {
		border-color: #1877f2;
	}

	.comment-post-btn {
		background: #1877f2;
		color: white;
		border: none;
		border-radius: 18px;
		padding: 8px 16px;
		font-size: 14px;
		font-weight: 500;
		cursor: pointer;
		transition: background 0.2s;
	}

	.comment-post-btn:hover {
		background: #166fe5;
	}

	/* Show comments when active */
	.post-card.active .post-comments {
		display: block;
	}

	/*--------------- Edit and delete button css -------------*/
	.post-options-container {
		position: relative;
		display: inline-block;
	}

	.post-options {
		background: none;
		border: none;
		color: #666;
		cursor: pointer;
		padding: 5px 10px;
		font-size: 16px;
	}

	.post-options:hover {
		color: #333;
	}

	.options-dropdown {
		display: none;
		position: absolute;
		right: 0;
		background-color: #fff;
		min-width: 120px;
		box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.1);
		border-radius: 4px;
		z-index: 1;
		padding: 5px 0;
	}

	.options-dropdown button {
		width: 100%;
		text-align: left;
		padding: 8px 16px;
		background: none;
		border: none;
		color: #333;
		cursor: pointer;
		font-size: 14px;
		display: flex;
		align-items: center;
		gap: 8px;
	}

	.options-dropdown button:hover {
		background-color: #f5f5f5;
	}

	.options-dropdown button i {
		width: 16px;
		text-align: center;
	}

	.show-dropdown {
		display: block;
	}
	.edit-post-btn i {
		color: #46a1f7; /* Green icon */
	}

	.delete-post-btn i {
		color: #fa5305; /* Red icon */
	}
	/*--------------- End Edit and delete button css -------------*/
</style>
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
					<!-- Notice Section -->
					<div class="col-md-6">
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

						<div class="card flex-fill">
							<div class="card-body">
								<div class="statistic-header">
									<h4>Important</h4>
								</div>
								<div class="notification-tab">
									<ul class="nav nav-tabs">
										<li>
											<a href="#" class="active" data-bs-toggle="tab" data-bs-target="#notification_tab">
												<i class="la la-bell"></i> Notifications
											</a>
										</li>
									</ul>
									<div class="tab-content">
										<div class="tab-pane active" id="notification_tab">
											<div class="employee-noti-content" style="max-height: 380px; overflow-y: auto;">
												<ul class="employee-notification-list">
													<!-- Notice content would go here -->
												</ul>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
						
						<!-- Holiday Section (below Notice) -->
						
					</div>
					<!-- /Notice & Holiday Section -->

					<!-- Post and comment Section -->
					{{-- <div class="col-md-6" >
						<div class="card flex-fill">
							<div class="post-container">
								<!-- Fixed Header Section -->
								<div class="post-header-container">
									<div class="post-add">
										<h4 class="post-title">All Posts</h4>
										<a href="#" class="add-post-btn">
											<i class="fas fa-plus-circle"></i> Add Post
										</a>
									</div>
								</div>

								<!-- Scrollable Content -->
								<div class="post-scroll-container" id="post-scroll-container">
									<!-- Post Card -->
									<div class="post-card">
										<!-- Post Header -->
										<div class="post-header">
											<div class="user-info">
												<img src="https://randomuser.me/api/portraits/men/1.jpg" alt="John Doe" class="post-avatar">
												<div class="user-details">
													<h5 class="post-username">John Doe</h5>
													<small class="post-timestamp">3 days ago</small>
												</div>
											</div>
											<button class="post-options">
												<i class="fas fa-ellipsis-h"></i>
											</button>
										</div>

										<!-- Post Content -->
										<div class="post-content-container">
											<p class="post-content">Just enjoyed a beautiful hike in the mountains today! The views were absolutely breathtaking. 🏔️ #nature #adventure</p>
											
											<!-- Post Image -->
											<div class="post-image-container">
												<img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" 
													alt="Post content" 
													class="post-image">
											</div>
										</div>

										<!-- Likes and Comments Count -->
										<div class="post-stats">
											<div class="stats-content">
												<div class="likes-count">
													<span class="like-count-badge">
														<i class="fas fa-thumbs-up"></i>
													</span>
													<span>24</span>
												</div>
												<div class="comments-count">
													<span>5 comments</span>
												</div>
											</div>
										</div>

										<!-- Action Buttons -->
										<div class="post-actions">
											<button class="btn-action like-btn">
												<i class="far fa-thumbs-up"></i>
												Like
											</button>
											<button class="btn-action comment-toggle-btn">
												<i class="fas fa-comment"></i>
												Comment
											</button>
										</div>

										<!-- Comments Section -->
										<div class="post-comments">
											<!-- Existing Comments -->
											<div class="comment-item">
												<img src="https://randomuser.me/api/portraits/women/1.jpg" alt="Jane Smith" class="comment-avatar">
												<div class="comment-bubble">
													<div class="comment-header">
														<h6 class="comment-username">Jane Smith</h6>
														<small class="comment-time">2 hours ago</small>
													</div>
													<p class="comment-text">Looks amazing! Which trail did you take?</p>
												</div>
											</div>
											
											<div class="comment-item">
												<img src="https://randomuser.me/api/portraits/men/2.jpg" alt="Mike Johnson" class="comment-avatar">
												<div class="comment-bubble">
													<div class="comment-header">
														<h6 class="comment-username">Mike Johnson</h6>
														<small class="comment-time">1 hour ago</small>
													</div>
													<p class="comment-text">I was there last weekend! The sunset is incredible from that viewpoint.</p>
												</div>
											</div>
										</div>

										<!-- Add Comment -->
										<div class="add-comment">
											<img src="https://randomuser.me/api/portraits/men/4.jpg" alt="You" class="comment-avatar">
											<div class="comment-form">
												<input type="text" placeholder="Write a comment..." class="comment-input">
												<button class="comment-post-btn">Post</button>
											</div>
										</div>
									</div>

									<!-- Post Card -->
									<div class="post-card">
										<!-- Post Header -->
										<div class="post-header">
											<div class="user-info">
												<img src="https://randomuser.me/api/portraits/men/1.jpg" alt="John Doe" class="post-avatar">
												<div class="user-details">
													<h5 class="post-username">John Doe</h5>
													<small class="post-timestamp">3 days ago</small>
												</div>
											</div>
											<button class="post-options">
												<i class="fas fa-ellipsis-h"></i>
											</button>
										</div>

										<!-- Post Content -->
										<div class="post-content-container">
											<p class="post-content">Just enjoyed a beautiful hike in the mountains today! The views were absolutely breathtaking. 🏔️ #nature #adventure</p>
											
											<!-- Post Image -->
											<div class="post-image-container">
												<img src="https://images.unsplash.com/photo-1464822759023-fed622ff2c3b?ixlib=rb-1.2.1&auto=format&fit=crop&w=1350&q=80" 
													alt="Post content" 
													class="post-image">
											</div>
										</div>

										<!-- Likes and Comments Count -->
										<div class="post-stats">
											<div class="stats-content">
												<div class="likes-count">
													<span class="like-count-badge">
														<i class="fas fa-thumbs-up"></i>
													</span>
													<span>24</span>
												</div>
												<div class="comments-count">
													<span>5 comments</span>
												</div>
											</div>
										</div>

										<!-- Action Buttons -->
										<div class="post-actions">
											<button class="btn-action like-btn">
												<i class="far fa-thumbs-up"></i>
												Like
											</button>
											<button class="btn-action comment-toggle-btn">
												<i class="fas fa-comment"></i>
												Comment
											</button>
										</div>

										<!-- Comments Section -->
										<div class="post-comments" id="post-comment-container">
											<!-- Existing Comments -->
											<div class="comment-item">
												<img src="https://randomuser.me/api/portraits/women/1.jpg" alt="Jane Smith" class="comment-avatar">
												<div class="comment-bubble">
													<div class="comment-header">
														<h6 class="comment-username">Jane Smith</h6>
														<small class="comment-time">2 hours ago</small>
													</div>
													<p class="comment-text">Looks amazing! Which trail did you take?</p>
												</div>
											</div>
											
											<div class="comment-item">
												<img src="https://randomuser.me/api/portraits/men/2.jpg" alt="Mike Johnson" class="comment-avatar">
												<div class="comment-bubble">
													<div class="comment-header">
														<h6 class="comment-username">Mike Johnson</h6>
														<small class="comment-time">1 hour ago</small>
													</div>
													<p class="comment-text">I was there last weekend! The sunset is incredible from that viewpoint.</p>
												</div>
											</div>
										</div>

										<!-- Add Comment -->
										<div class="add-comment">
											<img src="https://randomuser.me/api/portraits/men/4.jpg" alt="You" class="comment-avatar">
											<div class="comment-form">
												<input type="text" placeholder="Write a comment..." class="comment-input">
												<button class="comment-post-btn">Post</button>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div> --}}

					<div class="col-md-6">
						<div class="card flex-fill">
							<div class="post-container">
								<!-- Fixed Header Section -->
								<div class="post-header-container">
									<div class="post-add">
										<h4 class="post-title">All Posts</h4>
										<a href="#" class="add-post-btn">
											<i class="fas fa-plus-circle"></i> Add Post
										</a>
									</div>
								</div>
								
								<!-- Scrollable Content -->
								<div class="post-scroll-container" id="post-scroll-container">
									@foreach($posts as $post)
									<!-- Post Card -->
									<div class="post-card">
										<!-- Post Header -->
										<div class="post-header">
											<div class="user-info">
												<img src="{{ $post->employee_image ? asset($post->employee_image) : asset('user.png') }}" alt="{{ $post->employee_name }}" class="post-avatar">
												<div class="user-details">
													<h5 class="post-username">{{ $post->employee_name }}</h5>
													<small class="post-timestamp">{{ $post->time_ago }}</small>
													<small class="post-designation">{{ $post->designation }}</small>
												</div>
											</div>
											{{-- <button class="post-options">
												<i class="fas fa-ellipsis-h"></i>
											</button> --}}
											@if($Roledata->employee_id === $post->employee_code)
											<div class="post-options-container">
												<button class="post-options" onclick="toggleOptions(this)">
													<i class="fas fa-ellipsis-h"></i>
												</button>
												
												<div class="options-dropdown">
													{{-- <button class="edit-post-btn" 
															data-post-id="{{ $post->id }}"
															data-post-content="{{ $post->title }}"
															data-post-file="{{ $post->image_path }}"
															data-bs-toggle="modal" 
															data-bs-target="#editPostModal">
														<i class="fas fa-edit"></i> Edit
													</button> --}}
													
														<button class="edit-post-btn " 
																data-post-id="{{ $post->id }}"
																data-employee-code="{{ $post->employee_code }}"
																data-bs-toggle="modal" 
																data-bs-target="#editPostModal">
															<i class="fas fa-edit"></i> Edit
														</button>
														
													<button class="delete-post-btn" onclick="window.location.href='{{ route('posts.delete', ['id' => $post->id, 'emp_id' => $post->employee_code]) }}'">
														<i class="fas fa-trash"></i> Delete
													</button>
												</div>
											</div>
											@endif
										</div>

										<!-- Post Content -->
										<div class="post-content-container">
											<p class="post-content">{{ $post->title }}</p>
											
											@if($post->image_path)
											<!-- Post Image -->
											<div class="post-image-container">
												<img src="{{ $post->image_path }}" 
													alt="Post content" 
													class="post-image">
											</div>
											@endif
										</div>

										<!-- Likes and Comments Count -->
										<div class="post-stats">
											<div class="stats-content">
												<div class="likes-count">
													<span class="like-count-badge">
														<i class="fas fa-thumbs-up"></i>
													</span>
													<span>{{ $post->likes_count }}</span>
												</div>
												<div class="comments-count">
													<span>{{ $post->comments_count }} comment{{ $post->comments_count != 1 ? 's' : '' }}</span>
												</div>
											</div>
										</div>

										<!-- Action Buttons -->
										<div class="post-actions">
											{{-- <button class="btn-action like-btn" data-post-id="{{ $post->id }}">
												<i class="far fa-thumbs-up"></i>
												Like
											</button> --}}
											<button class="btn-action like-btn {{ $post->is_liked ? 'liked' : '' }}" 
													data-post-id="{{ $post->id }}">
												<i class="{{ $post->is_liked ? 'fas' : 'far' }} fa-thumbs-up"></i>
												{{ $post->is_liked ? 'Liked' : 'Like' }}
											</button>
											<button class="btn-action comment-toggle-btn">
												<i class="fas fa-comment"></i>
												Comment
											</button>
										</div>

										<!-- Comments Section (Initially hidden) -->
										<div class="post-comments">
											<!-- Comments will be loaded here dynamically -->
											@foreach($post->comments as $comment)
												<div class="comment-item">
													<img src="{{ $post->employee_image ? asset($post->employee_image) : asset('assets/img/user.png') }}" 
														alt="{{ $post->employee_name }}" 
														class="comment-avatar">
													<div class="comment-bubble">
														<div class="comment-header">
															<h6 class="comment-username">{{ $comment->commenter_name }}</h6>
															<small class="comment-time">{{ $comment->time_ago }}</small>
														</div>
														<p class="comment-text">{{ $comment->comment_text }}</p>
													</div>
												</div>
											@endforeach
										</div>

										<!-- Add Comment -->
										<div class="add-comment">
											<img src="{{asset('assets/img/user.png')}}" alt="You" class="comment-avatar">
											<form class="comment-form" data-post-id="{{ $post->id }}">
												@csrf
												<div class="comment-form">
													<input type="hidden" name="post_id" value="{{ $post->id }}">
													<input type="text" placeholder="Write a comment..." class="comment-input" name="comment_text" required>
													<button type="submit" class="comment-post-btn">Post</button>
												</div>
											</form>
										</div>
									</div>
									@endforeach
								</div>
							</div>
						</div>
					</div>
					<!-- /Post and comment Section -->

					<!-- Add this modal HTML right after your post-container div -->
						<div class="modal fade" id="addPostModal" tabindex="-1" aria-hidden="true">
							<div class="modal-dialog modal-dialog-centered">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Create New Post</h5>
										<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
									</div>
									<div class="modal-body">
										<form id="postForm" method="post" action="{{ route('posts.store') }}" enctype="multipart/form-data">
											@csrf
											<div class="form-group mb-3">
												<textarea class="form-control @error('content') is-invalid @enderror" 
														id="postContent" name="content" rows="5" 
														placeholder="What's on your mind?" required>{{ old('content') }}</textarea>
												@error('content')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
											</div>
											<div class="form-group mb-3">
												<label for="postFile">Add File (Optional - Images, PDF, Word, Video)</label>
												<input type="file" class="form-control @error('post_file') is-invalid @enderror" 
													id="postFile" name="post_file"
													accept="image/*,.pdf,.doc,.docx,video/*">
												@error('post_file')
													<div class="invalid-feedback">{{ $message }}</div>
												@enderror
												<small class="text-muted">Max file size: 10MB | Allowed formats: JPEG, PNG, GIF, PDF, DOC, DOCX, MP4, MOV, AVI</small>
											</div>
											<button type="submit" class="btn btn-primary">Post</button>
										</form>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
									</div>
								</div>
							</div>
						</div>
					<!------------end model ------------------>
					<!-- Edit Modal -->
					{{-- <div class="modal fade" id="editPostModal" tabindex="-1" aria-labelledby="editPostModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Edit Post</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<form id="editPostForm" method="post" action="" enctype="multipart/form-data">
										@csrf
										@method('PUT')
										<input type="text" name="post_id" id="editPostId">
										<input type="text" name="remove_file" id="removeFileFlag" value="0">

										<div class="form-group mb-3">
											<textarea class="form-control @error('content') is-invalid @enderror" 
													id="editPostContent" name="content" rows="5" 
													placeholder="What's on your mind?" required></textarea>
											@error('content')
												<div class="invalid-feedback">{{ $message }}</div>
											@enderror
										</div>

										<div class="form-group mb-3">
											<label for="editPostFile">Update File</label>
											<input type="file" class="form-control @error('post_file') is-invalid @enderror" 
												id="editPostFile" name="post_file"
												accept="image/*,.pdf,.doc,.docx,video/*">
											@error('post_file')
												<div class="invalid-feedback">{{ $message }}</div>
											@enderror
											<small class="text-muted">Max file size: 10MB | Allowed formats: JPEG, PNG, GIF, PDF, DOC, DOCX, MP4, MOV, AVI</small>
											
											<!-- Current File Display -->
											<div id="currentFileContainer" class="mt-3" style="display: none;">
												<div class="d-flex justify-content-between align-items-center">
													<strong>Current File:</strong>
													<button type="button" id="removeFileBtn" class="btn btn-sm btn-danger">Remove File</button>
												</div>
												<div id="currentFilePreview" class="mt-2"></div>
											</div>
										</div>

										<button type="submit" class="btn btn-primary">Update Post</button>
									</form>
								</div>
								<div class="modal-footer">
									<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
								</div>
							</div>
						</div>
					</div> --}}
					<div class="modal fade" id="editPostModal" tabindex="-1" aria-hidden="true">
						<div class="modal-dialog modal-dialog-centered">
							<div class="modal-content">
								<div class="modal-header">
									<h5 class="modal-title">Edit Post</h5>
									<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
								</div>
								<div class="modal-body">
									<form id="editPostForm" method="post" action="{{ route('posts.update') }}" enctype="multipart/form-data">
										@csrf
										@method('PUT')
										<input type="hidden" name="post_id" id="editPostId">
										<input type="hidden" name="remove_file" id="removeFileFlag" value="0">

										<div class="form-group mb-3">
											<textarea class="form-control" id="editPostContent" name="content" rows="5" required></textarea>
											<div class="invalid-feedback"></div>
										</div>

										<div class="form-group mb-3">
											<label for="editPostFile">Update File</label>
											<input type="file" class="form-control" id="editPostFile" name="post_file"
												accept="image/*,.pdf,.doc,.docx,video/*">
											<small class="text-muted">Max file size: 10MB | Allowed formats: JPEG, PNG, GIF, PDF, DOC, DOCX, MP4, MOV, AVI</small>
											
											<div id="currentFileContainer" class="mt-3" style="display:none;">
												<div class="d-flex justify-content-between align-items-center">
													<strong>Current File:</strong>
													<button type="button" id="removeFileBtn" class="btn btn-sm btn-danger">Remove File</button>
												</div>
												<div id="currentFilePreview" class="mt-2"></div>
											</div>
										</div>

										<button type="submit" class="btn btn-primary">Update Post</button>
									</form>
								</div>
							</div>
						</div>
					</div>

					
				</div>
			</div>
		</div>

		{{-- <div class="row">
			<div class="col-xxl-8 col-lg-12 col-md-12">
				<div class="row">
					<div class="col-md-6">
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
				</div>
			</div>
		</div> --}}
		
    </div>    
@endsection
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
	document.addEventListener('DOMContentLoaded', function() {
		// Toggle comments
		document.querySelectorAll('.comment-toggle-btn').forEach(button => {
			button.addEventListener('click', function() {
				const postCard = this.closest('.post-card');
				postCard.classList.toggle('active');
				
				// Update button text
				const isActive = postCard.classList.contains('active');
				if(isActive){
					this.innerHTML = `<i class="fas fa-comment primary" style="color:blue;"></i> ${isActive ? 'Comment' : 'Comment'}`;
				}else {
					this.innerHTML = `<i class="fas fa-comment" style="color:gray;"></i> ${isActive ? 'Comment' : 'Comment'}`;
				}
				// this.innerHTML = `<i class="fas fa-comment" style="color:blue;"></i> ${isActive ? 'Hide Comments' : 'Comment'}`;
			});
		});
		
		// Toggle like
		document.querySelectorAll('.like-btn').forEach(button => {
			button.addEventListener('click', function() {
				this.classList.toggle('liked');
				const icon = this.querySelector('i');
				icon.classList.toggle('far');
				icon.classList.toggle('fas');
				
				// Update like count (example)
				const likeCount = this.closest('.post-card').querySelector('.likes-count span:last-child');
				const currentCount = parseInt(likeCount.textContent);
				//likeCount.textContent = this.classList.contains('liked') ? currentCount + 1 : currentCount - 1;
			});
		});
	});
</script>

<script>
	document.addEventListener('DOMContentLoaded', function() {
	// Get modal instance
	var addPostModal = new bootstrap.Modal(document.getElementById('addPostModal'));
	
	// Show modal when Add Post is clicked
	document.querySelector('.add-post-btn').addEventListener('click', function(e) {
		e.preventDefault();
		addPostModal.show();
	});
	
	});
</script>





<script>
	$(document).ready(function() {
		// Handle comment form submission
		//alert('okk');
		$('.comment-form').on('submit', function(e) {
			e.preventDefault();
			//alert('okkkk');
			const form = $(this);
			const postId = form.data('post-id');
			const commentText = form.find('[name="comment_text"]').val().trim();
			
			if (!commentText) return;
			
			// Show loading state
			const submitBtn = form.find('.comment-post-btn');
			submitBtn.prop('disabled', true).text('Posting...');
			
			$.ajax({
				//url: '/comments',
				url:'{{url('comments')}}',
				method: 'POST',
				data: form.serialize(),
				success: function(response) {
					if (response.success) {
						// Clear the input
						form.find('[name="comment_text"]').val('');
						
						// Append the new comment to the comments section
						const commentsSection = form.closest('.post-card').find('.post-comments');
						
						// Create new comment HTML
						const newComment = `
							<div class="comment-item">
								<img src="${response.commenter.employee_image || 'https://randomuser.me/api/portraits/men/1.jpg'}" 
									alt="${response.commenter.employee_name}" class="comment-avatar">
								<div class="comment-bubble">
									<div class="comment-header">
										<h6 class="comment-username">${response.commenter.employee_name}</h6>
										<small class="comment-time">Just now</small>
									</div>
									<p class="comment-text">${response.comment.comment_text}</p>
								</div>
							</div>
						`;
						
						// Append the new comment
						commentsSection.append(newComment);
						
						// Update comment count
						const commentsCount = commentsSection.find('.comment-item').length;
						form.closest('.post-card').find('.comments-count span').text(commentsCount + ' comment' + (commentsCount !== 1 ? 's' : ''));
					}
				},
				error: function(xhr) {
					console.error('Error:', xhr.responseText);
					alert('Failed to post comment. Please try again.');
				},
				complete: function() {
					submitBtn.prop('disabled', false).text('Post');
				}
			});
		});
	});


	//like functionality
	$(document).on('click', '.like-btn', function() {
		const button = $(this);
		const postId = button.data('post-id');
		  const token = $('meta[name="csrf-token"]').attr('content');
    
			// Validate elements exist
			if (!token) {
				console.error('CSRF token not found');
				return;
			}
		
		$.ajax({
		
			url: `{{ url('posts') }}/${postId}/like`,
			method: 'POST',
			// headers: {
			// 	'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			// },
			  headers: {
					'X-CSRF-TOKEN': token
				},
			beforeSend: function() {
				button.prop('disabled', true);
			}, 
			cache: false,
			success: function(response) {
				if (response.success) {
					// Update like count and button state
					const likeCount = button.closest('.post-actions').siblings('.post-stats').find('.likes-count span:last');
					const currentCount = parseInt(likeCount.text()) || 0;
					
					if (response.action === 'liked') {
						likeCount.text(currentCount + 1);
						button.html('<i class="fas fa-thumbs-up"></i> Liked');
					} else {
						likeCount.text(Math.max(0, currentCount - 1));
						button.html('<i class="far fa-thumbs-up"></i> Like');
					}
				}
			},
			error: function(xhr) {
				console.error('Like error:', xhr.responseText);
				alert('Failed to process like. Please try again.');
			},
			complete: function() {
				button.prop('disabled', false);
			}
		});
	});


	//-----------for edit and delete button show
	function toggleOptions(button) {
		// Close all other dropdowns first
		document.querySelectorAll('.options-dropdown').forEach(dropdown => {
			if (dropdown !== button.nextElementSibling) {
				dropdown.classList.remove('show-dropdown');
			}
		});
		
		// Toggle the current dropdown
		const dropdown = button.nextElementSibling;
		dropdown.classList.toggle('show-dropdown');
	}

	// Close dropdown when clicking outside
	document.addEventListener('click', function(event) {
		if (!event.target.closest('.post-options-container')) {
			document.querySelectorAll('.options-dropdown').forEach(dropdown => {
				dropdown.classList.remove('show-dropdown');
			});
		}
	});
</script>

{{-- <script>
	document.addEventListener('DOMContentLoaded', function() {
		// When edit button is clicked
		document.querySelectorAll('.edit-post-btn').forEach(button => {
			button.addEventListener('click', function() {
				const postId = this.getAttribute('data-post-id');
				const postContent = this.getAttribute('data-post-content');
				const postFile = this.getAttribute('data-post-file');
				const postFileType = this.getAttribute('data-post-file-type');

				// Set form action
				document.getElementById('editPostForm').action = `/posts/${postId}`;
				document.getElementById('editPostId').value = postId;
				document.getElementById('editPostContent').value = postContent;
				document.getElementById('removeFileFlag').value = '0';

				// Handle file display
				const filePreview = document.getElementById('currentFilePreview');
				const fileContainer = document.getElementById('currentFileContainer');
				const removeFileBtn = document.getElementById('removeFileBtn');

				if (postFile) {
					fileContainer.style.display = 'block';
					
					// Display different preview based on file type
					if (postFileType && postFileType.startsWith('image/')) {
						filePreview.innerHTML = `<img src="${postFile}" class="img-thumbnail" style="max-height: 150px;">`;
					} else if (postFileType === 'application/pdf') {
						filePreview.innerHTML = `<i class="fas fa-file-pdf fa-3x text-danger"></i><br>
											<a href="${postFile}" target="_blank">View PDF</a>`;
					} else if (postFileType === 'application/msword' || postFileType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
						filePreview.innerHTML = `<i class="fas fa-file-word fa-3x text-primary"></i><br>
												<a href="${postFile}" target="_blank">View Document</a>`;
					} else if (postFileType && postFileType.startsWith('video/')) {
						filePreview.innerHTML = `<video controls style="max-width: 100%; max-height: 150px;">
											<source src="${postFile}" type="${postFileType}">
											Your browser does not support the video tag.
											</video>`;
					} else {
						filePreview.innerHTML = `<a href="${postFile}" target="_blank">Download File</a>`;
					}
				} else {
					fileContainer.style.display = 'none';
				}

				// Remove file button handler
				removeFileBtn.addEventListener('click', function() {
					fileContainer.style.display = 'none';
					document.getElementById('removeFileFlag').value = '1';
					document.getElementById('editPostFile').value = '';
				});
			});
		});
	});
</script> --}}

<script>
	$(document).ready(function() {
		// When edit button is clicked
		$(document).on('click', '.edit-post-btn', function() {
			const postId = $(this).data('post-id');
			const employeeCode = $(this).data('employee-code');
			//alert(postId);
			// Show loading state
			$('#editPostModal').find('.modal-body').prepend(
				'<div class="text-center py-3" id="loadingSpinner">' +
				'<div class="spinner-border text-primary"></div>' +
				'<p>Loading post data...</p>' +
				'</div>'
			);
			
			// AJAX request to fetch post data
			$.ajax({
				//url: 'posts/' + postId + '/edit',
				url:`{{ url('posts') }}/${postId}/edit`,
				
				type: 'GET',
				data: { employee_code: employeeCode },
				success: function(response) {
					$('#loadingSpinner').remove();
					
					// Set form action
					//$('#editPostForm').attr('action', '/hrms-v2/posts/' + postId);
					$('#editPostId').val(postId);
					$('#editPostContent').val(response.title);
					$('#removeFileFlag').val('0');
					
					// Handle file display
					if (response.image_path) {
						const fileUrl = "https://skilledworkerscloud.co.uk/hrms-v2/storage/app/public/" + response.image_path;
						const fileExtension = response.image_path.split('.').pop().toLowerCase();
						
						let filePreviewHtml = '';
						if (['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(fileExtension)) {
							filePreviewHtml = `<img src="${fileUrl}" class="img-thumbnail" style="max-height: 150px;">`;
						} else if (fileExtension === 'pdf') {
							filePreviewHtml = `<i class="fas fa-file-pdf fa-3x text-danger"></i><br>
											<a href="${fileUrl}" target="_blank">View PDF</a>`;
						} else if (['doc', 'docx'].includes(fileExtension)) {
							filePreviewHtml = `<i class="fas fa-file-word fa-3x text-primary"></i><br>
											<a href="${fileUrl}" target="_blank">View Document</a>`;
						} else if (['mp4', 'mov', 'avi'].includes(fileExtension)) {
							filePreviewHtml = `<video controls style="max-width: 100%; max-height: 150px;">
											<source src="${fileUrl}" type="video/${fileExtension}">
											Your browser does not support the video tag.
											</video>`;
						} else {
							filePreviewHtml = `<a href="${fileUrl}" target="_blank">Download File</a>`;
						}
						
						$('#currentFilePreview').html(filePreviewHtml);
						$('#currentFileContainer').show();
					} else {
						$('#currentFileContainer').hide();
					}
				},
				error: function(xhr) {
					$('#loadingSpinner').html('<div class="alert alert-danger">Error loading post data</div>');
					console.error('Error:', xhr.responseText);
				}
			});
		});
		
		// Remove file button handler
		$('#removeFileBtn').click(function() {
			$('#currentFileContainer').hide();
			$('#removeFileFlag').val('1');
			$('#editPostFile').val('');
		});
		
		// Form submission handler
		// $('#editPostForm').submit(function(e) {
		// 	e.preventDefault();
		// 	const formData = new FormData(this);
			
		// 	$.ajax({
		// 		url: $(this).attr('action'),
		// 		type: 'POST',
		// 		data: formData,
		// 		processData: false,
		// 		contentType: false,
		// 		success: function(response) {
		// 			$('#editPostModal').modal('hide');
		// 			location.reload(); // Or update the post dynamically
		// 		},
		// 		error: function(xhr) {
		// 			alert('Error updating post: ' + xhr.responseJSON.message);
		// 		}
		// 	});
		// });
	});
</script>
