<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attandence extends Model
{
    use HasFactory;
    protected $table ="attandence";

    protected $fillable = [
        'employee_code',
        'employee_name',
        'date',
        'time_in',
        'time_out',
        'month',
        'time_in_location',
        'time_out_location',
        'duty_hours',
        'emid'
    ];

    public $timestamps = false;
}
