<?php

namespace App\Models\Attendance;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttendancePermission extends Model
{
    use HasFactory;
       protected $table = 'attendance_permission'; // Specify table name if different from model name convention
    
    protected $fillable = [
        'emp_code',
        'punch_type',
        'default_punch_type',
        'emid'
    ];
    
    protected $casts = [
        'punch_type' => 'string', 
    ];
}
