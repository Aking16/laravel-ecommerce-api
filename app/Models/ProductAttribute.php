<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductAttribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'variant_id',
        'value',
        'sku',
        'price',
        'stock'
    ];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class, 'attribute_id');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'attribute_id');
    }
}
