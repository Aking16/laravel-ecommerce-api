<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'cart_id',
        'status',
        'method',
        'amount',
        'transaction_id',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    protected $with = ['cart'];

    public function cart()
    {
        return $this->belongsTo(Carts::class);
    }
}
