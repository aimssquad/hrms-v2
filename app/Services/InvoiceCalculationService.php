<?php

namespace App\Services;

use App\Models\TaxRate;

class InvoiceCalculationService
{
    public function calculate(array $data): array
    {
        $items = $data['items'];

        $subtotal = collect($items)->sum(fn ($i) =>
            $i['quantity'] * $i['unit_price']
        );

        /** DISCOUNT */
        $discountTotal = 0;
        if (($data['discount_type'] ?? null) === 'percent') {
            $discountTotal = ($subtotal * $data['discount_value']) / 100;
        } elseif (($data['discount_type'] ?? null) === 'flat') {
            $discountTotal = min($data['discount_value'], $subtotal);
        }

        $taxSystemId = $data['tax_system_id'];
        $taxSystem = strtolower($data['billing_country']);

        $calculatedItems = [];
        $totalTax = 0;

        foreach ($items as $item) {

            $lineSubtotal = $item['quantity'] * $item['unit_price'];
            $itemDiscount = ($lineSubtotal / $subtotal) * $discountTotal;
            $taxableAmount = $lineSubtotal - $itemDiscount;

            /** COUNTRY SPECIFIC TAX */
            if ($taxSystem === 'in') {
                $taxData = $this->applyIndiaGST($taxSystemId, $taxableAmount, $data);
            } elseif ($taxSystem === 'uk') {
                $taxData = $this->applyUKVAT($taxSystemId, $taxableAmount);
            } elseif ($taxSystem === 'us') {
                $taxData = $this->applyUSTax($taxSystemId, $taxableAmount, $data);
            } else {
                $taxData = ['taxes' => [], 'total_tax' => 0];
            }

            $totalTax += $taxData['total_tax'];

            $calculatedItems[] = [
                'item_name'       => $item['item_name'],
                'quantity'        => $item['quantity'],
                'unit_price'      => $item['unit_price'],
                'line_subtotal'   => round($lineSubtotal, 2),
                'discount_amount' => round($itemDiscount, 2),
                'taxable_amount'  => round($taxableAmount, 2),
                'tax_amount'      => round($taxData['total_tax'], 2),
                'line_total'      => round($taxableAmount + $taxData['total_tax'], 2),
                'taxes'           => $taxData['taxes']
            ];
        }

        return [
            'subtotal'       => round($subtotal, 2),
            'discount_total' => round($discountTotal, 2),
            'tax_total'      => round($totalTax, 2),
            'grand_total'    => round(($subtotal - $discountTotal + $totalTax), 2),
            'items'          => $calculatedItems
        ];
    }

    /** 🇮🇳 INDIA GST */
    private function applyIndiaGST(int $taxSystemId, float $amount, array $data): array
    {
        $sameState = ($data['billing_state'] === $data['company_state']);

        $taxTypes = $sameState
            ? ['CGST', 'SGST']
            : ['IGST'];

        $taxRates = TaxRate::where('tax_system_id', $taxSystemId)
            ->whereIn('tax_type', $taxTypes)
            ->get();

        return $this->calculateTaxes($taxRates, $amount);
    }

    /** 🇬🇧 UK VAT */
    private function applyUKVAT(int $taxSystemId, float $amount): array
    {
        $taxRates = TaxRate::where('tax_system_id', $taxSystemId)
            ->where('tax_type', 'VAT')
            ->get();

        return $this->calculateTaxes($taxRates, $amount);
    }

    /** 🇺🇸 USA SALES TAX */
    private function applyUSTax(int $taxSystemId, float $amount, array $data): array
    {
        $taxRates = TaxRate::where('tax_system_id', $taxSystemId)
            ->where(function ($q) use ($data) {
                $q->whereNull('state_code')
                  ->orWhere('state_code', $data['billing_state'] ?? null);
            })
            ->where(function ($q) use ($data) {
                $q->whereNull('city_code')
                  ->orWhere('city_code', $data['billing_city'] ?? null);
            })
            ->get();

        return $this->calculateTaxes($taxRates, $amount);
    }

    /** COMMON TAX CALCULATOR */
    private function calculateTaxes($taxRates, float $amount): array
    {
        $taxes = [];
        $totalTax = 0;

        foreach ($taxRates as $tax) {
            $taxAmount = round(($amount * $tax->rate) / 100, 2);

            $taxes[] = [
                'tax_type'   => $tax->tax_type,
                'tax_rate'   => $tax->rate,
                'tax_amount' => $taxAmount
            ];

            $totalTax += $taxAmount;
        }

        return [
            'taxes'     => $taxes,
            'total_tax' => $totalTax
        ];
    }
}
