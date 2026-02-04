<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Login Creadential</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.1/css/all.min.css">
</head>

<body style="font-family: 'Arial', 'Helvetica', 'Verdana', 'Tahoma', 'Geneva', sans-serif; margin: 0; padding: 0;">
    <table width="100%" cellspacing="0" cellpadding="0" border="0" style="background-color: #f5f5f5; padding: 20px;">
        <tr>
            <td align="center">
                <table width="600px" cellspacing="0" cellpadding="0" border="0"
                    style="background-color: #ffffff; border-radius: 10px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    <!-- Header -->
                    <tr>
                        <td>
                            <table style="border-spacing: 0; padding: 0; margin: 0;">
                                <tr>
                                    <td width="25%" style="padding-left: 20px;">
                                        <img src="{{ public_path('storage/app/public/'.$org_logo) }}" alt="" width="100%">
                                         {{-- <img src="https://ik.imagekit.io/oq9hcqjih/main-logo.png" alt="" width="100%"> --}}
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
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;"><strong>Dear {{ strtoupper($client_name) }},</strong></p>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;">
                                Welcome to <strong>{{$org_name}} !</strong> Thank you for connecting with us. 
                                We are thrilled to have you onboard and run your business operation smoothly! 
                            </p>

                           
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;"><strong>Click below to start your journey:</strong>
                            </p>
                            
                            <div style=" margin: 20px 0;">
                                <a href="https://skilledworkerscloud.co.uk/hrms-v2/register"
                                    style="text-decoration: none; color: #ffffff; background-color: #0044cc; padding: 10px 20px; border-radius: 5px; font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">👉
                                    <strong>Download our Android App from Play Store:</strong></a> <br> Use this creadential.
                            </div>

                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;"><strong>Your login details:</strong></p>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;"><strong>Username:</strong> {{ $client_email }}
                            </p>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;"><strong>Password:</strong> {{ $client_password }}</p>
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
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; margin: 0;">Our team is here to help! Reach out anytime at <a
                                    href="mailto: {{$org_email}}">{{$org_email}}</a> or
                                call <a href="tel:  {{$org_phone}}"> {{$org_phone}}</a></p>
                        </td>
                    </tr>
                    {{-- <tr>
                        <td style="font-size: 10px; font-family: 'Times New Roman', Times, serif; text-align: justify; padding: 0 20px;">
                            <p style="font-size: 10px; font-family: 'Times New Roman', Times, serif; text-align: justify; line-height: 1.2;">
                                <i><strong>Disclaimer:</strong> This email, including any attachments, is intended solely for the designated recipient(s) and may contain confidential or
                                    privileged information. Unauthorized access, distribution, or reliance on its content without our explicit written permission is strictly prohibited. 
                                    If you have received this email in error, please delete all copies and notify the sender immediately, with a copy to {{$org_email}}</i>
                            </p>         
                        </td>
                    </tr> --}}

                    <tr>
                        <td height="20"></td>
                    </tr>


                    <!-- Text Section -->

                    <tr>
                        <td style="padding: 0 20px;">
                            <img src="{{ public_path('storage/app/public/'.$org_logo) }}" alt="" style="width: 150px;">
                        </td>
                    </tr>

                    <tr>
                        <td height="30"></td>
                    </tr>

                    <tr>
                        <td style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333; padding: 0 20px;">
                            <p style="margin: 0 0 10px; padding-top: 10px;"><strong>Kind regards,</strong></p>
                        </td>
                    </tr>

                    <tr>
                        <td height="10"></td>
                    </tr>

                    <tr>
                        <td style="padding: 0 20px;">
                            <p style="margin: 0 0 20px; font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; font-weight: bold; color: #0044cc;">
                                {{$org_name}}
                            </p>
                        </td>
                    </tr>

                    


                    <!-- Contact Info Section -->
                    <tr>
                        <td style="color: #333; font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; line-height: 1.8; padding: 0 20px;">
                            <!-- Email -->
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/email.png" alt="Email"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Email:</strong> {{$org_email}}"
                                {{-- <a href="mailto:{{$org_email}}"
                                    style="color: #0044cc; text-decoration: none;">{{$org_email}}</a> --}}
                            </p>
                            <!-- Phone -->
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/phone-call.png" alt="Phone"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Phone:</strong> {{$org_phone}}
                            </p>
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/web.png" alt="Website"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Website:</strong> {{$org_website}}
                                {{-- <a href="https://www.skilledworkerscloud.co.uk"
                                    style="color: #0044cc; text-decoration: none;">{{$org_website}}</a> --}}
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td height="30"></td>
                    </tr>
                    <tr>
                        <td width="100%">
                            <table width="100%" style="border-spacing: 0; padding: 0; margin: 0;">
                                <tr>
                                    <td width="40%" style="background-color: #c2bbfd; padding: 0; margin: 0;">
                                        <img src="https://ik.imagekit.io/oq9hcqjih/border-img-01.png" alt="" width="100%">
                                    </td>
                                    <td width="60%" style="background-color: #151831; padding: 0; margin: 0; color: #67839c; text-align: center; height: 50px;border-radius: 16px 0 0 0;">
                                        powered by <a href="#" style="color: #67839c;" target="_blank">{{$org_name}}</a>
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