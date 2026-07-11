<?php

namespace App\Models\TaskManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkItemAssignment extends Model
{
    protected $table = 'work_item_assignments';

    protected $fillable = [
        'work_item_id',
        'employee_id',
        'assigned_by',
        'assigned_at',
        'emid',
        'status'
    ];

    public $timestamps = false;
}
