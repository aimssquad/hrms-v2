<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveApply extends Model
{
    use HasFactory;
    protected $table= "leave_apply";

    public function leaveType(){
        return $this->belongsTo(LeaveType::class,'leave_type');
    }
}
