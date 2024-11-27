<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory;
    protected $fillable = [
        'bill_for',
        'billing_month',
        'billing_type',
        'entity_id',
        'amount',
        'total_employee',
        'vat',
        'total_amount',
        'payment_mode',
        'description',
        'invoice_no',
        'org_code',
    ];
}
