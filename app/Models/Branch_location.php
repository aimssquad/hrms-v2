<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch_location extends Model
{
    use HasFactory;
    protected $table = 'branch_locations';
    
    protected $fillable = [
        'branch_name',
        'attendance_process',
        'branch_location',
        'latitude',
        'longitude',
        'radius',
        'emid',
        'status'
    ];
}
