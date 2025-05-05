<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Holiday2Type extends Model
{
    use HasFactory;
    protected $table="holiday2types";

    protected $fillable = [
        'holiday_type_name',
        'emid',
        'status'
    ];

    public function holidayApplications()
    {
        return $this->hasMany(HolidayApply::class, 'holiday_type2_id');
    }
}
