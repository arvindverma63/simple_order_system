<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['name', 'phone', 'sizes', 'total_cost'];

    protected $casts = [
        'sizes' => 'array', // Cast JSON to array
    ];
}
