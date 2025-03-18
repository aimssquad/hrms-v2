<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
</head>

<body style="font-family: 'Arial', 'Helvetica', 'Verdana', 'Tahoma', 'Geneva', sans-serif; margin: 0; padding: 0;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f5f5f5; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600px" cellspacing="0" cellpadding="0" border="0"
                    style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    {{-- <tr>
                        <td>
                            <img src="https://ik.imagekit.io/oq9hcqjih/banner-01.png" alt="" width="100%">
                        </td>
                    </tr> --}}

                    <!-- Body -->
                    <tr>
                        <td style="padding: 20px;">
                            <p style="font-size: 30px; color: #333;"><strong>Dear {{ strtoupper($employee_name) }} ,</strong></p>
                            <p style="font-size: 30px; color: #333;">
                                We received a request to reset your password for your employment profile account at
                                {{$company_name}}. Please find your new login details below:
                            </p>
                            
                           

                            <p style="font-size: 30px; color: #333;"><strong>Your login details:</strong></p>
                            <ul style="list-style-type: disc; margin-left: 20px;">
                                <li><strong>Username:</strong> {{ $employee_email }}</li>
                                <li><strong>Password:</strong> {{ $employee_password }}</li>
                            </ul>    

                            <p style="font-size: 30px; color: #333;"><strong>Login Here:</strong></p>
                            <div style=" margin: 20px 0;">
                                <a href="{{$url}}"
                                    style="text-decoration: none; color: #ffffff; background-color: #0044cc; padding: 10px 20px; border-radius: 5px; font-size: 30px;">👉
                                    Login URL</a>
                            </div>

                            <p style="font-size: 30px; color: #333;">
                                For security reasons, we recommend changing your password after logging in.
                            </p>
                            <p style="font-size: 30px; color: #333;">
                                If you did not request a password reset or need further assistance, please contact your HR
                                department immediately
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->

                    <tr>
                        <td style="font-size: 20px; padding: 0 20px;">
                            <i style="font-size: 20px;"><strong>Disclaimer:</strong> This email, including any attachments, is intended solely for the designated recipient(s) and may contain confidential or privileged information. Any unauthorized access,
                                distribution, or reliance on its content without explicit written permission is strictly prohibited. If you have received this email in error, please delete all copies and notify the sender
                                immediately, with a copy to {{$company_email}} .
                            </i>

                            <i style="font-size: 20px;">
                                Please note that this email does not guarantee a permanent position within the company. Employment status will be determined based on the terms outlined in your employment contract.
                            </i> 

                            <i style="font-size: 20px;">
                                While <strong> {{$company_name}} </strong> employs the latest virus protection measures, we strongly recommend conducting your own virus scan before opening any attachments. 
                                {{$company_name}} is not responsible for any loss or damage resulting from software viruses
                            </i>     
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>


                    <!-- Text Section -->

                    {{-- <tr>
                        <td style="padding: 0 20px;">
                            <img src="https://ik.imagekit.io/oq9hcqjih/main-logo.png" alt="" style="width: 350px;">
                        </td>
                    </tr> --}}

                    <tr>
                        <td height="30"></td>
                    </tr>

                    <tr>
                        <td style="text-align: left; color: #333; font-size: 30px; padding: 0 20px;">
                            <p style="margin: 0 0 10px; padding-top: 10px;"><strong>Best regards,</strong></p>
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>

                    <tr>
                        <td style="padding: 0 20px;">
                            <p style="margin: 0 0 20px; font-size: 30px; font-weight: bold; color: #0044cc;">{{strtoupper($company_name)}}
                                HR Team</p>
                        </td>
                    </tr>

                    <!-- Contact Info Section -->
                    <tr>
                        <td style="color: #333; font-size: 30px; line-height: 1.8; padding: 0 20px;">
                            <!-- Email -->
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/email.png" alt="Email"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Email:</strong>
                                <a href="mailto:{{$company_email}}"
                                    style="color: #0044cc; text-decoration: none;">{{$company_email}}</a>
                            </p>
                            <!-- Phone -->
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/phone-call.png" alt="Phone"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Phone:</strong> {{$company_phone}}
                            </p>
                            <!-- Landline -->
                            {{-- <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/telephone.png" alt="Landline"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Landline:</strong> +44 (0) 208 129 1655
                            </p> --}}
                            <!-- Website -->
                            {{-- <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/web.png" alt="Website"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Website:</strong>
                                <a href="https://www.skilledworkerscloud.co.uk"
                                    style="color: #0044cc; text-decoration: none;">www.skilledworkerscloud.co.uk</a>
                            </p> --}}
                        </td>
                    </tr>
                    <tr>
                        <td height="30"></td>
                    </tr>
                    {{-- <tr>
                        <td>
                            <img src="https://ik.imagekit.io/oq9hcqjih/footer-img.png" alt="" width="100%" height="auto">
                        </td>
                    </tr> --}}
                </table>
            </td>
        </tr>
    </table>
</body>

</html>