<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrSupportDtlDoc extends Model
{
    use HasFactory;
    protected $table = 'hr_support_dtl_docs';
    protected $fillable = [
        'support_id',
        'name',
        'document_description',
        'pdf',
        'doc',
    ];

    public function subHrFileType()
    {
        return $this->belongsTo(HrSupportFile::class, 'id');
    }
}
