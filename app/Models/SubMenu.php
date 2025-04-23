<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;
    protected $table = "sub_menu";

    

    public function module()
    {
        return $this->belongsTo(module::class, 'module_id', 'id');
    }
}
