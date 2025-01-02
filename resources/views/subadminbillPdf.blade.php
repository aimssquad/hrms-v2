<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing Invoice</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 5%; background-color: #f9f9f9;">
    <div style="width: 100%; max-width: 550px; margin: 0 auto; background: #ffffff; border: 1px solid #dddddd; border-radius: 5px; overflow: hidden;">
        <!-- Header Section -->
        <div style="background-color: #FF902F; color: white; padding: 20px; text-align: center;">
            <h1 style="margin: 0;">Invoice</h1>
        </div>

        <!-- Content Section -->
        <div style="padding: 20px;">
            <h2>Dear {{ $subadmin_name }},</h2>
            <p style="margin: 10px 0; color: #555555;">We hope this email finds you well. Please find below the details of your recent billing:</p>

            <!-- Billing Details Table -->
            <table style="border-collapse: collapse; width: 100%; margin: 20px 0;">
                <tr>
                    <th style="border: 1px solid #dddddd; padding: 8px; background-color: #f4f4f4;">Invoice Number</th>
                    <td style="border: 1px solid #dddddd; padding: 8px;">{{ $Invoice_no }}</td>
                </tr>
                <tr>
                    <th style="border: 1px solid #dddddd; padding: 8px; background-color: #f4f4f4;">Billing Date</th>
                    <td style="border: 1px solid #dddddd; padding: 8px;">{{ $Billing_date }}</td>
                </tr>
                <tr>
                    <th style="border: 1px solid #dddddd; padding: 8px; background-color: #f4f4f4;">Billing For</th>
                    <td style="border: 1px solid #dddddd; padding: 8px;">{{ $Billing_for }}</td>
                </tr>
                <tr>
                    <th style="border: 1px solid #dddddd; padding: 8px; background-color: #f4f4f4;">Organization Name</th>
                    <td style="border: 1px solid #dddddd; padding: 8px;">{{ $organization_name }}</td>
                </tr>
                <tr>
                    <th style="border: 1px solid #dddddd; padding: 8px; background-color: #f4f4f4;">Total Amount</th>
                    <td style="border: 1px solid #dddddd; padding: 8px;">{{ $Total_amount }}</td>
                </tr>
                <tr>
                    <th style="border: 1px solid #dddddd; padding: 8px; background-color: #f4f4f4;">VAT</th>
                    <td style="border: 1px solid #dddddd; padding: 8px;">{{ $Vat }}%</td>
                </tr>
                <tr>
                    <th style="border: 1px solid #dddddd; padding: 8px; background-color: #f4f4f4;">Discount</th>
                    <td style="border: 1px solid #dddddd; padding: 8px;">{{ $Discount }}</td>
                </tr>
            </table>

            <p style="margin: 10px 0; color: #555555;">If you have any questions regarding this invoice, please feel free to contact us at {{ $subadmin_email }}</p>

            <p style="margin: 10px 0; color: #555555;">Thank you for your business!</p>
        </div>

        <!-- Footer Section -->
        <div style="background-color: #FF902F; padding: 20px; text-align: center; font-size: 14px; color: #fcfbfb;">
            <p>&copy; {{ $subadmin_name }} | All rights reserved.</p>
            <p>{{ $subadmin_email }}</p>
        </div>
    </div>
</body>
</html>
