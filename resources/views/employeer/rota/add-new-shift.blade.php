@extends('employeer.include.app')

@if(app('request')->input('id'))
@section('title', 'Edit Shift Planning')
@else
@section('title', 'Add Shift Planning')
@endif
@section('content')
<div class="content container-fluid pb-0">
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            @if(app('request')->input('id'))
            <h3 class="page-title">Edit Shift Planning</h3>
            @else
            <h3 class="page-title">Add New Shift Planning</h3>
            @endif
            <ul class="breadcrumb">
               <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">Home</a></li>
               <li class="breadcrumb-item"><a href="{{url('rota-org/dashboard')}}">Rota Dashboard</a></li>
               @if(app('request')->input('id'))
               <li class="breadcrumb-item active">Edit Shift Planning</li>
               @else
               <li class="breadcrumb-item active">Add New Shift Planning</li>
               @endif
            </ul>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-body">
               @include('employeer.layout.message')
               <form action="" method="post" enctype="multipart/form-data">
                  {{csrf_field()}}
                  <div class="row form-group">
                     <div class="col-md-4">
                        <div class=" form-group">
                           <label for="inputFloatingLabel-grade" class="col-form-label"> Select Department</label>
                          <select class="select" id="selectFloatingLabel" name="department" required="" onchange="chngdepartment(this.value);">
                            <option value="">&nbsp;</option>
                            @foreach($departs as $dept)
                                <option value="{{ $dept->id }}" 
                                    @if(isset($shift_management) && $shift_management->department == $dept->id) 
                                        selected 
                                    @endif
                                >
                                    {{ $dept->department_name }}
                                </option>
                            @endforeach
                        </select>
                        </div>
                     </div>
                     <div class="col-md-4">
                        <div class="form-group">
                           <label for="designation" class="col-form-label"> Select Designation </label>
                        
                            <select class="select" id="designation" name="designation" onchange="employeeList()" required="">
                                <option value="">&nbsp;</option>
                                @if(app('request')->input('id'))
                                    @foreach($desig as $designation)
                                        <option value="{{ $designation->id }}"
                                            @if(isset($shift_management) && $shift_management->designation == $designation->id)
                                                selected 
                                            @endif
                                        >
                                            {{ $designation->designation_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>

                        </div>
                     </div>
                  </div>
                  <div class="row form-group">
                     <div class="col-md-3">
                        <div class=" form-group">	
                           <label for="inputFloatingLabel-shift-in-time" class="col-form-label">Work In Time</label>
                           <input id="inputFloatingLabel-shift-in-time" type="time" class="form-control input-border-bottom"  required="" name="time_in" value="<?php  if(app('request')->input('id')){ echo $shift_management->time_in; } ?>"  col-form-label="" style="">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class=" form-group">	
                           <label for="inputFloatingLabel-shift-out-time" class="col-form-label">Work Out Time</label>
                           <input id="inputFloatingLabel-shift-out-time"  name="time_out" value="<?php  if(app('request')->input('id')){ echo $shift_management->time_out; } ?>"  type="time" class="form-control input-border-bottom" required=""  col-form-label="">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class=" form-group">	
                           <label for="inputFloatingLabel-recess-from-time" class="col-form-label">Break Time From </label>
                           <input id="inputFloatingLabel-recess-from-time" name="rec_time_in" value="<?php  if(app('request')->input('id')){ echo $shift_management->rec_time_in; } ?>" type="time" class="form-control input-border-bottom" required=""  col-form-label="">
                        </div>
                     </div>
                     <div class="col-md-3">
                        <div class=" form-group">	
                           <label for="inputFloatingLabel-recess-to-time" class="col-form-label">Break Time To </label>
                           <input id="inputFloatingLabel-recess-to-time" name="rec_time_out" value="<?php  if(app('request')->input('id')){ echo $shift_management->rec_time_out; } ?>" type="time" class="form-control input-border-bottom" required=""  col-form-label="">
                        </div>
                     </div>
                  </div>
                  <div class="row form-group">
                     <div class="col-md-6">
                        <div class=" form-group">	
                           <label for="inputFloatingLabel-shift-description" class="col-form-label">Shift Description</label>
                           <textarea rows="5" class="form-control"  name="shift_des"  style=""><?php  if(app('request')->input('id')){ echo $shift_management->shift_des; } ?></textarea>
                        </div>
                     </div>
                  </div>
                  <br>
                  <div class="row form-group">
                     <div class="col-md-4">
                        <div class="sub-reset-btn">
                           <a href="#">	
                           <button class="btn btn-primary" type="submit" >Submit</button></a>
                           <!-- <i class="fas fa-ban reset-ban-icon"></i> -->
                           {{-- <a href="#">	
                           <button class="btn btn-default" type="submit">Reset</button></a> --}}
                        </div>
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

    function employeeList(event) {
    if (event) event.preventDefault();  // Prevent default action if needed

    var degId = $('#designation').val();
    console.log("Selected Designation ID:", degId);

    $.ajax({
        url: "{{ url('rota/add-shift-management-desi') }}/" + degId,
        type: "GET",
        success: function(response) {
            const empIdElement = document.getElementById("empId");
            if (empIdElement) {
                empIdElement.innerHTML = response;
            } else {
                console.error("Element with id 'empId' not found.");
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", error);
        }
    });
}

    </script>
@endsection