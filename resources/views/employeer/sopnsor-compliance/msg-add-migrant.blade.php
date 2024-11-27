@extends('employeer.include.app')
@section('title', 'Message')
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
@endphp
@section('content')

<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Message Centre</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('org-dashboarddetails')}}">Sponsor Compliance Dashboard</a></li>
               <li class="breadcrumb-item active">Message Centre</li>
            </ul>
         </div>
      </div>
   </div>
   <!-- /Page Header -->
   <div class="row">
    <div class="col-md-12">
       <div class="card custom-card">
          <div class="card-header">
             <h4 class="card-title"> Message Centre</h4>
          </div>
          <div class="card-body">
             <form action="{{ url('dashboard/send-mail-migrant') }}" method="post" enctype="multipart/form-data">
                {{csrf_field()}}
                <div class="row form-group">
                   <div class="col-md-4">
                      <div class="form-group form-floating-label">
                            <label for="employee_id" class="form-group">Select Employee</label>   
                         <input id="employee_name" type="text"  name="employee_name"  readonly   class="form-control input-border-bottom" required="" value="{{ $employeedata->emp_fname }} {{ $employeedata->emp_mname }} {{ $employeedata->emp_lname }} ({{ $employeedata->emp_code}})" style="margin-top: 22px;">
                         <input id="employee_id" type="hidden"  name="employee_id"  readonly   class="form-control input-border-bottom" required="" value="{{ $employeedata->emp_code}}" style="margin-top: 22px;">
                         
                      </div>
                   </div>
                   <div class="col-md-6">
                      <div class=" form-group form-floating-label">
                        <label for="email" class="form-group">Employees Email</label>
                         <input id="email" type="text"  name="email"    class="form-control input-border-bottom" readonly value="{{ $employeedata->emp_ps_email}}" required="" style="margin-top: 22px;">
                         
                      </div>
                   </div>
                </div>
                <div  class="row form-group" id="payment" >
                   <div class="col-md-12">
                      <div class=" form-group form-floating-label">
                        <label for="subject" class="form-group">CC</label>
                         <input id="cc" type="email"  name="cc"    class="form-control input-border-bottom"  style="margin-top: 22px;">
                        
                      </div>
                   </div>
                   <div class="col-md-12">
                      <div class=" form-group form-floating-label">
                        <label for="subject" class="form-group">Subject</label>
                         <input id="subject" type="text"  name="subject"    class="form-control input-border-bottom" required="" style="margin-top: 22px;">
                        
                      </div>
                   </div>
                   <div class="col-md-12">
                        <div class=" form-group form-floating-label">
                            <label for="subject" class="form-group">Message</label>
                            <textarea id="editor" name="msg" style="margin-top:20px">
                             </textarea>
                        </div>
                   </div>
                   <div class="col-md-12">
                      <div class=" form-group form-floating-label">
                         <input id="file" type="file"  name="file"    class="form-control input-border-bottom" style="margin-top: 22px;">
                         <label for="subject" class="form-group" style="margin-top: 22px;">Upload Attachment</label>
                      </div>
                   </div>
                </div>
                <div class="col-md-4" style="margin-top:25px;">
                   <button type="submit" class="btn btn-primary btn-up"><i class="fas fa-paper-plane"></i> SEND</button>
                </div>
          </div>
          </form>
       </div>
    </div>
 </div>
</div>
<!-- /Page Content -->
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
@endsection