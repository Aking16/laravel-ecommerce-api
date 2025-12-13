<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Auth;

class Payment extends Model
{
    protected static function booted(): void
    {
        static::addGlobalScope('owner', function ($query) {
            if (!Auth::check() || !Auth::user()->is_admin) {
                $query->where('user_id', Auth::id());
            }
        });
    }

    protected $fillable = [
        'cart_id',
        'user_id',
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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cart(): BelongsTo
    {
        return $this->belongsTo(Carts::class);
    }
}
