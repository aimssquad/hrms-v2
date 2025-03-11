<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
                                    {{-- @if($logo)
                                    <td width="25%" style="padding-left: 20px;">
                                        <img src="{{ asset('storage/app/public/' . $logo) }} " alt="" width="100%">
                                    </td>
                                    @endif --}}
                                    <td width="25%" style="padding-left: 20px;">
                                        <img src="https://ik.imagekit.io/oq9hcqjih/main-logo.png" alt="" width="100%">
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
                            <p style="font-size: 16px; color: #333;">Dear {{strtoupper($name)}},</p>
                            <p style="font-size: 16px; color: #333;">Welcome to <strong>Skilled Workers Cloud HRMS!</strong></p>
                            <p style="font-size: 16px; color: #333;">Your password is provided below.
                            </p>

                            {{-- <p style="font-size: 16px; color: #333;">As the next step, you need to complete your
                                organization profile. This ensures a seamless process for utilizing our HRMS features
                                and compliance services.</p> --}}
                            {{-- <p style="font-size: 16px; color: #333;"><strong>Username:</strong>
                            </p>     --}}
                            <div style="text-align: center; margin: 20px 0;">
                                <a href="{{$web}}"
                                    style="text-decoration: none; color: #ffffff; background-color: #0044cc; padding: 10px 20px; border-radius: 5px; font-size: 16px;">👉
                                    Your Login URL:</a>
                            </div>

                            <p style="font-size: 16px; color: #333;"><strong>Your login details:</strong></p>
                            <p style="font-size: 16px; color: #333;"><strong>Username:</strong> {{ $email }}
                            </p>
                            <p style="font-size: 16px; color: #333;"><strong>Password:</strong> {{ $pass }}</p>

                            {{-- <p style="font-size: 16px; color: #333;">Helpful tips to complete your organization profile:
                            </p> --}}
                        </td>
                    </tr>

                    <!-- Footer -->

                    <tr>
                        <td>
                            <p style="font-size: 24px; padding: 0 20px; margin: 0;"><strong> Need assistance?</strong>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>

                    <tr>
                        <td style="font-size: 18px; padding: 0 20px;">
                            <p style="margin: 0;">Our team is here to help! Reach out anytime at<a
                                    href="mailto: info@skilledworkerscloud.co.uk">info@skilledworkerscloud.co.uk</a> or
                                call <a href="tel: +44 074 6728 4718">+44 7467284718.</a></p>

                            <p>Let’s get started on your journey toward efficient HR and compliance!</p>
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>


                    <!-- Text Section -->

                    <tr>
                        <td style="padding: 0 20px;">
                            <img src="https://ik.imagekit.io/oq9hcqjih/main-logo.png" alt="" style="width: 150px;">
                        </td>
                    </tr>

                    <tr>
                        <td height="30"></td>
                    </tr>

                    <tr>
                        <td style="text-align: left; color: #333; font-size: 20px; padding: 0 20px;">
                            <p style="margin: 0 0 10px;"><strong>Kind regards,</strong></p>
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>

                    <tr>
                        <td style="padding: 0 20px;">
                            <p style="margin: 0 0 20px; font-size: 18px; font-weight: bold; color: #0044cc;">SWC HRMS Team</p>
                        </td>
                    </tr>

                    <!-- Contact Info Section -->
                    <tr>
                        <td style="color: #333; font-size: 16px; line-height: 1.8; padding: 0 20px;">
                            <!-- Email -->
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/email.png" alt="Email"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Email:</strong>
                                <a href="mailto:info@skilledworkerscloud.co.uk"
                                    style="color: #0044cc; text-decoration: none;">info@skilledworkerscloud.co.uk</a>
                            </p>
                            <!-- Phone -->
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/phone-call.png" alt="Phone"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Phone:</strong>  +44 7467284718
                            </p>
                            <!-- Landline -->
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/telephone.png" alt="Landline"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Landline:</strong> +44 (0) 208 129 1655
                            </p>
                            <!-- Website -->
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/web.png" alt="Website"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Website:</strong>
                                <a href="https://www.skilledworkerscloud.co.uk"
                                    style="color: #0044cc; text-decoration: none;">www.skilledworkerscloud.co.uk</a>
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
                                        powered by <a href="#" style="color: #67839c;" target="_blank">Skilled Workers Cloud</a>
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