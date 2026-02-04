<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Guest extends Model
{
    use HasFactory;
    protected $table= "guests";

    protected $fillable = [
        "emid",
        "guest_id",
        "company_name",
        "designation",
        "name",
        "email",
        "phone",
        "address",
        "tax_no",
        "status",
    ];

    public function invoices()
    {
        return $this->hasMany(Invoice::class, 'guest_id');
    }


}
