<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Filters\V1\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductSku extends Model
{
    /** @use HasFactory<\Database\Factories\ProductSkuFactory> */
    use HasFactory;

    public const ALLOWED_INCLUDES = [
        'product'
    ];

    protected $fillable = [
        'product_id',
        'sku',
        'price',
        'stock'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, "product_id");
    }

    public function variantValues()
    {
        return $this->belongsToMany(ProductVariantValue::class, 'sku_variant_values', 'sku_id', 'variant_value_id');
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }
}
