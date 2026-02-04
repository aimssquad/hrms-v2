<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    protected $table = 'invoices';

    protected $fillable = [
        'invoice_no',
        'guest_id',
        'emid',
        'country',
        'currency',
        'invoice_date',
        'invoice_send',
        'referance_no',
        'remarks',
        'total_tax',
        'grand_total',
    ];

    /**
     * Invoice belongs to a Guest (Customer)
     */
    public function guest()
    {
        return $this->belongsTo(Guest::class, 'guest_id');
    }

    /**
     * Invoice has many items
     */
    public function items()
    {
        return $this->hasMany(InvoiceItem::class, 'invoice_id');
    }


}
