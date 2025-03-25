<p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">Hello <b>Superadmin,</b></p>
@if($user_type == "Partner")
  <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">A new <b>Partner</b> has successfully registered on the <b>SWC_HRMS</b> portal. Below are the details:</p>
@else
  <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">A new @if($org_code) <b>Partner</b> @endif <b>Organisation</b> has successfully registered on the <b>SWC_HRMS</b> portal. Below are the details:</p>
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
          <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;"><b>Partner Name : </b> {{ $partner_name }}</li>
      @endif
  @endif
  <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;"><b>Company Name : </b> {{ strtoupper($com_name) }}</li>
  <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;"><b>Name : </b> {{ $f_name }} {{ $l_name }}</li>
  <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;"><b>Email : </b> {{ $email }}</li>
  <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;"><b>Phone Number : </b> {{ $p_no }}</li>
</ul>
<p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;"><i>Please review and take any necessary actions.</i></p>
<p style="margin-top: 20px; font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;"><b>Thanks,</b></p>
<p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;"><b>HRMS</b> System</p>
