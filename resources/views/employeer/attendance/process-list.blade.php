@extends('employeer.include.app')
@section('title', 'Execute Attendence')
@section('content')
<div class="content container-fluid pb-0">
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Execute Attendence</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('attendance-management/dashboard')}}">Attendence Dashboard</a></li>
               <li class="breadcrumb-item active">Execute Attendence</li>
            </ul>
         </div>
      </div>
   </div>
   @include('employeer.layout.message')
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-body">
               <form  method="post" action="{{ url('attendance-management/process-attendance') }}" enctype="multipart/form-data" >
                  <input type="hidden" name="_token" value="{{ csrf_token() }}">
                  <div class="row form-group">
                     <div class="col-md-3">
                        <div class=" form-group">
                           <label for="inputFloatingLabel-grade" class="col-form-label"> Select Department</label>
                           <select class="select" id="selectFloatingLabel" name="department" required="" onchange="chngdepartment(this.value);">
                              <option value="">&nbsp;</option>
                              @foreach($departs as $dept)
                              <option value='{{ $dept->id }}'  >{{ $dept->department_name }}</option>
                              @endforeach
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class="form-group">
                           <label for="designation" class="col-form-label"> Select Designation </label>
                           <select class="select" id="designation"  name="designation" required="" onchange="chngdepartmentdesign(this.value);">
                              <option value="">&nbsp;</option>
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class=" form-group">		
                           <label for="employee_code" class="col-form-label">Employee Code</label>
                           <select id="employee_code" type="text" class="select" name="employee_code"   style="">
                           </select>
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class=" form-group">
                           <label for="inputFloatingLabel-select-date"  class="col-form-label">From Date</label>
                           <input id="inputFloatingLabel-select-date"  type="date"  name="start_date" class="form-control input-border-bottom" required="" style="">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class=" form-group">
                           <label for="inputFloatingLabel-select-date"  class="col-form-label">To Date</label>
                           <input id="inputFloatingLabel-select-date"  type="date" name="end_date" class="form-control input-border-bottom" required="" style="">
                        </div>
                     </div>
                  </div>
                  <br>
                  <div class="row form-group">
                     <div class="col-md-3">
                        <a href="#">	
                        <button class="btn btn-primary" type="submit">View</button></a>
                        <a href="#">	
                        <button class="btn btn-primary" type="reset">Reset</button></a>
                     </div>
                  </div>
               </form>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-header d-flex justify-content-between align-items-center">
               <h4 class="card-title"><i class="fa fa-cog" aria-hidden="true" style="color:#10277f;"></i>&nbsp;Process Attendance</h4>
               <div>
                  <div class="row">
                     <div class="col-auto">
                         <form action="{{ route('exportTableData') }}" method="POST" id="exportForm" class="d-inline">
                             @csrf
                             <input type="hidden" name="data" id="data">
                             <input type="hidden" name="headings" id="headings">
                             <input type="hidden" name="filename" id="filename">
                             {{-- put the value - that is your file name --}}
                             <input type="hidden" id="filenameInput" value="Process-Attendence">
                             <button type="submit" class="btn btn-success btn-sm">
                                 <i class="fas fa-file-excel"></i> Export to Excel
                             </button>
                         </form>
                     </div>
                     <div class="col-auto">
                         <form action="{{ route('exportPDF') }}" method="POST" id="exportPDFForm">
                           @csrf
                           <input type="hidden" name="data" id="pdfData">
                           <input type="hidden" name="headings" id="pdfHeadings">
                           <input type="hidden" name="filename" id="pdfFilename">
                           <button type="submit" class="btn btn-info btn-sm">
                               <i class="fas fa-file-pdf"></i> Export to PDF
                           </button>
                       </form>
                     </div>
                 </div>
              </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <form method="post" action="{{ url('attendance-management/save-Process-Attandance') }}">
                     <input type="hidden" name="_token" value="{{ csrf_token() }}">
                     <table id="basic-datatables" class="display table table-striped table-hover" >
                        <thead>
                           <tr>
                              <th>Select
                                 <input type="checkbox" id="allval" name="select" value="select">
                              </th>
                              <th>Department</th>
                              <th>Designation</th>
                              <th>Employee Code</th>
                              <th>Employee Name</th>
                              <th>No.of Working Days</th>
                              <th>No.of Present Days</th>
                              <th>No.of Absent Days</th>
                              <th>No.of Leave Taken</th>
                              <!--<th>No.of Days Salary</th>-->
                           </tr>
                        </thead>
                        <tbody>
                           <?php
                              if(isset($result) && $result!=''  ){
                                                           print_r($result); 
                              }?>
                        </tbody>
                        <tfoot>
                           <?php
                              if(isset($result) && $result!=''  ){
                                                       
                              ?>
                           <tr>
                              <td colspan="11"><button style="float:right" type="submit" class="btn btn-primary">Save</button></td>
                           </tr>
                           <?php }
                              ?>
                        </tfoot>
                     </table>
                     </table>
                  </form>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection         
@section('script')
    <script >
      //   $(document).ready(function() {

      //       $('#multi-filter-select').DataTable( {
      //           "pageLength": 5,
      //           initComplete: function () {
      //               this.api().columns().every( function () {
      //                   var column = this;
      //                   var select = $('<select class="form-control"><option value=""></option></select>')
      //                   .appendTo( $(column.footer()).empty() )
      //                   .on( 'change', function () {
      //                       var val = $.fn.dataTable.util.escapeRegex(
      //                           $(this).val()
      //                           );

      //                       column
      //                       .search( val ? '^'+val+'$' : '', true, false )
      //                       .draw();
      //                   } );

      //                   column.data().unique().sort().each( function ( d, j ) {
      //                       select.append( '<option value="'+d+'">'+d+'</option>' )
      //                   } );
      //               } );
      //           }
      //       });

      //       // Add Row
      //       $('#add-row').DataTable({
      //           "pageLength": 5,
      //       });

      //       var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

      //       $('#addRowButton').click(function() {
      //           $('#add-row').dataTable().fnAddData([
      //               $("#addName").val(),
      //               $("#addPosition").val(),
      //               $("#addOffice").val(),
      //               action
      //               ]);
      //           $('#addRowModal').modal('hide');

      //       });
      //   });
        
        $('#allval').click(function(event) {  
        
            if(this.checked) {
                //alert("test");
                // Iterate each checkbox
                $(':checkbox').each(function() {
                    this.checked = true;                        
                });
            } else {
                $(':checkbox').each(function() {
                    this.checked = false;                       
                });
            }
        });
            function employeetype(val){
        var empid=val;
        
                $.ajax({
        type:'GET',
        url:'{{url('pis/getEmployeedailyattandeaneById')}}/'+empid,
        cache: false,
        success: function(response){
            
            
            document.getElementById("employee_code").innerHTML = response;
        }
        });
    }


        function chngdepartmentdesign(val){
        var empid=val;

                $.ajax({
        type:'GET',
        url:'{{url('pis/getEmployeedailyattandeaneshightById')}}/'+empid,
        cache: false,
        success: function(response){
            
        
            document.getElementById("employee_code").innerHTML = response;
        }
        });
    }
   function chngdepartment(empid){
        $.ajax({
        type:'GET',
        url:'{{url('pis/getEmployeedesigByshiftId')}}/'+empid,
        cache: false,
        success: function(response){
            document.getElementById("designation").innerHTML = response;
        }
        });
   }

   

    </script>
@endsection