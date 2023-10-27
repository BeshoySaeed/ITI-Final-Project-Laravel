<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Category;
use App\Models\Addition;
use App\Models\Order;
use App\Models\User;

class Item extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'img', 'price','description','discount','active','category_id'];

    protected function category() : BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function additions()
    {
        return $this->hasMany(ItemAddition::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }


    public function users() : BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }
}
