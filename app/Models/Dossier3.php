<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dossier3 extends Model
{
    use HasFactory;
    protected $table = 'dossier3'; 
    protected $fillable = [
        'dossier_id',
        'dossier2_id',
        'title3',
        'link3',
        'dossier_file3',
    ];
    public function dossier()
    {
        return $this->belongsTo(Dossier::class);
    }
    public function dossier2()
    {
        return $this->belongsTo(Dossier2::class);
    }
    public function files()
    {
        return $this->hasMany(DossierFile::class, 'dossier_id'); // Adjust 'dossier3_id' if your foreign key differs
    }
}
