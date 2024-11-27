<!DOCTYPE html>
<html lang="en" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <meta name="description" content="Smarthr - Bootstrap Admin Template">
      <meta name="keywords" content="admin, estimates, bootstrap, business, corporate, creative, management, minimal, modern, accounts, invoice, html5, responsive, CRM, Projects">
      <meta name="author" content="Dreamstechnologies - Bootstrap Admin Template">
      <title>Register - HRMS admin template</title>
      <!-- Favicon -->
      <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/assets/img/swch_logo.png') }}">
      <!-- Bootstrap CSS -->
      <link rel="stylesheet" href="{{asset('frontend/assets/css/bootstrap.min.css')}}">
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
         .height_register{
         height:525px;
         overflow:hidden;
         overflow-y:scroll;
         }
         .container2 {
         /*width: 200px;*/
         height:510px;
         overflow: auto;
         margin-bottom:60px;
         }
         /* the scrollbar area itself */
         ::-webkit-scrollbar {
         }
         /* the up/down/left/right buttons */
         ::-webkit-scrollbar-button {
         }
         /* the zone where the scroll will happen */
         ::-webkit-scrollbar-track {
         }
         /* not sure what this is */ 
         ::-webkit-scrollbar-track-piece {
         }
         /* the famous "elevator" */
         ::-webkit-scrollbar-thumb {
         }
         /* what stands in the corner, between the horizontal and the vertical scrollbars */
         ::-webkit-scrollbar-corner {
         }
         /* the resizer thingy into that corner */
         ::-webkit-resizer {
         }
         ::-webkit-scrollbar {
         width: 4px;
         }
         ::-webkit-scrollbar-track {
         border-radius: 10px;
         }
         ::-webkit-scrollbar-thumb {
         border-radius: 10px;
         webkit-box-shadow: inset 0 0 2px rgba(0,0,0,0.5); 
         background:#f9932f; 
         }
         @media(max-width:1199px){
         .login_main_right {
         padding: 85px 15px 0px 15px;
         }
         .img_middle img {
         margin-top: 18px;
         }
         }
         @media(max-width:768px){
         .container2 {
         width: 100%;
         height: auto;
         overflow: inherit;
         }
         .account-footer{
         text-align: center !important;
         }
         .account-footer a{
         display:block;
         margin-bottom:10px;
         }
         }
      </style>
   </head>
   <body class="account-page">
      <div class="container">
         <div class="main_bg bg-light padding p-0">
            <div class="row">
               <div class="col-sm-6 bg-white">
                  <div class="row">
                     <div class="login_main_right pt-0">
                        <div class="text-center">
                           <div class="account-logo">
                              <a href="https://skilledworkerscloud.co.uk/hrms-v2/"><img src="{{asset('frontend/assets/img/swc-logo-new.png')}}" alt="SWCH"></a>
                           </div>
                           <h3 class="account-title mt-4">Register Here</h3>
                           <!--<p class="account-subtitle">Access to our dashboard</p>-->
                        </div>
                        <form class="container2" action="{{url('register')}}" method="post" enctype="multipart/form-data">
                           {{csrf_field()}}
                           @include('employeer.layout.message')
                           @if (!empty($org_code))
                           <input type="hidden" class="form-control" name="org_code"  value="{{$org_code}}" autocomplete="off" >
                           <input type="hidden" class="form-control" name="subadmin"  value="Organization" autocomplete="off" >
                           @else
                           <div class="input-block mb-2">
                              <label class="col-form-label">Select type<span class="mandatory">*</span></label>
                              <select class="form-control" name="subadmin"  required="">
                                 <option value="">Select type</option>
                                 <option value="Partner">Partner</option>
                                 <option value="Organization">Organization</option>
                              </select>
                           </div>
                           @endif
                           <div class="input-block mb-2">
                              <label class="col-form-label">Organization name<span class="mandatory">*</span></label>
                              <input class="form-control" type="text" placeholder="Organization name" name="com_name"  required="" value="{{old('com_name')}}">
                              @if ($errors->has('com_name'))
                              <div class="error" style="color:red;">{{ $errors->first('com_name') }}</div>
                              @endif
                           </div>
                           <div class="input-block mb-2">
                              <label class="col-form-label">First Name<span class="mandatory">*</span></label>
                              <input class="form-control" type="text" name="f_name" required="" value="{{old('f_name')}}">
                              @if ($errors->has('f_name'))
                              <div class="error" style="color:red;">{{ $errors->first('f_name') }}</div>
                              @endif
                           </div>
                           <div class="input-block mb-2">
                              <label class="col-form-label">Last Name<span class="mandatory">*</span></label>
                              <input class="form-control" type="text" name="l_name" required=""  value="{{old('l_name')}}">
                              @if ($errors->has('l_name'))
                              <div class="error" style="color:red;">{{ $errors->first('l_name') }}</div>
                              @endif
                           </div>
                           <div class="input-block mb-2">
                              <label class="col-form-label">Email<span class="mandatory">*</span></label>
                              <input class="form-control" type="email" name="email" required="" value="{{old('email')}}">
                              @if ($errors->has('email'))
                              <div class="error" style="color:red;">{{ $errors->first('email') }}</div>
                              @endif
                           </div>
                           <div class="input-block mb-2">
                              <label class="col-form-label">Country<span class="mandatory">*</span></label>
                              <select class="form-control" name="country" id="country" required="">
                                 <option value="">Select Country</option>
                                 <?php foreach($user_details as $item){ ?>
                                 <option value="<?php echo $item->name ?>">{{$item->name}}</option>
                                 <?php } ?>
                              </select>
                           </div>
                           <div class="input-block mb-2">
                              <label class="col-form-label">Country Code<span class="mandatory">*</span></label>
                              <select class="form-control" name="country_code" id="country_code" required="">
                                 {{-- 
                                 <option value="">Select Country Code</option>
                                 --}}
                                 <?php //foreach($user_details as $item){ ?>
                                 {{-- 
                                 <option value="<?php// echo '+'.$item->phonecode ?>">+{{$item->phonecode}}</option>
                                 --}}
                                 <?php // } ?>
                              </select>
                           </div>
                           <div class="input-block mb-2">
                              <label class="col-form-label">Your Contact Number<span class="mandatory">*</span></label>								
                              <input class="form-control" type="text" name="p_no" required="" value="{{old('p_no')}}">
                              @if ($errors->has('p_no'))
                              <div class="error" style="color:red;">{{ $errors->first('p_no') }}</div>
                              @endif
                           </div>
                           <div class="input-block mb-2">
                              <label class="col-form-label">Password<span class="mandatory">*</span></label>
                              <input class="form-control" type="text" name="pass" required="">
                              @if ($errors->has('pass'))
                              <div class="error" style="color:red;">{{ $errors->first('pass') }}</div>
                              @endif
                           </div>
                           <div class="input-block mb-2">
                              <label class="col-form-label">Repeat Password<span class="mandatory">*</span></label>
                              <input class="form-control" type="text" name="con_password" required="">
                              @if ($errors->has('con_password'))
                              <div class="error" style="color:red;">{{ $errors->first('con_password') }}</div>
                              @endif
                           </div>
                           <div class="input-block mb-2 text-center">
                              <button class="btn btn-primary account-btn d-block w-100" type="submit">Register</button>
                           </div>
                           <div class="account-footer text-center">
                              <p>Already have an account? <a href="{{ url('/') }}">Login</a></p>
                           </div>
                        </form>
                     </div>
                  </div>
               </div>
        <!--       <div class="col-sm-6 bg-left_main">-->
        <!--          <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">-->
        <!--             <div class="carousel-indicators">-->
        <!--                @if($videos->isNotEmpty())-->
        <!--                @foreach($videos as $key => $video)-->
        <!--                <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="{{ $key }}" class="{{ $key == 0 ? 'active' : '' }}" aria-label="Slide {{ $key + 1 }}"></button>-->
        <!--                @endforeach-->
        <!--                @else-->
        <!--                <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="0" class="active" aria-label="Slide 1"></button>-->
        <!--                @endif-->
        <!--             </div>-->
        <!--             <div class="carousel-inner">-->
        <!--                @if($videos->isNotEmpty())-->
        <!--                @foreach($videos as $key => $video)-->
        <!--                <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">-->
        <!--                   <div class="img_middle">-->
        <!--                      @if(pathinfo($video->file_path, PATHINFO_EXTENSION) == 'mp4')-->
        <!--                      <video width="100%" style="padding-top:200px;" controls>-->
        <!--                         <source src="{{ asset('storage/app/public/' . $video->file_path) }}" type="video/mp4">-->
        <!--                         Your browser does not support the video tag.-->
        <!--                      </video>-->
        <!--                      @else-->
        <!--                      <img src="{{ asset('storage/app/public/' . $video->file_path) }}" alt="slider">-->
        <!--                      @endif-->
        <!--                   </div>-->
        <!--                   <div class="login_banner_text">-->
        <!--                      <h2><b>{{ ucfirst($video->file_name) }}</b></h2>-->
								<!--<p>{{ ucfirst($video->description) }}<p>-->
        <!--                   </div>-->
        <!--                </div>-->
        <!--                @endforeach-->
        <!--                @else-->
                        <!-- Default image carousel item if no videos/images are found -->
        <!--                <div class="carousel-item active">-->
        <!--                   <div class="img_middle">-->
        <!--                      <img src="{{ asset('frontend/assets/img/img2.gif') }}" alt="Default Image">-->
        <!--                   </div>-->
        <!--                   <div class="login_banner_text">-->
        <!--                      <h2>No Media Available</h2>-->
        <!--                      <p>Please check back later for updates.</p>-->
        <!--                   </div>-->
        <!--                </div>-->
        <!--                @endif-->
        <!--             </div>-->
        <!--             <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">-->
        <!--             <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
        <!--             <span class="visually-hidden">Previous</span>-->
        <!--             </button>-->
        <!--             <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">-->
        <!--             <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
        <!--             <span class="visually-hidden">Next</span>-->
        <!--             </button>-->
        <!--          </div>-->
        <!--       </div>-->
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
            </div>
         </div>
      </div>
      <!-- Main Wrapper -->
      <!--     <div class="main-wrapper">-->
      <!--<div class="account-content">-->
      <!--	<div class="container">-->
      <!--		<div class="account-logo">-->
      <!--			<a href="admin-dashboard.html"><img src="{{asset('frontend/assets/img/swch_logo.png')}}" alt="Dreamguy's Technologies"></a>-->
      <!--		</div>-->
      <!--		<div class="account-box">-->
      <!--			<div class="account-wrapper">-->
      <!--				<h3 class="account-title">Register Here</h3>-->
      <!--				{{-- <p class="account-subtitle">Access to our dashboard</p> --}}-->
      <!--				<form action="{{url('register')}}" method="post" enctype="multipart/form-data">-->
      <!--                             {{csrf_field()}}-->
      <!--                             @include('layout.message')-->
      <!--                                @if (!empty($org_code))-->
      <!--                                    <input type="hidden" class="form-control" name="org_code"  value="{{$org_code}}" autocomplete="off" >-->
      <!--                                    <input type="hidden" class="form-control" name="subadmin"  value="Organization" autocomplete="off" >-->
      <!--                                @else-->
      <!--                                     <div class="input-block mb-4">-->
      <!--                                         <label class="col-form-label">Select type<span class="mandatory">*</span></label>-->
      <!--                                         <select class="form-control" name="subadmin"  required="">-->
      <!--                                             <option value="">Select type</option>-->
      <!--                                             <option value="Partner">Partner</option>-->
      <!--                                             <option value="Organization">Organization</option>-->
      <!--                                         </select>-->
      <!--                                    </div>	-->
      <!--                                @endif-->
      <!--                             <div class="input-block mb-4">-->
      <!--						<label class="col-form-label">Organization name<span class="mandatory">*</span></label>-->
      <!--						<input class="form-control" type="text" placeholder="Organization name" name="com_name"  required="" value="{{old('com_name')}}">-->
      <!--                                 @if ($errors->has('com_name'))-->
      <!--                                     <div class="error" style="color:red;">{{ $errors->first('com_name') }}</div>-->
      <!--                                 @endif-->
      <!--					</div>-->
      <!--					<div class="input-block mb-4">-->
      <!--						<label class="col-form-label">First Name<span class="mandatory">*</span></label>-->
      <!--						<input class="form-control" type="text" name="f_name" required="" value="{{old('f_name')}}">-->
      <!--                                 @if ($errors->has('f_name'))-->
      <!--							<div class="error" style="color:red;">{{ $errors->first('f_name') }}</div>-->
      <!--					    @endif-->
      <!--					</div>-->
      <!--					<div class="input-block mb-4">-->
      <!--						<label class="col-form-label">Last Name<span class="mandatory">*</span></label>-->
      <!--						<input class="form-control" type="text" name="l_name" required=""  value="{{old('l_name')}}">-->
      <!--                                 @if ($errors->has('l_name'))-->
      <!--							<div class="error" style="color:red;">{{ $errors->first('l_name') }}</div>-->
      <!--					    @endif-->
      <!--					</div>-->
      <!--                             <div class="input-block mb-4">-->
      <!--						<label class="col-form-label">Email<span class="mandatory">*</span></label>-->
      <!--						<input class="form-control" type="email" name="email" required="" value="{{old('email')}}">-->
      <!--                                 @if ($errors->has('email'))-->
      <!--							<div class="error" style="color:red;">{{ $errors->first('email') }}</div>-->
      <!--					    @endif-->
      <!--					</div>-->
      <!--					<div class="input-block mb-4">-->
      <!--						<label class="col-form-label">Country<span class="mandatory">*</span></label>-->
      <!--						<select class="form-control" name="country" id="country" required="">-->
      <!--							<option value="">Select Country</option>-->
      <!--							<?php foreach($user_details as $item){ ?>-->
      <!--								<option value="<?php echo $item->name ?>">{{$item->name}}</option>-->
      <!--							<?php } ?>-->
      <!--						</select>-->
      <!--					</div>-->
      <!--                             <div class="input-block mb-4">-->
      <!--						<label class="col-form-label">Country Code<span class="mandatory">*</span></label>-->
      <!--						<select class="form-control" name="country_code" id="country_code" required="">-->
      <!--                                     {{-- <option value="">Select Country Code</option> --}}-->
      <?php //foreach($user_details as $item){ ?>
      {{-- 
      <option value="<?php// echo '+'.$item->phonecode ?>">+{{$item->phonecode}}</option>
      --}}
      <?php // } ?>
      <!--                                 </select>-->
      <!--					</div>-->
      <!--                             <div class="input-block mb-4">-->
      <!--						<label class="col-form-label">Your Contact Number<span class="mandatory">*</span></label>								-->
      <!--						<input class="form-control" type="text" name="p_no" required="" value="{{old('p_no')}}">-->
      <!--                                 @if ($errors->has('p_no'))-->
      <!--							<div class="error" style="color:red;">{{ $errors->first('p_no') }}</div>-->
      <!--					    @endif-->
      <!--					</div>-->
      <!--                             <div class="input-block mb-4">-->
      <!--						<label class="col-form-label">Password<span class="mandatory">*</span></label>-->
      <!--						<input class="form-control" type="text" name="pass" required="">-->
      <!--                                 @if ($errors->has('pass'))-->
      <!--							<div class="error" style="color:red;">{{ $errors->first('pass') }}</div>-->
      <!--					    @endif-->
      <!--					</div>-->
      <!--                             <div class="input-block mb-4">-->
      <!--						<label class="col-form-label">Repeat Password<span class="mandatory">*</span></label>-->
      <!--						<input class="form-control" type="text" name="con_password" required="">-->
      <!--                                 @if ($errors->has('con_password'))-->
      <!--							<div class="error" style="color:red;">{{ $errors->first('con_password') }}</div>-->
      <!--					    @endif-->
      <!--					</div>-->
      <!--					<div class="input-block mb-4 text-center">-->
      <!--						<button class="btn btn-primary account-btn" type="submit">Register</button>-->
      <!--					</div>-->
      <!--					<div class="account-footer">-->
      <!--						<p>Already have an account? <a href="{{ url('/') }}">Login</a></p>-->
      <!--					</div>-->
      <!--				</form>-->
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
      <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
      <script>
         $(document).ready(function() {
             $('#country').change(function() {
                 var countryName = $(this).val();
                 //console.log(countryName);
                 if (countryName) {
                     $.ajax({
                         url: "{{ route('get-country-code') }}",
                         type: "GET",
                         data: { country: countryName },
                         success: function(response) {
                             if (response.phonecode) {
                                 $('#country_code').html('<option value="+' + response.phonecode + '">+' + response.phonecode + '</option>');
                             } else {
                                 $('#country_code').html('<option value="">Country code not found</option>');
                             }
                         },
                         error: function(xhr) {
                             console.error("An error occurred: " + xhr.status + " " + xhr.statusText);
                             $('#country_code').html('<option value="">Country code not found</option>');
                         }
                     });
                 } else {
                     $('#country_code').html('<option value="">Select Country Code</option>');
                 }
             });
         });
         
      </script>
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