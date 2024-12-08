<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subadmin_bill extends Model
{
    use HasFactory;
    protected $fillable = [
        'bill_for',
        'discount_amount',
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
        'remarks',
        'date',
        'payment_description',
        'payment_dtl',
        'status',
    ];
}
