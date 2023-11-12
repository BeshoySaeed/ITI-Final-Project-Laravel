<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItemAddition extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['item_id','addition_id'];

    public function items()
    {
        return $this->belongsTo(Item::class);
    }

    public function orderItems()
    {
        return $this->belongsToMany(orderItems::class);
    }

    public function addition()
    {
        return $this->belongsTo(Addition::class);
    }
}
