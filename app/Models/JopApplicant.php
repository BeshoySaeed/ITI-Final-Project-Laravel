<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JopApplicant extends Model
{
    use HasFactory;

    protected $fillable = [
        "first_name",
        "last_name",
        "address",
        "address_location",
        "education",
        "mobile",
        "name",
        "cv"
    ];
}
