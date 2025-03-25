<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Employment Account is Ready!</title>
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
                    
                    <tr>
                        <td>
                            <table style="border-spacing: 0; padding: 0; margin: 0;">
                                <tr>
                                    <td width="25%" style="padding-left: 20px;">
                                      
                                    </td>
                                    <td width="60%" style="padding: 0;margin: 0;">
                                        <img src="https://ik.imagekit.io/oq9hcqjih/banner-02.png" alt="" width="100%">
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>


                    <!-- Body -->
                    <tr>
                        <td style="padding: 20px;">
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;"><strong>Dear {{ strtoupper($firstname) }} {{ strtoupper($maname) }}  {{ strtoupper($lname) }},</strong></p>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;">
                                Welcome to <strong> {{strtoupper($company_name)}} !</strong> We are excited to have you on board. Your employment
                                profile account has been successfully created, allowing you to access and manage your
                                account (employee profile, attendance, leave requests, and more).
                            </p>
                            
                           

                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;"><strong>Your login details:</strong></p>
                            <ul style="list-style-type: disc; margin-left: 20px;">
                                <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;"><strong>Username:</strong> {{ $email }}</li>
                                <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;"><strong>Password:</strong> {{ $password }}</li>
                            </ul>    

                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;"><strong>Login Here:</strong></p>
                            <div style=" margin: 20px 0;">
                                <a href="{{$baseUrl}}"
                                    style="text-decoration: none; color: #ffffff; background-color: #0044cc; padding: 10px 20px; border-radius: 5px; font-size: 16px;">👉
                                    Login URL</a>
                            </div>

                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;">
                                For security reasons, we recommend updating your password upon first login.
                            </p>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;">
                                If you have any questions or need assistance, feel free to reach out to your HR department.
                                    Looking forward to working together!
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->

                    <tr>
                        <td>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; padding: 0 20px; margin: 0;"><strong> Need assistance?</strong>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>

                    <tr>
                        <td style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; padding: 0 20px;">
                            <p style="margin: 0; font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">Our team is here to help! Reach out anytime at  <a
                                    href="mailto: {{$company_email}}">{{$company_email}}</a> or
                                call <a href="tel:  {{ $company_phone }}"> {{ $company_phone }}</a></p>

                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">Let’s get started on your journey toward efficient HR and compliance!</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 0 20px;">
                            <p style="font-size: 10px; font-family: 'Times New Roman', Times, serif; text-align: justify; line-height: 1.2;">
                                <i><strong>Disclaimer:</strong> This email, including any attachments, is intended solely for the designated recipient(s) and may contain confidential or privileged information. Any unauthorized access,
                                    distribution, or reliance on its content without explicit written permission is strictly prohibited. If you have received this email in error, please delete all copies and notify the sender
                                    immediately, with a copy to {{$company_email}} .
                                </i>
                            </p>
                            <p style="font-size: 10px; font-family: 'Times New Roman', Times, serif; text-align: justify; line-height: 1.2;">
                                <i>
                                    Please note that this email does not guarantee a permanent position within the company. Employment status will be determined based on the terms outlined in your employment contract.
                                </i> 
                            </p>
                            <p style="font-size: 10px; font-family: 'Times New Roman', Times, serif; text-align: justify; line-height: 1.2;">
                                <i>
                                    While <strong> {{$company_name}} </strong> employs the latest virus protection measures, we strongly recommend conducting your own virus scan before opening any attachments. 
                                    {{$company_name}} is not responsible for any loss or damage resulting from software viruses
                                </i> 
                            </p>    
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
                        <td style="text-align: left; color: #333; font-size: 16px; font-family: 'Times New Roman', Times, serif; padding: 0 20px; text-align: justify; padding: 0 20px;">
                            <p style="margin: 0 0 10px; padding-top: 10px;"><strong>Best regards,</strong></p>
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>

                    <tr>
                        <td style="padding: 0 20px;">
                            <p style="margin: 0 0 20px; font-size: 16px; font-family: 'Times New Roman', Times, serif; padding: 0 20px; text-align: justify; font-weight: bold; color: #0044cc;">{{strtoupper($company_name)}}
                                HR Team</p>
                        </td>
                    </tr>

                    <!-- Contact Info Section -->
                    <tr>
                        <td style="color: #333; font-size: 16px; font-family: 'Times New Roman', Times, serif; padding: 0 20px; text-align: justify; line-height: 1.8; padding: 0 20px;">
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
                    <tr>
                        <td width="100%">
                            <table width="100%" style="border-spacing: 0; padding: 0; margin: 0;">
                                <tr>
                                    <td width="40%" style="background-color: #c2bbfd; padding: 0; margin: 0;">
                                        <img src="https://ik.imagekit.io/oq9hcqjih/border-img-01.png" alt="" width="100%">
                                    </td>
                                    <td width="60%" style="background-color: #151831; padding: 0; margin: 0; color: #67839c; text-align: center; height: 50px;border-radius: 16px 0 0 0;">
                                       <a href="#" style="color: #67839c;" target="_blank"></a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>