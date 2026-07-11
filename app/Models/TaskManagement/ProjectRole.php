<?php

namespace App\Models\TaskManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectRole extends Model
{
    use HasFactory;

    protected $table = "project_roles";
    protected $fillable = [
        'id',
        'emid',
        'name'
    ];
}
