<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<link rel="icon" href="{{ asset('img/favicon.png')}}" type="image/x-icon"/>
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />

	<script src="{{ asset('employeeassets/js/plugin/webfont/webfont.min.js')}}"></script>
	<script>
		WebFont.load({
			google: {"families":["Lato:300,400,700,900"]},
			custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['{{ asset('employeeassets/css/fonts.min.css')}}']},
			active: function() {
				sessionStorage.fonts = true;
			}
		});
	</script>

	<!-- CSS Files -->
		<link rel="stylesheet" href="{{ asset('employeeassets/css/bootstrap.min.css')}}">
	<link rel="stylesheet" href="{{ asset('employeeassets/css/atlantis.min.css')}}">
<link rel="stylesheet" href="{{ asset('assets/css/calander.css')}}">
	<!-- CSS Just for demo purpose, don't include it in your project -->
	<link rel="stylesheet" href="{{ asset('employeeassets/css/demo.css')}}">
	<link rel="stylesheet" href="{{ asset('employeeassets/css/datepicker.css')}}">
<style>
table .form-control{height: 35px !important;}</style>
</head>
<body>
	<div class="wrapper">
		
  @include('dashboard.include.header')
		<!-- Sidebar -->
		
		 
		  <?php 
   function my_simple_crypt( $string, $action = 'encrypt' ) {
    // you may change these values to your own
    $secret_key = 'bopt_saltlake_kolkata_secret_key';
    $secret_iv = 'bopt_saltlake_kolkata_secret_iv';
 
    $output = false;
    $encrypt_method = "AES-256-CBC";
    $key = hash( 'sha256', $secret_key );
    $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );
 
    if( $action == 'encrypt' ) {
        $output = base64_encode( openssl_encrypt( $string, $encrypt_method, $key, 0, $iv ) );
    }
    else if( $action == 'decrypt' ){
        $output = openssl_decrypt( base64_decode( $string ), $encrypt_method, $key, 0, $iv );
    }
 
    return $output;
}
?>
		<!-- End Sidebar -->
		<div class="main-panel" style="width:100%">
			<div class="content">
				<div class="page-inner">
					<div class="page-header">
						<h4 class="page-title">Right to Work checks</h4>
						<ul class="breadcrumbs">
							<li class="nav-home">
								<a href="#">
									<i class="flaticon-home"></i>
								</a>
							</li>
							<li class="separator">
								<i class="flaticon-right-arrow"></i>
							</li>
							<li class="nav-item">
								<a href="{{ url('dashboard-right-works') }}">Right to Work checks List
</a>
							</li>
							
						</ul>
					</div>
				
				
					<div class="row">
						<div class="col-md-12">
							<div class="card">
								<div class="card-header">
									<h4 class="card-title">Right to Work Checklist (RTW)</h4>
								</div>
								<div class="card-body">
									<form name="basicform" id="basicform" method="post" action="{{ url('add-right-works') }}" >
									       <input type="hidden" name="_token" value="{{ csrf_token() }}"> 
        
        <div id="sf1" class="frm">
          <fieldset>
            <!-- <legend>Your Details</legend> -->

            <div class="row form-group">
       <div class="col-md-6">
       	<label>Name of Person</label>
		  <input type="hidden" class="form-control" id="employee_id" placeholder="" name="employee_id" required value="{{$employee_id}}" readonly>
     
        <select class="form-control"  id="employee_idnew" name="employee_idnew" required  disabled >
          <option value="">Applicant /Employee Name</option>
        @foreach($employee_rs as $employee)
                     <option value="{{$employee->emp_code}}"  @if($employee_id==$employee->emp_code) selected @endif>{{ $employee->emp_fname." ".$employee->emp_mname." ".$employee->emp_lname }} ({{$employee->emp_code}})</option>
                       @endforeach
        </select>
      </div>
      <div class="col-md-6">
      	<label>Date of Check</label>
        <input type="date" class="form-control" id="date" placeholder="" name="date" required value="{{$vis_due}}" readonly>
     
	 </div>
     
    </div>
    <div class="row form-group">
      <div class="col-md-12">
      	<label>Type of check</label><br>
     <div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="type[]" value="Initial check for new employee/applicant - required before employment" checked>Initial check before employment
  </label>
</div>
<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="type[]" value="Follow-up check on an existing employee - required before permission to work    expires (under List B - Group 1 or 2)" >Follow-up check on an employee
  </label>
</div>
      </div>
  </div>

  
  <div class="row form-group">
      <div class="col-md-12">
      	<label>Medium of check</label><br>
     <div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="mediumgg[]" value="In-person manual check with original documents" checked>In-person manual check with original documents</label>
</div>
<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="mediumgg[]" value="Online right to work check">Online right to work check</label>
</div>
      </div>
  </div>
  <div class="row form-group">
      <div class="col-md-4">
      	<label>Evidence presented</label><br>

     <select class="form-control" placeholder="" id="evidence" name="evidence"> <option value="">Select</option></select>
      </div>
      <div class="col-md-4">
      	<label>Work start time</label><br>
     <input type="date" class="form-control" placeholder="" name="start_date" id="start_date" value="{{$start_date}}" readonly>
      </div>
      <div class="col-md-4">
      	<label>Time of check</label><br>
     <input type="text" class="form-control" placeholder="" name="start_time">
      </div>
  </div>
      
            <div class="clearfix" style="height: 10px;clear: both;"></div>


            <div class="form-group" style="margin-top: 30px">
              <div class="col-lg-10 col-lg-offset-2">
                <button class="btn btn-primary open1" type="button">Next <span class="fa fa-arrow-right"></span></button> 
              </div>
            </div>

          </fieldset>
        </div>

        <div id="sf2" class="frm" style="display: none;">
              <p>You may conduct a physical document check or perform an online check to establish
a right to work. Where a right to work check has been conducted using the online
service, the information is provided in real-time, directly from Home Office systems
and there is no requirement to see the documents listed below.</p>
          <fieldset>
            
            <legend style="color: #00b1ff;font-size: 20px;">Step1 for physical check</legend>
            <p>You must <b>obtain original</b> documents from either <b>List A</b> or <b>List B</b> of acceptable documents for a manual right to work check.</p>

           <h3 style="background: #82b8fd;color: #fff;padding: 5px 20px;">List A</h3>
            <div class="row form-group">
    <div class="col-md-12">
    	<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="list_ap[]" value="A passport" checked>A passport <b>(current or expired)</b> showing the holder, or a person named in the
passport as the child of the holder, is a British citizen or a citizen of the UK and</br>
Colonies having the right of abode in the UK.
  </label>
</div>

<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="list_ap[]" value="A passport or national">A passport or passport card <b>(current or expired)</b> showing that the holder is a
national of the Republic of Ireland.
  </label>
</div>

<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input"  name="list_ap[]"  value="A Registration Certificate">
   A current document issued by the Home Office to a family member of an EEA
or Swiss citizen, and which indicates that the holder is permitted to stay in the</br>
United Kingdom indefinitely.
  </label>
</div>

<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input"  name="list_ap[]"  value="A Registration Certificate or Document">
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
    <input type="checkbox" class="form-check-input" name="list_ap[]"  value="A current Biometric Immigration">
   A current Biometric Immigration Document (biometric residence permit)
issued by the Home Office to the holder indicating that the person named is</br>
allowed to stay indefinitely in the UK, or has no time limit on their stay in the
UK.
    </label>
</div>
<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="list_ap[]"  value="A current passport endorsed">
   A current passport endorsed to show that the holder is exempt from
immigration control, is allowed to stay indefinitely in the UK, has the right of</br>
abode in the UK, or has no time limit on their stay in the UK. 
    </label>
</div>

<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="list_ap[]"  value="A current Immigration Status">
   A current Immigration Status Document issued by the Home Office to the holder
with an endorsement indicating that the named person is allowed to stay
indefinitely</br> in the UK or has no time limit on their stay in the UK, together with an
official document giving the person’s permanent National Insurance number</br>
and their name issued by a government agency or a previous employer.
</label>
</div>

<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input"  name="list_ap[]" value="A birth (short or long) or adoption">
   A birth or adoption certificate issued in the UK, together with an official
document giving the person’s permanent National Insurance number and their
name issued by</br> a government agency or a previous employer
    </label>
</div>

<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input"  name="list_ap[]" value="A birth (short or long) or adoption certificate">
  A birth or adoption certificate issued in the Channel Islands, the Isle of Man
or Ireland, together with an official document giving the person’s permanent
National Insurance </br> number and their name issued by a government agency or
a previous employer.
    </label>
</div>

<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input"  name="list_ap[]" value="A certificate of registration or naturalisation as a British">
   A certificate of registration or naturalisation as a British citizen, together with an
official document giving the person’s permanent National Insurance number
and their name </br>issued by a government agency or a previous employer.
    </label>
</div>
    </div>
</div>
<h3 style="background: #82b8fd;color: #fff;padding: 5px 20px;">List B Group 1</h3>
<div class="row form-group">
    <div class="col-md-12">
    	<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input"  name="list_bp[]" value="A current passport endorsed to show that the holder" checked>
   A current passport endorsed to show that the holder is allowed to stay in the
UK and is currently allowed to do the type of work in question.</label>
</div>

	<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="list_bp[]" value="A current Biometric Immigration Document">
   A current Biometric Immigration Document (biometric residence permit)
issued by the Home Office to the holder which indicates that the named
person can currently</br> stay in the UK and is allowed to do the work in question.
    </label>
</div>

<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input"  name="list_bp[]" value="A current Residence Card">
    
   A current document issued by the Home Office to a family member of an
EEA or Swiss citizen, and which indicates that the holder is permitted to stay
in the United</br> Kingdom for a time-limited period and to do the type of work in
question.
    
    </label>
</div>

<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="list_bp[]" value="A current Immigration Status Document containing a" >
  A document issued by the Bailiwick of Jersey, the Bailiwick of Guernsey or the
Isle of Man, which has been verified as valid by the Home Office Employer
Checking Service</br>, showing that the holder has been granted limited leave to
enter or remain under Appendix EU to the Jersey Immigration Rules, Appendix
EU to the</br> Immigration (Bailiwick of Guernsey) Rules 2008 or Appendix EU to the
Isle of Man Immigration Rules.</label>
</div>


<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="list_bp[]" value="A document issued by the Bailiwick of Jersey" >
 A document issued by the Bailiwick of Jersey or the Bailiwick of Guernsey,
which has been verified as valid by the Home Office Employer Checking
Service, showing</br> that the holder has made an application for leave to enter or
remain under Appendix EU to the Jersey Immigration Rules or Appendix EU to
the Immigration</br> (Bailiwick of Guernsey) Rules 2008, on or before 30 June 2021.</label>
</div>



<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="list_bp[]" value="A frontier worker permit" >
A frontier worker permit issued under regulation 8 of the Citizens’ Rights
(Frontier Workers) (EU Exit) Regulations 2020.</label>
</div>


<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="list_bp[]" value="A current immigration status document containing a photograph" >
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

<div class="row form-group">
	<div class="col-lg-12">
		<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="list_bpc[]" value="A Certificate of Application issued" checked>
    A document issued by the Home Office showing that the holder has made an
application for leave to enter or remain under Appendix EU to the immigration
rules on or</br> before 30 June 2021 together with a Positive Verification Notice
from the Home Office Employer Checking Service.</label>
</div>

	<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="list_bpc[]" value="An Application Registration Card issued">
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
    <input type="checkbox" class="form-check-input" name="list_bpc[]" value="A Positive Verification Notice">
    An application registration card issued by the Home Office stating that the
holder is permitted to take the employment in question, together with a
Positive Verification Notice</br> from the Home Office Employer Checking Service.
    </label>
</div>

	<div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="list_bpc[]" value="A Positive Verification Notice issued">
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

          </fieldset>
        </div>



        <div id="sf3" class="frm" style="display: none;">
          <fieldset>
            <legend>Step 2 Check</legend>
            <p>You must <b>check</b> that the documents are genuine and that the person presenting
them is the prospective employee or employee, the rightful holder and allowed to
do the type of work you are offering.</p>

            <div class="row form-group">
              <div class="col-lg-12">
              	<label>1. Are photographs consistent across documents
and with the person’s appearance?</label>&nbsp;&nbsp;

              	<div class="form-check-inline">
  <label class="form-check-label">
    <input type="radio" class="form-check-input" name="photographs" value="Yes" checked>Yes
  </label>
</div>
<div class="form-check-inline">
  <label class="form-check-label">
    <input type="radio" class="form-check-input"  name="photographs" value="No" >No
  </label>
</div>
<div class="form-check-inline disabled">
  <label class="form-check-label">
    <input type="radio" class="form-check-input" name="photographs" value="N/A" >N/A
  </label>
</div>
              </div>

              <!---------------------->

               <div class="col-lg-12">
              	<label>2. Are dates of birth correct and consistent
across documents?</label>&nbsp;&nbsp;

              	<div class="form-check-inline">
  <label class="form-check-label">
    <input type="radio" class="form-check-input" name="dates" value="Yes"  checked>Yes
  </label>
</div>
<div class="form-check-inline">
  <label class="form-check-label">
    <input type="radio" class="form-check-input" name="dates" value="No" >No
  </label>
</div>
<div class="form-check-inline disabled">
  <label class="form-check-label">
    <input type="radio" class="form-check-input" name="dates" value="N/A">N/A
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
    <input type="radio" class="form-check-input" name="expiry" value="Yes"  checked>Yes
  </label>
</div>
<div class="form-check-inline">
  <label class="form-check-label">
    <input type="radio" class="form-check-input" name="expiry" value="No" >No
  </label>
</div>
<div class="form-check-inline disabled">
  <label class="form-check-label">
    <input type="radio" class="form-check-input"  name="expiry" value="N/A">N/A
  </label>
</div>
              </div>

          <!------------------------------->


       <div class="col-lg-12">
              	<label>4. Have you checked work restrictions to determine
if the person is able to work for you and do the
type of work you are offering? (For students who
have limited permission to work</br>  during termtime, you must also obtain, copy and retain
details of their academic term and vacation
times covering the duration of their period of
study in the UK </br> for which they will be employed.)</label><br>

              	<div class="form-check-inline">
  <label class="form-check-label">
    <input type="radio" class="form-check-input" name="checked" value="Yes"  checked>Yes
  </label>
</div>
<div class="form-check-inline">
  <label class="form-check-label">
    <input type="radio" class="form-check-input"  name="checked" value="No"  >No
  </label>
</div>
<div class="form-check-inline disabled">
  <label class="form-check-label">
    <input type="radio" class="form-check-input"  name="checked" value="N/A"  >N/A
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
    <input type="radio" class="form-check-input"  name="satisfied" value="Yes"  checked>Yes
  </label>
</div>
<div class="form-check-inline">
  <label class="form-check-label">
    <input type="radio" class="form-check-input"  name="satisfied" value="No"  >No
  </label>
</div>
<div class="form-check-inline disabled">
  <label class="form-check-label">
    <input type="radio" class="form-check-input" name="satisfied" value="N/A"  >N/A
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
    <input type="radio" class="form-check-input" name="reasons" value="Yes"  checked>Yes
  </label>
</div>
<div class="form-check-inline">
  <label class="form-check-label">
    <input type="radio" class="form-check-input" name="reasons" value="No" >No
  </label>
</div>
<div class="form-check-inline disabled">
  <label class="form-check-label">
    <input type="radio" class="form-check-input"  name="reasons" value="N/A">N/A
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

          </fieldset>
        </div>







        <div id="sf4" class="frm" style="display: none;">
          <fieldset>
            <legend>Step 3 Copy</legend>
            <p>You must make a clear copy of each document in a format which cannot later be
altered, and retain the copy securely; electronically or in hardcopy. You must copy
and retain:</p>

            <div class="row form-group">
              <div class="col-lg-12">
            <div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="passports[]" value="any page with the document" checked>Passports: any page with the document expiry date, nationality, date of birth,
signature, leave expiry date, biometric details and photograph, and any page
containing information</br> indicating the holder has an entitlement to enter or
remain in the UK and undertake the work in question.  </label>
</div>

  <div class="form-check-inline">
  <label class="form-check-label">
    <input type="checkbox" class="form-check-input" name="passports[]" value="All other documents">All other documents:
  the document in full, both sides of a biometric residence
permit. You must also record and retain the date on which the check was made.
    </label>
</div>
              </div>

              <!---------------------->

            </div>

  <legend>Know the type of excuse you have</legend>
<p>If you have correctly carried out the above 3 steps you will have an excuse against
liability for a civil penalty if the above named person is found working for you
illegally. However, you need to be aware of the type of excuse you have as this
determines how long it lasts for, and if, and when you are required to do a followup check.</p>
<p>The documents that you have checked and copied are from:</p>



<div class="row form-group">
              <div class="col-lg-12">
            <div class="form-check-inline">
  <label class="form-check-label">
   List A   <input type="checkbox" style="margin-left: 17px" class="form-check-input" name="type_of_excuse[]" value="List A"  >
 You have a continuous statutory excuse for the full duration of the
person’s employment with you. You are not required to carry out any repeat right
to work checks on this.
    </label>
</div>

  <div class="form-check-inline">
  <label class="form-check-label">
    List B: Group 1   <input type="checkbox" style="margin-left: 17px" class="form-check-input" name="type_of_excuse[]" value="List B: Group 1"  >
 You have a time-limited statutory excuse which expires when
the person’s permission to be in the UK expires. You should carry out a follow-up
check when the </br>document evidencing their permission to work expires.
    </label>
</div>
 <div class="form-check-inline">
  <label class="form-check-label">
    List B: Group 2   <input type="checkbox" style="margin-left: 17px" class="form-check-input" name="type_of_excuse[]" value="List B: Group 2"   >
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
          				
          					
          					<input type="hidden" class="form-control" name="list_right" >
          					<input type="hidden" class="form-control" name="list_right_follow" >
          					<input type="hidden" class="form-control" name="list_right_date"  >
          				
          				<tr>
          					<td>List B: (Group 1)</td>
          					<input type="hidden" class="form-control" name="list_rightb" >
          					<input type="hidden" class="form-control" name="list_rightb_follow" >
                    <td><input type="date" class="form-control" name="list_rightb_date"  id="list_rightb_date"></td>
          				</tr>
          				
          					
          					<input type="hidden" class="form-control" name="list_rightti">
          					<input type="hidden" class="form-control" name="list_rightti_follow" >
          					<input type="hidden" class="form-control" name="list_rightti_date" >
          				
          				<tr>
          					<td>List B: (Group 2)</td>
          					<input type="hidden" class="form-control" name="list_rightbs" >
          					<input type="hidden" class="form-control" name="list_rightbs_follow" >
          					<td><input type="date" class="form-control" name="list_rightbs_date" ></td>
          				</tr>
						<tr>
          					<td>EUSS </td>
          					<input type="hidden" class="form-control" name="list_eusss">
          					<input type="hidden" class="form-control" name="list_euss_follow">
          					<td><input type="date" class="form-control" name="list_euss_date" id="list_euss_date"></td>
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
      
        </select>
        <input type="hidden" id="scan_f_img" name="scan_f_img">
       
              <div class="text-center rtw-scan">
                <div class="scan-hd">
                <h3>RTW Evidence Scans-1</h3>
                <p>Please copy and paste an image of your scanned RTW documents into the grey form field below.</p>
              </div>

              <div class="scan-body" style="background: #edecec;">
                  <!--<embed src="" frameborder="0" width="100%" height="700px" id="imgeid">-->
                 
                  <img name="imgeid" id="imgeid"   width="50%" >
                   <div id="scan_ne_id"  style="display:none;margin-top:20px;" >
                   <img name="imgeidnew" id="imgeidnew"   width="50%">
                   </div>
              </div>
              </div>
            </div>
          </div>

          <div class="row form-group">
            <div class="col-lg-12">
              <label>Select Documents</label>
                
               <select class="form-control"  id="scan_s" name="scan_s" onchange="checkscsns(this.value);" >
          <option value="">Select</option>
      
        </select>
         <input type="hidden" id="scan_s_img" name="scan_s_img">
         
              <div class="text-center rtw-scan">
                <div class="scan-hd">
                <h3>RTW Evidence Scans-2 (If applicable)</h3>
                <p>Please copy and paste an image of your scanned RTW documents into the blue form field below.</p>
              </div>

              <div class="scan-body" style="background: #e0f6ff;">
                  
                 <img name="imgeids" id="imgeids"   width="50%" >
                   <div id="scan_nse_id"  style="display:none;margin-top:20px;" >
                   <img name="imgeidsnew" id="imgeidsnew"   width="50%">
                   </div>
              </div>
              </div>
            </div>
          </div>


          <div class="row form-group">
            <div class="col-lg-12">
              <h4>Select Documents</h4>
                <div class="col-lg-12">
              <select class="form-control"  id="scan_r" name="scan_r" onchange="checkscsnr(this.value);">
          <option value="">Select</option>
      
        </select>
          <input type="hidden" id="scan_r_img" name="scan_r_img">
         </div>
              <div class="text-center rtw-scan">
                <div class="scan-hd">
                <h3>RTW Report</h3>
                <p>Please copy and paste a clear copy/image of RTW check result in the orange form below.</p>
              </div>

              <div class="scan-body" style="background: #ffedcb;">
                 
                 <img name="imgeidsj" id="imgeidsj"   width="50%" >
                  <div id="scan_nrse_id"  style="display:none;margin-top:20px;" >
                   <img name="imgeidsjnew" id="imgeidsjnew"   width="50%">
                   </div>
              </div>
              </div>
            </div>
          </div>


          <div class="row form-group">
          	<div class="col-md-6">
          		<label>RTW check result</label>
          		<!-- <textarea rows="5" class="form-control" placeholder="Positive/Negative Verification" style="resize: none;"  name="result"></textarea> -->
              <select class="form-control"  id="result" name="result" >
                <option value=""></option>
                <option value="Positive">Positive</option>
                <option value="Negative">Negative</option>
              </select>
          	</div>

          	<div class="col-md-6">
          		<label>Remarks</label>
          		<textarea rows="5" class="form-control" placeholder="Example: No dentist/sports job, No recourse to public fund. Maximum 20
hours weekly" style="resize: none;"  name="remarks"></textarea>
          	</div>
          </div>

          <div class="row form-group">
          	<div class="col-md-6">
          		<label>Checker Name</label>
          		<input type="text" class="form-control" name="checker"  value="{{$Roledata->f_name}} {{$Roledata->l_name}} ">
          	</div>
          	<div class="col-md-6">
          		<label>Contact No.</label>
          		<input type="text" class="form-control" name="contact" id="contact" value="{{$Roledata->con_num}}">
          	</div>
          </div>

          <div class="row form-group">
          	<div class="col-md-6">
          		<label>Designation</label>
          		<input type="text" class="form-control" name="designation" id="designation" value="{{$Roledata->desig}}">
          	</div>
          		<input type="hidden" class="form-control" name="emp_id" id="emp_id">
         
          	<div class="col-md-6">
          		<label>Email Address</label>
          		<input type="email" class="form-control" name="email" id="email" value="{{$Roledata->authemail}}">
          	</div>
          </div>
            

            <div class="clearfix" style="height: 10px;clear: both;"></div>

            <div class="form-group">
              <div class="col-lg-10 col-lg-offset-2">
                <button class="btn btn-warning back4" type="button"><span class="fa fa-arrow-left"></span> Back</button> 
                <button class="btn btn-primary open4" type="submit">Submit </button> 
                
              </div>
            </div>

          </fieldset>
        </div>

        
      </form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			 @include('employee.include.footer')
		</div>
		
	</div>
	<!--   Core JS Files   -->
	<script src="{{ asset('employeeassets/js/core/jquery.3.2.1.min.js')}}"></script>
	<script src="{{ asset('employeeassets/js/core/popper.min.js')}}"></script>
	<script src="{{ asset('employeeassets/js/core/bootstrap.min.js')}}"></script>

	<!-- jQuery UI -->
	<script src="{{ asset('employeeassets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js')}}"></script>
	<script src="{{ asset('employeeassets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js')}}"></script>

	<!-- jQuery Scrollbar -->
	<script src="{{ asset('employeeassets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js')}}"></script>
	<!-- Datatables -->
	<script src="{{ asset('employeeassets/js/plugin/datatables/datatables.min.js')}}"></script>
	<<!-- Atlantis JS -->
	<script src="{{ asset('employeeassets/js/atlantis.min.js')}}"></script>
	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="{{ asset('employeeassets/js/setting-demo2.js')}}"></script>
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
  // validate form on keyup and submit
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

  // Binding next button on first step
  $(".open1").click(function() {
      if (v.form()) {
        $(".frm").hide("fast");
        $("#sf2").show("slow");
      }
    });

     $(".open2").click(function() {
     if (v.form()) {
     $(".frm").hide("fast");
    $("#sf3").show("slow");
     }
    });
      $(".open3").click(function() {
     if (v.form()) {
     $(".frm").hide("fast");
    $("#sf4").show("slow");
     }
    });
    
    $(".open4").click(function() {
    
    });
    
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

  });
  	$(document).ready(function() {
		var empid="<?=$employee_id;?>";
		
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
				      var input = document.getElementById("date");
              // input.setAttribute("max", obj[0].emp_doj);
				     }
				     $("#start_date").attr("readonly", true);
				        if(obj[0].emp_doj!='1970-01-01'){
				     $("#start_date").val(obj[0].emp_doj);
				     } 
				
				        if(obj[0].visa_review_date!='1970-01-01'){
				     $("#list_rightb_date").val(obj[0].visa_review_date);
				     } 
				       if(obj[0].euss_review_date!='1970-01-01'){
				     $("#list_euss_date").val(obj[0].euss_review_date);
				     }    
					  
			 
		}
		});
		 	$.ajax({
		type:'GET',
		url:'{{url('pis/getEmployeedreportfileById')}}/'+empid,
        cache: false,
		success: function(response){
			
		
			document.getElementById("scan_f").innerHTML = response;
				document.getElementById("scan_s").innerHTML = response;
					document.getElementById("scan_r").innerHTML = response;
						document.getElementById("evidence").innerHTML = response;
		}
		});
	});
	
	
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
</body>
</html>