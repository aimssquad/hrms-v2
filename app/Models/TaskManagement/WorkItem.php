<?php

namespace App\Models\TaskManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkItem extends Model
{
    use HasFactory;

        protected $table = 'work_items';

    protected $fillable = [
        'unique_id',
        'project_id',
        'parent_id',
        'type',
        'title',
        'description',
        'image',
        'priority',
        'start_date',
        'end_date',
        'created_by',
        'status',
        'emid'
    ];

    // Parent relation
    public function parent()
    {
        return $this->belongsTo(WorkItem::class, 'parent_id');
    }

    // Children relation
    public function children()
    {
        return $this->hasMany(WorkItem::class, 'parent_id');
    }
    
    public function employees()
    {
        return $this->belongsToMany(
            \App\Models\UserModel::class,   // ✅ use User model
            'work_item_assignments',
            'work_item_id',
            'employee_id',            // pivot column
            'id',                     // users primary key
            'employee_id'             // users.employee_id
        )->withPivot('status', 'assigned_by', 'assigned_at');
    }
    
}
