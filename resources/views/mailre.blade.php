<p>Hello <b>Superadmin</b>,</p>
@if($user_type)
  <p>This is new Partner details: </p>
@else
  <p>This is new @if($org_code) <b>Partner</b> @endif <b>Organisation</b> details: </p>
@endif
<p>   Company  Name: {{ $com_name }}</p>
<p> Name : {{ $f_name }}  {{ $l_name }}</p>
<p>  E mail : {{ $email}}.</p>
<p>  Phone Number : {{ $p_no}}.</p>
<p>  Thanks</p>