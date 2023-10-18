<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\User;

class FeedBack extends Model
{
    use HasFactory;


    protected function user() : BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
