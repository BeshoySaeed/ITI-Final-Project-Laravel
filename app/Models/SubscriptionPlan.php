<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;


class SubscriptionPlan extends Model
{
    use HasFactory;
    protected $fillable = ["name", "benefit", "discount_value", "duration", "subscribe_value", "active"];

 
    protected function users() : HasMany
    {
        return $this->hasMany(User::class);
    }
}
