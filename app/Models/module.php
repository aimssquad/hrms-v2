<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class module extends Model
{
    use HasFactory;
    protected $table="module";

    public function subMenus()
    {
        return $this->hasMany(SubMenu::class, 'module_id', 'id');
    }



}
