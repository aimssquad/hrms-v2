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
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset("assets/css/fonts.min.css")}}']},
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

  @include('admin.include.header')
		<!-- Sidebar -->

		  @include('admin.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">
						<!-- <h4 class="page-title"> Visa Expiry</h4> -->

					</div>
			<div class="content">
				<div class="page-inner">

					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="fas fa-list"></i> Visa Expiry </h4>
									@if(Session::has('message'))
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
								</div>
							<?php
$cos_success_rs = 0;
$per_spi_appli = 0;
$per_spi_hr = 0;
if ($start_date == '' && $end_date == '' && $employee_id == '') {
    $visa_expiry_rs = DB::Table('visa_or_emp_details_apply')

        ->orderBy('id', 'desc')
        ->where('description', '=', 'Communicate with client (to secure their consent for admin review)')
        ->get();
}

if ($start_date == '' && $end_date == '' && $employee_id != '') {
    $visa_expiry_rs = DB::Table('visa_or_emp_details_apply')

        ->where('user_employee_id', '=', $employee_id)
        ->orderBy('id', 'desc')
        ->where('description', '=', 'Communicate with client (to secure their consent for admin review)')
        ->get();

}

if ($start_date != '' && $end_date != '' && $employee_id == '') {
    $start_date = date('Y-m-d', strtotime($start_date));
    $end_date = date('Y-m-d', strtotime($end_date));

    $visa_expiry_rs = DB::Table('visa_or_emp_details_apply')

        ->orderBy('id', 'desc')
        ->where('description', '=', 'Communicate with client (to secure their consent for admin review)')
        ->whereBetween('start_date', [$start_date, $end_date])
        ->get();

}

if ($start_date != '' && $end_date != '' && $employee_id != '') {

    $start_date = date('Y-m-d', strtotime($start_date));
    $end_date = date('Y-m-d', strtotime($end_date));

    $visa_expiry_rs = DB::Table('visa_or_emp_details_apply')
        ->where('user_employee_id', '=', $employee_id)
        ->orderBy('id', 'desc')
        ->whereBetween('start_date', [$start_date, $end_date])
        ->where('description', '=', 'Communicate with client (to secure their consent for admin review)')
        ->get();
}

?>				<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
												<tr>
													<th>Sl.No.</th>
													<th>Organisation Name</th>
													<th>Employee Name</th>
														<th>Communicate with client (to secure their consent for admin review) Date</th>

												<th>Visa Expiry Details</th>
												</tr>
											</thead>

											<tbody>
											  <?php $i = 1;?>
							@foreach($visa_expiry_rs as $company)
								<?php

$pass = DB::Table('registration')

    ->where('reg', '=', $company->emid)

    ->first();
$passname = DB::Table('users_admin_emp')

    ->where('employee_id', '=', $company->user_employee_id)

    ->first();
if (!empty($company->start_date)) {

    $sa_date = date('d/m/Y', strtotime($company->start_date));

} else {

    $sa_date = '';

}

?>
				<tr>

							<td>{{ $i }}</td>
							<td>{{ $pass->com_name }}</td>

							<td>{{ $passname->name }}</td>
							<td>
                 {{$sa_date}}
                  </td>

                        <td class="icon">
                            <a data-toggle="tooltip" data-placement="bottom" title="View"
 href="{{url('superadmin/visaexp-details/'.base64_encode($company->emid))}}" target="_blank"><img  style="width: 17px;" src="{{ asset('assets/img/view.png')}}"></a>



											</td>
						</tr>
						<?php
$i++;?>



  @endforeach
            								</tbody>
										</table>
									</div>
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