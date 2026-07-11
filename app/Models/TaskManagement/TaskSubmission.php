<?php

namespace App\Models\TaskManagement;

use Illuminate\Database\Eloquent\Model;

class TaskSubmission extends Model
{
    protected $table = 'task_submissions';

    protected $fillable = [
        'work_item_id',
        'employee_id',
        'file',
        'remarks',
        'submitted_at',
        'emid'
    ];

    public $timestamps = false;
}