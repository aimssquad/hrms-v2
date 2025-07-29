<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BreakTimes extends Model
{
    use HasFactory;
    protected $table = 'break_times';
    protected $fillable = [
        'employee_code',
        'employee_name',
        'date',
        'break_time_start',
        'break_time_end',
        'break_time_in_location',
        'break_time_out_location',
        'break_time_in_latitude',
        'break_time_in_longitude',
        'break_time_out_latitude',
        'break_time_out_longitude',
        'total_break_time',
        'break_month',
        'emid',
        'break_device_id',
        'punch_type',
	    'punch_status',
    ];
}
