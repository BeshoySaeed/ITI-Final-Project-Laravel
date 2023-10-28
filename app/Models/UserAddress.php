<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;



class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = ['id','user_id','street','area','city','building_name','floor_number','flat_number','gps_location'];


    protected $with = ['user'];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }


}
