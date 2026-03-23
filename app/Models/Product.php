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
        'category',
        'mainImage'
    ];

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function attributes()
    {
        return $this->hasManyThrough(
            ProductAttribute::class,
            ProductVariant::class,
            'product_id',  // Foreign key on variants
            'variant_id', // Foreign key on attributes
            'id',          // Local key on product
            'id'     // Local key on variants
        );
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

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }
}
