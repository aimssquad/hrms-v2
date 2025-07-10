<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempAttendance extends Model
{
    use HasFactory;
    protected $table = 'temp_attandences';
   protected $fillable = [
        'employee_code',
        'employee_name',
        'date',
        'time_in',
        'time_out',
        'time_in_location',
        'time_out_location',
        'time_in_latitude',
        'time_in_longitude',
        'time_out_latitude',
        'time_out_longitude',
        'duty_hours',
        'month',
        'emid',
        'device_id',
        'location_accuracy',
        'is_location_mocked',
        'photo_proof',
        'punch_type',
	    'punch_status',
        'remarks',
    ];
}
