<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossier extends Model
{
    use HasFactory;
    protected $table= "dossier";
    protected $fillable = ['title', 'link', 'dossier_file'];

    public function dossiers2()
    {
        return $this->hasMany(Dossier2::class, 'dossier_id');
    }
}
