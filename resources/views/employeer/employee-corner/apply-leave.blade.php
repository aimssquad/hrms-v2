@extends('employeer.employee-corner.main')
@section('title', 'Leave Apply')
@section('content')
    <div class="content container-fluid pb-0">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">
                    <h3 class="page-title">Leave Apply</h3>
                    <ul class="breadcrumb">
                        <li class="breadcrumb-item"><a href="admin-dashboard.html">Dashboard</a></li>
                        <li class="breadcrumb-item active">Leave Apply</li>
                    </ul>
                </div>
            </div>
        </div>
        <!-- /Page Header -->
        
        <div class="row">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-body">
                     <form action="#" method="post" enctype="multipart/form-data">
                        <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="employee_id" value="{{$employee->emp_code}}">
                        <input type="hidden" name="employee_name" value="{{$employee->emp_fname}} {{$employee->emp_mname}} {{$employee->emp_lname}}">
                        <div class="row form-group">
                           <div class="col-md-6">
                              <div class="pay-slip-heading">
                                 <h4 class="card-title">Leave Application</h4>
                                 @if(Session::has('Leave_msg'))
                                 <div class="alert alert-success" style="text-align:center;"><span class="glyphicon glyphicon-ok" ></span><em > {{ Session::get('Leave_msg') }}</em></div>
                                 @endif
                              </div>
                           </div>
                           <div class="col-md-6">
                              <div class="pay-slip-heading">
                                 <h4 class="card-title holiday"><a style="color: #4e9d05;" href="{{ url('org-employee-corner/holiday') }}" target="_blank"><i class="far fa-calendar-alt calender-icon"></i>Holiday Calender</a></h4>
                              </div>
                           </div>
                        </div>
                        <div class="row form-group">
                           <div class="col-md-3">
                              <div class="app-form-text">
                                 <h5>Employment Type:<span>{{$employee->employeetype}}</span></h5>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="app-form-text">
                                 <h5>Employee Code:<span>{{$employee->emp_code}}</span></h5>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="app-form-text">
                                 <h5>Employee Name:<span>{{$employee->emp_fname}} {{$employee->emp_mname}} {{$employee->emp_lname}}</span></h5>
                              </div>
                           </div>
                           <div class="col-md-3">
                              <div class="app-form-text date">
                                 <h5>
                                    Date Of Application:
                                    <span>
                                       <input class="form-control" type="date" name="date_of_apply" id="date_of_apply" required>
                                       <!--<?php echo date('d/m/Y'); ?>-->
                                    </span>
                                 </h5>
                              </div>
                           </div>
                        </div>
                        <div class="row form-group">
                           <div class="col-md-4">
                              <div class=" form-group form-floating-label">
                                 <label for="leave_type" class="col-form-label">Leave Type</label><br/>
                                 <select  id="leave_type" name="leave_type" onchange="getLeaveInHand(this);"  class="form-control input-border-bottom" required=""  style="margin-top: 20px;">
                                    <option  value="">&nbsp;</option>
                                    @foreach($leave_type_rs as $leave)
                                    <option value="{{$leave->id}}">{{$leave->leave_type_name}}</option>
                                    @endforeach
                                 </select>
                                 <input type="hidden" name="leave_alloc_type_id" id="leave_alloc_type_id" value="{{$leave_type_rs}}">
                              </div>
                           </div>
                           <div class="col-md-4">
                              <label for="leave_inhand" class="col-form-label">Leave In Hand</label>
                              <input  type="text"readonly="" name="leave_inhand" class="form-control"  id="leave_inhand" required=""   col-form-label="" style="margin-top: 25px;">
                              @if ($errors->has('leave_inhand'))
                              <div class="error" style="color:red;">{{ $errors->first('leave_inhand') }}</div>
                              @endif
                           </div>
                           <div class="col-md-4">
                              <div class=" form-group form-floating-label">
                                 <label for="from_date"  class="col-form-label">From Date</label><br/>
                                 <input type="date" id="from_date" name="from_date"  value="{{ old('from_date') }}""  type="date" class="form-control input-border-bottom" required="" style="margin-top: 16px;">
                                 @if ($errors->has('from_date'))
                                 <div class="error" style="color:red;">{{ $errors->first('from_date') }}</div>
                                 @endif
                              </div>
                           </div>
                        </div>
                        <div class="row form-group">
                           <div class="col-md-4">
                              <div class=" form-group form-floating-label">
                                 <label for="to_date"  class="col-form-label">To Date</label><br/>
                                 <input  id="to_date" name="to_date" value="{{ old('to_date') }}" onchange="get_duration()" type="date" class="form-control input-border-bottom" required="" style="margin-top: 16px;">
                                 @if ($errors->has('to_date'))
                                 <div class="error" style="color:red;">{{ $errors->first('to_date') }}</div>
                                 @endif
                              </div>
                           </div>
                           <div class="col-md-4">
                              <label for="days" class="col-form-label">No. Of Days</label>
                              <input   name="days" class="form-control" id="days"  type="text" readonly="" class="form-control input-border-bottom" required=""  placeholder="" style="margin-top: 25px;">
                           </div>
                        </div>
                        <div class="row form-group">
                           <div class="col-md-6">
                              <a class="apply" href="#">
                              <button class="btn btn-primary apply" type="submit" id="applysub">Apply</button>
                              </a>
                              <a class="apply" href="#">
                              <button class="btn btn-primary apply" type="submit">Reset</button>
                              </a>
                           </div>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
    </div>    
@endsection
@section('script')
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
         
         
         function getLeaveInHand(leavetype_id)
         {
         	//leave_alloc_type_id
         	//alert(leavetype_id.options[leavetype_id.selectedIndex].text);
         	var dateOfApply=$('#date_of_apply').val();
         
         	if(dateOfApply!=''){
         		$.ajax({
         			type:'GET',
         			url:'{{url('leave/get-leave-in-hand')}}/'+leavetype_id.value+'/'+dateOfApply,
         			success: function(response){
         			console.log(response);
         				if(response==0){
         
         					$('#leave_inhand').val(null);
         					$("#from_date").attr('readonly', true);
         					$("#to_date").attr('readonly', true);
         
         				}else{
         
         					$("#leave_inhand").val(response);
         					$("#from_date").attr('readonly', false);
         					$("#to_date").attr('readonly', false);
         					$('#days').val('');
         					$("#from_date").val('');
         					$("#to_date").val('');
         				}
         			}
         		});
         
         	}else{
         		alert('Select Date of application.');
         		leavetype_id.value='';
         	}
         
         
         
                   /*if(($("#leave_inhand").val()) == '0')
                   {
                       alert('hi');
                       $('#days').attr('readonly', true);
                       $("#from_date").attr('readonly', true);
                       $("#to_date").attr('readonly', true);
                   }*/
         }
         
         function get_duration()
         {
         
         
         var from_date= $("#from_date").val();
           var to_date= $("#to_date").val();
           var leave_type = $("#leave_type option:selected").val();
           var lvinhand = $('#leave_inhand').val();
           var cl_type = 'full';
         $.ajax({
         type:'GET',
         url:'{{url('leavecount/bydays')}}/'+from_date+'/'+to_date+'/'+leave_type,
               cache: false,
         success: function(response){
         
         	 $('#days').val(response);
         	 if(response==0){
         
         		 $("#applysub").prop("disabled", true);
         	 }else{
         		 $("#applysub").prop("disabled", false);
         	 }
         
         
         }
         });
         
         
         
         }
         
      </script>
@endsection