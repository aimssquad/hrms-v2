<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
		<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
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
	<style>
	    .card-title{margin-bottom: 0;}
	</style>
</head>
<body>
	<div class="wrapper">

   @include('employee.include.header')
		<!-- Sidebar -->

		  @include('employee.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
		    	<div class="page-header">

						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="#">
								Home
								</a>
							</li>

							<li class="separator">
							/
							</li>
							<li class="nav-item active">
								<a href="{{url('employee/change-of-circumstances')}}"> Change Of Circumstances (View)</a>
							</li>

						</ul>
					</div>
			<div class="content">
				<div class="page-inner">


@if(Session::has('message'))
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif

									<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">

								<div class="card-body">
									 <form  method="post" action="{{ url('employee/change-of-circumstances') }}" enctype="multipart/form-data" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

										<div class="row form-group">
										   <div class="col-md-3">
										  	<div class=" form-group">

<label for="employee_type" class="placeholder">Employment Type</label>
										  	  <select id="employee_type" type="text" class="form-control input-border-bottom" required="" name="employee_type" onchange="employeetype(this.value);" >
											    <option value="">Select</option>
												@foreach($employee_type_rs as $employee_typ)
                        <option value="{{$employee_typ->employee_type_name}}" <?php if (isset($employee_type) && $employee_type == $employee_typ->employee_type_name) {echo 'selected';}?> >{{$employee_typ->employee_type_name}}</option>
                        @endforeach
											  </select>

										  </div>
										  </div>

										  <div class="col-md-3">
										  	<div class=" form-group">

<label for="employee_code" class="placeholder">Employee Code</label>
										  	  <select id="employee_code" type="text" class="form-control input-border-bottom"  required=""  name="employee_code">
											     <?php if (isset($employee_type)) {

    $employee_rs = DB::table('employee')

        ->where('emp_status', '=', $employee_type)
        ->where('emid', '=', $Roledata->reg)
        ->get();
    ?>
    <option value=''>Select</option>
    ";
    <?php
foreach ($employee_rs as $bank) {
        ?>
         <option value="<?=$bank->emp_code;?>" <?php if (isset($employee_code) && $employee_code == $bank->emp_code) {echo 'selected';}?>><?=$bank->emp_fname;?> <?=$bank->emp_mname;?> <?=$bank->emp_lname;?> (<?=$bank->emp_code;?>)</option>
   <?php }}?>
											</select>

										  </div>
										  </div>



								     		<div class="col-md-3 btn-up">
								     		<a href="#">
										    <button class="btn btn-default" type="submit" style="background-color: #1572E8!important; color: #fff!important;">Go</button></a>


								     		</div>

										</div>
									</form>
								</div>
							</div>
						</div>
					</div>


						<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-user"></i> Change Of Circumstances  (View)</h4>
									<?php

if (isset($result) && $result != '') {
    ?>
												 <form  method="post" action="{{ url('employee/employee-circumstances-report') }}" enctype="multipart/form-data" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                	<input type="hidden" name="employee_code" value="{{$employee_code}}">
                                		<input type="hidden" name="employee_type" value="{{$employee_type}}">
										 <button data-toggle="tooltip" data-placement="bottom" title="Download PDF" class="btn btn-default" style="margin-top: -30px;background:none !important;float:right;font-size:16px;" type="submit"><img  style="width: 35px;" src="{{ asset('img/dnld-pdf.png')}}"></button>
											</form>


												 <!-- <form  method="post" action="{{ url('employee/employee-circumstances-report-excel') }}" enctype="multipart/form-data" >
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                		<input type="hidden" name="employee_code" value="{{ $employee_code }}">
                                			<input type="hidden" name="employee_type" value="{{$employee_type}}">
										 <button data-toggle="tooltip" data-placement="bottom" title="Download Excel" class="btn btn-default" style="margin-top: -30px;background:none !important;float:right;font-size:16px;" type="submit"><img  style="width: 35px;" src="{{ asset('img/excel-dnld.png')}}"></button>
											</form> -->

											<?php
}?>
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>	<th>Sl No</th>
												    	<th>Updated Date</th>
												    	<th>Employment Type</th>
													<th>Employee ID</th>
												<th>Employee Name</th>


													<th>Job  Title</th>
														<th>Address</th>

													<th>Contact Number</th>


													<th>Nationality</th>
													<th>BRP  Number</th>

													<th>Visa Expiry Date</th>
														<th>Remarks/Restriction to work</th>
													<th>Passport No</th>
													<th>EUSS Details</th>
													<th>DBS Details</th>
													<th>National Id Details</th>
													<th>Other Documents</th>

														<th>Are Sponsored migrants aware that they must <br>inform [HR/line manager] promptly of changes<br> in contact Details? </th>
															<th>Are Sponsored migrants  aware that they need to<br> cooperate Home Office interview by presenting original <br>passports during the Interview (In applicable cases)?</th>

											<th>Annual  Reminder Date</th>



												</tr>
											</thead>

											<tbody>
												 <?php

if (isset($result) && $result != '') {
    print_r($result);
}?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
						</div>




					</div>


				</div>
			</div>
				 @include('employee.include.footer')
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
			function employeetype(val){
		var empid=val;

			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedailyattandeaneByIdnewvchange')}}/'+empid,
        cache: false,
		success: function(response){


			document.getElementById("employee_code").innerHTML = response;
		}
		});
	}
	</script>
</body>
</html>