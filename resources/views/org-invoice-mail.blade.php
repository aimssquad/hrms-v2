<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Email</title>
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
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; line-height: 1.2; color: #333;">Hello <b>{{ strtoupper($org_com_name) }}</b>,</p>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; line-height: 1.2; color: #333;">Thank you for your business with us! Your invoice ({{$invoice_no}}) is due for payment.</p>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; line-height: 1.2; color: #333;"><strong>Invoice Details:</strong></p>
                            <ul style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify;">
                                <li>Invoice Number:  {{$invoice_no}} </li>
                                <li>Item:  {{$item}} </li>
                                <li>Date Issued: {{$invoice_date}}</li>
                                @if(empty($vat) && empty($discount_amount))
                                <li>Amount Due: {{$amount}} </li>
                                @else
                                <li>Amount Due: {{ $total_amount }}</li>
                                @endif
                                
                            </ul>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; line-height: 1.2; color: #333;">
                                Please see the attached Invoice herewith the email.
                            </p>
                            <p style="font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; line-height: 1.2; color: #333;">
                                If you have made your payment within last 5 days please ignore this email. 
                            </p>
                        </td>
                    </tr>
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
                            <p style="margin: 0;">Reach out anytime at <a
                                    href="mailto: {{ $p_email }}">{{ $p_email }}</a> or
                                call <a href="tel: {{ $p_phone }}">{{ $p_phone }}</a></p>

                            <p>Let’s get started on your journey toward efficient HR and compliance!</p>
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>


                    <!-- Text Section -->

                    <tr>
                        <td style="padding: 0 20px;">
                            {{-- <img src="https://ik.imagekit.io/oq9hcqjih/main-logo.png" alt="" style="width: 150px;"> --}}
                        </td>
                    </tr>

                    <tr>
                        <td height="30"></td>
                    </tr>

                    <tr>
                        <td style="text-align: left; color: #333; font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; padding: 0 20px;">
                            <p style="margin: 0 0 10px;"><strong>Kind regards,</strong></p>
                        </td>
                    </tr>

                    <tr>
                        <td height="20"></td>
                    </tr>

                    <tr>
                        <td style="padding: 0 20px;">
                            <p style="margin: 0 0 20px; font-size: 16px; font-family: 'Times New Roman', Times, serif; text-align: justify; font-weight: bold; color: #0044cc;">{{$p_com_name}}
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
                                <a href="mailto:{{ $p_email }}"
                                    style="color: #0044cc; text-decoration: none;">{{ $p_email }}</a>
                            </p>
                            <!-- Phone -->
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/phone-call.png" alt="Phone"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Phone:</strong> {{ $p_phone }}
                            </p>
                            <!-- Landline -->
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/telephone.png" alt="Landline"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Landline:</strong> {{ $p_land }}
                            </p>
                            <!-- Website -->
                            <p style="margin: 5px 0;">
                                <img src="https://ik.imagekit.io/oq9hcqjih/web.png" alt="Website"
                                    style="width: 24px; vertical-align: middle; margin-right: 5px;">
                                <strong>Website:</strong>
                                <a href="https://{{$p_website}}"
                                    style="color: #0044cc; text-decoration: none;">{{$p_website}}</a>
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
                                        powered by <a href="#" style="color: #67839c;" target="_blank">{{ $p_com_name }}</a>
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