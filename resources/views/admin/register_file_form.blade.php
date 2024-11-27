<!DOCTYPE html>
<html lang="en">
   <head>
      <meta http-equiv="X-UA-Compatible" content="IE=edge" />
      <link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
      <title>SWCH</title>
      <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
      <!-- Fonts and icons -->
      <script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
      <script>
         WebFont.load({
         	google: {"families":["Lato:300,400,700,900"]},
         	custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('assets/css/fonts.min.css')}}']},
         	active: function() {
         		sessionStorage.fonts = true;
         	}
         });
      </script>
      <!-- CSS Files -->
      <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css')}}">
      <link rel="stylesheet" href="{{ asset('assets/css/atlantis.min.css')}}">
      <!-- CSS Just for demo purpose, don't include it in your project -->
      <link rel="stylesheet" href="{{ asset('assets/css/demo.css')}}">
      <style>.autocomplete {
         position: relative;
         display: inline-block;
         }
         input {
         border: 1px solid transparent;
         background-color: #f1f1f1;
         padding: 10px;
         font-size: 16px;
         }
         input[type=text] {
         background-color: #f1f1f1;
         width: 100%;
         }
         input[type=submit] {
         background-color: DodgerBlue;
         color: #fff;
         cursor: pointer;
         }
         .autocomplete-items {
         position: absolute;
         border: 1px solid #d4d4d4;
         border-bottom: none;
         border-top: none;
         z-index: 99;
         /*position the autocomplete items to be the same width as the container:*/
         top: 100%;
         left: 0;
         right: 0;
         }
         .autocomplete-items div {
         padding: 10px;
         cursor: pointer;
         background-color: #fff; 
         border-bottom: 1px solid #d4d4d4; 
         }
         /*when hovering an item:*/
         .autocomplete-items div:hover {
         background-color: #e9e9e9; 
         }
         /*when navigating through the items using the arrow keys:*/
         .autocomplete-active {
         background-color: DodgerBlue !important; 
         color: #ffffff; 
         }
      </style>
   </head>
   <body>
      <div class="wrapper">
         @include('admin.include.header')
         <!-- Sidebar -->
         @include('admin.include.sidebar')
         <!-- End Sidebar -->
         <div class="main-panel">
            <div class="page-header">
               <!--<ul class="breadcrumbs">-->
               <!--	<li class="nav-home">-->
               <!--		<a href="#">-->
               <!--			<i class="flaticon-home"></i>-->
               <!--		</a>-->
               <!--	</li>-->
               <!--	 <li class="separator">-->
               <!--		<i class="flaticon-right-arrow"></i>-->
               <!--	</li>-->
               <!--	<li class="nav-item">-->
               <!--		<a href="#">HR File</a>-->
               <!--	</li>-->
               <!--	<li class="separator">-->
               <!--		<i class="flaticon-right-arrow"></i>-->
               <!--	</li>-->
               <!--	<li class="nav-item">-->
               <!--		<a href="{{url('superadmin/view-add-hr')}}"> HR File</a>-->
               <!--	</li>-->
               <!--	<li class="separator">-->
               <!--		<i class="flaticon-right-arrow"></i>-->
               <!--	</li>-->
               <!--	<li class="nav-item">-->
               <!--		<a href="#"> New HR File</a>-->
               <!--	</li> -->
               <!--</ul>-->
            </div>
            <div class="content">
               <div class="page-inner">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="card custom-card">
                           <div class="card-header">
                              <h4 class="card-title"><i class="fas fa-file"></i> Register Page Video And Images Uplode</h4>
                           </div>
                           <div class="card-body">
                              <!--<form action="{{ url('superadmin/upload_register_video_image') }}" method="post" enctype="multipart/form-data" id="myForm">-->
                              <!--   {{csrf_field()}}-->
                              <!--   <div class="row form-group">-->
                              <!--      <div class="col-md-6">-->
                              <!--         <div class="form-group">-->
                              <!--            <label for="name" class="placeholder">Title Of Slide</label>-->
                              <!--            <input type="text" class="form-control input-border-bottom" id="emidname" type="text"  name="name" required="">-->
                              <!--         </div>-->
                              <!--      </div>-->
                              <!--      <div class="col-md-6">-->
                              <!--         <div class="form-group">-->
                              <!--            <label for="description" class="placeholder">Description Of Slide</label>-->
                              <!--            <textarea class="form-control input-border-bottom" id="description" name="description" required></textarea>-->
                              <!--         </div>-->
                              <!--      </div>-->
                              <!--      <div class="col-md-6">-->
                              <!--         <div class="form-group">-->
                              <!--            <label for="ref_id" class="placeholder" style="padding-top:0;">File</label>-->
                              <!--            <input type="file" class="form-control input-border-bottom" name="image" required="">-->
                              <!--         </div>-->
                              <!--      </div>-->
                              <!--      <div class="col-md-12" id="show_image">-->
                                           
                              <!--      </div>-->
                              <!--   </div>-->
                              <!--   <div class="row form-group">-->
                              <!--      <div class="col-md-4">-->
                              <!--         <button type="submit" class="btn btn-default btn-up">Submit</button>-->
                              <!--      </div>-->
                              <!--   </div>-->
                              <!--</form>-->
                              <form action="{{ isset($video) ? route('update.register.video.image', $video->id) : route('upload.register.video.image') }}" 
      method="POST" 
      enctype="multipart/form-data" 
      id="myForm">
    {{ csrf_field() }}
    @if(isset($video))
        @method('PUT')
    @endif

    <div class="row form-group">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name" class="placeholder">Title Of Slide</label>
                <input type="text" 
                       class="form-control input-border-bottom" 
                       id="emidname" 
                       name="name" 
                       required 
                       value="{{ old('file_name', $video->file_name ?? '') }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="description" class="placeholder">Description Of Slide</label>
                <textarea class="form-control input-border-bottom" 
                          id="description" 
                          name="description" 
                          required>{{ old('description', $video->description ?? '') }}</textarea>
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="slide_order" class="placeholder">Slide Order</label>
                <input type="number" 
                       class="form-control input-border-bottom" 
                       id="slide_order" 
                       name="slide_order" 
                       required 
                       value="{{ old('slide_order', $video->slide_order ?? '') }}">
            </div>
        </div>

        <div class="col-md-6">
            <div class="form-group">
                <label for="image" class="placeholder">Select Image Or Video</label>
                <input type="file" 
                       class="form-control input-border-bottom" 
                       name="image" 
                       {{ isset($video) ? '' : 'required' }}>
            </div>
        </div>
        @if(isset($video))
      @if(in_array(pathinfo($video->file_path, PATHINFO_EXTENSION), ['mp4']))
                                                   <!-- Display video if the file is an mp4 -->
                                                   <video width="300" controls>
                                                       <source src="{{ asset('storage/' . $video->file_path) }}" type="video/mp4">
                                                       Your browser does not support the video tag.
                                                   </video>
                                               @else
                                                   <!-- Display image if the file is not an mp4 -->
                                                   <img src="{{ asset('storage/app/public/' . $video->file_path) }}" alt="Image" width="300">
                                               @endif
                                               @endif
    </div>

    <div class="row form-group">
        <div class="col-md-4">
            <button type="submit" class="btn btn-default btn-up">{{ isset($video) ? 'Update' : 'Submit' }}</button>
        </div>
    </div>
</form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @include('admin.include.footer')
         </div>
      </div>
      <!--   Core JS Files   -->
      <script src="{{ asset('assets/js/core/jquery.3.2.1.min.js')}}"></script>
      <script src="{{ asset('assets/js/core/popper.min.js')}}"></script>
      <script src="{{ asset('assets/js/core/bootstrap.min.js')}}"></script>
      <!-- jQuery UI -->
      <script src="{{ asset('assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
      <script src="{{ asset('assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>
      <!-- jQuery Scrollbar -->
      <script src="{{ asset('assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
      <!-- Datatables -->
      <script src="{{ asset('assets/js/plugin/datatables/datatables.min.js')}}"></script>
      <!-- Atlantis JS -->
      <script src="{{ asset('assets/js/atlantis.min.js')}}"></script>
      <!-- Atlantis DEMO methods, don't include it in your project! -->
      <script src="{{ asset('assets/js/setting-demo2.js')}}"></script>
   </body>
</html>