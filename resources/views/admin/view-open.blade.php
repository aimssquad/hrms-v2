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
	<style>.check-clr {
    color: #1572e8;
    font-size: 30px;
    font-weight: 300;
}</style>
</head>
<body>
	<div class="wrapper">
		
  @include('admin.include.header')
		<!-- Sidebar -->
		
		  @include('admin.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">
						<!-- <h4 class="page-title">Complain</h4> -->
						
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
						<!--		<a href="{{url('superadmin/view-complain')}}">Open Complain</a>-->
						<!--	</li> -->
							
						<!--</ul>-->
					</div>
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="far fa-grimace"></i> Open Complain
						</h4>
@if(Session::has('message'))										
							<div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('message') }}</em></div>
					@endif
									
								</div>
								<div class="card-body">
									<div class="table-responsive">
										<table id="basic-datatables" class="display table table-striped table-hover" >
											<thead>
											    
												<tr>
												    	<th>Sl No</th>
    													<th>Project Name</th>
												<th>Complain Type</th>
													<th>Organisation Name</th>
													<th>Complain By</th>
													<th>File</th>
													<th>Description</th>
													<th>Status </th>
												<th>Complain Date </th>
												<th>Complain Update Date </th>
												<th>Remarks </th>
												<th>Action</th>
														</tr>
											</thead>
											
											<tbody>
												   <?php $i = 1; ?>
									@foreach($opencomplain as $open)
									<?php
										 $employee_desigrs=DB::table('users_admin_emp')
     ->where('employee_id', '=',  $open->cr_by)
   
  ->first();

  ?>
  	<?php
										 $employee_or=DB::table('registration')
     ->where('reg', '=',  $open->emid)
    ->where('reg', 'like',  'EM%')
  ->first();

  ?>
                                        <tr>
                                            <td><?= $i ?></td>
											<td>  {{ $open->p_name }}  </td>
												<td>{{ $open->cat_name }} @if($open->cat_name=='Others') ( {{ $open->others }} ) @endif </td>
													<td> @if(!empty( $employee_or)) {{ $employee_or->com_name }}  @endif</td>
													<td>  {{ $employee_desigrs->name }}  </td>
												<td class="icon"> @if($open->flie!='') <a data-toggle="tooltip" data-placement="bottom" title="Download" href="{{asset('public/'.$open->flie)}}" download><img  style="width: 14px;" src="{{ asset('assets/img/download.png')}}"></a> @endif </td>
												<td>  {{ $open->descrption }}  </td>
												<td>  {{ ucwords($open->status) }}  </td>
											<td>{{ date('d/m/Y',strtotime($open->cr_date)) }} </td>
												<td>
                                                      @if($open->up_date)
													{{ date('d/m/Y',strtotime($open->up_date)) }} 
												 @endif</td>
												<td>  {{ $open->remarks }}  </td>

												  <td class="icon">
                                                <a data-toggle="tooltip" data-placement="bottom"  title="Edit" href="{{ url('superadmin/add-complain') }}?id={{ base64_encode( $open->id )}}"><img  style="width: 14px;" src="{{ asset('assets/img/edit.png')}}"></a>
                 
                                            </td>
												
                                        </tr>
                                        <?php $i++; ?>
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