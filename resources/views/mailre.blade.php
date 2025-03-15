<p>Hello <b>Superadmin,</b></p>
@if($user_type == "Partner")
  <p>A new <b>Partner</b> has successfully registered on the <b>SWC_HRMS</b> portal. Below are the details:</p>
@else
  <p>A new @if($org_code) <b>Partner</b> @endif <b>Organisation</b> has successfully registered on the <b>SWC_HRMS</b> portal. Below are the details:</p>
@endif
{{-- @if($user_type == "Organization")
  @if($org_code)
  <p><b>Partner Name : </b> {{$partner_name}}</p>
  @endif
@endif
<p><b>Company  Name : </b> {{ strtoupper($com_name) }}</p>
<p><b>Name : </b> {{ $f_name }}  {{ $l_name }}</p>
<p><b>E mail : </b> {{ $email}}.</p>
<p><b>Phone Number : </b> {{ $p_no}}.</p> --}}
<ul style="list-style-type: disc; padding-left: 20px;">
  @if($user_type == "Organization")
      @if($org_code)
          <li><b>Partner Name : </b> {{ $partner_name }}</li>
      @endif
  @endif
  <li><b>Company Name : </b> {{ strtoupper($com_name) }}</li>
  <li><b>Name : </b> {{ $f_name }} {{ $l_name }}</li>
  <li><b>Email : </b> {{ $email }}</li>
  <li><b>Phone Number : </b> {{ $p_no }}</li>
</ul>
<p><i>Please review and take any necessary actions.</i></p>
<p style="margin-top: 20px;"><b>Thanks,</b></p>
<p><b>HRMS</b> System</p>
