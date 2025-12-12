<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\V1\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Carts extends Model
{
    use HasFactory;

    protected $fillable = [];

    public function attributes(): BelongsToMany
    {
        return $this->belongsToMany(
            Attributes::class,
            'cart_variant',
            'carts_id',
            'attributes_id'
        )->withPivot('discounts_id')
            ->withTimestamps();
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }
}
