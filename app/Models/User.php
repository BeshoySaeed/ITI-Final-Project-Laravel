<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Role;
use App\Models\Order;
use App\Models\UserPhone;
use App\Models\Item;
use App\Models\FeedBack;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'first_name',
        'last_name',
        'role_id',
        'email',
        'password',
        'balance',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    protected function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }

    protected function phones() : HasMany
    {
        return $this->hasMany(UserPhone::class);
    }

    protected function addresses() : HasMany
    {
        return $this->hasMany(UserPhone::class);
    }

    protected function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    protected function items(): BelongsToMany
    {
        return $this->belongsToMany(Item::class);
    }

    protected function feedBacks() : HasMany
    {
        return $this->hasMany(FeedBack::class);
    }
}
