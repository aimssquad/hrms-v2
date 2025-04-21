<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TempAttendance extends Model
{
    use HasFactory;
    protected $table = 'temp_attandence';
    protected $fillable = [
        'branch_id',
        'employee_id',
        'employee_name',
        'date',
        'time',
        'time_in_location',
        'time_out_location',
        'emid'
    ];
}
