<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JopApplicant extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "first_name",
        "last_name",
        "email",
        "mobile",
        "education",
        "cv"
    ];
}
