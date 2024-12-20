<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="Smarthr - Bootstrap Admin Template">
      <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
      <meta name="author" content="Dreamstechnologies - Bootstrap Admin Template">
      <title>SWCH Login</title>
      <!-- Favicon -->
      <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/img/swch_logo.png') }}">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="{{asset('frontend/assets/css/bootstrap.min.css')}}">
      <!-- Fontawesome CSS -->
      <link rel="stylesheet" href="{{asset('frontend/assets/plugins/fontawesome/css/fontawesome.min.css')}}">
      <link rel="stylesheet" href="{{asset('frontend/assets/plugins/fontawesome/css/all.min.css')}}">
      <!-- Lineawesome CSS -->
      <link rel="stylesheet" href="{{asset('frontend/assets/css/line-awesome.min.css')}}">
      <link rel="stylesheet" href="{{asset('frontend/assets/css/material.css')}}">
      <!-- Lineawesome CSS -->
      <link rel="stylesheet" href="{{asset('frontend/assets/css/line-awesome.min.css')}}">
      <!-- Main CSS -->
      <link rel="stylesheet" href="{{asset('frontend/assets/css/style.css')}}">
      <style>
         body{
         background-color: #fff;
         }
         .login_banner_text{
         text-align: center;
         width: 100%;
         margin-top: 50px;
         margin-bottom:110px;
         }
         .carousel-indicators [data-bs-target] {
         height: 5px;
         border-radius: 11px;
         background-color: #e0e0e0;
         }
         .carousel-indicators .active {
         background-color: #f9932f;
         }
         .eye_section{
         position: absolute;
         top: 14px;
         right: 8px;
         }
         .login-btn {
         padding: 10px 0px;
         display: block;
         width: 100%;
         }
         .login_main_right{
         padding:85px 115px 0px 115px;
         }
         .img_middle{
         /*position: absolute;*/
         width: 485px;
         left: 0;
         right: 0;
         margin: auto;
         top:10%;
         overflow: hidden;
         height: auto;
         }
         .img_middle img{
         height: 405px;
         object-fit: cover;
         margin-top:50px;
         }
         .bg-left_main{
         background: #f1f1f1;
         }
         .padding{
         padding:20px 35px;
         -webkit-box-shadow: -2px 0px 22px -5px rgba(0,0,0,0.23);
         -moz-box-shadow: -2px 0px 22px -5px rgba(0,0,0,0.23);
         box-shadow: -2px 0px 22px -5px rgba(0,0,0,0.23);
         }
         .carousel-control-next,.carousel-control-prev{
         display:none;
         }
         @media(max-width:1199px){
         .login_main_right {
         padding: 85px 15px 0px 15px;
         }
         .img_middle img {
         margin-top: 18px;
         }
         }
      </style>
   </head>
   <body class="account-page">
      <div class="container">
         <div class="main_bg bg-light padding">
            <div class="row">
				<!--<div class="col-sm-6 bg-left_main">-->
				<!--	<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">-->
				<!--	   <div class="carousel-indicators">-->
				<!--		  @if($videos->isNotEmpty())-->
				<!--		  @foreach($videos as $key => $video)-->
				<!--		  <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" aria-label="Slide {{ $key + 1 }}"></button>-->
				<!--		  @endforeach-->
				<!--		  @else-->
				<!--		  <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>-->
				<!--		  @endif-->
				<!--	   </div>-->
				<!--	   <div class="carousel-inner">-->
				<!--		  @if($videos->isNotEmpty())-->
				<!--		  @foreach($videos as $key => $video)-->
				<!--		  <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">-->
				<!--			 <div class="img_middle">-->
				<!--				@if(pathinfo($video->file_path, PATHINFO_EXTENSION) == 'mp4')-->
				<!--				<video width="100%" style="padding-top:200px;" controls autoplay>-->
				<!--				   <source src="{{ asset('storage/app/public/' . $video->file_path) }}" type="video/mp4">-->
				<!--				   Your browser does not support the video tag.-->
				<!--				</video>-->
				<!--				@else-->
				<!--				<img src="{{ asset('storage/app/public/' . $video->file_path) }}" alt="slider">-->
				<!--				@endif-->
				<!--			 </div>-->
				<!--			 <div class="login_banner_text">-->
				<!--				<h2><b>{{ ucfirst($video->file_name) }}</b></h2>-->
				<!--				<p>{{ ucfirst($video->description) }}<p>-->
				<!--			 </div>-->
				<!--		  </div>-->
				<!--		  @endforeach-->
				<!--		  @else-->
						  <!-- Default image carousel item if no videos/images are found -->
				<!--		  <div class="carousel-item active">-->
				<!--			 <div class="img_middle">-->
				<!--				<img src="{{ asset('frontend/assets/img/img1.gif') }}" alt="Default Image">-->
				<!--			 </div>-->
				<!--			 <div class="login_banner_text">-->
				<!--				<h2>No Media Available</h2>-->
				<!--				<p>Please check back later for updates.</p>-->
				<!--			 </div>-->
				<!--		  </div>-->
				<!--		  @endif-->
				<!--	   </div>-->
				<!--	   <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">-->
				<!--	   <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
				<!--	   <span class="visually-hidden">Previous</span>-->
				<!--	   </button>-->
				<!--	   <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">-->
				<!--	   <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
				<!--	   <span class="visually-hidden">Next</span>-->
				<!--	   </button>-->
				<!--	</div>-->
				<!-- </div>	-->
				<div class="col-sm-6 bg-left_main">
                    <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @if($videos->isNotEmpty())
                                @foreach($videos as $key => $video)
                                    <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" aria-label="Slide {{ $key + 1 }}"></button>
                                @endforeach
                            @else
                                <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>
                            @endif
                        </div>
                        <div class="carousel-inner">
                            @if($videos->isNotEmpty())
                                @foreach($videos as $key => $video)
                                    <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                        <div class="img_middle">
                                            @if(pathinfo($video->file_path, PATHINFO_EXTENSION) == 'mp4')
                                                <video width="100%" style="padding-top:200px;" muted controls>
                                                    <source src="{{ asset('storage/app/public/' . $video->file_path) }}" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            @else
                                                <img src="{{ asset('storage/app/public/' . $video->file_path) }}" alt="slider">
                                            @endif
                                        </div>
                                        <div class="login_banner_text">
                                            	<h2><b>{{ ucfirst($video->file_name) }}</b></h2>
							                    	<p>{{ ucfirst($video->description) }}<p>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Default image carousel item if no videos/images are found -->
                                <div class="carousel-item active">
                                    <div class="img_middle">
                                        <img src="{{ asset('frontend/assets/img/defult.gif') }}" alt="Default Image">
                                    </div>
                                    <div class="login_banner_text">
                                        <h2>No Media Available</h2>
                                        <p>Please check back later for updates.</p>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
				
               <div class="col-sm-6 bg-white">
                  <div class="row">
                     <div class="login_main_right">
                        <div class="text-center">
                           <div class="account-logo">
                              <a href="#"><img src="{{asset('frontend/assets/img/swc-logo-new.png')}}" alt="SWCH"></a>
                           </div>
                           <h3 class="account-title mt-4">Login</h3>
                           <p class="account-subtitle">Access to our dashboard</p>
                        </div>
                        <form action="" method="post">
                           @csrf
                           @include('employeer.layout.message')
                           <div class="input-block mb-4">
                              <label class="col-form-label">Email Address</label>
                              <input class="form-control" type="text" value="" name="email">
                              @if ($errors->has('email'))
                              <div class="error" style="color:red;">{{ $errors->first('email') }}</div>
                              @endif
                           </div>
                           <div class="input-block mb-4">
                              <div class="row align-items-center">
                                 <div class="col">
                                    <label class="col-form-label">Password</label>
                                 </div>
                              </div>
                              <div class="position-relative">
                                 <input class="form-control" type="password" value="" id="password" name="psw">
                                 @if ($errors->has('psw'))
                                 <div class="error" style="color:red;">{{ $errors->first('psw') }}</div>
                                 @endif
                                 <div class="eye_section">
                                    <span class="fa-solid fa-eye-slash" id="toggle-password"></span>
                                 </div>
                              </div>
                              <div class="row align-items-center mt-2">
                                 <div class="col">
                                    <label class="col-form-label"></label>
                                 </div>
                                 <div class="col-auto">
                                    <a class="text-muted" href="{{ url('forgot-password') }}">
                                    Forgot password?
                                    </a>
                                 </div>
                              </div>
                           </div>
                           <div class="input-block mb-4 text-center">
                              <button class="btn btn-primary account-btn login-btn" type="submit">Login</button>
                           </div>
                           <div class="account-footer text-center">
                              <p>Don't have an account yet? <a href="{{ url('register') }}">Register</a></p>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- Main Wrapper -->
      <!--     <div class="main-wrapper">-->
      <!--<div class="account-content">-->
      <!--	{{-- <a href="job-list.html" class="btn btn-primary apply-btn">Apply Job</a> --}}-->
      <!--	<div class="container">-->
      <!--		 Account Logo -->
      <!--		<div class="account-logo">-->
      <!--			<a href="admin-dashboard.html"><img src="{{asset('frontend/assets/img/swch_logo.png')}}" alt="Dreamguy's Technologies"></a>-->
      <!--		</div>-->
      <!--		 /Account Logo -->
      <!--		<div class="account-box">-->
      <!--			<div class="account-wrapper">-->
      <!--				<h3 class="account-title">Login</h3>-->
      <!--				<p class="account-subtitle">Access to our dashboard</p>-->
      <!--				 Account Form -->
      <!--				<form action="" method="post">-->
      <!--                             @csrf-->
      <!--                             @include('layout.message')-->
      <!--					<div class="input-block mb-4">-->
      <!--						<label class="col-form-label">Email Address</label>-->
      <!--						<input class="form-control" type="text" value="" name="email">-->
      <!--                                 @if ($errors->has('email'))-->
      <!--                                 <div class="error" style="color:red;">{{ $errors->first('email') }}</div>-->
      <!--                                 @endif-->
      <!--					</div>-->
      <!--					<div class="input-block mb-4">-->
      <!--						<div class="row align-items-center">-->
      <!--							<div class="col">-->
      <!--								<label class="col-form-label">Password</label>-->
      <!--							</div>-->
      <!--							<div class="col-auto">-->
      <!--								<a class="text-muted" href="{{ url('forgot-password') }}">-->
      <!--									Forgot password?-->
      <!--								</a>-->
      <!--							</div>-->
      <!--						</div>-->
      <!--						<div class="position-relative">-->
      <!--							<input class="form-control" type="password" value="" id="password" name="psw">-->
      <!--                                     @if ($errors->has('psw'))-->
      <!--                                     <div class="error" style="color:red;">{{ $errors->first('psw') }}</div>-->
      <!--                                     @endif-->
      <!--							<span class="fa-solid fa-eye-slash" id="toggle-password"></span>-->
      <!--						</div>-->
      <!--					</div>-->
      <!--					<div class="input-block mb-4 text-center">-->
      <!--						<button class="btn btn-primary account-btn" type="submit">Login</button>-->
      <!--					</div>-->
      <!--					<div class="account-footer">-->
      <!--						<p>Don't have an account yet? <a href="{{ url('register') }}">Register</a></p>-->
      <!--					</div>-->
      <!--				</form>-->
      <!--				 /Account Form -->
      <!--			</div>-->
      <!--		</div>-->
      <!--	</div>-->
      <!--</div>-->
      <!--     </div>-->
      <!-- /Main Wrapper -->
      <!-- jQuery -->
      <script src="{{asset('frontend/assets/js/jquery-3.7.1.min.js')}}"></script>
      <!-- Bootstrap Core JS -->
      <script src="{{asset('frontend/assets/js/bootstrap.bundle.min.js')}}"></script>
      <!-- Custom JS -->
      <script src="{{asset('frontend/assets/js/app.js')}}"></script>
        <script>
    document.addEventListener('DOMContentLoaded', function() {
        const carousel = document.querySelector('#carouselExampleAutoplaying');
        const videos = carousel.querySelectorAll('video');

        // Initially pause all videos and set them to muted
        videos.forEach(video => {
            video.pause();
            video.muted = true;
        });

        // Listen for carousel slide event
        carousel.addEventListener('slid.bs.carousel', function() {
            // Pause all videos and set them back to muted
            videos.forEach(video => {
                video.pause();
                video.muted = true;
            });

            // Find the active item and play the video with sound if it's available
            const activeItem = carousel.querySelector('.carousel-item.active');
            const video = activeItem.querySelector('video');

            if (video) {
                video.muted = false; // Unmute the video
                video.currentTime = 0; // Start from the beginning
                video.play(); // Play only the video in the active slide
            }
        });
    });
</script>
   </body>
</html>