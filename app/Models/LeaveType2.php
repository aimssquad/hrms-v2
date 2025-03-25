<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType2 extends Model
{
    use HasFactory;
    protected $table = 'leave_type2';
    
    protected $fillable = [
        'leave_type_name',
        'alies',
        'remarks',
        'color_code',
        'leave_type_status'
    ];
    
    protected $casts = [
        'leave_type_status' => 'boolean',
    ];
}
