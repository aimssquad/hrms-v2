<!DOCTYPE html>
<html>
<head>
    <title>Invoice</title>

    <style>
        @page { size: A4; margin: 1cm; }

        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
        }

        .content {
            width: 100%;
            max-width: 700px;
            margin: 0 auto;
            padding-bottom: 80px;
        }

        .footer {
            position: fixed;
            bottom: 10px;
            width: 100%;
            max-width: 700px;
            left: 50%;
            transform: translateX(-50%);
            text-align: center;
            font-size: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 6px;
            border: 1px solid #ddd;
        }

        th {
            background: #f5f5f5;
            font-weight: bold;
        }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
    </style>
</head>

<body>

@php
    $guest = $invoice->guest;

    $currencySymbol = match ($invoice->country) {
        'India'   => '₹',
        'England' => '£',
        'USA'     => '$',
        default   => ''
    };

    $taxLabel = match($invoice->country) {
        'India' => 'GST',
        'England' => 'VAT',
        default => 'Sales Tax'
    };

    $subTotal = 0;
    $totalTax = 0;
@endphp

<div class="content">

    <!-- HEADER -->
    <table style="border:none;">
        <tr style="border:none;">
            <td style="border:none; width:40%;">
                <img src="{{ public_path('storage/'.$organization->logo) }}" style="height:90px;">
            </td>
            <td style="border:none; width:60%; text-align:right; font-size:14px;">
                <strong style="font-size:16px;">{{ $organization->com_name }}</strong><br>
                {{ $organization->address }}<br>
                Email: {{ $organization->email }}
                <br>
                Phone: {{ $organization->p_no }}
                <br>
                Website: {{ $organization->website }}
            </td>
        </tr>
    </table>

    <!-- BLUE BAR -->
    <div style="height:14px; background:#154377; margin:15px 0;"></div>

    <!-- INVOICE INFO -->
    <table style="border:none; margin-bottom:15px;">
        <tr style="border:none;">
            <td style="border:none; font-size:14px;">
                <strong>Invoice To:</strong><br>
                {{ $guest->name }}<br>
                {{ $guest->company_name }}<br>
                {{ $guest->address }}<br>
                Phone: {{ $guest->phone }}
                <br>
                Email: {{ $guest->email }}
                <br>
                {{ $taxLabel }} : {{ $guest->tax_no }}
            </td>
            <td style="border:none; text-align:right; font-size:14px;">
                <strong>Date:</strong> {{ \Carbon\Carbon::parse($invoice->invoice_date)->format('d F Y') }}<br>
                <strong>Invoice No:</strong> {{ $invoice->invoice_no }}<br>
                <strong>Currency:</strong> {{ $invoice->currency }}
            </td>
        </tr>
    </table>

    <!-- ITEMS TABLE -->
    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="28%">Service</th>
                <th width="8%">Qty</th>
                <th width="12%">Unit Price</th>
                <th width="12%">Discount</th>
                <th width="10%">{{ $taxLabel }} %</th>
                <th width="12%">Taxable</th>
                <th width="13%">Total</th>
            </tr>
        </thead>

        <tbody>
        @foreach($invoice->items as $key => $item)

            @php
                // 1️⃣ BASE PRICE
                $basePrice = $item->quantity * $item->unit_price;

                // 2️⃣ DISCOUNT
                if ($item->discount_type === 'percentage_discount') {
                    $discountAmount = ($basePrice * $item->discount) / 100;
                } else {
                    $discountAmount = $item->discount;
                }

                $netAmount = $basePrice - $discountAmount;
                if ($netAmount < 0) $netAmount = 0;

                // 3️⃣ TAX
                if ($item->tax_type === 'inclusive') {
                    $taxAmount  = $netAmount - ($netAmount / (1 + $item->tax_percent / 100));
                    $lineTotal  = $netAmount;
                    $baseAmount = $netAmount - $taxAmount;
                } else {
                    $taxAmount  = ($netAmount * $item->tax_percent) / 100;
                    $baseAmount = $netAmount;
                    $lineTotal  = $netAmount + $taxAmount;
                }

                $subTotal += $baseAmount;
                $totalTax += $taxAmount;
            @endphp

            <tr>
                <td class="text-center">{{ $key+1 }}</td>
                <td>{{ $item->service_name }}</td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-right">{{ $currencySymbol }} {{ number_format($item->unit_price,2) }}</td>

                <td class="text-right">
                    {{ $currencySymbol }} {{ number_format($item->discount,2) }}<br>
                    <small>({{ str_replace('_',' ', $item->discount_type) }})</small>
                </td>

                <td class="text-center">
                    {{ $item->tax_percent }}%<br>
                    <small>({{ ucfirst($item->tax_type) }})</small>
                </td>

                <td class="text-right">{{ $currencySymbol }} {{ number_format($taxAmount,2) }}</td>
                <td class="text-right">{{ $currencySymbol }} {{ number_format($baseAmount,2) }}</td>
            </tr>

        @endforeach
        </tbody>
    </table>

    <!-- TOTALS -->
    <table style="margin-top:10px;">
        <tr>
            <td style="border:none;"></td>
            <td style="border:none;"></td>
            <td style="border:none;"></td>
            <td style="border:none;"></td>
            <td style="border:none;"></td>
            <td class="text-right"><strong>Sub Total</strong></td>
            <td class="text-right">{{ $currencySymbol }} {{ number_format($subTotal,2) }}</td>
        </tr>

        <tr>
            <td colspan="5" style="border:none;"></td>
            <td class="text-right"><strong>{{ $taxLabel }} Total</strong></td>
            <td class="text-right">{{ $currencySymbol }} {{ number_format($invoice->total_tax,2) }}</td>
        </tr>

        <tr>
            <td colspan="5" style="border:none;"></td>
            <td class="text-right"><strong>Grand Total</strong></td>
            <td class="text-right"><strong>{{ $currencySymbol }} {{ number_format($invoice->grand_total,2) }}</strong></td>
        </tr>
    </table>

    <!-- DISCLAIMER -->
    <div style="margin-top:75px; font-style:italic; font-size:12px;">
        <strong>Disclaimer:</strong> This is a system generated Invoice and does not require any signature or stamp.
    </div>

    <!-- BLUE BAR -->
    

</div>

<!-- FOOTER -->
<div class="footer">
    <div style=" margin-botom:25px; height:14px; background:#154377; margin:20px 0;"></div>
    <strong>Registered Office:</strong> {{ $organization->address }}<br>
    Email: {{ $organization->email }}
    <br>
    Phone: {{ $organization->p_no }}
    <br>
    Website: {{ $organization->website }}
</div>

</body>
</html>
