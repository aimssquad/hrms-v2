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
		
  @include('admin.include.header')
		<!-- Sidebar -->
		
		  @include('admin.include.sidebar')
		<!-- End Sidebar -->
		<div class="main-panel">
			<div class="page-header">
						
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
						<!--		<a href="#">HR File</a>-->
						<!--	</li>-->
						<!--	<li class="separator">-->
						<!--		<i class="flaticon-right-arrow"></i>-->
						<!--	</li>-->
						<!--	<li class="nav-item">-->
						<!--		<a href="{{url('superadmin/view-add-hr')}}"> HR File</a>-->
						<!--	</li>-->
						<!--	<li class="separator">-->
						<!--		<i class="flaticon-right-arrow"></i>-->
						<!--	</li>-->
						<!--	<li class="nav-item">-->
						<!--		<a href="#"> New HR File</a>-->
						<!--	</li> -->
						<!--</ul>-->
					</div>
			<div class="content">
				<div class="page-inner">
					
					<div class="row">
						<div class="col-md-12">
							<div class="card custom-card">
								<div class="card-header">
									<h4 class="card-title"><i class="fas fa-file-word"></i> New HR File</h4>
								</div>
								<div class="card-body">
									<form action="" method="post" enctype="multipart/form-data" id="myForm">
			 {{csrf_field()}}
			 
										<div class="row form-group">
										
									<input id="emid" type="hidden"  name="emid"    class="form-control input-border-bottom" required="" style="margin-top: 22px;" >
										<div class="col-md-6">
						<div class="form-group">
						    <label for="emidname" class="placeholder">Organisation Name</label>
												<input type="text" class="form-control input-border-bottom" id="emidname" type="text"  name="emidname" required=""   onchange="checkcompany();">
												
												
											</div>
					</div>
					<div class="col-md-4">
											<div class="form-group">
											    <label for="ref_id" class="placeholder" style="padding-top:0;">Assign To</label>
											    	<select class="form-control input-border-bottom" id="ref_id" required=""  name="ref_id">
													<option value="">&nbsp;</option>
													
												</select>
												
												
											</div>
											</div>
				
											 
											<div class="col-md-4">
												<div class=" form-group">
												    <label for="job_date" class="placeholder">Start Date for HR File Preparation</label>
													<input id="job_date" type="date"  name="job_date"    class="form-control input-border-bottom"      required="" onchange="checkdate();">
												
												
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group">
												    <label for="hr_file_date" class="placeholder">HR File Prearation Deadline</label>
													<input id="hr_file_date" type="date"  name="hr_file_date"    class="form-control input-border-bottom"      required="" readonly>
												
												
												</div>
											</div>
												<div class="col-md-4">
												<div class=" form-group">
												    <label for="sub_due_date" class="placeholder">Lag Time After Submission</label>
													<input id="sub_due_date" type="date"  name="sub_due_date"    class="form-control input-border-bottom"   readonly >
												
												
												</div>
											</div>
											</div>
											<div class="row form-group">
											
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
   
   


<script>


 $(document).ready(function(){
    $('#myForm').on('submit', function(e){
         var empid=document.getElementById("sub_due_date").value;
        e.preventDefault();
        if(empid!=''){
            this.submit();
        }else{
            $("#sub_due_date").focus();
        }
    });
});  
    
    function bank_epmloyee(val) {
	if(val=='Rejected'){
	document.getElementById("criman_bank_new").style.display = "block";	
	}else{
		document.getElementById("criman_bank_new").style.display = "none";	
	}
  
}

</script>
<?php

	$aryytestsys=array();

	foreach($or_de as $billdept){
	    
	    
		$aryytestsys[]='"'.$billdept->com_name.'"';
	}
	$strpsys=implode(',',$aryytestsys);
	
?>
<script src="{{ asset('js/jquery.autosuggest.js')}}"></script>
<script>
var component_name= [<?= $strpsys;?>];
console.log(component_name);
$("#emidname").autosuggest({
			sugggestionsArray: component_name
		});

  function checkcompany(){
	   var empid=document.getElementById("emidname").value;
	  
	   	$.ajax({
		type:'GET',
		url:'{{url('pis/getremidnamepaykkById')}}/'+empid,
        cache: false,
		success: function(response){
			
			
			var obj = jQuery.parseJSON(response);
			
			
			
			  var reg=obj[0].reg;
			  var address=obj[0].address;
			  if(obj[0].address2){
			       var address2=' , '+obj[0].address2;
			  }else{
			      var address2='';
			  }
			  
			  if(obj[0].road){
			       var road=' , '+obj[0].road;
			  }else{
			      var road='';
			  }
			  if(obj[0].city){
			       var city=' , '+obj[0].city;
			  }else{
			      var city='';
			  }
			  if(obj[0].zip){
			       var zip=' , '+obj[0].zip;
			  }else{
			      var zip='';
			  }
			   if(obj[0].country){
			       var country=' , '+obj[0].country;
			  }else{
			      var country='';
			  }
			
			var address=address+' '+address2+''+road+''+city+''+zip+''+country;
			 
				  $("#emid").val(reg);
				  
				      	 
		}
		});
		
		
			$.ajax({
		type:'GET',
		url:'{{url('pis/getremidnamepaykkByIdauthof')}}/'+empid,
        cache: false,
		success: function(responseg){
			
			
			 
				   $("#ref_id").html(responseg);
		}
		});
			$.ajax({
		type:'GET',
		url:'{{url('pis/getremidnamepaykkByIdauthoflust')}}/'+empid,
        cache: false,
		success: function(responsejj){
				
			var objh = jQuery.parseJSON(responsejj);
			 console.log(objh);
			  $("#job_date").val(objh.type);
			  	  $("#hr_file_date").val(objh.d_type);
			  	   $("#sub_due_date").val(objh.sub_date);
			 
			
				 
		}
		});
   }
   
   function checkdate(val){
       var empid=document.getElementById("job_date").value; 
		
			   	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeererivewByIdhrfile')}}/'+empid,
        cache: false,
		success: function(response){
			console.log(response);
			
		 $("#hr_file_date").val(response);
		}
		});
		 var empid=document.getElementById("emidname").value;
	  
			$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeererivewByIdsuhrfile')}}/'+empid,
        cache: false,
		success: function(response){
			console.log(response);
			
		 $("#sub_due_date").val(response);
		}
		});
   }
   
</script>
</body>
</html>