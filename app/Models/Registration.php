<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Registration extends Model
{
    use HasFactory;
    protected $table="registration";

    public function menus()
    {
        return $this->hasMany(MobileOrganizationMenu::class, 'organization_id', 'id');
    }

    public function activeEmployees()
    {
        return $this->hasMany(User::class, 'emid', 'reg')->where('status', 'active');
    }
    
    public function inactiveEmployees()
    {
        return $this->hasMany(User::class, 'emid', 'reg')->where('status', 'inactive');
    }

}
