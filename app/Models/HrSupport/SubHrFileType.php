<?php

namespace App\Models\HrSupport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubHrFileType extends Model
{
    use HasFactory;
    protected $table = 'sub_hr_filetype';

    protected $fillable = [
        'type_id',
        'sub_name',
        'status',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    public function type()
    {
        return $this->belongsTo(HrSupportFileType::class, 'type_id');
    }

     // Many-to-One relationship with HrSupportFileType
     public function hrSupportFileType()
     {
         return $this->belongsTo(HrSupportFileType::class, 'type_id');
     }
 
     // One-to-Many relationship with HrSupportFile
     public function hrSupportFiles()
     {
         return $this->hasMany(HrSupportFile::class, 'sub_type_id');
     }
}
