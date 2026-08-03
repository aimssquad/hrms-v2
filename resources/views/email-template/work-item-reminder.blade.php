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
                                    <td width="25%" style="padding-left: 20px;">
                                        {{-- <img src="https://ik.imagekit.io/oq9hcqjih/main-logo.png" alt="" width="100%"> --}}
                                        <img src="{{ $reminder['company_logo'] }}"
                                            alt="{{ $reminder['company_name'] }}"
                                            width="100%">
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
                        <td style="padding:30px;">

                            <h2 style="margin:0;color:#0044cc;font-size:28px;">
                                {{ $reminder['work_item_type'] }} Reminder
                            </h2>

                            <br>

                            <p style="font-size:18px;color:#333;">
                                Dear <strong>{{ strtoupper($reminder['employee_name']) }}</strong>,
                            </p>

                            <p style="font-size:16px;color:#333;line-height:28px;">
                                We hope you are doing well.
                            </p>

                            <p style="font-size:16px;color:#333;line-height:28px;">
                                This is a friendly reminder regarding your assigned
                                <strong>{{ $reminder['work_item_type'] }}</strong>.
                            </p>

                            <div style="background:#f8f9fa;border-left:5px solid #0044cc;padding:18px;margin:25px 0;">
                                <strong>Message from your Project Manager</strong>
                                <br><br>
                                {!! nl2br(e($reminder['custom_message'])) !!}
                            </div>

                            <table width="100%" cellpadding="12" cellspacing="0"
                                style="border-collapse:collapse;border:1px solid #dcdcdc;font-size:15px;">

                                <tr style="background:#f4f6f9;">
                                    <td width="35%" style="border:1px solid #dcdcdc;">
                                        <strong>Project</strong>
                                    </td>
                                    <td style="border:1px solid #dcdcdc;">
                                        {{ $reminder['project_title'] }}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="border:1px solid #dcdcdc;">
                                        <strong>{{ $reminder['work_item_type'] }}</strong>
                                    </td>
                                    <td style="border:1px solid #dcdcdc;">
                                        {{ $reminder['work_item_title'] }}
                                    </td>
                                </tr>

                                <tr style="background:#f4f6f9;">
                                    <td style="border:1px solid #dcdcdc;">
                                        <strong>Description</strong>
                                    </td>
                                    <td style="border:1px solid #dcdcdc;">
                                        {!! $reminder['work_item_description'] !!}
                                    </td>
                                </tr>

                                <tr>
                                    <td style="border:1px solid #dcdcdc;">
                                        <strong>Due Date</strong>
                                    </td>
                                    <td style="border:1px solid #dcdcdc;color:#dc3545;font-weight:bold;">
                                        {{ $reminder['end_date'] }}
                                    </td>
                                </tr>

                            </table>

                            <br>

                            <p style="font-size:16px;color:#333;line-height:28px;">
                                Please ensure that this
                                <strong>{{ strtolower($reminder['work_item_type']) }}</strong>
                                is completed before the due date.
                            </p>

                            <p style="font-size:16px;color:#333;line-height:28px;">
                                If you are experiencing any issues or need assistance, please contact
                                your project manager as soon as possible.
                            </p>

                            <br>

                            <p style="font-size:16px;color:#333;">
                                Thank you for your cooperation.
                            </p>

                        </td>
                    </tr>

                    <!-- Footer -->

                    <tr>
                        <td>
                            <p style="font-size: 30px; padding: 0 20px; margin: 0;"><strong> Need assistance?</strong>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>

                    <tr>
                        <td style="font-size: 18px; padding: 0 20px;">
                            
                            <p style="margin: 0; font-size: 30px;">Our team is here to help! Reach out anytime at <a style="font-size: 30px;"
                                    href="mailto: info@skilledworkerscloud.co.uk"><strong>info@skilledworkerscloud.co.uk</strong></a> or
                                call <a href="tel: +44 7467284718"><strong>+44 7467284718.</strong></a></p>

                            <p style="font-size: 30px;">Let’s get started on your journey toward efficient HR and compliance!</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 20px; padding: 0 20px;">
                            <i style="font-size: 20px;"><strong>Disclaimer:</strong> This email, including any attachments, is intended solely for the designated recipient(s) and may contain confidential or
                                 privileged information. Unauthorized access, distribution, or reliance on its content without our explicit written permission is strictly prohibited. 
                                 If you have received this email in error, please delete all copies and notify the sender immediately, with a copy to info@skilledworkerscloud.co.uk.</i>
                            <i style="font-size: 20px;">
                                While <strong>Skilled Workers Cloud HRMS</strong> employs the latest virus protection measures, we strongly recommend conducting your own virus scan before opening any attachments.
                                 <strong>SWC HRMS</strong> is not responsible for any loss or damage resulting from software viruses.
                            </i>     
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>


                    <!-- Text Section -->

                    <tr>
                        <td style="padding: 0 20px;">  
                            {{-- <img src="https://ik.imagekit.io/oq9hcqjih/main-logo.png" alt="" style="width: 350px;">  --}}
                            <img src="{{ $reminder['company_logo'] }}"
                                            alt="{{ $reminder['company_name'] }}"
                                            style="width: 350px;">
                        </td>
                    </tr>

                    <tr>
                        <td height="30"></td>
                    </tr>

                    <tr>
                        <td style="text-align: left; color: #333; font-size: 30px; padding: 0 20px;">
                            <p style="margin: 0 0 10px;"><strong>Kind regards,</strong></p>
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>

                    <tr>
                        <td style="padding: 0 20px;">
                            <p style="margin: 0 0 20px; font-size: 30px; font-weight: bold; color: #0044cc;">SWC HRMS Team</p>
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

















<h2>{{$reminder['work_item_type']}} Reminder</h2>

<p>Hello {{ $reminder['employee_name'] }},</p>

<p>{{$reminder['custom_message']}}</p>

<table border="1" cellpadding="10">

<tr>
    <td><strong>Project</strong></td>
    <td>{{ $reminder['project_title'] }}</td>
</tr>

<tr>
    <td><strong>Work Item</strong></td>
    <td>{{ $reminder['work_item_title'] }}</td>
</tr>

<tr>
    <td><strong>Description</strong></td>
    <td>{!! $reminder['work_item_description'] !!}</td>
</tr>

<tr>
    <td><strong>Due Date</strong></td>
    <td>{{ $reminder['end_date'] }}</td>
</tr>

</table>