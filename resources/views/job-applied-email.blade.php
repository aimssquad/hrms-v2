<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Template</title>
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
                                        <img src="{{ asset('storage/app/public/' . $Roledata->logo) }}" alt="Company Logo"  width="100%">
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
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; padding: 0 20px; margin: 0; color: #333;">Dear {{ $name }},</p>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; padding: 0 20px; margin: 0; color: #333;">Thank you for taking the time to apply for {{ $pos }} (Job code: {{ $job_code }}). We appreciate your interest in our company. We are currently in the process of receiving applications for this position and will review your application soon. If you are shortlisted to continue to the interview process, we will be in contact with
                                you.
                            </p>

                            {{-- <p style="font-size: 16px; color: #333;">As the next step, you need to complete your
                                organization profile. This ensures a seamless process for utilizing our HRMS features
                                and compliance services.</p> --}}

                            {{-- <div style="text-align: center; margin: 20px 0;">
                                <a href="https://skilledworkerscloud.co.uk/hrms-v2/register"
                                    style="text-decoration: none; color: #ffffff; background-color: #0044cc; padding: 10px 20px; border-radius: 5px; font-size: 16px;">👉
                                    Complete Your Organization Profile</a>
                            </div>

                            <p style="font-size: 16px; color: #333;">Your login details:</p>
                            <p style="font-size: 16px; color: #333;"><strong>Username:</strong> [Organization User Name]
                            </p>
                            <p style="font-size: 16px; color: #333;"><strong>Password:</strong> [Password]</p>

                            <p style="font-size: 16px; color: #333;">Helpful tips to complete your organization profile:
                            </p>
                            <ol style="font-size: 16px; color: #333;">
                                <li>Navigate to the ‘Organization Profile’ tab to begin.</li>
                                <li>Go to ‘Profile Status’ and fill in necessary details.</li>
                                <li>Upload required documents under the ‘Documents’ section.</li>
                                <li>Ensure all fields are completed to meet compliance standards.</li>
                            </ol> --}}
                        </td>
                    </tr>

                    <!-- Footer -->

                    <tr>
                        <td>
                            <p style="font-size: 24px; font-family: 'Times New Roman', Times, serif; text-align: justify; padding: 0 20px; margin: 0;"><strong> Need assistance?</strong>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>

                    <tr>
                        <td style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; padding: 0 20px; margin: 0;">
                            <p style="margin: 0;">Our team is here to help! Reach out anytime at <a
                                    href="mailto: {{$Roledata->email}}">{{$Roledata->email}}</a> or
                                call <a href="tel: +44 074 6728 4718">{{$Roledata->p_no}}</a></p>

                            <p>Let’s get started on your journey toward efficient HR and compliance!</p>
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>


                    <!-- Text Section -->

                    <tr>
                        <td style="padding: 0 20px;">
                            <img src="{{ asset('storage/app/public/' . $Roledata->logo) }}" alt="" style="width: 150px;">
                        </td>
                    </tr>

                    <tr>
                        <td height="30"></td>
                    </tr>

                    <tr>
                        <td style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; padding: 0 20px; margin: 0; color: #333; ">
                            <p style="margin: 0 0 10px;"><strong>Kind regards,</strong></p>
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>

                    <tr>
                        <td style="padding: 0 20px;">
                            <p style="margin: 0 0 20px; font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; padding: 0 20px; margin: 0; font-weight: bold; color: #0044cc;">{{ $Roledata->com_name }}
                                Team</p>
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
                                <a href="mailto:{{ $Roledata->email }}"
                                    style="color: #0044cc; text-decoration: none;">{{ $Roledata->email }}</a>
                            </p>
                            <!-- Phone -->
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/phone-call.png" alt="Phone"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Phone:</strong> {{ $Roledata->p_no }}
                            </p>
                            <!-- Landline -->
                            @if($Roledata->land != '')
                                <p style="margin: 5px 0;">
                                    <img src="https://ik.imagekit.io/oq9hcqjih/telephone.png" alt="Landline"
                                        style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                    <strong>Landline:</strong> {{  $Roledata->land }}
                                </p>
                            @endif
                            <!-- Website -->
                            @if($Roledata->website != '')
                                <p style="margin: 5px 0;">
                                    <img src="https://ik.imagekit.io/oq9hcqjih/web.png" alt="Website"
                                        style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                    <strong>Website:</strong>
                                    <a href="{{ $Roledata->website }}"
                                        style="color: #0044cc; text-decoration: none;">{{ $Roledata->website }}</a>
                                </p>
                            @endif
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
                                        powered by <a href="#" style="color: #67839c;" target="_blank">{{$Roledata->com_name}}</a>
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