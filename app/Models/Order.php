<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use SoftDeletes;
    protected $fillable = ['phone', 'sizes', 'total_cost', 'order_date', 'user_id', 'status'];
    protected $casts = [
        'sizes' => 'array', // Cast JSON to array
    ];
    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
