@php
	$orgDtl = DB::table('registration')->where('id',$organization_id)->get();
	$comName = $orgDtl[0]->com_name;
	//dd($comName);
@endphp
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
									<h4 class="card-title"><i class="fas fa-bars"></i>Organization Mobile Menu - {{ strtoupper($comName) }}<span></span></h4>
                                    @if(Session::has('message'))
                                    <div class="alert alert-denger" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
                                    @endif
								</div>
								<div class="card-body" style="">
									<form action="{{ route('save.employee.menu') }}" method="POST">
										@csrf <!-- CSRF Token for security -->
										<input type="hidden" name="organization_id" value="{{$organization_id}}">
										<div class="table-responsive">
											<table class="table table-striped table-bordered custom-table" style="border: 1px solid rgb(204, 200, 200);">
												<thead>
													<tr>
														<th width="50">#</th>
														<th>Module Permission</th>
													</tr>
												</thead>
												<tbody>
													@foreach($menus as $menu)
														<tr>
															<td class="text-center">
																<label class="custom_check">
																	<input type="checkbox" name="menu_ids[]" value="{{ $menu->id }}"
																		{{ in_array($menu->id, $assignedMenus) ? 'checked' : '' }}>													
																	<span class="checkmark"></span>
																</label>																
															</td>
															<td>{{ $menu->menu_name ?? 'N/A' }}</td>
														</tr>
													@endforeach
												</tbody>
											</table>
										</div>
									
										<div class="col-md-6">
											<label class="col-form-label">Status</label>
											<select name="status" class="form-control">
												<option value="">Select</option>
												<option value="1" {{ isset($status) && $status == 1 ? 'selected' : '' }}>Active</option>
												<option value="0" {{ isset($status) && $status == 0 ? 'selected' : '' }}>Inactive</option>
											</select>
										</div>
										<br>
										<div class="col-md-6">
											<button type="submit" class="btn btn-primary">Submit</button>
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