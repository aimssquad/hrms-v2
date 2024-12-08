<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

     // Table associated with the model
     protected $table = 'notices';

     // Fillable fields for mass assignment
     protected $fillable = [
         'title',
         'description',
         'image',
         'organization_id',
         'created_by_type',
         'created_by_id',
         'start_date',
         'end_date',
     ];
}
