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
                <strong style="font-size: 16px;">SKILLED WORKERS CLOUD LTD.</strong><br><br>
                G21, Unit 3, Triangle Centre,<br>
                399 Uxbridge Road<br>
                UB1 3EJ, United Kingdom<br>
                Mobile/Whats app : 07467284718<br>
                Landline : +44 0208 129 1655
                <br>
                Email: info@skilledworkerscloud.co.uk<br>
                {{-- Website: <a href="https://skilledworkerscloud.co.uk/" style="text-decoration: none; color: #004AAD;">https://skilledworkerscloud.co.uk/</a> --}}
            </td>
        </tr>
        
        <tr><td colspan="7" style="height: 20px;"></td></tr>

        <tr>
            <td colspan="4" style="border: none; padding: 10px;">
                <strong>Invoice To:</strong> {{ strtoupper("$f_name $l_name") }}<br>
                <strong>Address: </strong>{{ucfirst($address)}}<br>
                {{ ucfirst("$city $road $zip") }}<br>
                {{ucfirst($p_no)}}<br>
                <a href="mailto:{{$email}}" style="text-decoration: none; color: #004AAD;">{{$email}}</a>
            </td>
            <td colspan="3" style="text-align: right; border: none; padding: 10px;">
                <strong>Invoice Date:</strong> {{ isset($invoice_date) ? \Carbon\Carbon::parse($invoice_date)->format('d/m/Y') : 'NA' }}<br>
                <strong>Invoice No:</strong> {{$invoice_no}}
            </td>
        </tr>
        
        <tr><td colspan="7" style="height: 20px;"></td></tr>

        <tr style="background-color: #f5f5f5;">
            <th style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">#</th>
            <th style="padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">Item Name</th>
            <th style="padding: 10px; text-align: center; border-bottom: 1px solid #ddd;">Quantity</th>
            <th style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">Unit Price</th>
            <th style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">Unit Price Excluding VAT</th>
            <th style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">Discount</th>
            <th style="padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">Total</th>
        </tr>

        <tr>
            <td style="padding: 10px; border-bottom: 1px solid #eee;">1</td>
            <td style="padding: 10px; border-bottom: 1px solid #eee;">{{$item}}</td>
            <td style="padding: 10px; text-align: center; border-bottom: 1px solid #eee;"></td>
            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;"></td>
            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">{{$amount}}</td>
            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">{{$discount_amount ?? '0.00'}}</td>
            <td style="padding: 10px; text-align: right; border-bottom: 1px solid #eee;">
                @php
                    $subtotal = $discount_amount ? ($amount - $discount_amount) : $amount;
                    echo number_format($subtotal, 2);
                @endphp
            </td>
        </tr>

        <!-- Payment Summary Section -->
        <tr>
            <td colspan="4" style="border: none; padding: 10px;">
               
            </td>
            <td colspan="3" style="border: none; padding: 10px; text-align: right;">
                @php
                    $vat_amount = $vat ? ($subtotal * $vat / 100) : 0;
                    $grand_total = $total_amount ?: ($subtotal + $vat_amount);
                @endphp
                
                @if($vat)
                <div style="margin-bottom: 5px;">
                    <span style="margin-right: 20px;"><strong>VAT ({{$vat}}%):</strong></span>
                    <span>{{ number_format($vat_amount, 2) }}</span>
                </div>
                @endif
                
                <div style="margin-bottom: 5px;">
                    <span style="margin-right: 20px;"><strong>Subtotal:</strong></span>
                    <span>{{ number_format($subtotal, 2) }}</span>
                </div>
                
                <div style="margin-top: 10px; font-size: 1.1em;">
                    <span style="margin-right: 20px;"><strong>Total Paid:</strong></span>
                    @if(empty($vat) || empty($discount_amount))
                        <span style="color: #004AAD; font-weight: bold;">{{ number_format($amount, 2) }}</span>
                    @else
                        <span style="color: #004AAD; font-weight: bold;">{{ number_format($grand_total, 2) }}</span>
                    @endif
                    
                </div>
            </td>
        </tr>

        <tr>
            <td colspan="7" style="height: 45px;"></td>
        </tr>

        <tr>
            <td colspan="4" style="border: none; padding: 10px;">
                <strong>Payment Method:</strong> {{$payment_mode}}
            </td>
            <td colspan="3" style="border: none; padding: 10px; text-align: right;"></td>
        </tr>
        <tr>
            <td colspan="7" style="height: 100px;"></td>
        </tr>
        <tr>
            <td colspan="4" style="border: none; padding: 10px;"></td>
            <td colspan="3" style="border: none; padding: 10px; text-align: right;"><i>Thank you for your customs !</i></td>
        </tr>
        <tr>
            <td colspan="7" style="height: 100px;"></td>
        </tr>
        <tr>
            <td colspan="7" style="border: none; text-align:center; padding: 10px;">
                Website: <a href="https://skilledworkerscloud.co.uk/" style="text-decoration: none; color: #004AAD;">www.//skilledworkerscloud.co.uk/</a>
            </td>
           
        </tr>
    </table>

</body>
</html>