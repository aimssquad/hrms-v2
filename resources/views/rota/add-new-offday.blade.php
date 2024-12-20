<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
<link rel="icon" href="{{ asset('assets/img/icon.ico')}}" type="image/x-icon"/>
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
		
  @include('rota.include.header')
		<!-- Sidebar -->
		
		  @include('rota.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
		<div class="page-header">
						<!-- <h4 class="page-title">Time Shift Management</h4> -->
						
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="{{url('rotadashboard')}}">
								Home
								</a>
							</li>
							 <li class="separator">
								/
							</li>
							<li class="nav-home">
								<a href="{{url('rota/offday')}}">
								Day Off
								</a>
							</li>
							 <li class="separator">
								/
							<li class="nav-item active">
								<a href="{{url('rota/add-shift-management')}}"> Edit Day Off Details</a>
							</li>
							
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
						<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-calendar-times" aria-hidden="true" style="color:#10277f;"></i>&nbsp;Day Off Details</h4>
								</div>
								<div class="card-body">
									<form action="" method="post" enctype="multipart/form-data">
			 {{csrf_field()}}
										<div class="row form-group">
										   <div class="col-md-4">
										  	<div class=" form-group">		
										  
<label for="inputFloatingLabel-grade" class="placeholder"> Select Department</label>
										  	  				<select class="form-control input-border-bottom" id="selectFloatingLabel" name="department" required="" onchange="chngdepartment(this.value);">
                                                                                            
							<option value="">&nbsp;</option>
			                 @foreach($departs as $dept)
                            <option value='{{ $dept->id }}' <?php  if(app('request')->input('id')){ if($shift_management->department==$dept->id){ echo 'selected'; } } ?> >{{ $dept->department_name }}</option>
												
                            @endforeach
                                                                                                
						</select>
									
										  	
										  </div>
										  </div>
										 <div class="col-md-4">
			<div class="form-group">
			    	<label for="designation" class="placeholder"> Select Designation </label>
				<select class="form-control input-border-bottom" id="designation"  name="designation" required="" onchange="chngdepartmentshift(this.value);">
					<option value="">&nbsp;</option>
					@if(app('request')->input('id'))
					 @foreach($desig as $desig)
                     <option value="{{$desig->id}}" <?php  if(app('request')->input('id')){  if($shift_management->designation==$desig->id){ echo 'selected';} } ?>>{{$desig->designation_name}}</option>
                       @endforeach
                       @endif
				</select>
			
			</div>
		</div> 	
										  <div class="col-md-4">
										  	<div class=" form-group">	
	<label for="shift_code" class="placeholder">Shift Code</label>
										     <select  id="shift_code"  name="shift_code"class="form-control input-border-bottom" required="" >
											    <option value="">&nbsp;</option>
												
												@if(app('request')->input('id'))
					 @foreach($shiftc as $shiftcval)
                     <option value="{{$shiftcval->id}}" <?php  if(app('request')->input('id')){  if($shift_management->shift_code==$shiftcval->id){ echo 'selected';} } ?>>{{$shiftcval->shift_code}} ( {{ $shiftcval->shift_des }}  )</option>
                       @endforeach
                       @endif
											  </select>
										  

										    </div>
										  </div>
										
										
										 
										</div>

<div class="row form-group">
										 	

										 <div class="col-md-3">
											  <input id="inputFloatingLabel-monday" type="checkbox" name="mon" value="1" <?php  if(app('request')->input('id')){  if($shift_management->mon=='1'){ echo 'checked';} } ?>>
											   <label for="inputFloatingLabel-monday" class="day-check">Monday</label>
										 	
										 </div>	

										 <div class="col-md-3">
											  <input id="inputFloatingLabel-tuesday" type="checkbox" name="tue" value="1" <?php  if(app('request')->input('id')){  if($shift_management->tue=='1'){ echo 'checked';} } ?>>
											   <label for="inputFloatingLabel-tuesday" class="day-check">Tuesday</label>
										 	
										 </div>	

										 <div class="col-md-3">
											  <input id="inputFloatingLabel-wednesday" type="checkbox" name="wed" value="1" <?php  if(app('request')->input('id')){  if($shift_management->wed=='1'){ echo 'checked';} } ?>>
											   <label for="inputFloatingLabel-wednesday" class="day-check">Wednesday</label>
										 	
										 </div>
										 	 <div class="col-md-3">
											  <input id="inputFloatingLabel-thursday" type="checkbox" name="thu" value="1" <?php  if(app('request')->input('id')){  if($shift_management->thu=='1'){ echo 'checked';} } ?>>
											  <label for="inputFloatingLabel-thursday" class="day-check">Thursday</label>
										 	
										 </div>
									    </div>	

									    	<div class="row form-group">
										

										 <div class="col-md-3">
											  <input id="inputFloatingLabel-friday" type="checkbox" name="fri" value="1" <?php  if(app('request')->input('id')){  if($shift_management->fri=='1'){ echo 'checked';} } ?>>
											   <label for="inputFloatingLabel-friday" class="day-check">Friday</label>
										 	
										 </div>	

										 <div class="col-md-3">
											  <input id="inputFloatingLabel-saturday" type="checkbox" name="sat" value="1" <?php  if(app('request')->input('id')){  if($shift_management->sat=='1'){ echo 'checked';} } ?>>
											   <label for="inputFloatingLabel-saturday" class="day-check">Saturday</label>
										 	
										 </div>	
<div class="col-md-3">
											  <input id="inputFloatingLabel-sunday" type="checkbox" name="sun" value="1" <?php  if(app('request')->input('id')){  if($shift_management->sun=='1'){ echo 'checked';} } ?>>
											  <label for="inputFloatingLabel-sunday" class="day-check">Sunday</label>
										 	
										 </div>
										 
									    </div>	

											<div class="row form-group">
											
										    <div class="col-md-4">
										    <div class="sub-reset-btn">	
								     		<a href="#">	
										    <button class="btn btn-default" type="submit" style="margin-top: 28px; background-color: #1572E8!important; color: #fff!important;">Submit</button></a>
											<!-- <i class="fas fa-ban reset-ban-icon"></i> -->
										    <a href="#">	
										    <button class="btn btn-default" type="submit" style="margin-top: 28px; background-color: #1572E8!important; color: #fff!important;">Reset</button></a>
										    </div>

								     		</div>
											</div>	



									</form>
								</div>
							</div>
						</div>
					</div>

				</div>
			</div>
				 @include('rota.include.footer')
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
		   
   function chngdepartment(empid){
	  
	   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedesigByshiftId')}}/'+empid,
        cache: false,
		success: function(response){
			
			
			document.getElementById("designation").innerHTML = response;
		}
		});
   }
      function chngdepartmentshift(empid){
	  
	   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedesigBylateId')}}/'+empid,
        cache: false,
		success: function(response){
			
			
			document.getElementById("shift_code").innerHTML = response;
		}
		});
   }
   
   
	</script>
</body>
</html>