<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Branch;

class Employee extends Model
{
    use HasFactory;


    protected function branch() :BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
