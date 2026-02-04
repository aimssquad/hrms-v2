<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    protected $table = 'invoice_items';

    protected $fillable = [
        'invoice_id',
        'emid',
        'service_name',
        'quantity',
        'unit_price',
        'discount',
        'discount_type',
        'tax_percent',
        'tax_type',
        'sub_total',
    ];

    /**
     * Item belongs to an invoice
     */
    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoice_id');
    }

}
