<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Order;
use App\Models\Addition;


class OrderItem extends Model
{
    use HasFactory;



    protected function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function additions()
    {
        return $this->belongsToMany(Addition::class);
    }
}
