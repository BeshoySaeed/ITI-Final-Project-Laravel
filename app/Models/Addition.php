<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\orderItems;


class Addition extends Model
{
    use HasFactory;


    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function orderItems()
    {
        return $this->belongsToMany(orderItems::class);
    }
}
