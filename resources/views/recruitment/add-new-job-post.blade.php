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
      <!--<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>-->
      <script src="https://cdn.ckeditor.com/ckeditor5/23.0.0/classic/ckeditor.js"></script>
   </head>
   <body>
      <div class="wrapper">
         @include('recruitment.include.header')
         <!-- Sidebar -->
         @include('recruitment.include.sidebar')
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
                     <a href="{{url('recruitment/job-post')}}">Job Posting</a>
                  </li>
                  <li class="separator">
                     /
                  </li>
                  <li class="nav-item active">
                     <a href="#"> New Job Posting</a>
                  </li>
               </ul>
            </div>
            <div class="content">
               <div class="page-inner">
                  <div class="row">
                     <div class="col-md-12">
                        <div class="card custom-card">
                           <div class="card-header">
                              @if(isset($_GET['id']))
                              <h4 class="card-title"><i class="fas fa-briefcase"></i> Edit Job Posting</h4>
                              @else
                              <h4 class="card-title"><i class="fas fa-briefcase"></i> Add Job Posting</h4>
                              @endif 
                           </div>
                           <div class="card-body" style="">
                              <form action="" method="post" enctype="multipart/form-data">
                                 {{csrf_field()}}					
                                 <div class="row form-group">
                                    <div class="col-md-3">
                                        
                                       <div class=" form-group">
                                          <label for="inputFloatingLabel-soc-code" class="placeholder">JOB Code</label>
                                          <select id="soc" class="form-control input-border-bottom" required="" name="soc"  onchange="chngdepartment(this.value);">
                                             <option value="">&nbsp;</option>
                                             @foreach($department_rs as $dept)
                                             <?php
                                                $email = Session::get('emp_email');
                                                $dataRoledata = DB::table('registration')      
                                                
                                                ->where('email','=',$email) 
                                                ->first();
                                                if(isset($_GET['id'])){
                                                  
                                                 if($designation[0]->soc==$dept->id){
                                                     ?>
                                             <option value="{{$dept->soc}}" <?php  if(isset($_GET['id'])){  if($designation[0]->soc==$dept->id){ echo 'selected';} } ?>>{{$dept->soc}}</option>
                                             <?php
                                                }
                                                }else{
                                                 $deptgf= DB::table('company_job')      
                                                
                                                ->where('emid','=',$dataRoledata->reg) 
                                                ->where('soc','=',$dept->id) 
                                                ->first();
                                                
                                                
                                                ?>
                                             <option value="{{$dept->soc}}" <?php  if(isset($_GET['id'])){  if($designation[0]->soc==$dept->id){ echo 'selected';} } ?>>{{$dept->soc}}</option>
                                             <?php
                                                }
                                                ?>
                                             @endforeach
                                          </select>
                                       </div>
                                    </div>
                                    <?php   if(isset($_GET['id'])){
                                       ?>
                                    <div class="col-md-3">
                                       <label for="title" class="placeholder">Job Title</label>
                                       <input id="title" type="text"  name="title" class="form-control input-border-bottom" required=""  value="<?php if(isset($_GET['id'])){  echo $designation[0]->title;  }?>{{ old('title') }}" 	>
                                    </div>
                                    <?php
                                       }else{
                                           ?>
                                    <div class="col-md-3">
                                       <div class=" form-group">
                                          <label for="title" class="placeholder">Job Title</label>
                                          <select id="title" class="form-control input-border-bottom" required="" name="title"  onchange="chngdepartmentdesp(this.value);">
                                             <option value="">&nbsp;</option>
                                          </select>
                                       </div>
                                    </div>
                                    <?php
                                       }
                                       ?>
                                    <div class="col-md-3">
                                       <div class=" form-group">
                                          <label for="department" class="placeholder">Department</label>
                                          <input id="department" type="text" class="form-control input-border-bottom" required="" name="department" value="<?php if(isset($_GET['id'])){  echo $designation[0]->department;  }?>{{ old('title') }}" <?php if(isset($_GET['id'])){ echo 'readonly';}?>>
                                       </div>
                                    </div>
                                    <!-- <div class="col-md-4">
                                       <div class=" form-group form-floating-label">		
                                       
                                         <select id="inputFloatingLabel-soc-code" type="text" class="form-control input-border-bottom" required=""  style="margin-top: 24px;">
                                         	<option>Select</option>
                                           <option>HR Manager</option>
                                       	<option>Taxation expert</option>
                                       	
                                         </select>
                                           <label for="inputFloatingLabel-soc-code" style="margin-top: 20px;" class="placeholder">Job Title</label>
                                       </div>
                                       </div> -->
                                    <!-- <div class="col-md-3">
                                       <div class=" form-group">
                                       <label for="inputFloatingLabel-job-details" class="placeholder">Job Code</label>
                                       	<input id="inputFloatingLabel-job-details" type="text"  name="job_code"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->job_code;  }?>{{ old('job_code') }}"  class="form-control input-border-bottom" required="">
                                       
                                       
                                       </div>
                                       </div> -->
                                 </div>
                                 <div class="row form-group">
                                    <div class="col-md-12">
                                       <label for="job_desc" class="placeholder">Job Description</label>
                                       <textarea id="job_desc"   name="job_desc" type="text"  rows="5" class="form-control"  required="" <?php if(isset($_GET['id'])){ echo '';}?>><?php if(isset($_GET['id'])){  ?>  {!! $designation[0]->job_desc !!} <?php  }?>  </textarea>
                                    </div>
                                    <div class="col-md-4">
                                       <div class=" form-group">
                                          <label for="inputFloatingLabel-job-type" class="placeholder">Job Type</label>	
                                          <select id="inputFloatingLabel-job-type" name="job_type" type="text" class="form-control input-border-bottom" required="">
                                             <option value="">&nbsp;</option>
                                             <option value="Full Time"  <?php  if(request()->get('id')!=''){  if($designation[0]->job_type=='Full Time'){ echo 'selected';} } ?>>Full Time</option>
                                             <option value="Part Time"  <?php  if(request()->get('id')!=''){  if($designation[0]->job_type=='Part Time'){ echo 'selected';} } ?>>Part Time</option>
                                             <option value="Contractual"  <?php  if(request()->get('id')!=''){  if($designation[0]->job_type=='Contractual'){ echo 'selected';} } ?>>Contractual</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class=" form-group">
                                          <label for="working_hour" class="placeholder">Working Hours (Weekly)</label>
                                          <select id="working_hour" name="working_hour" class="form-control input-border-bottom" required="">
                                             <option value="">&nbsp;</option>
                                             @for ($i = 1; $i <= 80; $i+=0.5)
                                             <option value="{{ $i }}" <?php  if(request()->get('id')!=''){  if($designation[0]->working_hour==$i){ echo 'selected';}}  ?>>{{ $i }}</option>
                                             @endfor
                                          </select>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row form-group">
                                    <div class="col-md-6">
                                       <label for="inputFloatingLabel-salary" class="placeholder">Job Experience</label>
                                       <div class="row">
                                          <div class="col-md-4">
                                             <div class=" form-group">
                                                <select id="inputFloatingLabel-selaect-salary" name="work_min"  class="form-control input-border-bottom" required="">
                                                   <option value="">Min</option>
                                                   @for ($i = 0; $i <= 15; $i++)
                                                   <option value="{{ $i }}" <?php  if(request()->get('id')!=''){  if($designation[0]->work_min==$i){ echo 'selected';}}  ?>>{{ $i }}</option>
                                                   @endfor
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class=" form-group">
                                                <select id="inputFloatingLabel-selaect-salary" name="work_max"   class="form-control input-border-bottom" required="">
                                                   <option  value="">Max</option>
                                                   @for ($j = 0; $j <= 50; $j++)
                                                   <option value="{{ $j }}" <?php  if(request()->get('id')!=''){  if($designation[0]->work_max==$j){ echo 'selected';}}  ?>>{{ $j }}</option>
                                                   @endfor
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <label for="inputFloatingLabel-salary" class="placeholder"> Basic Salary</label>
                                       <div class="row">
                                          <div class="col-md-4">
                                             <div class=" form-group">
                                                <label for="basic_min" class="placeholder">Min</label>
                                                <input id="basic_min" type="text" class="form-control input-border-bottom" required="" name="basic_min"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->basic_min;  }?>{{ old('basic_min') }}">
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class=" form-group">	
                                                <label for="basic_max" class="placeholder">Max</label>	
                                                <input id="basic_max" type="text" class="form-control input-border-bottom" required="" name="basic_max"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->basic_max;  }?>{{ old('basic_max') }}">
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class=" form-group">
                                                <label for="time_pre" class="placeholder"> Period </label>	
                                                <select class="form-control input-border-bottom" id="time_pre" required="" name="time_pre">
                                                   <option value="">&nbsp;</option>
                                                   <option value="Annually" <?php  if(request()->get('id')!=''){  if($designation[0]->time_pre=='Annually'){ echo 'selected';} } ?>>Annually</option>
                                                   <option value="Monthly"  <?php  if(request()->get('id')!=''){  if($designation[0]->time_pre=='Monthly'){ echo 'selected';} } ?>>Monthly</option>
                                                   <option value="Hourly"  <?php  if(request()->get('id')!=''){  if($designation[0]->time_pre=='Hourly'){ echo 'selected';} } ?>>Hourly</option>
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class=" form-group">	
                                          <label for="inputFloatingLabel-add-1" class="placeholder">Number Of Vacancies</label>				
                                          <input id="inputFloatingLabel-add-1" type="number" class="form-control input-border-bottom" required="" name="no_vac"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->no_vac;  }?>{{ old('no_vac') }}">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class=" form-group">	
                                          <label for="inputFloatingLabel-add-2" class="placeholder">Job Location</label>
                                          <input id="inputFloatingLabel-add-2" type="text" class="form-control input-border-bottom" required="" name="job_loc"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->job_loc;  }?>{{ old('job_loc') }}">
                                       </div>
                                    </div>
                                 </div>
                                 <div class="row form-group">
                                    <div class="col-md-12">
                                       <h2 style="color:#1269db">Desired Candidate</h2>
                                    </div>
                                    <div class="col-md-4">
                                       <div class=" form-group">	
                                          <label for="inputFloatingLabel-qualification" class="placeholder">Qualifications</label>	
                                          <input id="inputFloatingLabel-qualification" type="text" class="form-control input-border-bottom" required="" name="quli"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->quli;  }?>{{ old('quli') }}">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class=" form-group">	
                                          <label for="inputFloatingLabel-skill-set" class="placeholder">Skill Set</label>	
                                          <input id="inputFloatingLabel-skill-set" type="text" class="form-control input-border-bottom" name="skill"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->skill;  }?>{{ old('skill') }}">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <label for="inputFloatingLabel-age" class="placeholder">Age</label>
                                       <input id="skil_set" type="hidden" class="form-control input-border-bottom" required="" name="skil_set" value="<?php if(isset($_GET['id'])){  echo $designation[0]->skil_set;  }?>{{ old('skil_set') }}" >
                                       <div class="row">
                                          <div class="col-md-4">
                                             <div class=" form-group">
                                                <select id="inputFloatingLabel-age"  name="age_min" class="form-control input-border-bottom" required="">
                                                   <option value="">Min</option>
                                                   @for ($k = 15; $k <= 35; $k++)
                                                   <option value="{{ $k }}" <?php  if(request()->get('id')!=''){  if($designation[0]->age_min==$k){ echo 'selected';}}  ?>>{{ $k }}</option>
                                                   @endfor
                                                </select>
                                             </div>
                                          </div>
                                          <div class="col-md-4">
                                             <div class=" form-group">
                                                <select id="inputFloatingLabel-age" name="age_max"  class="form-control input-border-bottom" required="">
                                                   <option value="">Max</option>
                                                   @for ($l = 30; $l <= 70; $l++)
                                                   <option value="{{ $l }}" <?php  if(request()->get('id')!=''){  if($designation[0]->age_max==$l){ echo 'selected';}}  ?>>{{ $l }}</option>
                                                   @endfor
                                                </select>
                                             </div>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class=" form-group">
                                          <!-- 	<input id="inputFloatingLabel-gender" type="text" class="form-control input-border-bottom" required="" style="margin-top: 22px;">
                                             <label for="inputFloatingLabel-gender" class="placeholder">Gender</label> -->
                                          <h6>Gender</h6>
                                          <input type="checkbox" id="gender_male" name="gender_male" value="Male" <?php  if(request()->get('id')!=''){  if($designation[0]->gender_male=='Male'){ echo 'checked';} } ?>>
                                          <label for="vehicle1">Male</label>&nbsp &nbsp &nbsp
                                          <input type="checkbox" id="gender" name="gender" value="Female" <?php  if(request()->get('id')!=''){  if($designation[0]->gender=='Female'){ echo 'checked';} } ?>>
                                          <label for="vehicle1">Female</label>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class=" form-group">
                                          <label for="inputFloatingLabel-job-posting-date"  class="placeholder">Job Posting Date</label>
                                          <input id="inputFloatingLabel-job-posting-date"  type="date"  class="form-control input-border-bottom" required="" name="post_date"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->post_date;  }?>{{ old('post_date') }}" <?php if(isset($_GET['id'])){ ?> readonly  <?php }else{?> max="{{date('Y-m-d')}}" <?php } ?> >
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class=" form-group">
                                          <label for="inputFloatingLabel-end-date"  class="placeholder">Closing Date</label>
                                          <input id="inputFloatingLabel-end-date"  type="date"  class="form-control input-border-bottom" required="" name="clos_date"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->clos_date;  }?>{{ old('clos_date') }}">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class=" form-group">
                                          <label for="author" class="placeholder"> Authorising Officer</label>
                                          <input id="author" type="text" class="form-control input-border-bottom" required="" name="author"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->author;  }?>{{ old('author') }}">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class=" form-group">
                                          <label for="desig" class="placeholder"> Authorising Officer’s Designation</label>
                                          <input id="desig" type="text" class="form-control input-border-bottom" required=""  name="desig"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->desig;  }?>{{ old('desig') }}">
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class=" form-group">
                                          <label for="inputFloatingLabel-mail" class="placeholder"> Contact Number</label>
                                          <input id="inputFloatingLabel-mail" type="tel" class="form-control input-border-bottom" required=""  name="con_num"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->con_num;  }?>{{ old('con_num') }}">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class=" form-group">
                                          <label for="inputFloatingLabel-number" class="placeholder">Email</label>
                                          <input id="inputFloatingLabel-number" type="email" class="form-control input-border-bottom" required="" name="email"  value="<?php if(isset($_GET['id'])){  echo $designation[0]->email;  }?>{{ old('email') }}">
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class=" form-group">
                                          <label for="role" class="placeholder">Is this a new role</label>
                                          <select class="form-control input-border-bottom" id="role" required="" name="role">
                                             <option value="">&nbsp;</option>
                                             <option value="Yes" <?php  if(request()->get('id')!=''){  if($designation[0]->role=='Yes'){ echo 'selected';} } ?>>Yes</option>
                                             <option value="No"  <?php  if(request()->get('id')!=''){  if($designation[0]->role=='No'){ echo 'selected';} } ?>>No</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-6">
                                       <div class=" form-group">
                                          <label for="english_pro" class="placeholder">Language Requirements
                                          </label>		
                                          <select class="form-control input-border-bottom" id="english_pro"  name="english_pro" required="" onchange="trade_epmloyee(this.value);">
                                             <option value="">&nbsp;</option>
                                             <option value="English Proficiency - Minimum of  UKVI IELTS 4 or  equivalent for international candidates only" <?php  if(request()->get('id')!=''){  if($designation[0]->english_pro=='English Proficiency - Minimum of  UKVI IELTS 4 or  equivalent for international candidates only'){ echo 'selected';} } ?>>English Proficiency - Minimum of  UKVI IELTS 4 or  equivalent for international candidates only</option>
                                             <option value="Not Required" <?php  if(request()->get('id')!=''){  if($designation[0]->english_pro=='Not Required'){ echo 'selected';} } ?>>Not Required</option>
                                             <option value="Others" <?php  if(request()->get('id')!=''){  if($designation[0]->english_pro=='Others'){ echo 'selected';} } ?>>Others</option>
                                          </select>
                                       </div>
                                    </div>
                                    <div class="col-md-4 " id="criman_new" <?php   if(request()->get('id')!=''){ if($designation[0]->english_pro=='Others'){  ?> style="display:block;" <?php }else{ ?> style="display:none;" <?php }}else{ ?> style="display:none;" <?php  }  ?>>
                                       <div class="form-group">
                                          <label for="other" class="placeholder">Give Details </label>
                                          <input id="other" type="text" class="form-control input-border-bottom" name="other"  value="@if(request()->get('id')!='') @if($designation[0]->other){{  $designation[0]->other }}@endif @endif">
                                       </div>
                                    </div>
                                    <?php  if(request()->get('id')!=''){
                                       ?>
                                    <div class="col-md-4">
                                       <div class=" form-group">
                                          <label for="status" class="placeholder">Status</label>		
                                          <select class="form-control input-border-bottom" id="status" required="" name="status">
                                             <option value="">&nbsp;</option>
                                             <option value="Job Created" <?php  if(request()->get('id')!=''){  if($designation[0]->status=='Job Created'){ echo 'selected';} } ?>>Job Created</option>
                                             <option value="Published"  <?php  if(request()->get('id')!=''){  if($designation[0]->status=='Published'){ echo 'selected';} } ?>>Published</option>
                                          </select>
                                       </div>
                                    </div>
                                    <?php } ?>
                                 </div>
                                 <div class="row form-group">
                                    <div class="col-md-12">
                                       <button class="btn btn-default" type="submit">Submit</button>
                                    </div>
                                 </div>
                              </form>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @include('recruitment.include.footer')
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
         
           function chngdepartment(empid){
          
           	$.ajax({
         type:'GET',
         url:'{{url('pis/getjobpostByIdlkkk')}}/'+empid,
               cache: false,
         success: function(response){
         
         		document.getElementById("title").innerHTML = response;
         	
         }
         });
          }
            function chngdepartmentdesp(empid){
           var soc=$( "#soc option:selected" ).val();
          
           	$.ajax({
         type:'GET',
         url:'{{url('pis/getjobpostByIdlkkkll')}}/'+empid+'/'+soc,
               cache: false,
         success: function(response){
         	console.log(response);
          var obj = jQuery.parseJSON(response);
         	 var job_desc=obj.des_job;
         	  var department=obj.department;
         	 
         	
         		   $("#job_desc").val(job_desc);
         		    $("#skil_set").val(obj.skil_set);
         		      $("#department").val(department);
         		 
         			CKEDITOR.instances['job_desc'].setData(job_desc);
         			  $("#department").attr("readonly", true);
         	
         }
         });
          }
          
            function trade_epmloyee(val) {
         if(val=='Others'){
         document.getElementById("criman_new").style.display = "block";	
         $("#other").prop('required',true);
         
         }else{
         document.getElementById("criman_new").style.display = "none";	
         	$("#other").prop('required',false);
         }
         
         }
          
      </script>
      <script>CKEDITOR.replace( 'job_desc' );</script>
   </body>
</html>