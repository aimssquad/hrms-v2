@extends('employeer.include.app')
@section('title', 'Right to Work checks')
@php 
$user_type = Session::get("user_type");
$sidebarItems = \App\Helpers\Helper::getSidebarItems();
//dd($employeeh->emid);
@endphp
@section('content')
<div class="main-panel" style="width:100%">
   <div class="content">
      <div class="page-inner">
         <div class="row">
            <div class="col-sm-12">
               <h3 class="page-title">Right To Work Checks</h3>
               <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{route('organization.home')}}">Dashboard</a></li>
                  <li class="breadcrumb-item active">Right To Work Checks</li>
               </ul>
            </div>
         </div>
         <div class="row">
            <div class="col-md-12">
               <div class="card">
                  <div class="card-header">
                     <h4 class="card-title">Right to Work Checklist (RTW) @if($work_rs->evidence=='share_code') Share code @endif<span id="share"></span></h4>
                  </div>
                  <div class="card-body">
                     <form name="basicform" id="basicform" method="post" action="{{ url('org-edit-right-works') }}" enctype="multipart/form-data">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
                        <input type="hidden" name="id" value="{{$work_rs->id}}">
                        <div id="sf1" class="frm">
                           {{-- 
                           <fieldset>
                              --}}
                              <!-- <legend>Your Details</legend> -->
                              <div class="row form-group">
                                 <div class="col-md-6">
                                    <label>Name of Person</label>
                                    <input type="hidden" name="employee_id" value="{{$employeeh->emp_code}}">
                                    <select class="form-control"  id="employee_id" name="employee_id" required   disabled>
                                       <option value="">Applicant /Employee Name</option>
                                       @foreach($employee_rs as $employee)
                                       <option value="{{$employee->emp_code}}" @if($employee->emp_code==$employeeh->emp_code) selected @endif >{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }} ({{$employee->emp_code}})</option>
                                       @endforeach
                                    </select>
                                 </div>
                                 <div class="col-md-6">
                                    <label>Date of Check</label>
                                    <input type="date" class="form-control" id="date" placeholder="" name="date" required value="{{$work_rs->date}}" >
                                 </div>
                              </div>
                              <?php 
                                 $timearray=array();
                                 $timearray=explode(',',$work_rs->type);
                                 
                                 ?>
                              <div class="row form-group">
                                 <div class="col-md-12">
                                    <label>Type of check</label><br>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input" name="type[]" id="initialCheck" value="Initial check for new employee/applicant - required before employment" <?php if(in_array("Initial check for new employee/applicant - required before employment", $timearray)){ echo 'checked';}?> >Initial check before employment
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input" name="type[]" id="followUpCheck" value="Follow-up check on an existing employee - required before permission to work    expires (under List B - Group 1 or 2)"  <?php if(in_array("Follow-up check on an existing employee - required before permission to work    expires (under List B - Group 1 or 2)", $timearray)){ echo 'checked';}?>>Follow-up check on an employee
                                       </label>
                                    </div>
                                 </div>
                              </div>
                              <?php 
                                 $timearray=array();
                                 $timearray=explode(',',$work_rs->medium);
                                 
                                 ?>
                              <div class="row form-group">
                                 <div class="col-md-12">
                                    <label>Medium of check</label><br>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input comon" name="medium[]" value="In-person manual check with original documents" <?php if(in_array("In-person manual check with original documents", $timearray)){ echo 'checked';}?>>In-person manual check with original documents</label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input comon" name="medium[]" value="Online right to work check" <?php if(in_array("Online right to work check", $timearray)){ echo 'checked';}?>>Online right to work check</label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input" id="share_code_checkbox" name="medium[]" value="Share Code" <?php if(in_array("Share Code", $timearray)){ echo 'checked';}?> onclick='document.getElementById("share").innerHTML = " Share Code"'>Share Code</label>
                                    </div>
                                 </div>
                              </div>
                              <div class="row form-group">
                                 <div class="col-md-4">
                                    <?php
                                       $desig_rs=DB::table('employee')
                                        
                                         ->where('emp_code', '=',  $work_rs->employee_id)
                                          ->where('emid', '=',  $employeeh->emid)
                                         ->first();
                                           $employee_rs=DB::table('employee_qualification')
                                        
                                         ->where('emp_id', '=',  $work_rs->employee_id)
                                          ->where('emid', '=',  $employeeh->emid)
                                         ->get();
                                          $employee_otherd_doc_rs = DB::table('employee_other_doc')
                                         ->where('emid','=',$employeeh->emid )
                                                             ->where('emp_code','=',  $work_rs->employee_id)
                                                        ->get();
                                       $result_status1='';
                                         
                                         
                                       ?>
                                    <label>Evidence presented</label><br>
                                    <input type="text" class="form-control" placeholder="" id="evidence"  name="evidence" value="{{$work_rs->evidence}}">
                                    <!--<select class="form-control" placeholder="" id="evidence" name="evidence">-->
                                    <!--   <option value="">Select</option>-->
                                       <?php
                                        //   foreach($employee_rs as $bank)
                                        //   {
                                        //   if($work_rs->evidence==$bank->quli.' Transcript Document'){
                                        //       $se= 'selected';
                                        //       }else{
                                        //           $se='';
                                        //       }
                                        //   if($bank->doc!=''){
                                        //   echo '<option value="'.$bank->quli.' Transcript Document" '.$se.'>'.$bank->quli.' Transcript Document</option>';
                                           
                                        //   }
                                        //   if($work_rs->evidence==$bank->quli.' Certificate Document'){
                                        //       $se= 'selected';
                                        //       }else{
                                        //           $se='';
                                        //       }
                                        //     if($bank->doc2!=''){
                                        //   echo '<option value="'.$bank->quli.' Certificate Document"  '.$se.'>'.$bank->quli.' Certificate Document</option>';
                                           
                                        //   }
                                        //   }
                                          
                                        //   foreach($employee_otherd_doc_rs as $banknew)
                                        //   {
                                        //   if($work_rs->evidence==$banknew->doc_name){
                                        //       $se= 'selected';
                                        //       }else{
                                        //           $se='';
                                        //       }
                                        //   if($banknew->doc_name!=''){
                                        //   echo '<option value="'.$banknew->doc_name.'"  '.$se.'>'.$banknew->doc_name.'</option>';
                                           
                                        //   }
                                          
                                        //   }
                                        //   if($work_rs->evidence=='pr_add_proof'){
                                        //       $se= 'selected';
                                        //       }else{
                                        //           $se='';
                                        //       }
                                        //   if($desig_rs->pr_add_proof!=''){
                                        //      echo '<option value="pr_add_proof" '.$se.'>Proof Of Correspondence   Address </option>'; 
                                             
                                        //   }
                                        //   if($work_rs->evidence=='pass_docu'){
                                        //       $se= 'selected';
                                        //       }else{
                                        //           $se='';
                                        //       }
                                        //   if($desig_rs->pass_docu!=''){
                                        //   echo '<option value="pass_docu" '.$se.'>Passport    Document </option>'; 
                                             
                                        //   }
                                        //   if($work_rs->evidence=='Share Code'){
                                        //       $se= 'selected';
                                        //       }else{
                                        //           $se='';
                                        //       }
                                        //   if (!empty($work_rs->share_doc)){
                                        //         echo  '<option value="Share Code" '.$se.'>Share Code</option>';
                                        //       }
                                        //   if($work_rs->evidence=='visa_upload_doc'){
                                        //       $se= 'selected';
                                        //       }else{
                                        //           $se='';
                                        //       }
                                        //   if($desig_rs->visa_upload_doc!=''){
                                        //      echo '<option value="visa_upload_doc" '.$se.'>Visa    Document </option>'; 
                                             
                                        //   }
                                        //   if($work_rs->evidence=='euss_upload_doc'){
                                        //       $se= 'selected';
                                        //       }else{
                                        //           $se='';
                                        //       }
                                          
                                        //   if($desig_rs->euss_upload_doc!=''){
                                        //      echo '<option value="euss_upload_doc" '.$se.'>EUSS    Document </option>'; 
                                             
                                        //   }
                                        //   if($work_rs->evidence=='nat_upload_doc'){
                                        //       $se= 'selected';
                                        //       }else{
                                        //           $se='';
                                        //       }
                                          
                                        //   if($desig_rs->nat_upload_doc!=''){
                                        //      echo '<option value="nat_upload_doc" '.$se.'>National Id     Document </option>'; 
                                             
                                        //   }
                                          ?>
                                    <!--</select>-->
                                 </div>
                                 <div class="col-md-4">
                                    <label>Work start time</label><br>
                                    <input type="date" class="form-control" placeholder="" name="start_date" id="start_date" value="{{$work_rs->start_date}}">
                                 </div>
                                 <div class="col-md-4">
                                    <label>Time of check</label><br>
                                    <input type="text" class="form-control" placeholder="" name="start_time" value="{{$work_rs->start_time}}">
                                 </div>
                              </div>
                              <div class="clearfix" style="height: 10px;clear: both;"></div>
                              <div class="form-group" style="margin-top: 30px">
                                 <div class="col-lg-10 col-lg-offset-2">
                                    <button class="btn btn-primary open1" type="button">Next <span class="fa fa-arrow-right"></span></button> 
                                 </div>
                              </div>
                              {{-- 
                           </fieldset>
                           --}}
                        </div>
                        <?php 
                           $timearray=array();
                           $timearray=explode(',',$work_rs->list_ap);
                           
                           ?>
                        {{-- @if($work_rs->evidence=='share_code') --}}
                        <div id="sf5" class="frm" style="display: none;">
                           <div class="row form-group">
                              <div class="col-md-6">
                                 <label>Share Code Referance No</label>
                                 <input type="text" class="form-control" id="date" placeholder="" name="share_referance_no" required value="{{$work_rs->share_referance_no}}" style="text-transform: uppercase;">
                              </div>
                              <div class="col-md-6">
                                 <label>Share Code Use By</label>
                                 <input type="text" class="form-control" id="date" placeholder="" name="share_code_used_by" required value="{{$work_rs->share_code_used_by}}" style="text-transform: uppercase;">
                              </div>
                              <div class="col-md-6">
                                 <label>Company Name</label>
                                 <input type="text" class="form-control" id="date" placeholder="" name="share_com_name" required value="{{$work_rs->share_com_name}}" style="text-transform: uppercase;">
                              </div>
                              <div class="col-md-6">
                                 <label>Date of Check</label>
                                 <input type="date" class="form-control" id="date" placeholder="" name="share_date_check" required value="{{ \Carbon\Carbon::parse($work_rs->share_date_check)->format('Y-m-d') }}" >
                              </div>
                              <div class="col-md-6">
                                 <label>Permission To Work From</label>
                                 <input type="date" class="form-control" id="date" placeholder="" name="share_permission_form" required value="{{ \Carbon\Carbon::parse($work_rs->share_permission_form)->format('Y-m-d') }}" >
                              </div>
                              <div class="col-md-6">
                                 <label>Permission To Work Expiry</label>
                                 <input type="date" class="form-control" id="date" placeholder="" name="share_permission_expiry" required value="{{ \Carbon\Carbon::parse($work_rs->share_permission_expiry)->format('Y-m-d') }}" >
                              </div>
                              <div class="col-md-6">
                                 <label>Remarks</label>
                                 <input type="text" class="form-control" id="date" placeholder="" name="share_remarks" required value="{{ $work_rs->share_remarks}}" >
                              </div>
                              {{-- <div class="col-md-6" id="file-upload-area">
                                 <label>Document Upload</label>
                                 <div class="input-group mb-2 file-input-row">
                                     <input type="file" class="form-control" name="share_doc[]" required>
                                     <button type="button" class="btn btn-success add-file">+</button>
                                 </div>
                              </div> --}}
                              @php
                              // Decode the JSON value from the database into an array
                                 $existingDocs = $work_rs->share_doc ? json_decode($work_rs->share_doc, true) : [];
                              @endphp
                          
                          <div class="col-md-6" id="file-upload-area">
                              <label>Uploaded Documents</label>
                          
                              <!-- Loop through existing documents and display them with download links -->
                              @foreach ($existingDocs as $doc)
                                  <div class="input-group mb-2 file-input-row">
                                      <a href="{{ asset('storage/uploads/rtw/' . $doc) }}" target="_blank" class="form-control text-primary" style="text-decoration: underline;">
                                          {{ $doc }}
                                      </a>
                                  </div>
                              @endforeach
                          
                              <!-- Add a new file upload input -->
                              <div class="input-group mb-2 file-input-row" id="file-upload-area">
                                  <input type="file" class="form-control" name="share_doc[]" required>
                                  <button type="button" class="btn btn-success add-file">+</button>
                              </div>
                          </div>
                          
                              
                           </div>
                           <div class="row form-group">
                              <div class="col-md-12">
                                 <label style="padding-top:10px; text:20px;">If you employ this person you must : </label><br>
                                 <div class="form-check-inline">
                                    <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="share_phically" value="Check this look like the person you meet face to face or by video call" {{ $work_rs->share_phically == "Check this look like the person you meet face to face or by video call" ? 'checked' : '' }}>
                                    Check this look like the person you meet face to face or by video call</label>
                                 </div>
                                 <div class="form-check-inline">
                                    <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="share_hardcopy" value="Keep a secure copy of this online check(either electronicaly or hand copy), for duretion of the employment and for 2 years after" {{ $work_rs->share_hardcopy == "Keep a secure copy of this online check(either electronicaly or hand copy), for duretion of the employment and for 2 years after" ? 'checked' : '' }}>
                                    Keep a secure copy of this online check(either electronicaly or hand copy), for duretion of the employment and for 2 years after</label>
                                 </div>
                              </div>
                           </div>
                           <div class="clearfix" style="height: 10px;clear: both;"></div>
                           <div class="form-group" style="margin-top: 30px">
                              <div class="col-lg-10 col-lg-offset-2">
                                 <button class="btn btn-warning back1" id="share_back" type="button"><span class="fa fa-arrow-left"></span> Back</button> 
                                 <button class="btn btn-primary" type="submit">Submit </button> 
                              </div>
                           </div>
                        </div>   
                        {{-- @else   --}}
                        <div id="sf2" class="frm" style="display: none;">
                           <p>You may conduct a physical document check or perform an online check to establish
                              a right to work. Where a right to work check has been conducted using the online
                              service, the information is provided in real-time, directly from Home Office systems
                              and there is no requirement to see the documents listed below.
                           </p>
                           {{-- 
                           <fieldset>
                              --}}
                              <legend style="color: #00b1ff;font-size: 20px;">Step1 for physical check</legend>
                              <p>You must <b>obtain original</b> documents from either <b>List A</b> or <b>List B</b> of acceptable documents for a manual right to work check.</p>
                              <h3 style="background: #82b8fd;color: #fff;padding: 5px 20px;">List A</h3>
                              <div class="row form-group">
                                 <div class="col-md-12">
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input" name="list_ap[]" value="A passport"  <?php if(in_array("A passport", $timearray)){ echo 'checked';}?>>A passport 
                                       <b>(current or expired)</b> showing the holder, or a person named in the
                                       passport as the child of the holder, is a British citizen or a citizen of the UK and</br>
                                       Colonies having the right of abode in the UK.
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input" name="list_ap[]" value="A passport or national" <?php if(in_array("A passport or national", $timearray)){ echo 'checked';}?>>
                                       A passport or passport card <b>(current or expired)</b> showing that the holder is a
                                       national of the Republic of Ireland.
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input"  name="list_ap[]"  value="A Registration Certificate" <?php if(in_array("A Registration Certificate", $timearray)){ echo 'checked';}?>>
                                       A current document issued by the Home Office to a family member of an EEA
                                       or Swiss citizen, and which indicates that the holder is permitted to stay in the</br>
                                       United Kingdom indefinitely.
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input"  name="list_ap[]"  value="A Registration Certificate or Document" <?php if(in_array("A Registration Certificate or Document", $timearray)){ echo 'checked';}?>>
                                       A document issued by the Bailiwick of Jersey, the Bailiwick of Guernsey or the
                                       Isle of Man, which has been verified as valid by the Home Office Employer</br>
                                       Checking Service, showing that the holder has been granted unlimited
                                       leave to enter or remain under Appendix EU to the Jersey Immigration
                                       Rules,</br> Appendix EU to the Immigration (Bailiwick of Guernsey) Rules 2008 or
                                       Appendix EU to the Isle of Man Immigration Rules.
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input" name="list_ap[]"  value="A current Biometric Immigration" <?php if(in_array("A current Biometric Immigration", $timearray)){ echo 'checked';}?>>
                                       A current Biometric Immigration Document (biometric residence permit)
                                       issued by the Home Office to the holder indicating that the person named is</br>
                                       allowed to stay indefinitely in the UK, or has no time limit on their stay in the
                                       UK.
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input" name="list_ap[]"  value="A current passport endorsed" <?php if(in_array("A current passport endorsed", $timearray)){ echo 'checked';}?>>
                                       A current passport endorsed to show that the holder is exempt from
                                       immigration control, is allowed to stay indefinitely in the UK, has the right of</br>
                                       abode in the UK, or has no time limit on their stay in the UK.
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input" name="list_ap[]"  value="A current Immigration Status"  <?php if(in_array("A current Immigration Status", $timearray)){ echo 'checked';}?>>
                                       A current Immigration Status Document issued by the Home Office to the holder
                                       with an endorsement indicating that the named person is allowed to stay
                                       indefinitely</br> in the UK or has no time limit on their stay in the UK, together with an
                                       official document giving the person’s permanent National Insurance number</br>
                                       and their name issued by a government agency or a previous employer.
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input"  name="list_ap[]" value="A birth (short or long) or adoption" <?php if(in_array("A birth (short or long) or adoption", $timearray)){ echo 'checked';}?>>
                                       A birth or adoption certificate issued in the UK, together with an official
                                       document giving the person’s permanent National Insurance number and their
                                       name issued by</br> a government agency or a previous employer
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input"  name="list_ap[]" value="A birth (short or long) or adoption certificate" <?php if(in_array("A birth (short or long) or adoption certificate", $timearray)){ echo 'checked';}?>>
                                       A birth or adoption certificate issued in the Channel Islands, the Isle of Man
                                       or Ireland, together with an official document giving the person’s permanent
                                       National Insurance</br> number and their name issued by a government agency or
                                       a previous employer.
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input"  name="list_ap[]" value="A certificate of registration or naturalisation as a British" <?php if(in_array("A certificate of registration or naturalisation as a British", $timearray)){ echo 'checked';}?>>
                                       A certificate of registration or naturalisation as a British citizen, together with an
                                       official document giving the person’s permanent National Insurance number
                                       and their name</br> issued by a government agency or a previous employer. 
                                       </label>
                                    </div>
                                 </div>
                              </div>
                              <?php 
                                 $timearray=array();
                                 $timearray=explode(',',$work_rs->list_bp);
                                 
                                 ?>
                              <h3 style="background: #82b8fd;color: #fff;padding: 5px 20px;">List B Group 1</h3>
                              <div class="row form-group">
                                 <div class="col-md-12">
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input"  name="list_bp[]" value="A current passport endorsed to show that the holder"  <?php if(in_array("A current passport endorsed to show that the holder", $timearray)){ echo 'checked';}?> >
                                       A current passport endorsed to show that the holder is allowed to stay in the
                                       UK and is currently allowed to do the type of work in question.</label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input" name="list_bp[]" value="A current Biometric Immigration Document" <?php if(in_array("A current Biometric Immigration Document", $timearray)){ echo 'checked';}?>>
                                       A current Biometric Immigration Document (biometric residence permit)
                                       issued by the Home Office to the holder which indicates that the named
                                       person can currently</br> stay in the UK and is allowed to do the work in question.
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input"  name="list_bp[]" value="A current Residence Card" <?php if(in_array("A current Residence Card", $timearray)){ echo 'checked';}?>>
                                       A current document issued by the Home Office to a family member of an
                                       EEA or Swiss citizen, and which indicates that the holder is permitted to stay
                                       in the United</br> Kingdom for a time-limited period and to do the type of work in
                                       question.
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input" name="list_bp[]" value="A current Immigration Status Document containing a" <?php if(in_array("A current Immigration Status Document containing a", $timearray)){ echo 'checked';}?>  >
                                       A document issued by the Bailiwick of Jersey, the Bailiwick of Guernsey or the
                                       Isle of Man, which has been verified as valid by the Home Office Employer
                                       Checking Service</br>, showing that the holder has been granted limited leave to
                                       enter or remain under Appendix EU to the Jersey Immigration Rules, Appendix
                                       EU to the</br> Immigration (Bailiwick of Guernsey) Rules 2008 or Appendix EU to the
                                       Isle of Man Immigration Rules.</label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input" name="list_bp[]" <?php if(in_array("A document issued by the Bailiwick of Jersey", $timearray)){ echo 'checked';}?> value="A document issued by the Bailiwick of Jersey" >
                                       A document issued by the Bailiwick of Jersey or the Bailiwick of Guernsey,
                                       which has been verified as valid by the Home Office Employer Checking
                                       Service, showing</br> that the holder has made an application for leave to enter or
                                       remain under Appendix EU to the Jersey Immigration Rules or Appendix EU to
                                       the Immigration</br> (Bailiwick of Guernsey) Rules 2008, on or before 30 June 2021.</label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input" name="list_bp[]" value="A frontier worker permit" <?php if(in_array("A frontier worker permit", $timearray)){ echo 'checked';}?>>
                                       A frontier worker permit issued under regulation 8 of the Citizens’ Rights
                                       (Frontier Workers) (EU Exit) Regulations 2020.</label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input" name="list_bp[]" value="A current immigration status document containing a photograph"  <?php if(in_array("A current immigration status document containing a photograph", $timearray)){ echo 'checked';}?>>
                                       A current immigration status document containing a photograph issued by
                                       the Home Office to the holder with a valid endorsement indicating that the
                                       named person may</br> stay in the UK, and is allowed to do the type of work in
                                       question, together with an official document giving the person’s permanent
                                       National Insurance</br> number and their name issued by a government agency
                                       or a previous employer.</label>
                                    </div>
                                 </div>
                              </div>
                              <h3 style="background: #82b8fd;color: #fff;padding: 5px 20px;">List B Group 2</h3>
                              <?php 
                                 $timearray=array();
                                 $timearray=explode(',',$work_rs->list_bpc);
                                 
                                 ?>
                              <div class="row form-group">
                                 <div class="col-lg-12">
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input" name="list_bpc[]" value="A Certificate of Application issued" <?php if(in_array("A Certificate of Application issued", $timearray)){ echo 'checked';}?>>
                                       A document issued by the Home Office showing that the holder has made an
                                       application for leave to enter or remain under Appendix EU to the immigration
                                       rules on or</br> before 30 June 2021 together with a Positive Verification Notice
                                       from the Home Office Employer Checking Service.</label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input" name="list_bpc[]" value="An Application Registration Card issued" <?php if(in_array("An Application Registration Card issued", $timearray)){ echo 'checked';}?>>
                                       A document issued by the Bailiwick of Jersey or the Bailiwick of Guernsey,
                                       showing that the holder has made an application for leave to enter or remain
                                       under Appendix</br> EU to the Jersey Immigration Rules or Appendix EU to the
                                       Immigration (Bailiwick of Guernsey) Rules 2008 on or before 30 June 2021
                                       together with</br> a Positive Verification Notice from the Home Office Employer
                                       Checking Service.
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input" name="list_bpc[]" value="A Positive Verification Notice"  <?php if(in_array("A Positive Verification Notice", $timearray)){ echo 'checked';}?>>
                                       An application registration card issued by the Home Office stating that the
                                       holder is permitted to take the employment in question, together with a
                                       Positive Verification Notice </br>from the Home Office Employer Checking Service.
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input" name="list_bpc[]" value="A Positive Verification Notice issued" <?php if(in_array("A Positive Verification Notice issued", $timearray)){ echo 'checked';}?>>
                                       A Positive Verification Notice issued by the Home Office Employer Checking
                                       Service to the employer or prospective employer, which indicates that the
                                       named person may stay</br> in the UK and is permitted to do the work in question
                                       </label>
                                    </div>
                                 </div>
                              </div>
                              <div class="clearfix" style="height: 10px;clear: both;"></div>
                              <div class="form-group">
                                 <div class="col-lg-10 col-lg-offset-2">
                                    <button class="btn btn-warning back2" type="button"><span class="fa fa-arrow-left"></span> Back</button> 
                                    <button class="btn btn-primary open2" type="button">Next <span class="fa fa-arrow-right"></span></button> 
                                 </div>
                              </div>
                              {{-- 
                           </fieldset>
                           --}}
                        </div>
                        <div id="sf3" class="frm" style="display: none;">
                           {{-- 
                           <fieldset>
                              --}}
                              <legend>Step 2 Check</legend>
                              <p>You must <b>check</b> that the documents are genuine and that the person presenting
                                 them is the prospective employee or employee, the rightful holder and allowed to
                                 do the type of work you are offering.
                              </p>
                              <div class="row form-group">
                                 <div class="col-lg-12">
                                    <label>1. Are photographs consistent across documents
                                    and with the person’s appearance?</label>&nbsp;&nbsp;
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="photographs" value="Yes" <?php if($work_rs->photographs=='Yes'){ echo 'checked';}?>>Yes
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input"  name="photographs" value="No"  <?php if($work_rs->photographs=='No'){ echo 'checked';}?>>No
                                       </label>
                                    </div>
                                    <div class="form-check-inline disabled">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="photographs" value="N/A"  <?php if($work_rs->photographs=='N/A'){ echo 'checked';}?>>N/A
                                       </label>
                                    </div>
                                 </div>
                                 <!---------------------->
                                 <div class="col-lg-12">
                                    <label>2. Are dates of birth correct and consistent
                                    across documents?</label>&nbsp;&nbsp;
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="dates" value="Yes"  <?php if($work_rs->dates=='Yes'){ echo 'checked';}?> >Yes
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="dates" value="No"  <?php if($work_rs->dates=='No'){ echo 'checked';}?> >No
                                       </label>
                                    </div>
                                    <div class="form-check-inline disabled">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="dates" value="N/A" <?php if($work_rs->dates=='N/A'){ echo 'checked';}?>>N/A
                                       </label>
                                    </div>
                                 </div>
                                 <!------------------------------>
                                 <div class="col-lg-12">
                                    <label>3. Are expiry dates for time-limited permission
                                    to be in the UK in the future i.e. they have not
                                    passed (if applicable)?</label>&nbsp;&nbsp;
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="expiry" value="Yes"  <?php if($work_rs->expiry=='Yes'){ echo 'checked';}?>>Yes
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="expiry" value="No" <?php if($work_rs->expiry=='No'){ echo 'checked';}?> >No
                                       </label>
                                    </div>
                                    <div class="form-check-inline disabled">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input"  name="expiry" value="N/A"  <?php if($work_rs->expiry=='N/A'){ echo 'checked';}?>>N/A
                                       </label>
                                    </div>
                                 </div>
                                 <!------------------------------->
                                 <div class="col-lg-12">
                                    <label>4. Have you checked work restrictions to determine
                                    if the person is able to work for you and do the
                                    type of work you are offering? (For students who
                                    have limited permission to work</br> during termtime, you must also obtain, copy and retain
                                    details of their academic term and vacation
                                    times covering the duration of their period of
                                    study in the UK </br> for which they will be employed.)</label><br>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="checked" value="Yes"  <?php if($work_rs->checked=='Yes'){ echo 'checked';}?> >Yes
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input"  name="checked" value="No" <?php if($work_rs->checked=='No'){ echo 'checked';}?> >No
                                       </label>
                                    </div>
                                    <div class="form-check-inline disabled">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input"  name="checked" value="N/A"   <?php if($work_rs->checked=='N/A'){ echo 'checked';}?>>N/A
                                       </label>
                                    </div>
                                 </div>
                                 <!------------------------------->
                                 <div class="col-lg-12">
                                    <label>5. Are you satisfied the document is genuine,
                                    has not been tampered with and belongs to
                                    the holder?</label>&nbsp;&nbsp;
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input"  name="satisfied" value="Yes"  <?php if($work_rs->satisfied=='Yes'){ echo 'checked';}?>>Yes
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input"  name="satisfied" value="No"    <?php if($work_rs->satisfied=='No'){ echo 'checked';}?>>No
                                       </label>
                                    </div>
                                    <div class="form-check-inline disabled">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="satisfied" value="N/A"     <?php if($work_rs->satisfied=='N/A'){ echo 'checked';}?>>N/A
                                       </label>
                                    </div>
                                 </div>
                                 <!------------------------------->
                                 <div class="col-lg-12">
                                    <label>6. Have you checked the reasons for any
                                    different names across documents (e.g.
                                    marriage certificate, divorce decree, deed
                                    poll)? (Supporting documents should also be
                                    photocopied</br>  and a copy retained.)</label>&nbsp;&nbsp;<br>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="reasons" value="Yes"   <?php if($work_rs->reasons=='Yes'){ echo 'checked';}?>>Yes
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input" name="reasons" value="No" <?php if($work_rs->reasons=='No'){ echo 'checked';}?>>No
                                       </label>
                                    </div>
                                    <div class="form-check-inline disabled">
                                       <label class="form-check-label">
                                       <input type="radio" class="form-check-input"  name="reasons" value="N/A" <?php if($work_rs->reasons=='N/A'){ echo 'checked';}?>>N/A
                                       </label>
                                    </div>
                                 </div>
                                 <!------------------------------->
                              </div>
                              <div class="clearfix" style="height: 10px;clear: both;"></div>
                              <div class="form-group">
                                 <div class="col-lg-10 col-lg-offset-2">
                                    <button class="btn btn-warning back3" type="button"><span class="fa fa-arrow-left"></span> Back</button> 
                                    <button class="btn btn-primary open3" type="button">Next </button> 
                                    <img src="spinner.gif" alt="" id="loader" style="display: none">
                                 </div>
                              </div>
                              {{-- 
                           </fieldset>
                           --}}
                        </div>
                        <?php 
                           $timearray=array();
                           $timearray=explode(',',$work_rs->passports); 
                        ?>
                        <div id="sf4" class="frm" style="display: none;">
                              {{-- 
                              <fieldset>
                                 --}}
                              <legend>Step 3 Copy</legend>
                              <p>You must make a clear copy of each document in a format which cannot later be
                                 altered, and retain the copy securely; electronically or in hardcopy. You must copy
                                 and retain:
                              </p>
                              <div class="row form-group">
                                 <div class="col-lg-12">
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input" name="passports[]" value="any page with the document"  <?php if(in_array("any page with the document", $timearray)){ echo 'checked';}?> >Passports: 
                                       any page with the document expiry date, nationality, date of birth,
                                       signature, leave expiry date, biometric details and photograph, and any page
                                       containing information</br> indicating the holder has an entitlement to enter or
                                       remain in the UK and undertake the work in question. 
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       <input type="checkbox" class="form-check-input" name="passports[]" value="All other documents" <?php if(in_array("All other documents", $timearray)){ echo 'checked';}?>>All other documents:
                                       the document in full, both sides of a biometric residence
                                       permit. You must also record and retain the date on which the check was made.
                                       </label>
                                    </div>
                                 </div>
                                 <!---------------------->
                              </div>
                              <?php 
                                 $timearray=array();
                                 $timearray=explode(',',$work_rs->type_of_excuse);
                                 
                                 ?>
                              <legend>Know the type of excuse you have</legend>
                              <p>If you have correctly carried out the above 3 steps you will have an excuse against
                                 liability for a civil penalty if the above named person is found working for you
                                 illegally. However, you need to be aware of the type of excuse you have as this
                                 determines how long it lasts for, and if, and when you are required to do a followup check.
                              </p>
                              <p>The documents that you have checked and copied are from:</p>
                              <div class="row form-group">
                                 <div class="col-lg-12">
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       List A   <input type="checkbox" style="margin-left: 17px" class="form-check-input" name="type_of_excuse[]" value="List A"  <?php if(in_array("List A", $timearray)){ echo 'checked';}?> >
                                       You have a continuous statutory excuse for the full duration of the
                                       person’s employment with you. You are not required to carry out any repeat right
                                       to work checks on this.
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       List B: Group 1   <input type="checkbox" style="margin-left: 17px" class="form-check-input" name="type_of_excuse[]" value="List B: Group 1"  <?php if(in_array("List B: Group 2", $timearray)){ echo 'checked';}?> >
                                       You have a time-limited statutory excuse which expires when
                                       the person’s permission to be in the UK expires. You should carry out a follow-up
                                       check when the </br>document evidencing their permission to work expires.
                                       </label>
                                    </div>
                                    <div class="form-check-inline">
                                       <label class="form-check-label">
                                       List B: Group 2   <input type="checkbox"  style="margin-left: 17px" class="form-check-input" name="type_of_excuse[]" value="List B: Group 2"  <?php if(in_array("List B: Group 2", $timearray)){ echo 'checked';}?> >
                                       You have a time-limited statutory excuse which expires six
                                       months from the date specified in your Positive Verification Notice. This means that
                                       you should carry </br>out a follow-up check when this notice expires.
                                       </label>
                                    </div>
                                 </div>
                                 <!---------------------->
                              </div>
                              <div class="row form-group">
                                 <div class="col-md-12">
                                    <table class="text-left table table-striped">
                                       <thead>
                                          <tr>
                                             <th>Know the type of excuse you have</th>
                                             <th>Date followup required</th>
                                          </tr>
                                       </thead>
                                       <tbody>
                                          <input type="hidden" class="form-control" name="list_right" value="{{ $work_rs->list_right }}">
                                          <input type="hidden" class="form-control" name="list_right_follow" value="{{ $work_rs->list_right_follow }}">
                                          <input type="hidden" class="form-control" name="list_right_date"  value="@if($work_rs->list_right_date!='1970-01-01'){{ $work_rs->list_right_date }}@endif">
                                          <tr>
                                             <td>List B: (Group 1)</td>
                                             <input type="hidden" class="form-control" name="list_rightb" value="{{ $work_rs->list_rightb }}">
                                             <input type="hidden" class="form-control" name="list_rightb_follow" value="{{ $work_rs->list_rightb_follow }}">
                                             <td><input type="date" class="form-control" id="list_rightb_date" name="list_rightb_date" value="@if($work_rs->list_rightb_date!='1970-01-01'){{ $work_rs->list_rightb_date }}@endif"></td>
                                          </tr>
                                          <input type="hidden" class="form-control" name="list_rightti" value="{{ $work_rs->list_rightti }}">
                                          <input type="hidden" class="form-control" name="list_rightti_follow" value="{{ $work_rs->list_rightti_follow }}">
                                          <input type="hidden" class="form-control" name="list_rightti_date" value="@if($work_rs->list_rightti_date!='1970-01-01'){{ $work_rs->list_rightti_date }}@endif">
                                          <tr>
                                             <td>List B: (Group 2)</td>
                                             <input type="hidden" class="form-control" name="list_rightbs" value="{{ $work_rs->list_rightbs }}">
                                             <input type="hidden" class="form-control" name="list_rightbs_follow" value="{{ $work_rs->list_rightbs_follow }}">
                                             <td><input type="date" class="form-control" name="list_rightbs_date" value="@if($work_rs->list_rightbs_date!='1970-01-01'){{ $work_rs->list_rightbs_date }}@endif"></td>
                                          </tr>
                                          <tr>
                                             <td>EUSS </td>
                                             <input type="hidden" class="form-control" name="list_eusss"  value="{{ $work_rs->list_eusss }}">
                                             <input type="hidden" class="form-control" name="list_euss_follow"  value="{{ $work_rs->list_euss_follow }}">
                                             <td><input type="date" class="form-control" name="list_euss_date" id="list_euss_date" value="@if($work_rs->list_euss_date!='1970-01-01'){{ $work_rs->list_euss_date }}@endif"></td>
                                          </tr>
                                       </tbody>
                                    </table>
                                 </div>
                              </div>
                              <div class="row form-group">
                                 <div class="col-lg-12">
                                    <label>Select Document</label>
                                    <select class="form-control"  id="scan_f" name="scan_f"  onchange="checkscsnf(this.value);">
                                       <option value="">Select</option>
                                       <?php
                                          foreach($employee_rs as $bank)
                                          {
                                           if($work_rs->scan_f==$bank->quli.' Transcript Document'){
                                               $se= 'selected';
                                               }else{
                                                   $se='';
                                               }
                                           if($bank->doc!=''){
                                           echo '<option value="'.$bank->quli.' Transcript Document" '.$se.'>'.$bank->quli.' Transcript Document</option>';
                                           
                                           }
                                           if($work_rs->scan_f==$bank->quli.' Certificate Document'){
                                               $se= 'selected';
                                               }else{
                                                   $se='';
                                               }
                                            if($bank->doc2!=''){
                                           echo '<option value="'.$bank->quli.' Certificate Document"  '.$se.'>'.$bank->quli.' Certificate Document</option>';
                                           
                                           }
                                          }
                                          foreach($employee_otherd_doc_rs as $banknew)
                                          {
                                           if($work_rs->scan_f==$banknew->doc_name){
                                               $se= 'selected';
                                               }else{
                                                   $se='';
                                               }
                                          if($banknew->doc_name!=''){
                                          echo '<option value="'.$banknew->doc_name.'"  '.$se.'>'.$banknew->doc_name.'</option>';
                                           
                                          }
                                          
                                          }
                                          if($work_rs->scan_f=='pr_add_proof'){
                                               $se= 'selected';
                                               }else{
                                                   $se='';
                                               }
                                          if($desig_rs->pr_add_proof!=''){
                                             echo '<option value="pr_add_proof" '.$se.'>Proof Of Correspondence   Address </option>'; 
                                             
                                          }
                                          if($work_rs->scan_f=='pass_docu'){
                                               $se= 'selected';
                                               }else{
                                                   $se='';
                                               }
                                          if($desig_rs->pass_docu!=''){
                                           echo '<option value="pass_docu" '.$se.'>Passport    Document </option>'; 
                                             
                                          }
                                           if($work_rs->scan_f=='visa_upload_doc'){
                                               $se= 'selected';
                                               }else{
                                                   $se='';
                                               }
                                          if($desig_rs->visa_upload_doc!=''){
                                             echo '<option value="visa_upload_doc" '.$se.'>Visa    Document </option>'; 
                                             
                                          }
                                          if($work_rs->scan_f=='euss_upload_doc'){
                                               $se= 'selected';
                                               }else{
                                                   $se='';
                                               }
                                          
                                          if($desig_rs->euss_upload_doc!=''){
                                             echo '<option value="euss_upload_doc" '.$se.'>EUSS    Document </option>'; 
                                             
                                          }
                                          if($work_rs->scan_f=='nat_upload_doc'){
                                               $se= 'selected';
                                               }else{
                                                   $se='';
                                               }
                                          
                                          if($desig_rs->nat_upload_doc!=''){
                                             echo '<option value="nat_upload_doc" '.$se.'>National Id     Document </option>'; 
                                             
                                          }
                                          ?>
                                    </select>
                                    <input type="hidden" id="scan_f_img" name="scan_f_img" value="{{$work_rs->scan_f_img}}">
                                    <div class="text-center rtw-scan">
                                       <div class="scan-hd">
                                          <h3>RTW Evidence Scans-1</h3>
                                          <p>Please copy and paste an image of your scanned RTW documents into the grey form field below.</p>
                                       </div>
                                       <div class="scan-body" style="text-align:center;background: #edecec;">
                                          <!--<embed src="" frameborder="0" width="100%" height="700px" id="imgeid">-->
                                          <?php
                                             $secod=array();
                                             if($work_rs->scan_f=='visa_upload_doc'){
                                                
                                                  $secod=explode(",",$work_rs->scan_f_img);
                                                 
                                             ?>
                                          <img name="imgeid" id="imgeid"   width="50%"  @if($work_rs->scan_f_img!='')  src="<?=env("BASE_URL");?>public/{{$secod[0]}}"  @endif  >
                                          <?php
                                             }else{
                                                ?>
                                          <img name="imgeid" id="imgeid"   width="50%"  @if($work_rs->scan_f_img!='')  src="<?=env("BASE_URL");?>public/{{$work_rs->scan_f_img}}"  @endif  >
                                          <?php
                                             }
                                              
                                             ?>
                                          <div id="scan_ne_id"  @if($work_rs->scan_f_img!='' && $work_rs->scan_f=='visa_upload_doc' &&  isset($secod[1]) &&  $secod[1]!='')  style="display:block;margin-top:20px;" @else style="display:none;margin-top:20px;" @endif  >
                                          <img name="imgeidnew" id="imgeidnew"   width="50%"  @if($work_rs->scan_f_img!='' && $work_rs->scan_f=='visa_upload_doc' &&  isset($secod[1]) &&  $secod[1]!='')  src="<?=env("BASE_URL");?>public/{{$secod[1]}}" @else  @endif >
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              </div>
                              <div class="row form-group">
                                 <div class="col-lg-12">
                                    <h4>Select Documents</h4>
                                    <select class="form-control"  id="scan_s" name="scan_s" onchange="checkscsns(this.value);" >
                                       <option value="">Select</option>
                                       <?php
                                          foreach($employee_rs as $bank)
                                          {
                                          if($work_rs->scan_s==$bank->quli.' Transcript Document'){
                                             $se= 'selected';
                                             }else{
                                                   $se='';
                                             }
                                          if($bank->doc!=''){
                                          echo '<option value="'.$bank->quli.' Transcript Document" '.$se.'>'.$bank->quli.' Transcript Document</option>';
                                          
                                          }
                                          if($work_rs->scan_s==$bank->quli.' Certificate Document'){
                                             $se= 'selected';
                                             }else{
                                                   $se='';
                                             }
                                          if($bank->doc2!=''){
                                          echo '<option value="'.$bank->quli.' Certificate Document"  '.$se.'>'.$bank->quli.' Certificate Document</option>';
                                          
                                          }
                                          }
                                          foreach($employee_otherd_doc_rs as $banknew)
                                          {
                                          if($work_rs->scan_s==$banknew->doc_name){
                                             $se= 'selected';
                                             }else{
                                                   $se='';
                                             }
                                          if($banknew->doc_name!=''){
                                          echo '<option value="'.$banknew->doc_name.'"  '.$se.'>'.$banknew->doc_name.'</option>';
                                          
                                          }
                                          
                                          }
                                          if($work_rs->scan_s=='pr_add_proof'){
                                             $se= 'selected';
                                             }else{
                                                   $se='';
                                             }
                                          if($desig_rs->pr_add_proof!=''){
                                             echo '<option value="pr_add_proof" '.$se.'>Proof Of Correspondence   Address </option>'; 
                                             
                                          }
                                          if($work_rs->scan_s=='pass_docu'){
                                             $se= 'selected';
                                             }else{
                                                   $se='';
                                             }
                                          if($desig_rs->pass_docu!=''){
                                          echo '<option value="pass_docu" '.$se.'>Passport    Document </option>'; 
                                             
                                          }
                                          if($work_rs->scan_s=='visa_upload_doc'){
                                             $se= 'selected';
                                             }else{
                                                   $se='';
                                             }
                                          if($desig_rs->visa_upload_doc!=''){
                                             echo '<option value="visa_upload_doc" '.$se.'>Visa    Document </option>'; 
                                             
                                          }
                                          if($work_rs->scan_s=='euss_upload_doc'){
                                             $se= 'selected';
                                             }else{
                                                   $se='';
                                             }
                                          
                                          if($desig_rs->euss_upload_doc!=''){
                                             echo '<option value="euss_upload_doc" '.$se.'>EUSS    Document </option>'; 
                                             
                                          }
                                          if($work_rs->scan_s=='nat_upload_doc'){
                                             $se= 'selected';
                                             }else{
                                                   $se='';
                                             }
                                          
                                          if($desig_rs->nat_upload_doc!=''){
                                             echo '<option value="nat_upload_doc" '.$se.'>National Id     Document </option>'; 
                                             
                                          }
                                       ?>
                                    </select>
                                    <input type="hidden" id="newid" name="newid" value="{{$work_rs->id}}">
                                    <input type="hidden" id="scan_s_img" name="scan_s_img" value="{{$work_rs->scan_s_img}}">
                                    <div class="text-center rtw-scan">
                                       <div class="scan-hd">
                                          <h3>RTW Evidence Scans-2 (If applicable)</h3>
                                          <p>Please copy and paste an image of your scanned RTW documents into the blue form field below.</p>
                                       </div>
                                       <div class="scan-body" style="background: #e0f6ff;">
                                          <?php
                                             $secod=array();
                                             if($work_rs->scan_s=='visa_upload_doc'){
                                                
                                                $secod=explode(",",$work_rs->scan_s_img);
                                             ?>
                                          <img name="imgeids" id="imgeids"   width="50%"  @if($work_rs->scan_s_img!='')  src="<?=env("BASE_URL");?>public/{{$secod[0]}}"  @endif  >
                                          <?php
                                             }else{
                                                ?>
                                          <img name="imgeids" id="imgeids"   width="50%"  @if($work_rs->scan_s_img!='')  src="<?=env("BASE_URL");?>public/{{$work_rs->scan_s_img}}"  @endif  >
                                          <?php
                                             }
                                             ?>
                                          <div id="scan_nse_id"   @if($work_rs->scan_s_img!='' && $work_rs->scan_s=='visa_upload_doc' &&  isset($secod[1]) &&  $secod[1]!='')   style="display:block;margin-top:20px;" @else style="display:none;margin-top:20px;" @endif   >
                                          <img name="imgeidsnew" id="imgeidsnew"   width="50%"  @if($work_rs->scan_s_img!='' && $work_rs->scan_s=='visa_upload_doc' &&  isset($secod[1]) &&  $secod[1]!='')  src="<?=env("BASE_URL");?>public/{{$secod[1]}}"  @else  @endif >
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row form-group">
                                 <div class="col-lg-12">
                                    <h4>Select Documents</h4>
                                    <select class="form-control"  id="scan_r" name="scan_r" onchange="checkscsnr(this.value);">
                                       <option value="">Select</option>
                                          <?php
                                             foreach($employee_rs as $bank)
                                             {
                                             if($work_rs->scan_r==$bank->quli.' Transcript Document'){
                                                $se= 'selected';
                                                }else{
                                                      $se='';
                                                }
                                             if($bank->doc!=''){
                                             echo '<option value="'.$bank->quli.' Transcript Document" '.$se.'>'.$bank->quli.' Transcript Document</option>';
                                             
                                             }
                                             if($work_rs->scan_r==$bank->quli.' Certificate Document'){
                                                $se= 'selected';
                                                }else{
                                                      $se='';
                                                }
                                             if($bank->doc2!=''){
                                             echo '<option value="'.$bank->quli.' Certificate Document"  '.$se.'>'.$bank->quli.' Certificate Document</option>';
                                             
                                             }
                                             }
                                             foreach($employee_otherd_doc_rs as $banknew)
                                             {
                                             if($work_rs->scan_r==$banknew->doc_name){
                                                $se= 'selected';
                                                }else{
                                                      $se='';
                                                }
                                             if($banknew->doc_name!=''){
                                             echo '<option value="'.$banknew->doc_name.'"  '.$se.'>'.$banknew->doc_name.'</option>';
                                             
                                             }
                                             
                                             }
                                             if($work_rs->scan_r=='pr_add_proof'){
                                                $se= 'selected';
                                                }else{
                                                      $se='';
                                                }
                                             if($desig_rs->pr_add_proof!=''){
                                                echo '<option value="pr_add_proof" '.$se.'>Proof Of Correspondence   Address </option>'; 
                                                
                                             }
                                             if($work_rs->scan_r=='pass_docu'){
                                                $se= 'selected';
                                                }else{
                                                      $se='';
                                                }
                                             
                                             
                                             if($desig_rs->pass_docu!=''){
                                             echo '<option value="pass_docu" '.$se.'>Passport    Document </option>'; 
                                                
                                             }
                                             if($work_rs->scan_r=='visa_upload_doc'){
                                                $se= 'selected';
                                                }else{
                                                      $se='';
                                                }
                                             if($desig_rs->visa_upload_doc!=''){
                                                echo '<option value="visa_upload_doc" '.$se.'>Visa    Document </option>'; 
                                                
                                             }
                                             if($work_rs->scan_r=='euss_upload_doc'){
                                                $se= 'selected';
                                                }else{
                                                      $se='';
                                                }
                                             
                                             if($desig_rs->euss_upload_doc!=''){
                                                echo '<option value="euss_upload_doc" '.$se.'>EUSS    Document </option>'; 
                                                
                                             }
                                             if($work_rs->scan_r=='nat_upload_doc'){
                                                $se= 'selected';
                                                }else{
                                                      $se='';
                                                }
                                             
                                             if($desig_rs->nat_upload_doc!=''){
                                                echo '<option value="nat_upload_doc" '.$se.'>National Id     Document </option>'; 
                                                
                                             }
                                          ?>
                                    </select>
                                    <input type="hidden" id="scan_r_img" name="scan_r_img"  value="{{$work_rs->scan_r_img}}">
                                    <div class="text-center rtw-scan">
                                       <div class="scan-hd">
                                          <h3>RTW Report</h3>
                                          <p>Please copy and paste a clear copy/image of RTW check result in the orange form below.</p>
                                       </div>
                                       <div class="scan-body" style="background: #ffedcb;">
                                             <?php
                                                $secod=array();
                                                if($work_rs->scan_r=='visa_upload_doc'){
                                                   
                                                   $secod=explode(",",$work_rs->scan_r_img);
                                                ?>
                                             <img name="imgeidsj" id="imgeidsj"   width="50%"  @if($work_rs->scan_r_img!='')  src="<?=env("BASE_URL");?>public/{{$secod[0]}}"  @endif  >
                                             <?php
                                                }else{
                                                   ?>
                                             <img name="imgeidsj" id="imgeidsj"   width="50%"  @if($work_rs->scan_r_img!='')  src="<?=env("BASE_URL");?>public/{{$work_rs->scan_r_img}}"  @endif  >
                                             <?php
                                                }
                                                ?>
                                          <div id="scan_nrse_id"   @if($work_rs->scan_r_img!='' && $work_rs->scan_r=='visa_upload_doc' &&  isset($secod[1]) &&  $secod[1]!='')   style="display:block; margin-top:20px;" @else style="display:none; margin-top:20px;" @endif    >
                                             <img name="imgeidsjnew" id="imgeidsjnew"   width="50%"  @if($work_rs->scan_r_img!='' && $work_rs->scan_r=='visa_upload_doc' &&  isset($secod[1]) &&  $secod[1]!='')  src="<?=env("BASE_URL");?>public/{{$secod[1]}}"  @else  @endif >
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <div class="row form-group">
                                 <div class="col-md-6">
                                    <label>RTW check result</label>
                                    <!-- <textarea rows="5" class="form-control" placeholder="Positive/Negative Verification" style="resize: none;"  name="result">{{ $work_rs->result }}</textarea> -->
                                    <select class="form-control"  id="result" name="result" >
                                    <option value=""></option>
                                    <option value="Positive" @if($work_rs->result=='Positive') selected @endif>Positive</option>
                                    <option value="Negative" @if($work_rs->result=='Negative') selected @endif>Negative</option>
                                    </select>
                                 </div>
                                 <div class="col-md-6">
                                    <label>Remarks</label>
                                    <textarea rows="5" class="form-control" placeholder="Example: No dentist/sports job, No recourse to public fund. Maximum 20
                                       hours weekly" style="resize: none;"  name="remarks">{{ $work_rs->remarks }}</textarea>
                                 </div>
                              </div>
                              <div class="row form-group">
                                 <div class="col-md-6">
                                    <label>Checker Name</label>
                                    <input type="text" class="form-control" name="checker" value="{{ $work_rs->checker }}">
                                 </div>
                                 <div class="col-md-6">
                                    <label>Contact No.</label>
                                    <input type="text" class="form-control" name="contact" id="contact" value="{{ $work_rs->contact }}">
                                 </div>
                              </div>
                              <div class="row form-group">
                                 <div class="col-md-6">
                                    <label>Designation</label>
                                    <input type="text" class="form-control" name="designation" id="designation"  value="{{ $work_rs->designation }}" >
                                 </div>	
                                    <input type="hidden" class="form-control" name="emp_id" id="emp_id"  value="{{ $work_rs->emp_id }}" >
                                 <div class="col-md-6">
                                    <label>Email Address</label>
                                    <input type="email" class="form-control" name="email" id="email"  value="{{ $work_rs->email }}" >
                                 </div>
                              </div>
                              <div class="clearfix" style="height: 10px;clear: both;"></div>
                              <div class="form-group">
                                 <div class="col-lg-10 col-lg-offset-2">
                                    <button class="btn btn-warning back4" type="button"><span class="fa fa-arrow-left"></span> Back</button> 
                                    <button class="btn btn-primary open4" type="submit">Submit </button> 
                                 </div>
                              </div>
                              {{-- </fieldset> --}}
                        </div>
                        {{-- @endif --}}
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>         
@endsection
@section('script')
<script>
//    document.addEventListener("DOMContentLoaded", function() {
//     var checkbox = document.getElementById("share_code_checkbox");
//     var formDiv = document.getElementById("sf5");

//     checkbox.addEventListener("change", function() {
//         if (checkbox.checked) {
//             formDiv.style.display = "block"; // Show the form when checked
//         } else {
//             formDiv.style.display = "none"; // Hide the form when unchecked
//         }
//     });
// });
   document.addEventListener("DOMContentLoaded", function () {
    const shareCodeCheckbox = document.getElementById("share_code_checkbox");
    const evidenceSelect = document.getElementById("evidence");
    const comon = document.getElementsByClassName("comon");

    // Store the original select box options
    const originalOptions = evidenceSelect.innerHTML;

    shareCodeCheckbox.addEventListener("change", function () {
        if (this.checked) {
            // Add the "Share code" option only if it's not already present
            if (!document.getElementById("evidence2")) {
                evidenceSelect.innerHTML = `
                    <option value="">Select</option>
                    <option value="share_code">Share code</option>
                `;
                evidenceSelect.id = "evidence2"; 
            }
        } else {
            // Restore the original options and ID
            evidenceSelect.innerHTML = originalOptions;
            evidenceSelect.id = "evidence"; 
        }
    });
});
</script>
<script>
   $(document).ready(function () {
       $(document).on('click', '.add-file', function () {
           var fileInputHtml = `
               <div class="input-group mb-2 file-input-row">
                   <input type="file" class="form-control" name="share_doc[]" required>
                   <button type="button" class="btn btn-danger remove-file">-</button>
               </div>`;
           $('#file-upload-area').append(fileInputHtml);
       });

       $(document).on('click', '.remove-file', function () {
           $(this).closest('.file-input-row').remove();
       });
   });
</script>
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
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.2/jquery.validate.min.js"></script>
<script type="text/javascript">
   jQuery().ready(function() {
    // Validate form on keyup and submit
    var v = jQuery("#basicform").validate({
        rules: {
            email: {
                required: true,
                email: true,
            },
            phone: {
                required: true,
            },
            method: {
                required: true,
            },
            city: {
                required: true,
            },
            country: {
                required: true,
            },
            postcode: {
                required: true,
            },
            ca1: {
                required: true,
            }
        },
        errorElement: "span",
        errorClass: "help-inline-error",
    });

    // Function to check if 'Share Code' is checked and show step 5
    function checkShareCode() {
        if ($("#share_code_checkbox").is(":checked")) {
            $(".frm").hide("fast");
            $("#sf5").show("slow");
            return false;  // Stop further execution of click event
        }
        return true; // Continue to the next step normally
    }

   $("#initialCheck").change(function(){
      if ($(this).is(":checked")) {
         $("#followUpCheck").prop("checked", false);
      }
   });

   $("#followUpCheck").change(function(){
      if ($(this).is(":checked")) {
         $("#initialCheck").prop("checked", false);
      }
   });

    // When '.comon' checkbox is selected, uncheck the #share_code_checkbox
    $(".comon").change(function() {
        if ($(this).is(":checked")) {
            $("#share_code_checkbox").prop("checked", false);
        }
    });

    // When #share_code_checkbox is selected, uncheck all .comon checkboxes
    $("#share_code_checkbox").change(function() {
        if ($(this).is(":checked")) {
            $(".comon").prop("checked", false);
        }
    });

    // Binding next button on first step
    $(".open1").click(function() {
        if (v.form()) {
            if (checkShareCode()) {
                $(".frm").hide("fast");
                $("#sf2").show("slow");
            }
        }
    });

    $(".open2").click(function() {
        if (v.form()) {
            if (checkShareCode()) {
                $(".frm").hide("fast");
                $("#sf3").show("slow");
            }
        }
    });

    $(".open3").click(function() {
        if (v.form()) {
            if (checkShareCode()) {
                $(".frm").hide("fast");
                $("#sf4").show("slow");
            }
        }
    });

    $(".open4").click(function() {
        if (v.form()) {
            checkShareCode();
        }
    });

    // Back buttons to navigate to previous steps
    $(".back2").click(function() {
        $(".frm").hide("fast");
        $("#sf1").show("slow");
    });

    $(".back3").click(function() {
        $(".frm").hide("fast");
        $("#sf2").show("slow");
    });

    $(".back4").click(function() {
        $(".frm").hide("fast");
        $("#sf3").show("slow");
    });

    // Add back button event to return to the first step (sf1)
    $(".back-to-start").click(function() {
        $(".frm").hide("fast");
        $("#sf1").show("slow");
    });
});

   // jQuery().ready(function() {
   //   // validate form on keyup and submit
   //     var v = jQuery("#basicform").validate({
   //       rules: {
           
   //         email: {
   //           required: true,
             
   //           email: true,
             
   //         },
   //         phone: {
   //           required: true,
             
   //         },
   //         method: {
   //           required: true,
             
   //         },
   //  city: {
   //           required: true,
             
   //         },
   //          country: {
   //           required: true,
             
   //         },
   //          postcode: {
   //           required: true,
             
   //         },
   // ca1: {
   //           required: true,
             
   //         }
   //       },
   //       errorElement: "span",
   //       errorClass: "help-inline-error",
   //     });
   
   //   // Binding next button on first step
   //   $(".open1").click(function() {
   //       if (v.form()) {
   //         $(".frm").hide("fast");
   //         $("#sf2").show("slow");
   //       }
   //     });
   
   //      $(".open2").click(function() {
   //      if (v.form()) {
   //      $(".frm").hide("fast");
   //     $("#sf3").show("slow");
   //      }
   //     });
   //       $(".open3").click(function() {
   //      if (v.form()) {
   //      $(".frm").hide("fast");
   //     $("#sf4").show("slow");
   //      }
   //     });
       
   //     $(".open4").click(function() {
       
   //     });
       
   //     $(".back2").click(function() {
   //       $(".frm").hide("fast");
   //       $("#sf1").show("slow");
   //     });
   
   //     $(".back3").click(function() {
   //       $(".frm").hide("fast");
   //       $("#sf2").show("slow");
   //     });
   
   //     $(".back4").click(function() {
   //       $(".frm").hide("fast");
   //       $("#sf3").show("slow");
   //     });
   
   //   });
         function checkemp(val){
           var empid=val;
           
                      $.ajax({
           type:'GET',
           url:'{{url('pis/getEmployeetaxempByIdnewemployee')}}/'+empid,
           cache: false,
           success: function(response){
           
                var obj = jQuery.parseJSON(response);
                   console.log(obj[0]);
                 var emp_code=obj[0].emp_code;
            
                     $("#emp_id").val(emp_code);
                   
                       $("#emp_id").attr("readonly", true);
               
                   
                        if(obj[0].emp_doj!='1970-01-01'){
                        $("#start_date").val(obj[0].emp_doj);
                        }
                        $("#start_date").attr("readonly", true);
                         if(obj[0].euss_review_date!='1970-01-01'){
                        $("#list_euss_date").val(obj[0].euss_review_date);
                        } 
                         
                         
                
           }
           });
                $.ajax({
           type:'GET',
           url:'<?=env("BASE_URL");?>pis/getEmployeedreportfileById/'+empid,
           cache: false,
           success: function(response){
               
           
               document.getElementById("scan_f").innerHTML = response;
                   document.getElementById("scan_s").innerHTML = response;
                       document.getElementById("scan_r").innerHTML = response;
           }
           });
       }
       
       
       function checkscsnf(val){
       
       var emp_id=$("#emp_id").val();
           $.ajax({
           type:'GET',
           url:'{{url('pis/getEmployeedreportfileByInewscand')}}/'+emp_id+'/'+val,
           cache: false,
           success: function(response){
                if(val=='visa_upload_doc'){
                   var nameArr = response.split(',');
                   var gg="<?=env("BASE_URL");?>public/"+nameArr[0];
          
         
           $("#imgeid").attr("src",gg);
           if(nameArr[1]!='' && nameArr[1]!=undefined){
                var ggn="<?=env("BASE_URL");?>public/"+nameArr[1];
          
         
           $("#imgeidnew").attr("src",ggn);
            $("#scan_ne_id").show();
               
           }
                }else{
                    var gg="<?=env("BASE_URL");?>public/"+response;
       
         
           $("#imgeid").attr("src",gg);
                }
               
               
           $("#scan_f_img").val(response);  	   
           }
           });
       
   }
   function checkscsns(val){
       
       var emp_id=$("#emp_id").val();
           $.ajax({
           type:'GET',
           url:'{{url('pis/getEmployeedreportfileByInewscand')}}/'+emp_id+'/'+val,
           cache: false,
           success: function(response){
               
                if(val=='visa_upload_doc'){
                   var nameArr = response.split(',');
                   var gg="<?=env("BASE_URL");?>public/"+nameArr[0];
          
         
           $("#imgeids").attr("src",gg);
           if(nameArr[1]!='' && nameArr[1]!=undefined){
                var ggn="<?=env("BASE_URL");?>public/"+nameArr[1];
          
         
           $("#imgeidsnew").attr("src",ggn);
            $("#scan_nse_id").show();
               
           }
                }else{
                    var gg="<?=env("BASE_URL");?>public/"+response;
       
         
           $("#imgeids").attr("src",gg);
                }
               
               
              
         
          
                   $("#scan_s_img").val(response);  
           }
           });
       
   }
   function checkscsnr(val){
       
       var emp_id=$("#emp_id").val();
           $.ajax({
           type:'GET',
           url:'{{url('pis/getEmployeedreportfileByInewscand')}}/'+emp_id+'/'+val,
           cache: false,
           success: function(response){
              if(val=='visa_upload_doc'){
                   var nameArr = response.split(',');
                   var gg="<?=env("BASE_URL");?>public/"+nameArr[0];
          
         
           $("#imgeidsj").attr("src",gg);
           if(nameArr[1]!='' && nameArr[1]!=undefined){
                var ggn="<?=env("BASE_URL");?>public/"+nameArr[1];
          
         
           $("#imgeidsjnew").attr("src",ggn);
            $("#scan_nrse_id").show();
               
           }
                }else{
                    var gg="<?=env("BASE_URL");?>public/"+response;
       
         
           $("#imgeidsj").attr("src",gg);
                }
         
          
             $("#scan_r_img").val(response);
           
                  
           }
           });
       
   }
</script>
@endsection