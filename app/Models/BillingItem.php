<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingItem extends Model
{
    use HasFactory;
    protected $table = 'billing_item';
    protected $fillable = [
        'item_name',
        'description',
        'status',
    ];
}
