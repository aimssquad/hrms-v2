<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table = 'notifications';

     // Fillable fields for mass assignment
    protected $fillable = [
         'emid',
         'employee_id',
         'title',
         'description',
         'start_date',
         'end_date',
     ];
}
