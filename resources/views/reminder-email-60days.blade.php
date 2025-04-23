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
                                        <img src="{{ asset('storage/'.$Roledata->logo)}}" alt="" width="100%">
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
                            <p style="font-size: 16px; color: #333;">Dear {{ $offer->emp_fname }} {{ $offer->emp_mname }} {{ $offer->emp_lname }},</p>
                            <p style="font-size: 16px; color: #333;">
                                {{ $offer->emp_pr_street_no}} @if( $offer->emp_per_village) ,{{ $offer->emp_per_village}} @endif @if( $offer->emp_pr_state) ,{{ $offer->emp_pr_state}} @endif @if( $offer->emp_pr_city) ,{{ $offer->emp_pr_city}} @endif
                                @if( $offer->emp_pr_pincode) ,{{ $offer->emp_pr_pincode}} @endif  @if( $offer->emp_pr_country) ,{{ $offer->emp_pr_country}} @endif
                            </p>
                            <p style="font-size: 16px; color: #333;">Date : {{date('d/m/Y',strtotime($offer->visa_exp_date.'  - 60  days'))}}</p>
                            <p style="font-size: 16px; color: #333;">
                                Further to your employment on a temporary visa, I am writing to remind you that this visa is due to
                                expire on {{date('d/m/Y',strtotime($offer->visa_exp_date))}}. You are therefore requested to make arrangements to renew your right to
                                work documentation in order for you to remain in employment.
                            </p>
                            <p style="font-size: 16px; color: #333;">Examples of the documents we require are as follows:
                            </p>
                            <ol style="font-size: 16px; color: #333;">
                                <li>A copy of your completed application; and</li>
                                <li>Proof of postage; and/or</li>
                                <li> An acknowledgement letter from the Home Office confirming receipt of your application</li>
                                <li> Where a Certificate of Application provides you with the right to work it is your responsibility
                                to ensure your certificate of application is always dated within 6 months</li>
                            </ol>
                            <p style="font-size: 16px; color: #333;">{{ $Roledata->com_name }}  will complete a check with the Home Office Employer Checking Service to
                                obtain confirmation of any application at the time of your visa expiring or at 5 monthly intervals
                                dependent on the checking requirements for the right to work documents you provide to us. Where
                                a negative verification notice is received, we cannot continue to employ you, unless you are able to
                                provide alternative evidence to satisfy us that you have the right to work.</p>

                            {{-- <div style="text-align: center; margin: 20px 0;">
                                <a href="https://skilledworkerscloud.co.uk/hrms-v2/register"
                                    style="text-decoration: none; color: #ffffff; background-color: #0044cc; padding: 10px 20px; border-radius: 5px; font-size: 16px;">👉
                                    Complete Your Organization Profile</a>
                            </div> --}}

                            <p style="font-size: 16px; color: #333;">
                                As previously advised, the immigration, Asylum and the Nationality Act 2006 requires all employers
                                to make documentation checks at the start of every new colleague’s employment. This legislation
                                also requires employers to carry out follow-up checks where the documents provided only give a
                                colleague the temporary right to work in the UK. This also forms part of the employment with
                                {{ $Roledata->com_name }}
                            </p>
                            <p style="font-size: 16px; color: #333;">
                                Please bring your original documents into the HR team without delay or no later than & 15 days of
                                issuance of letter;. Otherwise, we will have no option but to review your ongoing right to work
                                when your current visa expires. A failure to provide sufficient document evidencing your ongoing
                                right to work in the UK could result {{ $Roledata->com_name }} taking action, which may include
                                considering the summary termination of your employment.
                                Please do not hesitate to contact me if you have any concern or would like to discuss this further.
                            </p>
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
                                    href="mailto: {{ $Roledata->email }}">{{ $Roledata->email }}</a> or
                                call <a href="tel: {{ $Roledata->p_no }}">{{ $Roledata->p_no }}</a></p>

                            <p>Let’s get started on your journey toward efficient HR and compliance!</p>
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>


                    <!-- Text Section -->

                    <tr>
                        <td style="padding: 0 20px;">
                            <img src="{{ asset('storage/'.$Roledata->logo)}}" alt="" style="width: 150px;">
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
                            <p style="margin: 0 0 20px; font-size: 18px; font-weight: bold; color: #0044cc;">{{ $Roledata->com_name }}
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
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/telephone.png" alt="Landline"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Landline:</strong> {{ $Roledata->land }}
                            </p>
                            <!-- Website -->
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/web.png" alt="Website"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Website:</strong>
                                <a href="{{ $Roledata->website }}"
                                    style="color: #0044cc; text-decoration: none;">{{ $Roledata->website }}</a>
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