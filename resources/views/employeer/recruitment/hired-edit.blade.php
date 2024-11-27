@extends('employeer.include.app')
@section('title', 'Hired  Details')
@section('content')
<!-- Page Content -->
<div class="content container-fluid pb-0">
   <!-- Page Header -->
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">Hired  Details</h3>
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('recruitment/dashboard')}}">Recruitment Dashboard</a></li>
               <li class="breadcrumb-item active">Hired  Details</li>
            </ul>
         </div>
      </div>
   </div>
   <!-- /Page Header -->
   @include('employeer.layout.message')
   <div class="row">
      <div class="card">
         <div class="card-body">
            <form action="#" method="post" enctype="multipart/form-data">
               {{csrf_field()}}
               <input id="id" type="hidden"  name="id" class="form-control input-border-bottom" required="" value="<?php   echo $job->id;  ?>" >
               <input id="id" type="hidden"  name="job_id" class="form-control input-border-bottom" required="" value="<?php   echo $job->job_id;  ?>" >
               <div class="row form-group">
                  <div class="col-md-4">
                     <div class="app-form-text">
                        <h5>Job Title:<span>{{$job->job_title}}</span></h5>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="app-form-text">
                        <h5>Candidate Name:<span>{{$job->name}}</span></h5>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="app-form-text">
                        <h5>Email:<span>{{$job->email}}</span></h5>
                     </div>
                  </div>
                  @if($job->dob!='')
                  <div class="col-md-4">
                     <div class="app-form-text">
                        <h5>Date Of Birth:<span>{{ date('d/m/Y',strtotime($job->dob))}}</span></h5>
                     </div>
                  </div>
                  @endif
                  <div class="col-md-4">
                     <div class="app-form-text">
                        <h5>Contact Number:<span>+{{$job->phone}}</span></h5>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="app-form-text">
                        <h5>Gender:<span>{{$job->gender}}</span></h5>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="app-form-text">
                        <h5>Total Year of Experience:<span>{{$job->exp}} Years {{$job->exp_month}} Months</span></h5>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="app-form-text">
                        <h5>Education Qualification:<span>{{$job->edu}}</span></h5>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="app-form-text">
                        <h5>Skill Set:<span>{{$job->skill}}</span></h5>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="app-form-text">
                        <h5>Skill level:<span>{{$job->skill_level}}</span></h5>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="app-form-text">
                        <h5>Current Organization:<span>{{$job->cur_or}}</span></h5>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="app-form-text">
                        <h5>Current Job Title:<span>{{$job->cur_deg}}</span></h5>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="app-form-text">
                        <h5>Current Salary:<span> @if($job->sal!='') {{ number_format($job->sal,2)}} @endif</span></h5>
                     </div>
                  </div>
                  <div class="col-md-8">
                     <div class="app-form-text">
                        <h5>Current Location / Address:<span>{{$job->location}} @if(!empty($job->zip)), {{$job->zip}} @endif</span></h5>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="app-form-text">
                        <h5>Expected Salary:<span>@if($job->sal!='') {{ number_format($job->exp_sal,2)}}  @endif</span></h5>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <div class="app-form-text">
                        <h5>Apply Date:<span> <?php
                           echo date('d/m/Y',strtotime($job->date));
                           if($job->date>='2021-02-22'){
                           echo ' '.date('h:i A ',strtotime($job->date));
                           }
                           ?></span></h5>
                     </div>
                  </div>
                  @if($job->apply!='')
                  <div class="col-md-4">
                     <div class="app-form-text">
                        <h5>How the candidate applied ?:<span>{{ $job->apply }}</span></h5>
                     </div>
                  </div>
                  @endif
                  @if($job->recruited!='')
                  <div class="col-md-6">
                     <div class="app-form-text">
                        <h5>Are  there suitable settled workers available to be recruited for this role ?:<span>{{ $job->recruited }} @if($job->recruited=='Yes')( {{ $job->other }} ) @endif</span></h5>
                     </div>
                  </div>
                  @endif
                  <div class="col-md-4">
                     <div class="app-form-text">
                        <h5>Current Stage of Recruitment:<span>{{ $job->status}}</span></h5>
                     </div>
                  </div>
                  <div class="col-md-8">
                     <div class="app-form-text">
                        <h5>Remarks:<span>{{ $job_details->remarks}}</span></h5>
                     </div>
                  </div>
                  <div class="col-md-6">
                     <div class="app-form-text">
                        <h5>Date:<span>{{  date('d/m/Y',strtotime($job_details->date))}}</span></h5>
                     </div>
                  </div>
                  <div class="col-md-4">
                     <?php  if($job->upload_sh!=''){   ?>
                     <button class="btn btn-success download" type="button" style="    margin: 11px 0 0;"><a href="{{asset('storage/app/public/'.$job->upload_sh)}}" download target="blank">Download Interview Sheet</a></button>
                     <?php
                        }
                        
                        ?>
                  </div>
               </div>
               <div class="row form-group" style="background:none;margin-top:15px">
                  <div class="col-md-12">
                     <button class="btn btn-primary sub" type="button" onclick="goBack()">Back</button>
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
</script>
<script>
   function goBack() {
     window.history.back();
   }
</script>
@endsection