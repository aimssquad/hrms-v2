<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubadminRegistration extends Model
{
    use HasFactory;
    protected $table = 'sub_admin_registrations';

    // public function organization()
    // {
    //     return $this->belongsTo(Registration::class, 'org_code', 'org_code')
    //                 ->where('status', 'active')
    //                 ->where('verify', 'approved');
    // }

    public function organizations()
    {
        return $this->hasMany(Registration::class, 'org_code', 'org_code')
            ->where('status', 'active')
            ->where('verify', 'approved');
    }

}
