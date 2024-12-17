<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossier2 extends Model
{
    use HasFactory;
    protected $table = 'dossier2'; 
    protected $fillable = [
        'dossier_id',
        'title2',
        'link2',
        'dossier_file2',
    ];

    public function dossier()
    {
        return $this->belongsTo(Dossier::class, 'dossier_id');
    }
}
