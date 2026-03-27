<?php

namespace App\Models;

use App\Http\Filters\V1\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    public const ALLOWED_INCLUDES = [
        'images',
        'subCategory',
        'mainImage',
        'variants',
        'variantValues',
        'skus',
        'skuValues'
    ];

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description'
    ];

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function subCategory()
    {
        return $this->belongsTo(SubCategory::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function mainImage()
    {
        return $this->morphOne(Image::class, 'imageable')
            ->where('is_main', true);
    }

    public function variantValues()
    {
        return $this->hasManyThrough(
            ProductVariantValue::class,
            ProductVariant::class,
            'product_id',  // Foreign key on variants
            'variant_id', // Foreign key on attributes
            'id',          // Local key on product
            'id'     // Local key on variants
        );
    }

    public function skus()
    {
        return $this->hasMany(ProductSku::class);
    }

    public function skuValues()
    {
        return $this->hasManyThrough(
            SkuVariantValue::class,
            ProductSku::class,
            'product_id',
            'sku_id',
            'id',
            'id'
        );
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }
}
