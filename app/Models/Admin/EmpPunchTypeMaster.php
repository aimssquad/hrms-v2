<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpPunchTypeMaster extends Model
{
    use HasFactory;
    protected $table = 'emp_punch_type_masters';
    protected $fillable = [
        'punch_type_name',
        'status'
    ];
}
