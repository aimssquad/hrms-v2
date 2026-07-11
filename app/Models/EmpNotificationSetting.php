<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpNotificationSetting extends Model
{
    use HasFactory;

    protected $table = 'emp_notification_settings';

    protected $fillable = [
        'employee_id',
        'emid',
        'notification_module_id',
        'is_enabled',
    ];

    public static function isMuted($employeeId, $moduleId)
    {
        return self::where('employee_id', $employeeId)
            ->where('notification_module_id', $moduleId)
            ->where('is_enabled', 0)
            ->exists();
    }

    public function module()
    {
        return $this->belongsTo(EmpNotificationModule::class, 'notification_module_id');
    }
}
