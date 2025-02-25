<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
		<link rel="icon" href="{{ asset('img/favicon.png')}}">
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="{{ asset('assets/img/icon.ico')}}" type="image/x-icon"/>
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
	 <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>

	 <style>
input[type=checkbox], input[type=radio] {
    /* padding-right: 10px; */
    margin-right: 8px;
}
.vat{margin-top:17px;}
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
						<!-- <h4 class="page-title">Package</h4> -->
			</div>
			<div class="content">
				<div class="page-inner">
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="fas fa-bars"></i>Edit Billing Item</h4>
								</div>
								<div class="card-body" style="">
                                    {{-- <form action="{{ route('billing_item.update', $item->id) }}" method="post">
                                        @csrf
                                        <label>Item Name</label>
                                        <input type="text" name="item_name" class="form-control" value="{{ $item->item_name }}" required>
                                
                                        <label>Description</label>
                                        <textarea name="description" class="form-control">{{ $item->description }}</textarea>
                                
                                        <label>Status</label>
                                        <select name="status" class="form-control" required>
                                            <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>Active</option>
                                            <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>Inactive</option>
                                        </select>
                                
                                        <button type="submit" class="btn btn-primary">Update</button>
                                    </form> --}}
                                    <form action="{{ route('billing_item.update', $item->id) }}" method="post" enctype="multipart/form-data">
			                            {{csrf_field()}}			                            
										<div class="row">
		 	                                
		 	                                <div class="col-md-6">
										        <div class="form-group ">
										            <label for="menu_name" class="placeholder">Item Name</label>
                                                    <input type="text" name="item_name" class="form-control" value="{{ $item->item_name }}" required>
											    </div>
										    </div>
                                            <div class="col-md-2">
										        <div class="form-group ">
										            <label for="status" class="placeholder">Status</label>    
                                                    <select name="status" class="form-control" required>
                                                        <option value="0" {{ $item->status == 0 ? 'selected' : '' }}>Active</option>
                                                        <option value="1" {{ $item->status == 1 ? 'selected' : '' }}>Inactive</option>
                                                    </select>
											    </div>
										    </div>
                                            <div class="col-md-10">
										        <div class="form-group ">
										            <label for="description" class="placeholder">Description</label>
                                                    <textarea name="description" class="form-control">{{ $item->description }}</textarea>
											    </div>
										    </div>
                                        
                                            <div class="col-md-12 btn-up">
                                                <button type="submit" class="btn btn-default">Submit</button></div>
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
	<script >
		$(document).ready(function() {
			$('#basic-datatables').DataTable({
			});
            
            
		});


	</script>

</body>
</html>