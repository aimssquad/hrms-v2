<?php

namespace App\Models\Post;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostCommentReply extends Model
{
    use HasFactory;
    protected $table = "post_comment_replys";
    protected $fillable = [
        'post_id',
        'comment_id',
        'comment_employee_id',
        'reply_employee_id',
        'reply'
    ];
}
