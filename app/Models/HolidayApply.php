<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HolidayApply extends Model
{
    use HasFactory;
    protected $table = 'holiday_apply';

    protected $fillable = [
        'holiday_type2_id',
        'employee_id',
        'emp_reporting_auth_name',
        'emp_reporting_auth_id',
        'holiday_types',
        'form_date',
        'no_of_days',
        'hour',
        'emid',
        'status'
    ];



    public function employee()
    {
        return $this->belongsTo(User::class, 'employee_id', 'employee_id');
    }

    public function holidayType()
    {
        return $this->belongsTo(Holiday2Type::class, 'holiday_type2_id');
    }

    public function getDurationAttribute()
    {
        if ($this->no_of_days) {
            return $this->no_of_days . ' day(s)';
        } elseif ($this->hour) {
            $hours = floor($this->hour / 60);
            $minutes = $this->hour % 60;
            
            $duration = '';
            if ($hours > 0) $duration .= $hours . ' hour' . ($hours > 1 ? 's' : '');
            if ($minutes > 0) $duration .= ($hours > 0 ? ' ' : '') . $minutes . ' minute' . ($minutes > 1 ? 's' : '');
            
            return $duration ?: '0 minutes';
        }
        return 'N/A';
    }


}
