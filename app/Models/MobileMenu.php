<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MobileMenu extends Model
{
    use HasFactory;
    protected $table= "mobile_menus";
    protected $fillable = ['menu_name', 'identifier', 'image','url','type','description','status'];
}
