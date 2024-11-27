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
        'employee_charge',
        'max_organizations',
        'min_employees',
        'max_employees',
        'payment_date_range',
        'org_code',
    ];
}
