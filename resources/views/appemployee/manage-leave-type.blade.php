<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	
	<link rel="icon" href="{{ asset('assets/img/icon.ico')}}" type="image/x-icon"/>
	<!-- Fonts and icons -->
		<script src="{{ asset('assets/js/plugin/webfont/webfont.min.js')}}"></script>
		<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('employeeassets/css/fonts.min.css')}}'] },
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
</head>
<body>
	<div class="wrapper">
	
		<!-- End Sidebar -->
		<div class="main-panel">
	
			
			<div class="content">
				<div class="page-inner">
			
					<!-- New-Field -Start--->
                    <div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									
									@if(isset($holidaydtl) && !empty($holidaydtl))
                            	<h4 class="card-title"><img src="{{ asset('img/leave-icon.png')}}" alt="" width="17"> &nbsp; Edit Manage Leave Type</h4>
							
                            	@else
                                <h4 class="card-title"><i class="far fa-calendar"></i> Add Leave Type</h4>
							
						
                                @endif 
								</div>
								<div class="card-body">
									<form action="{{url('applaeve/leave-management/new-leave-type')}}" method="post" enctype="multipart/form-data" class="form-horizontal" >
									{{csrf_field()}}
												 <input type="hidden" name="id" value="<?php  if(!empty($holidaydtl->id)){echo $holidaydtl->id;} ?>">
										 <input type="hidden" name="reg" value="<?php echo $Roledata->reg;?>">
										
										<div class="row">
										<div class="col-md-6">
										<div class="form-group">
										    	<label for="leave-type" class="placeholder">Leave Type</label>
												<input  type="text" class="form-control input-border-bottom" required=""  name='leave_type_name' id="leave-type" value="<?php if(isset($holidaydtl->id)){  echo $holidaydtl->leave_type_name;  }?>{{ old('leave_type_name') }}">
											
													@if($errors->has('leave_type_name'))
                                            <div class="error" style="color:red;">{{$errors->first('leave_type_name')}}</div>
                                        @endif
										
											</div>
																									  
										</div>
										<div class="col-md-6">
										   <div class="form-group">
										       <label for="alias" class="placeholder">Leave Type Sort Code</label>
												<input  type="text" class="form-control input-border-bottom" required=""  name='alies'  id="alias" value="<?php if(isset($holidaydtl->id)){  echo $holidaydtl->alies;  }?>{{ old('alies') }}">
												
																			@if($errors->has('alies'))
                                            <div class="error" style="color:red;">{{ $errors->first('alies') }}</div>
                                 @endif
									
											</div>
										
				                     	</div>

				                     	
							

				                     	<div class="col-md-6">
										   <div class="form-group">
										       	<label for="inputFloatingLabel-remarks" class="placeholder">Remarks</label>
												<input id="inputFloatingLabel-remarks" type="text" class="form-control input-border-bottom"  name='remarks' value="<?php if(isset($holidaydtl->id)){  echo $holidaydtl->remarks;  }?>">
											
											
											

											</div>
										
				                     	</div>
					
					
					      
					</div>
					             <div class="row form-group">
										<div class="col-md-12">
										   <button type="submit" class="btn btn-default">Submit</button>
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