<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\orderItems;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;
    protected $fillable =
    [
    'user_id',
    'completed',
    'status',
    'note',
    'payment_method',
    'discount_code',
    'confirm_instructions',
    'street',
    'area',
    'city',
    'building_name',
    'floor_number',
    'flat_number',
    'GPS_location',
    'phone1',
    'phone2',
];

    protected function user () : BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
