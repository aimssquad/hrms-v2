<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpNotification extends Model
{
    use HasFactory;
    protected $table = 'emp_notifications';

    // Fillable fields for mass assignment
    protected $fillable = [
        'emid',
        'employee_id',
        'user_id',
        'type',
        'title',
        'description',
        'reference_id',
        'reference_type',
        'start_date',
        'end_date',
        'is_read',
        'read_at',
        'status'
    ];
}
