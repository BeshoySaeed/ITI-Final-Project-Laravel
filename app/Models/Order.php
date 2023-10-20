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
    protected $fillable = 
    ['user_id',
     'completed',
     'note',
    'payment_method',
    'discount_code',
    'confirm_instructions',
    // 'phone_id',
    // 'address_id',
];

    protected function user () : BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function items()
    {
        return $this->belongsToMany(Item::class);
    }
}
