<?php

namespace App\Models\HrSupport;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class HrSupportFile extends Model
{
    use SoftDeletes;
    protected $table = 'hr_support_files';
    protected $fillable = [
        'type_id',
        'sub_type_id',
        'title',
        'small_description',
        'description',
        'pdf',
        'doc',
        'status',
    ];

    protected $dates = ['deleted_at'];

    public function type()
    {
        return $this->belongsTo(HrSupportFileType::class, 'type_id');
    }
    public function subType()
    {
        return $this->belongsTo(SubHrFileType::class, 'sub_type_id'); // Ensure 'sub_type_id' is the correct foreign key
    }
}
