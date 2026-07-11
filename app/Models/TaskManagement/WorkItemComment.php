<?php

namespace App\Models\TaskManagement;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkItemComment extends Model
{
    use HasFactory;

    protected $table = 'work_item_comments';

    protected $fillable = [

        'project_id',

        'work_item_id',

        'parent_comment_id',

        'employee_id',

        'comment',

        'file',

        'comment_type',

        'is_edited',

        'is_deleted',

        'emid'
    ];

    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */

    public function user()
    {
       return $this->belongsTo(
            \App\Models\UserModel::class,
            'employee_id',
            'employee_id'
        )->select(
        
            'employee_id',
        
            'name',
        
            'emid'
        );
    }

   

    public function workItem()
    {
        return $this->belongsTo(
            \App\Models\TaskManagement\WorkItem::class,
            'work_item_id'
        );
    }



    public function parent()
    {
        return $this->belongsTo(
            WorkItemComment::class,
            'parent_comment_id'
        );
    }



    public function replies()
    {
        return $this->hasMany(
            WorkItemComment::class,
            'parent_comment_id'
        )
        ->where('is_deleted', 0)
        ->with('user')
        ->orderBy('id', 'ASC');
    }
}