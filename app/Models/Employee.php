<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;
    protected $table="employee";

    public function posts()
    {
        return $this->hasMany(\App\Models\Post\Post::class, ['employee_code', 'emid'], ['emp_code', 'emid']);
    }
}
