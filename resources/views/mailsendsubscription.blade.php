<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge" />
	<title>SWCH</title>
	<meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
</head>

<body>
	
	<table width="900px" style="margin:auto;font-family: calibri;margin: auto;
    font-family: calibri;
    border: 5px solid #add5f7;
    padding: 10px;">
		<tr>
			<td><h3>Hello, {{ $com_name }}</h3></td>
			
		</tr>
		


		<tr>
			<tr><td>
			
<p>Your subscription plan <b>{{$plan_name}}</b> is due to
expire on {{date('d/m/Y',strtotime($expiry_date))}}. </p>
<p>You are therefore requested to make arrangements to renew your plan in order to use the application.</p>


<p>Please do not hesitate to contact us, if you have any concern or would like to discuss this further.</p>

<p>Yours sincerely</p>
<p>WorkPermitCloud Limited</p>
<p><img width="100px" src="https://skilledworkerscloud.co.uk/hrms-v2/public/assets/img/logo.png" alt="" /></p>
<p>2nd Floor, 120-117, Whitechapel Road, London, E2 1JE
                        <br>+44 0208 129 1655<br>
                        infoswc@skilledworkerscloud.co.uk<br>
                        www.infoswc@skilledworkerscloud.co.uk<br>
                        VAT Registration# 34544491960</p>
			</td></tr>
		</tr>
	</table>
</body>

</html>