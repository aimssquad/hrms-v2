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
                                        <img src="{{ asset('storage/'.$Roledata->logo )}}" alt="" width="100%">
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
                            <p style="font-size: 16px; color: #333;">Dear {{ $name }},</p>
                            <p style="font-size: 16px; color: #333;">Thank you for your interest for the position of {{ $pos }} (job code: {{ $job_code }}). We would like to invite you for a telephone interview. 
                                The interview / assessment details are as follows:
                            </p>

                            <p style="font-size: 16px; color: #333;">Date : {{ date('d/m/Y', strtotime($date))}}</p>

                            {{-- <div style="text-align: center; margin: 20px 0;">
                                <a href="https://skilledworkerscloud.co.uk/hrms-v2/register"
                                    style="text-decoration: none; color: #ffffff; background-color: #0044cc; padding: 10px 20px; border-radius: 5px; font-size: 16px;">👉
                                    Complete Your Organization Profile</a>
                            </div> --}}

                            <p style="font-size: 16px; color: #333;">Time: {{ date('h:i A', strtotime($from_time))}}  To  {{ date('h:i A', strtotime($to_time))}}</p>
                            @if($place!='')
                                <p style="font-size: 16px; color: #333;">Interview Place : {{ $place }} </p>
                            @endif    
                            
                            @if($panel!='')
                                <p style="font-size: 16px; color: #333;">Interview Panel : {{ $panel }} </p>
                            @endif
                            <p style="font-size: 16px; color: #333;">Interviewer : {{ $job_d->author }} </p>
                            <p style="font-size: 16px; color: #333;"> If you no longer wish to be considered for this post please reply to us at {{ $job_d->email }} within next three (03) working days with the subject title “withdrawn”. Doing this promptly may then allow us to allocate your interview slot to another applicant.</p>
                            <ol style="font-size: 16px; color: #333;">
                                <li>
                                    If you have any special requirements that should be taken into account during the assessment and selection process, 
                                    please highlight these to us by calling 0{{ $Roledata->p_no }}.</li>
                                <li>
                                    You will be notified if your interview was successful.Should you be successful following the interview process, your referees will be contacted to confirm your employment history. If you
                                    have not done so already it is advisable that you check your referees availability and ensure that you have provided us with contact information such as their work email address. 
                                    When references are taken up, it is your responsibility to chase your referees in order that an unconditional offer of employment can be made. 
                                    Please be aware we require the last 3 years of references including any gaps.
                                </li>
                                {{-- <li>
                                    If you have any queries about the interview, please do not hesitate to contact  {{ $job_d->email }} and  0{{ $job_d->con_num }} directly. 
                                    We look forward to hearing from you directly via reply email.
                                </li> --}}
                                <li>Ensure all fields are completed to meet compliance standards.</li>
                            </ol>
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
                            <p style="margin: 0;">Our team is here to help! Reach out anytime at <a
                                    href="mailto: {{ $Roledata->email }}">{{ $Roledata->email ?? 'N/A' }}</a> or
                                call <a href="tel: {{ $job_d->con_num }}">{{ $job_d->con_num ?? 'N/A' }}</a></p>

                            <p>Let’s get started on your journey toward efficient HR and compliance!</p>
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>


                    <!-- Text Section -->

                    <tr>
                        <td style="padding: 0 20px;">
                            <img src="{{ asset('storage/'.$Roledata->logo )}}" alt="" style="width: 150px;">
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
                            <p style="margin: 0 0 20px; font-size: 18px; font-weight: bold; color: #0044cc;">{{ ucwords($Roledata->com_name) }}
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
                                <a href="mailto:{{$Roledata->email}}"
                                    style="color: #0044cc; text-decoration: none;">{{$Roledata->email ?? 'N/A'}}</a>
                            </p>
                            <!-- Phone -->
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/phone-call.png" alt="Phone"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Phone:</strong> {{$Roledata->p_no ?? 'N/A'}}
                            </p>
                            <!-- Landline -->
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/telephone.png" alt="Landline"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Landline:</strong> {{$Roledata->land ?? 'N/A'}}
                            </p>
                            <!-- Website -->
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/web.png" alt="Website"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Website:</strong>
                                <a href="https://www.skilledworkerscloud.co.uk"
                                    style="color: #0044cc; text-decoration: none;">{{$Roledata->website ?? 'N/A'}}</a>
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