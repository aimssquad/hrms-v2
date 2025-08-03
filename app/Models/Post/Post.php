<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $table = 'post';
    
    protected $fillable = [
        'emid',
        'employee_code',
        'title',
        'content',
        'image_path'
    ];

   public function employee(): BelongsTo
    {
        return $this->belongsTo(\App\Models\Employee::class, 'employee_code', 'emp_code')
            ->where('emid', $this->emid);
    }

    public function likes()
    {
        return $this->hasMany(PostLike::class, 'post_id');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_id')->with('employee');
    }
}