<?php

namespace App\Models\TaskManagement;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{

    protected $fillable = [
        'id',
        'project_id',
        'task_name',
        'task_desc',
        'tags',
        'assignedTo',
        'start_date',
        'expected_end_date',
        'updatedBy',
        'createdBy',
        'priority',
        'status',
        'task_file',
        'task_doc',
        'created_at',
        'updated_at'
    ];

    // Define relationships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function assignedEmployee()
    {
        return $this->belongsTo(\App\Models\Employee::class, 'assignedTo', 'id');
    }

    public function taskComments()
    {
        return $this->hasMany(TaskComment::class, 'task_id', 'id');
    }

}
