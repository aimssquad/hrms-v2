<?php

namespace App\Models\TaskManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPermission extends Model
{
    use HasFactory;
    protected $table = "project_permissions";
    protected $fillable = [
        'id',
        'emid',
        'name'
    ];
}
