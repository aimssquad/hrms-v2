<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
	
	
	<!-- Fonts and icons -->
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
</head>
<body>
	<div class="wrapper">
 @include('settings.include.header')
		<!-- Sidebar -->
		
		  @include('settings.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">
						<!-- <h4 class="page-title">HCM Master</h4> -->
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="{{url('settingdashboard')}}">
									Home
								</a>
							</li>
							<li class="separator">
								/
							</li>
							<li class="nav-item">
								<a href="#">HCM Master</a>
							</li>
							<li class="separator">
								/
							</li>
							<li class="nav-item">
								
								<a href="{{url('settings/vw-bank-sortcode')}}">Bank Sortcode </a>
							</li>
							<li class="separator">
								/
							</li>
							<li class="nav-item active">
								<a href="#"> New Bank Sortcode </a>
							</li>
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									
									@if(isset($bankdetails) && !empty($bankdetails))
                            	
							<h4 class="card-title"><i class="fas fa-university"></i> Edit Bank Sortcode </h4>
                            	@else
                                
							<h4 class="card-title"><i class="fas fa-university"></i> Add Bank Sortcode </h4>
                                @endif 
								</div>
								<div class="card-body">
									<form action="{{ url('settings/bank-sortcode') }}" method="post" enctype="multipart/form-data">
				  {{csrf_field()}}
				   <input type="hidden" name="bankid" value="{{ ((isset($bankdetails) && !empty($bankdetails))?$bankdetails[0]->id:'')}}">
										<div class="row">
										<div class="col-md-4">
										<div class="form-group">
											<label for="inputFloatingLabel"  class="placeholder">Bank Name</label>	
											<select name="bank_name" id="bank_name"  class="form-control input-border-bottom" required="">
                                        @foreach($MastersbankName as $value):
                 <option value="{{ $value->id }}" <?php if(!empty($bankdetails[0]->id)){ if( $bankdetails[0]->bank_name == $value->id){  echo "selected"; } } ?>>
                                             {{ $value->master_bank_name }} 
                                         </option>
                                        @endforeach
                                    </select>

												
											</div>
																									  
										</div>
										<div class="col-md-4">
										<div class="form-group">
											<label for="inputFloatingLabel1" class="placeholder">Bank Sort Code</label>
												<input id="inputFloatingLabel1" type="text" class="form-control input-border-bottom" required="" name="bank_sort"   value="{{ (isset($bankdetails[0]->bank_sort) && !empty($bankdetails[0]->bank_sort))?$bankdetails[0]->bank_sort:old('bank_sort')}}">
												
												@if ($errors->has('bank_sort'))
											<div class="error" style="color:red;">{{ $errors->first('bank_sort') }}</div>
										@endif
											</div>
										
					</div>
					
					
					</div>
					<div class="row form-group">
										<div class="col-md-4">
										   <button type="submit" class="btn btn-default">Submit</button>
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
			@include('settings.include.footer')
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