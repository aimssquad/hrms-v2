<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceRule extends Model
{
    use HasFactory;
    use HasFactory;
    protected $table = 'rule2_table'; // Replace with your actual table name
    protected $fillable = [
        'item_id',
        'type',
        'entity_id',
        'is_default',
        'employee_charge',
        'payment_start_date',
        'payment_end_date',
        'org_code',
    ];

    public function billingItem()
    {
        return $this->belongsTo(BillingItem::class, 'item_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'entity_id', 'employee_id');
    }
    
}
