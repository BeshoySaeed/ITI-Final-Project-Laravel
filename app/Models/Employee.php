<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Branch;

class Employee extends Model
{
    use HasFactory;
    protected $fillable = ['first_name', 'last_name', 'job_title', 'email', 'phone', 'national_id', 'street', 'area', 'city', 'salary', 'joined_at', 'branch_id'];

    protected function branch(): BelongsTo
    {
        return $this->belongsTo(Branch::class);
    }
}
