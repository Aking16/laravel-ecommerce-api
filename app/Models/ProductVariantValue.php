<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Http\Filters\V1\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductVariantValue extends Model
{
    /** @use HasFactory<\Database\Factories\ProductVariantValueFactory> */
    use HasFactory;

    public const ALLOWED_INCLUDES = [
        'product',
    ];

    protected $fillable = [
        'variant_id',
        'value'
    ];

    public function variant()
    {
        return $this->belongsTo(ProductVariant::class, 'variant_id');
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }
}
