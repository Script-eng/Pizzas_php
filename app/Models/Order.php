<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\OrderStatus;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'pizza_id',
        'quantity',
        'address',
        'notes',
        'status',
        'total_price',
    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function pizza()
    {
        return $this->belongsTo(Pizza::class);
    }
}
