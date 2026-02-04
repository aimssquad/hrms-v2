<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Helpdesk extends Model
{
    use HasFactory;

    protected $table = "helpdesks";

    protected $fillable = [
        "ticket_no",
        "emid",
        "employee_id",
        "name",
        "email",
        "message",
        "image",
        "status",
        "created_at",
        "updated_at"
    ];

    // optional cast
    protected $casts = [
        "status" => "integer",
        "created_at" => "date",
        "updated_at" => "date",
    ];
}
