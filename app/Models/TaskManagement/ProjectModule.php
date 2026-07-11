<?php

namespace App\Models\TaskManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectModule extends Model
{
    use HasFactory;
    protected $table = "project_module";
    protected $fillable = [
        'id',
        'project_id',
        'module_name',
        'description',
        'order_by',
        'emid',
        'created_by'
    ];
}
