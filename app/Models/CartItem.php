<?php

namespace App\Models;

use App\Http\Filters\V1\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CartItem extends Model
{
    use HasFactory;

    public const ALLOWED_INCLUDES = [
        'cart',
        'sku',
        'product',
    ];

    protected $fillable = [
        'cart_id',
        'sku_id',
        'quantity'
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }

    public function sku()
    {
        return $this->belongsTo(ProductSku::class);
    }

    public function getProductAttribute()
    {
        return $this->sku?->product;
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }
}
