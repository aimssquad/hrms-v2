<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $table = 'post';
    
    protected $fillable = [
        'emid',
        'employee_code',
        'title',
        'image_path'
    ];

    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class, 'post_id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(PostComment::class, 'post_id');
    }

    public function isLikedBy(string $emid, string $employeeCode): bool
    {
        return $this->likes()
            ->where('emid', $emid)
            ->where('employee_code', $employeeCode)
            ->exists();
    }
}