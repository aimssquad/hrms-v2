 <!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
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
	<style>
	    .card .card-body, .card-light .card-body {
    padding: 20px 10px;
}
.main-panel{margin-top:0;}
	</style>
</head>
<body>
	<div class="wrapper">

		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title"> New Pay Group</h4>
								</div>
								<div class="card-body">
								   <?php if(isset($_GET['id'])){ 
								    ?>
									<form action="{{url('appsettings/paygroup?id='.$_GET['id'])}}" method="post" enctype="multipart/form-data">
									    <?php
								}else{
								    ?>
								     <form action="{{url('appsettings/paygroup')}}" method="post" enctype="multipart/form-data">
								    <?php
								}
								?>	   
									<input id="emid" type="hidden" class="form-control input-border-bottom" required="" name="emid"  value="{{$emid}}" >
			 {{csrf_field()}}
										<div class="row form-group">
										<div class="col-md-4">
										  
										  <div class="form-group form-floating-label">
												<input id="inputFloatingLabel" type="text" class="form-control input-border-bottom" required="" id="grade_name" name="grade_name"     value="<?php  if(app('request')->input('id')){  echo $getGrade[0]->grade_name; } ?>{{ old('grade_name') }}">
												<label for="inputFloatingLabel" class="placeholder">Pay Group</label>
												@if ($errors->has('grade_name'))
											<div class="error" style="color:red;">{{ $errors->first('grade_name') }}</div>
										@endif
											</div>
										</div>
										<div class="col-md-4">
										  <div class="form-group form-floating-label">
												<select class="form-control input-border-bottom" id="selectFloatingLabel" required="" name="grade_status">
													
													<option value="active"  <?php  if(app('request')->input('id')){ if($getGrade[0]->grade_status=='active'){ echo 'selected'; } } ?> >Active</option>
                                                    <option value="inactive"  <?php  if(app('request')->input('id')){ if($getGrade[0]->grade_status=='inactive'){ echo 'selected'; } } ?> >Inactive</option>
                                                    
												</select>
												<label for="selectFloatingLabel" class="placeholder">Select</label>
											</div>
										</div>
										<div class="col-md-4" style="margin-top:35px;">
										  <button class="btn btn-default" type="submit">Submit</button>
										</div>
										</div>
									</form>
								</div>
							</div>
						</div>

						

						
					</div>
				</div>
			</div>
		
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

			$('#multi-filter-select').DataTable( {
				"pageLength": 5,
				initComplete: function () {
					this.api().columns().every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value=""></option></select>')
						.appendTo( $(column.footer()).empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
								);

							column
							.search( val ? '^'+val+'$' : '', true, false )
							.draw();
						} );

						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						} );
					} );
				}
			});

			// Add Row
			$('#add-row').DataTable({
				"pageLength": 5,
			});

			var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

			$('#addRowButton').click(function() {
				$('#add-row').dataTable().fnAddData([
					$("#addName").val(),
					$("#addPosition").val(),
					$("#addOffice").val(),
					action
					]);
				$('#addRowModal').modal('hide');

			});
		});
	</script>
</body>
</html>