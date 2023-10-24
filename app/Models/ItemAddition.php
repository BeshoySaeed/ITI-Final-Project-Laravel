<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ItemAddition extends Model
{
    use HasFactory;
    protected $fillable = ['item_id','addition_id'];

    public function items()
    {
        return $this->belongsToMany(Item::class);
    }

    public function orderItems()
    {
        return $this->belongsToMany(orderItems::class);
    }
}
