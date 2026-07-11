<?php

namespace App\Models\TaskManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkItemUserRole extends Model
{
    use HasFactory;
    protected $table = "work_item_user_roles"; 
    
    protected $fillable = [
            'project_id',
            'work_item_id',
            'employee_id',
            'project_role_id',
            'emid',
            'created_by'
        ];
}
