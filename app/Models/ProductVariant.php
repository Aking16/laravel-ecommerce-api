<?php

namespace App\Models;


use App\Http\Filters\V1\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\ProductAttribute;

class ProductVariant extends Model
{
    use HasFactory;

    public const ALLOWED_INCLUDES = [
        'product',
        'attributes',
    ];

    protected $fillable = [
        'product_id',
        'name'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class, 'variant_id');
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }
}
