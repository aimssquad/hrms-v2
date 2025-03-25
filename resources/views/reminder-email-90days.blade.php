<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Follow-Up Reminder: Your Visa Expires in 90 Days</title>
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
                                        <img src="{{ asset('storage/app/public/'.$Roledata->logo)}}" alt="" width="100%">
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
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; color: #333; text-align: justify; "><strong>Dear {{ $offer->emp_fname }} {{ $offer->emp_mname }} {{ $offer->emp_lname }},</strong></p>
                          
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; color: #333; text-align: justify;">
                                We hope this email finds you well. This is a reminder that your visa is set to expire on <strong>{{date('d/m/Y',strtotime($offer->visa_exp_date))}},</strong> 90 days from today. To maintain your
                                employment with <strong>{{ $Roledata->com_name }}</strong> it is essential to renew your visa and provide updated right-to-work documentation.                                
                            </p>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;"><strong>Example of Required Documentation:</strong>
                            </p>
                            <ul style="list-style-type: disc; margin-left: 20px;">
                                <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">A Share Code with HO Reference Number to prove your Right-to-Work.</li>
                                <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">A copy of your completed visa application and/or Document Checklist.</li>
                                <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">Proof of postage and/or Submitted application.</li>
                                <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">Acknowledgment letter or email from the Home Office confirming receipt of your application.</li>
                                <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">If applicable, a Certificate of Application providing you with the right to work (must always be dated within 6 months).</li>
                            </ul>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;"><strong>What You Need to Do:</strong>
                            </p>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;">Please submit your updated information regarding your Right-to-Work to the HR team no
                                later than <strong>15 days from the issuance of this letter. </strong>Failure to provide any update of your
                                information may result in a review of your ongoing employment.                                
                            </p>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;">
                                <strong>Employer's Responsibilities:</strong>
                            </p>
                            <ul style="list-style-type: disc; margin-left: 20px;">
                                <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">As required by the Immigration, Asylum, and Nationality Act 2006, we must ensure
                                    all employees have valid right-to-work documentation.</li>
                                <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">If necessary, we will contact the Home Office Employer Checking Service to confirm
                                    your application status. In case of a negative verification notice, we may not be able
                                    to continue your employment unless alternative evidence is provided.
                                </li>
                            </ul>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;">We understand that visa renewals can be a complex process. Please do not hesitate to contact
                                us at <strong>{{ $Roledata->email }}</strong> if you have any concerns or require assistance.
                            </p>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;"><strong>Next Steps:</strong></p>
                            <ol style="list-style-type: decimal; margin-left: 20px;">
                                <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">Gather and submit the required documents and update your visa application information promptly.</li>
                                <li style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">Reach out to HR for guidance if needed.</li>
                            </ol>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; color: #333;">Your cooperation is crucial to ensure compliance with employment and immigration laws,
                                and we are here to support you through this process.
                            </p>

                            
                        </td>
                    </tr>

                    <tr>
                        <td style=" padding: 0 20px;">
                            <p style="font-size: 10px; font-family: 'Times New Roman', Times, serif; text-align: justify; line-height: 1.2;">
                                <i><strong>Disclaimer:</strong> This email, including any attachments, is intended solely for the designated recipient(s) and may contain confidential or privileged information. Any unauthorized access,
                                    distribution, or reliance on its content without explicit written permission is strictly prohibited. If you have received this email in error, please delete all copies and notify the sender
                                    immediately, with a copy to {{ $Roledata->email }} .
                                </i>
                            </p>

                            <p style="font-size: 10px; font-family: 'Times New Roman', Times, serif; text-align: justify; line-height: 1.2;">
                                <i>
                                    Please note that this email does not guarantee a permanent position within the company. Employment status will be determined based on the terms outlined in your employment contract.
                                </i> 
                            </p>
                           
                            <p style="font-size: 10px; font-family: 'Times New Roman', Times, serif; text-align: justify; line-height: 1.2;">
                                <i>
                                    While <strong> {{$Roledata->com_name}} </strong> employs the latest virus protection measures, we strongly recommend conducting your own virus scan before opening any attachments. 
                                    {{$Roledata->com_name}} is not responsible for any loss or damage resulting from software viruses
                                </i> 
                            </p>    
                        </td>
                    </tr>

                    <!-- Footer -->


                    <tr>
                        <td height="20"></td>
                    </tr>

                    

                    <tr>
                        <td height="20"></td>
                    </tr>


                   

                    <tr>
                        <td height="30"></td>
                    </tr>

                    <tr>
                        <td style="text-align: left; color: #333; font-size: 16px; font-family: 'Times New Roman', Times, serif; padding: 0 20px; text-align: justify;">
                            <p style="margin: 0 0 10px;"><strong>Best regards,</strong></p>
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>

                    <tr>
                        <td style="padding: 0 20px;">
                            <p style="margin: 0 0 20px; font-size: 16px; font-family: 'Times New Roman', Times, serif; font-weight: bold; color: #0044cc;"><strong>{{ $Roledata->com_name }} HR Team</strong></p>
                        </td>
                    </tr>

                    <!-- Contact Info Section -->
                    <tr>
                        <td style="color: #333; font-size: 16px; font-family: 'Times New Roman', Times, serif; line-height: 1.8; padding: 0 20px;">
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
                            {{-- <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/telephone.png" alt="Landline"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Landline:</strong> {{ $Roledata->land }}
                            </p> --}}
                            <!-- Website -->
                            {{-- <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/web.png" alt="Website"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Website:</strong>
                                <a href="{{ $Roledata->website }}"
                                    style="color: #0044cc; text-decoration: none;">{{ $Roledata->website }}</a>
                            </p> --}}
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