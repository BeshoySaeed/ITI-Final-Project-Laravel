<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class UserPhone extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'user_id','phone'];

    protected $with = ['user'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
}
