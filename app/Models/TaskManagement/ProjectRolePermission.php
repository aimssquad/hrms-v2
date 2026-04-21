<?php

namespace App\Models\TaskManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRolePermission extends Model
{
    use HasFactory;
    protected $table = "project_role_permissions";
    protected $fillable = [
        'id',
        'project_id',
        'role_id',
        'project_permission_id'
    ];
}
