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
	<style>.shift-field {
    padding: 10px;
    background-color: #dcdcdc;
    margin: 25px 0px;
}

</style>
</head>
<body>
	<div class="wrapper">
		

		<div class="main-panel">
	
			<div class="content">
				<div class="page-inner">
					
						<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="fa fa-users" aria-hidden="true" style="color:#10277f;"></i>&nbsp;Duty Roster (Employee wise)</h4>
								</div>
								<div class="card-body">
									<form action="{{ url('approta/add-employee-duty') }}" method="post" enctype="multipart/form-data">
			 {{csrf_field()}}
			 
			  <input type="hidden" name="reg" value="{{ $Roledata->reg }}">
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
				
				</select>
				
			</div>
		</div> 	
											 <div class="col-md-4">
			<div class="form-group">
			    <label for="employee_id" class="placeholder"> Select Employee </label>
				<select class="form-control input-border-bottom" id="employee_id"  name="employee_id" required="" >
					<option value="">&nbsp;</option>
				
				</select>
				
			</div>
		</div> 	
										 <div class="col-md-4">
			<div class="form-group">
			    <label for="inputFloatingLabel-select-date" class="placeholder" > From Date </label>
			    <input type="date" class="form-control input-border-bottom" name="start_date" id="inputFloatingLabel-select-date" required="">
			    	
			
			
			</div>
		</div> 							
										
					 <div class="col-md-4">
			<div class="form-group">
			   <label for="inputFloatingLabel-select-date" class="placeholder" > To Date </label>
			    <input type="date" class="form-control input-border-bottom " name="end_date" id="inputFloatingLabel-select-date" required="" >
			     
			
				
			</div>
		</div> 							
										 
										</div>
		<div class="row form-group shift-field" id="shift_code">
										 	

										 

									    </div>	


											<div class="row form-group">
											
										    <div class="col-md-4">
										    <div class="sub-reset-btn">	
								     		<a href="#">	
										    <button class="btn btn-default" type="submit" style="background-color: #1572E8!important; color: #fff!important;">Submit</button></a>
											<!-- <i class="fas fa-ban reset-ban-icon"></i> -->
										    <a href="#">	
										    <button class="btn btn-default" type="submit" style="background-color: #1572E8!important; color: #fff!important;">Reset</button></a>
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
	  
	  var emid= "<?=$Roledata->reg;?>";
	   	$.ajax({
		type:'GET',
			url:'{{url('appattendance/getEmployeedesigByshiftId/absent')}}/'+empid+'/'+emid,
        cache: false,
		success: function(response){
			
			
			document.getElementById("designation").innerHTML = response;
		}
		});
   }
      function chngdepartmentshift(empid){
	  
	     var emid= "<?=$Roledata->reg;?>";
	   	$.ajax({
		type:'GET',
		url:'{{url('approta/getEmployeedesigBydutytshiftId')}}/'+empid+'/'+emid,
        cache: false,
		success: function(response){
			
			
			document.getElementById("shift_code").innerHTML = response;
		}
		});
			 	$.ajax({
		type:'GET',
		url:'{{url('appattendance/getEmployeedailyattandeaneshightByIdnewr')}}/'+empid+'/'+emid,
        cache: false,
		success: function(response){
			
			
			document.getElementById("employee_id").innerHTML = response;
		}
		});
		
   }
   
   	
			function chngdepartmentshiftcode(val)
	{	
		//$('#emplyeename').show();		
		
		
$.ajax({
				type:'GET',
				url:'{{url('role/get-employee-all-details-shift')}}/'+val,
				success: function(response){


 

				  
				   var obj = jQuery.parseJSON(response);
				  console.log(obj);
				  
					  var bank_sort=obj[0].time_in; 

					  $("#time_in").val(bank_sort);
				   $("#time_in").attr("readonly", true);
				   
				  
				   
				
				  
			  
				}
			});
		$("#inputFloatingLabel").val(name[0]); 
			


		//$("#emp_name").attr("readonly", true);  
	}
   
   
	</script>
</body>
</html>