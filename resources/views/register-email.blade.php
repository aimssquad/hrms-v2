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
                            <img src="https://ik.imagekit.io/oq9hcqjih/banner-01.png" alt="" width="100%">
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding: 20px;">
                            <p style="font-size: 30px; color: #333;"><strong>Dear {{ strtoupper($com_name) }},</strong></p>
                            <p style="font-size: 30px; color: #333;">
                                Welcome to <strong>Skilled Workers Cloud HRMS !</strong> Thank you for registering with us. 
                                We are thrilled to have you onboard and are excited to support your HR and sponsorship compliance needs and to run your business operation smoothly! 
                            </p>

                            <p style="font-size: 30px; color: #333;">
                                As the next step, you need to complete your organization profile. 
                                This ensures a seamless process for utilizing our HRMS features and compliance services.
                            </p>
                            <p style="font-size: 30px; color: #333;"><strong>Click below to start your journey:</strong>
                            </p>
                            
                            <div style=" margin: 20px 0;">
                                <a href="https://skilledworkerscloud.co.uk/hrms-v2/register"
                                    style="text-decoration: none; color: #ffffff; background-color: #0044cc; padding: 10px 20px; border-radius: 5px; font-size: 30px;">👉
                                    Complete Your Organization Profile</a>
                            </div>

                            <p style="font-size: 30px; color: #333;"><strong>Your login details:</strong></p>
                            <p style="font-size: 30px; color: #333;"><strong>Username:</strong> {{ $email }}
                            </p>
                            <p style="font-size: 30px; color: #333;"><strong>Password:</strong> {{ $pass}}</p>

                            <p style="font-size: 30px; color: #333;"><strong>Helpful tips to complete your organization profile:</strong>
                            </p>
                            {{-- <ol style="font-size: 30px; color: #333;">
                                <li>Navigate to the ‘Organization Profile’ tab to begin.</li>
                                <li>Go to ‘Profile Status’ and fill in:</li>
                                <li>Basic business details: trading name, company registration number, business address, trading hours, and trading period.</li>
                                <li>Information about your authorizing officer (e.g., director or key employee). 
                                    This person will liaise with the Home Office regarding your sponsor license application.</li>
                                <li>Basic details of all employees for the hierarchy chart, a mandatory Home Office requirement.</li>
                                <li>Upload required documents under the ‘Documents’ section. Use the ‘Add’ button for additional uploads. </li>
                                <li>Make sure every field is filled out completely to ensure full compliances.</li>
                            </ol> --}}
                            <ol style="font-size: 30px; color: #333; line-height: 1.6;">
                                <li>Navigate to the <strong>‘Organization Profile’</strong> tab to begin.</li>
                                <li>Go to <strong>‘Profile Status’</strong> and fill in:
                                    <ul style="list-style-type: disc; margin-left: 20px;">
                                        <li>Basic business details: trading name, company registration number, business address, trading hours, and trading period.</li>
                                        <li>Information about your authorizing officer (e.g., director or key employee). This person will liaise with the Home Office regarding your sponsor license application.</li>
                                        <li>Basic details of all employees for the hierarchy chart, a mandatory Home Office requirement.</li>
                                    </ul>
                                </li>
                                <li>Upload required documents under the <strong>‘Documents’</strong> section. Use the <strong>‘Add’</strong> button for additional uploads</li>
                                <li>Make sure every field is filled out completely to ensure full compliances.</li>
                            </ol>
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
                        <td style="font-size: 30px; padding: 0 20px;">
                            <p style="margin: 0;">Our team is here to help! Reach out anytime at <a
                                    href="mailto: info@skilledworkerscloud.co.uk">info@skilledworkerscloud.co.uk</a> or
                                call <a href="tel:  +44 7467284718"> +44 7467284718</a></p>

                            <p style="font-size: 30px;">Let’s get started on your journey toward efficient HR and compliance!</p>
                        </td>
                    </tr>
                    <tr>
                        <td style="font-size: 20px; padding: 0 20px;">
                            <p style="font-size: 20px;"><strong>Disclaimer:</strong> This email, including any attachments, is intended solely for the designated recipient(s) and may contain confidential or
                                 privileged information. Unauthorized access, distribution, or reliance on its content without our explicit written permission is strictly prohibited. 
                                 If you have received this email in error, please delete all copies and notify the sender immediately, with a copy to info@skilledworkerscloud.co.uk.</p>
                            <p style="font-size: 20px;">
                                While <strong>Skilled Workers Cloud HRMS</strong> employs the latest virus protection measures, we strongly recommend conducting your own virus scan before opening any attachments.
                                 <strong>SWC HRMS</strong> is not responsible for any loss or damage resulting from software viruses.
                            </p>     
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>


                    <!-- Text Section -->

                    <tr>
                        <td style="padding: 0 20px;">
                            <img src="https://ik.imagekit.io/oq9hcqjih/main-logo.png" alt="" style="width: 350px;">
                        </td>
                    </tr>

                    <tr>
                        <td height="30"></td>
                    </tr>

                    <tr>
                        <td style="text-align: left; color: #333; font-size: 30px; padding: 0 20px;">
                            <p style="margin: 0 0 10px; padding-top: 10px;"><strong>Kind regards,</strong></p>
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>

                    <tr>
                        <td style="padding: 0 20px;">
                            <p style="margin: 0 0 20px; font-size: 30px; font-weight: bold; color: #0044cc;">SWC HRMS
                                Team</p>
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
                                <strong>Phone:</strong> +44 074 6728 4718
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