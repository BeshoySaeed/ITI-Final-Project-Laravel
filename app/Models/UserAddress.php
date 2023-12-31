<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = ['id','user_id','street','area','city','building_name','floor_number','flat_number','gps_location'];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
