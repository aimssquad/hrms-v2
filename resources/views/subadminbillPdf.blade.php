<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
    <style>
        @page {
            size: A4;
            margin: 1cm;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 12px;
            position: relative;
            min-height: 100vh;
        }
        .content {
            padding-bottom: 60px; /* Space for footer */
        }
        .footer {
            position: absolute;
            bottom: 0;
            width: 100%;
            max-width: 700px;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            font-size: 10px;
            padding: 5px 0;
        }
    </style>
</head>
<body style="margin: 0; padding: 15px; font-family: Arial, sans-serif; position: relative; min-height: 100vh;">

<div class="content" style="width: 100%; max-width: 700px; margin: 0 auto; padding-bottom: 60px;">
    <!-- Header -->
    <div style="margin-bottom: 15px;">
        <div style="float: left; width: 40%;">
            <img src="https://ik.imagekit.io/oq9hcqjih/main-logo.png?updatedAt=1733651934565" alt="Logo" style="height: 90px;">
        </div>
        <div style="float: right; width: 60%; text-align: right; line-height: 1.3; font-size: 16px;">
            <strong style="font-size: 18px;">SKILLED WORKERS CLOUD LTD.</strong><br>
            Suite 602, 6th Floor, 252-262 Romford Road, <br>
            London, E7 9HZ United Kingdom<br>
            Landline: +44 0208 129 1655<br>
            Mobile/WhatsApp: +44 (0)7467284718<br>
            Email: <a href="mailto:info@skilledworkerscloud.co.uk">info@skilledworkerscloud.co.uk</a>
        </div>
        <div style="clear: both;"></div>
    </div>
    <div style='height:10px;'></div>
    <!-- Blue Divider -->
    <div style="height: 14px; background-color: #154377; margin: 15px 0;"></div>
    <div style='height:10px;'></div>
    <!-- Bill To and Invoice Details -->
    <div style="margin-bottom: 15px;">
        <div style="float: left; width: 60%; font-size: 16px;">
            <strong>Invoice To:</strong><br>
            {{ strtoupper("$com_name") }}<br>
            {{ucfirst($address)}}<br>
            {{ ucfirst("$city $road $zip") }}<br>
            United Kingdom<br>
            Mobile: {{ucfirst($p_no)}}
        </div>
        <div style="float: right; width: 40%; text-align: right; font-size: 16px;">
            <strong>Date:</strong> {{ isset($invoice_date) ? \Carbon\Carbon::parse($invoice_date)->format('d F Y') : 'NA' }}
            <br><strong>Invoice no:</strong> {{$invoice_no}}
            
        </div>
        <div style="clear: both;"></div>
    </div>

    <!-- Items Table -->
    <table style="width: 100%; border-collapse: collapse; margin-bottom: 15px; font-size: 16px;">
        <thead>
            <tr style="background-color: #f5f5f5;">
                <th style="padding: 5px; text-align: left; border: 1px solid #ddd; width: 5%;">Sl. no</th>
                <th style="padding: 5px; text-align: left; border: 1px solid #ddd; width: 35%;">Item Name</th>
                <th style="padding: 5px; text-align: center; border: 1px solid #ddd; width: 8%;">Quantity</th>
                <th style="padding: 5px; text-align: right; border: 1px solid #ddd; width: 12%;">Unit Price</th>
                <th style="padding: 5px; text-align: right; border: 1px solid #ddd; width: 15%;">Unit Price Exc. VAT</th>
                <th style="padding: 5px; text-align: right; border: 1px solid #ddd; width: 15%;">Discount</th>
                <th style="padding: 5px; text-align: right; border: 1px solid #ddd; width: 10%;">Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding: 5px; ">1</td>
                <td style="padding: 5px; ">{{$item}}</td>
                <td style="padding: 5px; text-align: center; "></td>
                <td style="padding: 5px; text-align: right; "></td>
                <td style="padding: 5px; text-align: right; ">£{{number_format($amount, 2)}}</td>
                <td style="padding: 5px; text-align: right; ">£{{number_format($discount_amount ?? 0, 2)}}</td>
                @php
                $subtotal = $discount_amount ? ($amount - $discount_amount) : $amount;
                   // echo number_format($subtotal, 2);
                @endphp
                <td style="padding: 5px; text-align: right; ">£{{number_format($subtotal, 2)}}</td>
            </tr>
            @php
                $vat_amount = $vat ? ($subtotal * $vat / 100) : 0;
                $grand_total = $total_amount ?($subtotal + $vat_amount):$amount;
            @endphp
            @if($vat)
            <tr>
                <td style="padding: 5px; "></td>
                <td style="padding: 5px; "></td>
                <td style="padding: 5px; "></td>
                <td style="padding: 5px; "></td>
                <td style="padding: 5px; "></td>
                <td style="padding: 5px; text-align: right; "><strong>VAT({{$vat}}%)</strong></td>
                <td style="padding: 5px; text-align: right; ">£{{number_format($vat_amount, 2)}}</td>
            </tr>
            @endif
            <tr>
                <td style="padding: 5px; "></td>
                <td style="padding: 5px;  font-size: 12px;">Remarks: {{strip_tags($remarks ?? '')}}</td>
                <td style="padding: 5px; "></td>
                <td style="padding: 5px; "></td>
                <td style="padding: 5px; "></td>
                <td style="padding: 5px; text-align: right; "><strong>Sub Total</strong></td>
                <td style="padding: 5px; text-align: right; ">£{{number_format($subtotal, 2)}}</td>
            </tr>
            <tr>
                <td style="padding: 5px; "></td>
                <td style="padding: 5px; "></td>
                <td style="padding: 5px; "></td>
                <td style="padding: 5px; "></td>
                <td style="padding: 5px; "></td>
                <td style="padding: 5px; text-align: right; "><strong>Total Paid</strong></td>
                <td style="padding: 5px; text-align: right; ">£{{number_format($grand_total, 2)}}</td>
            </tr>
            {{-- <tr>
                <td style="padding: 5px; border: 1px solid #eee;"></td>
                <td style="padding: 5px; border: 1px solid #eee;"></td>
                <td style="padding: 5px; border: 1px solid #eee;"></td>
                <td style="padding: 5px; border: 1px solid #eee;"></td>
                <td style="padding: 5px; border: 1px solid #eee;"></td>
                <td style="padding: 5px; text-align: right; border: 1px solid #eee;"><strong>Due</strong></td>
                <td style="padding: 5px; text-align: right; border: 1px solid #eee;">NIL</td>
            </tr> --}}
        </tbody>
    </table>

    <!-- Billing Details -->
    <div style="margin-bottom: 10px; font-size: 16px;">
        <h4 style="margin: 5px 0; font-size: 18px;">Billing Details</h4>
        <div style="line-height: 1.5;">
            <strong>Bank Name:</strong> Barclays Plc<br>
            <strong>Account Name:</strong> Skilled Workers Cloud Ltd<br>
            <strong>Sort Code:</strong> 20-41-50<br>
            <strong>Account No.</strong> 7303 0849<br>
            <strong>Payment Method:</strong> Online/Offline
        </div>
    </div>
    <div style='height:40px;'></div>
    <!-- Thank You -->
    <div style="text-align: right; margin-bottom: 10px; font-style: italic; font-size: 16px;">
        Thank you for your business!
    </div>
    <div style='height:100px;'></div>
    <!-- Disclaimer -->
    <div style="font-style: italic; font-size: 16px; margin-bottom: 25px;">
        <strong>Disclaimer :</strong> This is a system generated Invoice and does not require any signature or Stamp.
    </div>
    
    <!-- Blue Divider -->
    <div style="height: 14px; background-color: #154377; margin: 10px 0;"></div>
</div>
<!-- Fixed Footer -->
<div class="footer" style="position: absolute; bottom: 0; width: 100%; max-width: 700px; left: 50%; transform: translateX(-50%); text-align: center; font-size: 16px; padding: 5px 0;">
   <b style="font-size: 14px;">Registered Office: Suite 602, 6th Floor, 252-262 Romford Road, London, E7 9HZ United Kingdom</b><br>
    Landline: +44 0208 129 1655 Mobile: +44 (0)7467284718<br>
    Email: <a href="mailto:info@skilledworkerscloud.co.uk" style="color: #000080; text-decoration: none;">info@skilledworkerscloud.co.uk</a> 
    Web: <a href="https://www.skilledworkerscloud.co.uk" style="color: #000080; text-decoration: none;">www.skilledworkerscloud.co.uk</a>
</div>

</body>
</html>