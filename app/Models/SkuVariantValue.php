<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Filters\V1\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class SkuVariantValue extends Model
{
    /** @use HasFactory<\Database\Factories\SkuVariantValueFactory> */
    use HasFactory;

    public const ALLOWED_INCLUDES = [
        'sku',
        'variantValue'
    ];

    protected $fillable = [
        'sku_id',
        'variant_id',
    ];

    public function sku()
    {
        return $this->belongsTo(ProductSku::class, "sku_id");
    }

    public function variantValue()
    {
        return $this->belongsTo(ProductVariantValue::class, "variant_value_id");
    }



    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }
}
