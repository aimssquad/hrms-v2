<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileOrganizationMenu extends Model
{
    use HasFactory;
    protected $table = 'mobile_organization_menus';
    protected $fillable = [
        'menu_id',
        'organization_id',
        'permission_by',
        'status'
    ];

    // public function menu()
    // {
    //     return $this->belongsTo(MobileMenu::class, 'menu_id');
    // }
    public function menu()
    {
        return $this->belongsTo(MobileMenu::class, 'menu_id', 'id');
    }

    public function organization()
    {
        return $this->belongsTo(Registration::class, 'organization_id', 'id'); 
    }
}
