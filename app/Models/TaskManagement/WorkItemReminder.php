<?php

namespace App\Models\TaskManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkItemReminder extends Model
{
    protected $table = 'work_item_reminders';

    protected $fillable = [

        'work_item_id',

        'employee_id',

        'reminder_type',

        'days_before',

        'sent_at',

        'status',
        'emid',

    ];
}
