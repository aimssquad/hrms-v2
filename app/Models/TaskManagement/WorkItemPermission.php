<?php

namespace App\Models\TaskManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkItemPermission extends Model
{
    use HasFactory;

    protected $table = 'work_item_permissions';

    protected $fillable = [

        'project_id',
        'work_item_id',

        'employee_id',
        'emid',

        'access_type',
        'role',

        'created_by'
    ];

    public $timestamps = false;

  

    // Project
    public function project()
    {
        return $this->belongsTo(\App\Models\Project::class, 'project_id');
    }

    // Work Item
    public function workItem()
    {
        return $this->belongsTo(
            \App\Models\TaskManagement\WorkItem::class,
            'work_item_id'
        );
    }

    // User
    public function user()
    {
        return $this->belongsTo(
            \App\Models\UserModel::class,
            'employee_id',
            'employee_id'
        );
    }
}