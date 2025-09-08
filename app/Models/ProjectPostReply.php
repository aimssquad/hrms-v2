<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPostReply extends Model
{
    use HasFactory;
    protected $table ="project_post_reply";
    protected $fillable = [
       'emid',
       'project_id',
       'post_id',
       'employee_code',
       'reply_text',
       'file' 
    ];



    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'employee_code', 'employee_id');
    // }
    public function user()
    {
        return $this->belongsTo(User::class, 'employee_code', 'employee_id')
            ->where('users.emid', $this->emid);
    }


    public function post()
    {
        return $this->belongsTo(ProjectPost::class, 'post_id', 'id');
    }

}
