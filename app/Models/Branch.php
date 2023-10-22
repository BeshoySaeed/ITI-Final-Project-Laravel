<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Employee;


class Branch extends Model
{
    use HasFactory;


    protected function employees() : HasMany
    {
        return $this->hasMany(Employee::class);
    }

    protected $fillable = [
        "name",
        "address",
        "address_location"
    ];
 }
