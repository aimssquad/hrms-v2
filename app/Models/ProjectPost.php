<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectPost extends Model
{
    use HasFactory;
    protected $table ="project_post";

    protected $fillable = [
       'emid',
       'project_id',
       'parent_id',
       'employee_code',
       'title',
       'file' 
    ];

    // public function user()
    // {
    //     return $this->belongsTo(User::class, 'employee_code', 'employee_id','emid');
    // }
    

 public function user()
{
    return $this->belongsTo(User::class, 'employee_code', 'employee_id')
        ->where('users.emid', $this->emid); // use current post's emid
}


    public function replies()
    {
        return $this->hasMany(ProjectPostReply::class, 'post_id', 'id');
    }


}
