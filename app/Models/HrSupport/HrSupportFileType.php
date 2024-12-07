<?php

namespace App\Models\HrSupport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class HrSupportFileType extends Model
{
    use SoftDeletes;

    protected $fillable = ['type', 'description', 'status'];
    public function supportFiles()
    {
        return $this->hasMany(HrSupportFile::class, 'type_id');
    }

    // One-to-Many relationship with SubHrFileType
    public function subHrFileTypes()
    {
        return $this->hasMany(SubHrFileType::class, 'type_id');
    }

    // One-to-Many relationship with HrSupportFile
    public function hrSupportFiles()
    {
        return $this->hasMany(HrSupportFile::class, 'type_id');
    }
    
   
}
