<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Item;
use App\Models\orderItems;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Addition extends Model
{
    use HasFactory;
   protected $fillable = ['name', 'img', 'price','description'];


   public function item(): BelongsToMany
   {
       return $this->belongsToMany(Item::class);
   }
}
