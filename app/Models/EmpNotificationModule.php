<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmpNotificationModule extends Model
{
    use HasFactory;

    protected $table = 'notification_modules';

    protected $fillable = [
        'name',
    ];

    const BIRTHDAY = 1;
    const HOLIDAY = 2;
    const VISA_EXPIRY = 3;
    const PASSPORT_EXPIRY = 4;
    const DBS_EXPIRY = 5;
    const EUSS_EXPIRY = 6;
    const NOTICE = 7;

    public function settings()
    {
        return $this->hasMany(EmpNotificationSetting::class, 'notification_module_id');
    }
}
