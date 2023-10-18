<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\orderItems;



class Order extends Model
{
    use HasFactory;

    protected function user () : BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
