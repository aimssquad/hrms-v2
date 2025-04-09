<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>
</head>
<body style="font-family: Arial, sans-serif; margin: 0; padding: 20px;">

    <table style="width: 100%; border-collapse: collapse; max-width: 900px; margin: auto;" align="center">
        <tr>
            <td colspan="3" style="border: none; padding: 10px;">
                {{-- <img src="https://ik.imagekit.io/oq9hcqjih/main-logo.png?updatedAt=1733651934565" alt="Logo" style="height: 50px;"> --}}
                {{-- @if($p_logo) --}}
                <img src="{{$logo}}" alt="Logo" style="height: 50px;">
                {{-- @else 
                <h1>{{ strtoupper($p_com_name) }}</h1>
                @endif --}}
            </td>
            <td colspan="4" style="text-align: right; border: none; padding: 10px;">
                <strong style="font-size: 16px;">{{ strtoupper($p_com_name) }}</strong><br><br>
                {{ strtoupper($p_address) }}<br>
                {{ strtoupper("$p_road, $p_city") }}<br>
                {{ strtoupper("$p_zip, $p_country") }}<br>
                Mobile/Whats app : {{ $p_phone ?? '' }}<br>
                Landline : {{ $p_land }} <br>
                Email: {{ $p_email ?? ''}}<br>
                {{-- Website: <a href="https://skilledworkerscloud.co.uk/" style="text-decoration: none; color: #004AAD;">https://skilledworkerscloud.co.uk/</a> --}}
            </td>
        </tr>
        
        <tr><td colspan="7" style="height: 20px;"></td></tr>

        <tr>
            <td colspan="4" style="border: none; padding: 10px;">
                <strong>Invoice To:</strong> {{ strtoupper($org_com_name) }}<br>
                <strong>Address: </strong>{{ucfirst($org_address)}}<br>
                {{-- {{ ucfirst("$org_road, $org_city") }}<br>
                {{ ucfirst("$org_zip, $org_country") }}<br> --}}
                {{ucfirst($org_phone)}}<br>
                <a href="mailto:{{$org_email}}" style="text-decoration: none; color: #004AAD;">{{$org_email}}</a>
            </td>
            <td colspan="3" style="text-align: right; border: none; padding: 10px;">
                <strong>Date:</strong> {{ isset($invoice_date) ? \Carbon\Carbon::parse($invoice_date)->format('d/m/Y') : 'NA' }}<br>
                <strong>Invoice No:</strong> {{$invoice_no}}
            </td>
        </tr>
        
        <tr><td colspan="7" style="height: 20px;"></td></tr>

        <tr style="background-color: #f5f5f5;">
            <th style="font-size:12px; padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">#</th>
            <th style="font-size:12px; padding: 10px; text-align: left; border-bottom: 1px solid #ddd;">Item Name</th>
            <th style="font-size:12px; padding: 10px; text-align: center; border-bottom: 1px solid #ddd;">Quantity</th>
            <th style="font-size:12px; padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">Unit Price</th>
            <th style="font-size:12px; padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">Unit Price Exc.VAT</th>
            <th style="font-size:12px; padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">Discount</th>
            <th style="font-size:12px; padding: 10px; text-align: right; border-bottom: 1px solid #ddd;">Total</th>
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
                    $grand_total = $total_amount;
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
                    @if(empty($vat) && empty($discount_amount))
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
            <td colspan="7" style="border: none; padding: 10px;">
                {{-- <strong>Payment Method:</strong> {{$payment_mode}}  --}}
                <div style="display: block; margin-bottom: 8px;">
                <strong>Payment Method:</strong> {{ $payment_mode }}
                </div>
                <i><strong>Disclaimer :</strong> This is a system generated Invoice and does not require any signature or Stamp.</i>
            </td>
            
            {{-- <td colspan="3" style="border: none; padding: 10px; text-align: right;"></td> --}}
        </tr>
        <tr>
            <td colspan="7" style="height: 100px;"></td>
        </tr>
        <tr>
            <td colspan="4" style="border: none; padding: 10px;"></td>
            <td colspan="3" style="border: none; padding: 10px; text-align: right;">
                {{-- <strong style="font-size:12px;">Disclaimer :-</strong> <i style="font-size:12px;">This is a system generated Invoice and does not require any signature or Stamp.</i><br> --}}
                <i>Thank you for your customs !</i>
            </td>
        </tr>
        <tr>
            <td colspan="7" style="height: 150px;"></td>
        </tr>
        <tr>
            <td colspan="7" style="border: none; text-align:center; padding: 10px;">
                Website: <a href="{{ $p_website }}" style="text-decoration: none; color: #004AAD;">{{ $p_website ?? ""}}</a>
            </td>
           
        </tr>
    </table>

</body>
</html>