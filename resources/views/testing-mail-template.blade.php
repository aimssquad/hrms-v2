<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 20px;">

    <table style="width: 100%; border-collapse: collapse; max-width: 900px; margin: auto;" align="center">
        <tr>
            <td colspan="3" style="border: none; padding: 10px;">
                <img src="https://ik.imagekit.io/oq9hcqjih/main-logo.png?updatedAt=1733651934565" alt="Logo" style="height: 50px;">
            </td>
            <td colspan="4" style="text-align: right; border: none; padding: 10px;">
                <strong style="font-size: 16px;">SKILLED WORKERS CLOUD LTD.</strong><br>
                G21, Unit 3, Triangle Centre,<br>
                399 Uxbridge Road<br>
                UB1 3EJ, United Kingdom<br>
                Mobile: 07467284718<br>
                Email: info@skilledworkerscloud.co.uk<br>
                Website: <a href="https://skilledworkerscloud.co.uk/" style="text-decoration: none; color: #004AAD;">https://skilledworkerscloud.co.uk/</a>
            </td>
        </tr>
        
        <tr><td colspan="7" style="height: 20px;"></td></tr>

        <tr>
            <td colspan="3" style="border: none; padding: 10px;">
                <strong>Invoice To:</strong> {{ strtoupper($com_name) }}<br>
                <strong>Address: {{strtoupper($address)}}</strong><br>
                <strong>City: {{strtoupper($city)}}</strong><br>
                <strong>{{ strtoupper("$road $zip") }}</strong><br>
                {{ strtoupper("$f_name $l_name") }}<br>
                {{strtoupper($p_no)}}<br>
                <a href="mailto:{{$email}}" style="text-decoration: none; color: #004AAD;">{{$email}}</a>
            </td>
            <td colspan="4" style="text-align: right; border: none; padding: 10px;">
                <strong>Invoice No:</strong> {{$invoice_no}}<br>
                <strong>Invoice Date:</strong> {{ isset($invoice_date) ? \Carbon\Carbon::parse($invoice_date)->format('d/m/Y') : 'NA' }}
            </td>
        </tr>
        
        <tr><td colspan="7" style="height: 20px;"></td></tr>

        <tr style="background-color: #fff;">
            <td style="padding: 10px;"><strong>#</strong></td>
            <td style="padding: 10px;"><strong>Item Name</strong></td>
            <td style="padding: 10px;"><strong>Quantity</strong></td>
            <td style="padding: 10px;"><strong>Unit Price</strong></td>
            <td style="padding: 10px;"><strong>Unit Price Excluding VAT</strong></td>
            <td style="padding: 10px;"><strong>Discount</strong></td>
            <td style="padding: 10px;"><strong>Total</strong></td>
        </tr>

        <tr>
            <td style="padding: 10px;">1</td>
            <td style="padding: 10px;">{{$item}}</td>
            <td style="padding: 10px;"></td>
            <td style="padding: 10px;"></td>
            <td style="padding: 10px;"></td>
            <td style="padding: 10px;">{{$amount}}</td>
            <td style="padding: 10px;">
                @php
                    $subtotal = $discount_amount ? ($amount - $discount_amount) : $amount;
                    echo number_format($subtotal, 2);
                @endphp
            </td>
        </tr>
        @php
            $vat_amount = $vat ? ($subtotal * $vat / 100) : 0;
            $grand_total = $total_amount ?: ($subtotal + $vat_amount);
        @endphp
        @if($vat)
        <tr>
            <td colspan="3"></td>
            <td colspan="4" style="padding: 10px; text-align: right;"><strong>Vat({{$vat}}):</strong> <span style="color: #004AAD;">{{ number_format($vat_amount, 2) }} </span></td>
        </tr>
        @endif
        <tr>
            <td height="20"></td>
        </tr>
        <tr>
            <td colspan="3" style="padding: 10px; border-bottom: 2px solid #ddd;"><strong>Payment Method:</strong> {{$payment_mode}}</td>
            <td colspan="4" style="padding: 10px; text-align: right; border-bottom: 2px solid #ddd;"><strong>Subtotal:</strong> {{ number_format($subtotal, 2) }}</td>
        </tr>
        <tr>
            <td colspan="3"></td>
            <td colspan="4" style="padding: 10px; text-align: right;"><strong>Total Paid:</strong> <span style="color: #004AAD;">{{ number_format($grand_total, 2) }}</span></td>
        </tr>

        <tr><td colspan="7" style="height: 20px;"></td></tr>
    </table>

</body>
</html>