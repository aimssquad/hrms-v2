<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
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
    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <style>
        .form-control:disabled, .form-control[readonly] {background:none !important;}
    </style>
</head>
<body>
	<div class="wrapper">
		
  @include('dashboard.include.header')
		<!-- Sidebar -->
		
	
		<!-- End Sidebar -->
		<div class="main-panel" style="width:100%">
		<div class="page-header">
						<!-- <h4 class="page-title">Dashboard</h4> -->
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="{{url('dashboarddetails')}}">
									<i class="flaticon-home" style="font-size:18px;"></i>
								</a>
							</li>
							<!-- <li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li> -->
							<!-- <li class="nav-item">
								<a href="#">Dashboard</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
							<a href="{{url('dashboard/message-center')}}">Message Centre</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="#"> New Message Centre</a>
							</li> -->
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"> Message Centre</h4>
								</div>
								<div class="card-body">
									<form action="" method="post" enctype="multipart/form-data">
			 {{csrf_field()}}
										<div class="row form-group">
										<div class="col-md-4">
						<div class="form-group form-floating-label">
												
													<select class="form-control input-border-bottom" id="employee_id" name="employee_id" required="" onchange="billvalue(this.value);" style="margin-top: 22px;">
                                                                                <option value="">&nbsp;</option>
			               
			                  @foreach($or_rs as $billdept)
			                 
                            <option value='{{ $billdept->emp_code}}' >{{ $billdept->emp_fname }} {{ $billdept->emp_mname }} {{ $billdept->emp_lname }} ({{ $billdept->emp_code}})</option>
                            
							 @endforeach					
                           
                                                                                                
						</select>
						<label for="employee_id" class="placeholder">Select Employee</label>
										</div>
											
												
											</div>
											<div class="col-md-6">
												<div class=" form-group form-floating-label">
													<input id="email" type="text"  name="email"    class="form-control input-border-bottom" required="" style="margin-top: 22px;">
												
												<label for="email" class="placeholder">Employees Email</label>
												</div>
											</div>
											</div>
											<div  class="row form-group" id="payment" style="display:none">
											    	<div class="col-md-12">
												<div class=" form-group form-floating-label">
													<input id="cc" type="email"  name="cc"    class="form-control input-border-bottom"  style="margin-top: 22px;">
												
												<label for="subject" class="placeholder">CC</label>
												</div>
											</div> 
											<div class="col-md-12">
												<div class=" form-group form-floating-label">
													<input id="subject" type="text"  name="subject"    class="form-control input-border-bottom" required="" style="margin-top: 22px;">
												
												<label for="subject" class="placeholder">Subject</label>
												</div>
											</div>
											
					<div class="col-md-12">
					    <textarea id="editor" name="msg" style="margin-top:20px">
          
        </textarea>
			
				</div>
											 
											
								<div class="col-md-12">
												<div class=" form-group form-floating-label">
													<input id="file" type="file"  name="file"    class="form-control input-border-bottom" style="margin-top: 22px;">
												
												<label for="subject" class="placeholder" style="margin-top: 22px;">Upload Attachment</label>
												</div>
											</div>				
														
											
											</div>
					<div class="col-md-4" style="margin-top:25px;">
						<button type="submit" class="btn btn-default btn-up"><i class="fas fa-paper-plane"></i> SEND</button>
					</div>
										</div>
									</form>
								</div>
							</div>
						</div>

						

						
					</div>
				</div>
			</div>
			 @include('dashboard.include.footer')
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
				  function billvalue(empid){
	   
	   	$.ajax({
		type:'GET',
		url:'{{url('pis/getbillorganmsgnewempmsgById')}}/'+empid,
        cache: false,
		success: function(response){
			
			
			var obj = jQuery.parseJSON(response);
			 $("#payment").show();
			 console.log(obj);
			
			 
				    $("#email").val(obj[0].emp_ps_email);
				   $("#email").attr("readonly", true);
				  
				   
		}
		});
   }
	</script>
	<script>CKEDITOR.replace( 'editor' );</script>
</body>
</html>