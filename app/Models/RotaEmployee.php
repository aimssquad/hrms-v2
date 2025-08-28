<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RotaEmployee extends Model
{
    use HasFactory;
    protected $table="rota_employee";

      protected $fillable = [
        'employee_id',
        'emid',
        'file',
        'w_hours',
        'w_min',
        'in_time',
        'out_time',
        'min_tol',
        'date',
        'remarks',
        'cr_date',
    ];
}
