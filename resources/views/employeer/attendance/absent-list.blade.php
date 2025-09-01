@extends('employeer.include.app')
@section('title', \App\Helpers\Helper::cachedTrans('Absentee Record'))
@section('content')
<div class="content container-fluid pb-0">
   <div class="page-header">
      <div class="row align-items-center">
         <div class="col">
            <h3 class="page-title">{{\App\Helpers\Helper::cachedTrans('Absentee Record')}}</h3>
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{url('organization/employerdashboard')}}">{{\App\Helpers\Helper::cachedTrans('Home')}}</a></li>
                <li class="breadcrumb-item"><a href="{{url('attendance-management/dashboard')}}">{{\App\Helpers\Helper::cachedTrans('Dashboard')}}</a></li>
               <li class="breadcrumb-item active">{{\App\Helpers\Helper::cachedTrans('Absentee Record')}}</li>
            </ul>
         </div>
      </div>
   </div>
   @include('employeer.layout.message')
   <div class="row">
      <div class="col-md-12">
         <div class="card custom-card">
            <div class="card-body">
               <form  method="post" action="{{ url('attendance-management/absent-report') }}" enctype="multipart/form-data" >
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="row form-group">
                        <div class="col-md-3">
                        <div class=" form-group">
                            <label for="inputFloatingLabel-grade" class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Select Department')}} </label>
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
                            <label for="designation" class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Select Designation')}}  </label>
                            <select class="select" id="designation"  name="designation" required="" onchange="chngdepartmentdesign(this.value);">
                                <option value="">&nbsp;</option>
                            </select>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <div class=" form-group">		
                            <label for="employee_code" class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Employee Code')}} </label>
                            <select id="employee_code" type="text" class="select" name="employee_code" required>
                            </select>
                        </div>
                        </div>
                        <div class="col-md-3">
                        <div class="form-group">
                            <label for="inputFloatingLabel-choose-year" class="col-form-label">{{\App\Helpers\Helper::cachedTrans('Choose Year')}} </label>
                            <select id="inputFloatingLabel-choose-year" name="year_value" class="select" required="">
                                <option value="">&nbsp;</option>
                                <?php for($i = date("Y")-2; $i <=date("Y")+5; $i++){
                                    echo '<option value="' . $i . '">' . $i . '</option>' . PHP_EOL;
                                    } ?>
                            </select>
                        </div>
                        </div>
                    </div>
                    <br>
                    <div class="row form-group">
                        <div class="col-md-3">
                            <a href="#">	
                            <button class="btn btn-primary" type="submit">{{\App\Helpers\Helper::cachedTrans('View')}} </button></a>
                            <a href="#">	
                            <button class="btn btn-primary" type="reset">{{\App\Helpers\Helper::cachedTrans('Reset')}} </button></a>
                        </div>
                    </div>
                
               </form>
            </div>
         </div>
      </div>
   </div>
   <div class="row">
      <div class="col-md-12">
         <div class="card">
            <div class="card-header">
            <div class="row">
                <div class="col-md-6"> <h4 class="card-title"><i class="far fa-file-powerpoint" aria-hidden="true" style="color:#10277f;"></i>&nbsp; {{\App\Helpers\Helper::cachedTrans('Absent Report')}} </h4></div>
                <div class="col-md-6 d-flex justify-content-end"> <!-- Added d-flex and justify-content-end -->
                    <?php 
                    if(isset($result) && $result != '') { 
                    ?>
                        <a data-toggle="tooltip" data-placement="bottom" class="btn-download btn-download me-3" title="View" href="{{ url('attendance/absent-record-card/'.base64_encode($employee_code).'/'.base64_encode($year_value)) }}" target="_blank">
                            <i class="fa-solid fa-eye"></i>{{\App\Helpers\Helper::cachedTrans('View')}} 
                        </a>
                        <a data-toggle="tooltip" data-placement="bottom" title="Download PDF" class="btn-download btn-download-pdf" href="{{ url('attendance/absent-record-card-pdf/'.base64_encode($employee_code).'/'.base64_encode($year_value)) }}"> {{\App\Helpers\Helper::cachedTrans('Download PDF')}}</a>
                    <?php 
                    } 
                    ?>
                </div>
                
               {{-- <h4 class="card-title"><i class="far fa-file-powerpoint" aria-hidden="true" style="color:#10277f;"></i>&nbsp;Absent Report --}}
                  <?php 
                     //if(isset($result) && $result!=''  ){
                                         ?>
                  {{-- <span>		<a data-toggle="tooltip" data-placement="bottom" title="View" href="{{ url('attendance/absent-record-card/'.base64_encode($employee_code).'/'.base64_encode($year_value)) }}" target="_blank"><img style="width: 35px;" src="{{ asset('img/view.png')}}"></a></span>
                  <span>		<a data-toggle="tooltip" data-placement="bottom" title="Download PDF" href="{{ url('attendance/absent-record-card-pdf/'.base64_encode($employee_code).'/'.base64_encode($year_value)) }}"  ><img style="width: 35px;" src="{{ asset('img/dnld-pdf.png')}}"></a></span> --}}
                  <?php
                    // }?>
               {{-- </h4> --}}
            </div>
            </div>
            <div class="card-body">
               <div class="table-responsive">
                  <table id="basic-datatables" class="display table table-striped table-hover" >
                     <thead>
                        <tr>
                           <th> {{\App\Helpers\Helper::cachedTrans('Sl. No')}} </th>
                           <th> {{\App\Helpers\Helper::cachedTrans('Department')}} </th>
                           <th> {{\App\Helpers\Helper::cachedTrans('Designation')}} </th>
                           <th> {{\App\Helpers\Helper::cachedTrans('Employee Code')}} </th>
                           <th> {{\App\Helpers\Helper::cachedTrans('Employee Name')}} </th>
                           <th> {{\App\Helpers\Helper::cachedTrans('Month')}} </th>
                           <th> {{\App\Helpers\Helper::cachedTrans('No.of Working Days')}} </th>
                           <th> {{\App\Helpers\Helper::cachedTrans('No.of Present Days')}} </th>
                           <th> {{\App\Helpers\Helper::cachedTrans('No.of Leave Taken')}} </th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                           if(isset($result) && $result!=''  ){
                                                        print_r($result); 
                           }?>
                     </tbody>
                  </table>
                  </table>
               </div>
            </div>
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
            url:'{{url('pis/getEmployeedailyattandeaneshightById/absent')}}/'+empid,
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