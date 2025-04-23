<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmployeePermission extends Model
{
    use HasFactory;

    // Define the table name
    protected $table = 'employee_permissions';

    // Specify fillable attributes
    protected $fillable = [
        'org_id',
        'employee_id',
        'module_name',
        'submenu_name',
        'submenu_id',
        'can_add',
        'can_edit',
        'can_delete',
        'can_export',
        'can_import',
        'created_at',
        'updated_at',
    ];

    // Disable timestamps if not needed
    public $timestamps = false;
}
