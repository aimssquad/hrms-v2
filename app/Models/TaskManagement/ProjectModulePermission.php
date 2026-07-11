<?php

namespace App\Models\TaskManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectModulePermission extends Model
{
    use HasFactory;
    protected $table = "project_module_permission";
    protected $fillable = [
        'id',
        'project_id',
        'project_module_id',
        'employee_id',
        'emid',
        'created_by'
    ];
}
