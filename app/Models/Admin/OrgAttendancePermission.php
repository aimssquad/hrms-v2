<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrgAttendancePermission extends Model
{
    use HasFactory;
    protected $fillable = [
        'punch_type_id',
        'punch_type',
        'default_punch_type_id',
        'emid'
    ];
}
