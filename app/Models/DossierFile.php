<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DossierFile extends Model
{
    use HasFactory;
    protected $table = 'dossier_file'; 
    protected $fillable = [
        'dossier_id',
        'file_name',
        'description',
        'file',
    ];
}
