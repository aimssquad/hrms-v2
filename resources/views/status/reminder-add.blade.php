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
	<style>.autocomplete {
  position: relative;
  display: inline-block;
}

input {
  border: 1px solid transparent;
  background-color: #f1f1f1;
  padding: 10px;
  font-size: 16px;
}

input[type=text] {
  background-color: #f1f1f1;
  width: 100%;
}

input[type=submit] {
  background-color: DodgerBlue;
  color: #fff;
  cursor: pointer;
}

.autocomplete-items {
  position: absolute;
  border: 1px solid #d4d4d4;
  border-bottom: none;
  border-top: none;
  z-index: 99;
  /*position the autocomplete items to be the same width as the container:*/
  top: 100%;
  left: 0;
  right: 0;
}

.autocomplete-items div {
  padding: 10px;
  cursor: pointer;
  background-color: #fff; 
  border-bottom: 1px solid #d4d4d4; 
}

/*when hovering an item:*/
.autocomplete-items div:hover {
  background-color: #e9e9e9; 
}

/*when navigating through the items using the arrow keys:*/
.autocomplete-active {
  background-color: DodgerBlue !important; 
  color: #ffffff; 
}</style>
</head>
<body>
	<div class="wrapper">
		
  @include('status.include.header')
		<!-- Sidebar -->
		
		  @include('status.include.sidebar')
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
							<li class="nav-item">
								<a href="#">Invoice Reminder</a>
							</li>
							<li class="separator">
							/
							</li>
							<li class="nav-item">
								<a href="{{url('organisation-status/view-reminder')}}"> Invoice Reminder</a>
							</li>
							<li class="separator">
							/
							</li>
							<li class="nav-item active">
								<a href="#"> New Invoice Reminder</a>
							</li>
						</ul>
					</div>
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="fas fa-file-invoice"></i> New Invoice Reminder</h4>
								</div>
								<div class="card-body">
									<form action="" method="post" enctype="multipart/form-data">
			 {{csrf_field()}}
			 
										<div class="row form-group">
										
									<?php
									if(count($bill_rs)==0){
									    $type="1st Invoice Reminder";
									    
									}else if(count($bill_rs)==1){
									     $type="2nd Invoice Reminder";
									}else if(count($bill_rs)==2){
									     $type="3rd Invoice Reminder";
									}else{
									  $type='';  
									}
									?>
					<div class="col-md-4">
					<div class="form-group">
					    <label for="type" class="placeholder">Reminder Type</label>
							<input id="type" type="text"  name="type"    class="form-control input-border-bottom" required=""  readonly value="{{$type}}">
												
													
											</div>
											</div>
											 
											<div class="col-md-4">
												<div class="form-group">
												    	<label for="date" class="placeholder">Date</label>
													<input id="date" type="date"  name="date"    class="form-control input-border-bottom" required=""   min="{{date('Y-m-d')}}">
												
											
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group">
												    	<label for="time" class="placeholder">Time</label>
													<input id="time" type="time"  name="time"    class="form-control input-border-bottom" required="" >
												
											
												</div>
											</div>
												<div class="col-md-12">
												<div class=" form-group">
												    <label for="remarks" class="placeholder">Remarks</label>
												    <textarea  id="remarks"  name="remarks"    class="form-control input-border-bottom"></textarea>
												
												
												
												</div>
											</div>
					<div class="col-md-4">
						<button type="submit" class="btn btn-default btn-up">Submit</button>
					</div>
										</div>
									</form>
								</div>
							</div>
						</div>

						

						
					</div>
				</div>
			</div>
			 @include('status.include.footer')
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
   
   


<script>

  function checkcompany(){
	   var empid=document.getElementById("emidname").value;
	  
	   	$.ajax({
		type:'GET',
		url:'{{url('pis/getremidnamepaykkById')}}/'+empid,
        cache: false,
		success: function(response){
			
			
			var obj = jQuery.parseJSON(response);
			
			 console.log(obj);
			
			  var reg=obj[0].reg;
			
			 
				  $("#emid").val(reg);	   
		}
		});
   }

</script>
</body>
</html>