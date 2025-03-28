<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingRule extends Model
{
    use HasFactory;
    protected $table = 'rule_table'; // Replace with your actual table name
    protected $fillable = [
        'type',
        'entity_id',
        'is_default',
        'billing_for',

        'min_organizations',
        'max_organizations',
        'organization_charge',

        'min_employees',
        'max_employees',
        'employee_charge',
        
        'billing_mode',
        'payment_date_from',
        'payment_date_to',
        //'payment_date_range',
        'org_code',
    ];
}
