<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Email</title>
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
                                        {{-- <img src="https://ik.imagekit.io/oq9hcqjih/main-logo.png" alt="" width="100%"> --}}
                                        @if($partner_logo)
                                            <img src="{{asset('storage/app/public/'.$partner_logo)}}" alt="" width="100%">
                                        @else
                                            <h1><b>{{$partner_name}}</b></h1>
                                        @endif
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
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;"><strong>Dear {{ strtoupper($com_name) }},</strong></p>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;">
                                Welcome to <strong>{{ $partner_name }}</strong> Thank you for registering with us. 
                                We are thrilled to have you onboard and are excited to support your HR and sponsorship compliance needs and to run your business operation smoothly! 
                            </p>

                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;">
                                As the next step, you need to complete your organization profile. 
                                This ensures a seamless process for utilizing our HRMS features and compliance services.
                            </p>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;"><strong>Click below to start your journey:</strong>
                            </p>
                            
                            <div style=" margin: 20px 0;">
                                <a href="{{$web}}"
                                    style="text-decoration: none; color: #ffffff; background-color: #0044cc; padding: 10px 20px; border-radius: 5px; font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">👉
                                    Complete Your Organization Profile</a>
                            </div>

                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;"><strong>Your login details:</strong></p>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;"><strong>Username:</strong> {{ $email }}
                            </p>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;"><strong>Password:</strong> {{ $pass}}</p>

                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;"><strong>Helpful tips to complete your organization profile:</strong>
                            </p>
                            <ol style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333; line-height: 1.6;">
                                <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">Navigate to the <strong>‘Organization Profile’</strong> tab to begin.</li>
                                <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">Go to <strong>‘Profile Status’</strong> and fill in:
                                    <ul style="list-style-type: disc; margin-left: 20px;">
                                        <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">Basic business details: trading name, company registration number, business address, trading hours, and trading period.</li>
                                        <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">Information about your authorizing officer (e.g., director or key employee). This person will liaise with the Home Office regarding your sponsor license application.</li>
                                        <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">Basic details of all employees for the hierarchy chart, a mandatory Home Office requirement.</li>
                                    </ul>
                                </li>
                                <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">Upload required documents under the <strong>‘Documents’</strong> section. Use the <strong>‘Add’</strong> button for additional uploads</li>
                                <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">Make sure every field is filled out completely to ensure full compliances.</li>
                            </ol>
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
                                    href="mailto: {{ $partner_email }}">{{ $partner_email }}</a> or
                                call <a href="tel:  {{ $partner_phone }}"> {{ $partner_phone }}</a></p>

                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">Let’s get started on your journey toward efficient HR and compliance!</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 10px; font-family: 'Times New Roman', Times, serif; text-align: justify; padding: 0 20px;">
                            <p style="font-size: 10px; font-family: 'Times New Roman', Times, serif; text-align: justify; line-height: 1.2;">
                                <i><strong>Disclaimer:</strong> This email, including any attachments, is intended solely for the designated recipient(s) and may contain confidential or
                                    privileged information. Unauthorized access, distribution, or reliance on its content without our explicit written permission is strictly prohibited. 
                                    If you have received this email in error, please delete all copies and notify the sender immediately, with a copy to {{ $partner_email }}.</i>
                            </p>
                            
                            <p style="font-size: 10px; font-family: 'Times New Roman', Times, serif; text-align: justify; line-height: 1.2;">
                                <i>
                                    While <strong>{{ $partner_name }}</strong> employs the latest virus protection measures, we strongly recommend conducting your own virus scan before opening any attachments.
                                     <strong>{{ $partner_name }}</strong> is not responsible for any loss or damage resulting from software viruses.
                                </i> 
                            </p>     
                               
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>


                    <!-- Text Section -->

                    <tr>
                        <td style="padding: 0 20px;">
                            @if($partner_logo)
                                <img src="{{asset('storage/app/public/'.$partner_logo)}}" alt="" style="width: 150px;">
                            @endif
                            {{-- <img src="https://ik.imagekit.io/oq9hcqjih/main-logo.png" alt="" style="width: 150px;"> --}}
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
                        <td height="20"></td>
                    </tr>

                    <tr>
                        <td style="padding: 0 20px;">
                            <p style="margin: 0 0 20px; font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; font-weight: bold; color: #0044cc;">{{ $partner_name }}
                                Team</p>
                        </td>
                    </tr>

                    <!-- Contact Info Section -->
                    <tr>
                        <td style="color: #333; font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; line-height: 1.8; padding: 0 20px;">
                            <!-- Email -->
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/email.png" alt="Email"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Email:</strong>
                                <a href="mailto:{{ $partner_email }}"
                                    style="color: #0044cc; text-decoration: none;">{{ $partner_email }}</a>
                            </p>
                            <!-- Phone -->
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/phone-call.png" alt="Phone"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Phone:</strong> {{ $partner_phone}}
                            </p>
                            <!-- Landline -->
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/telephone.png" alt="Landline"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Landline:</strong> {{ $partner_land }}
                            </p>
                            <!-- Website -->
                            @if($partner_website)
                                <p style="margin: 5px 0;">
                                    <img src="https://ik.imagekit.io/oq9hcqjih/web.png" alt="Website"
                                        style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                    <strong>Website:</strong>
                                    <a href="{{ $partner_website }}"
                                        style="color: #0044cc; text-decoration: none;">{{ $partner_website }}</a>
                                </p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td height="30"></td>
                    </tr>
                    <tr>
                        <td>
                            <img src="https://ik.imagekit.io/oq9hcqjih/footer-img.png" alt="" width="100%" height="auto">
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>