<?php

namespace App\Models;

use App\Http\Filters\V1\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Variants extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'color',
        'variant_categories_id',
    ];

    public function variant_categories(): BelongsTo
    {
        return $this->belongsTo(VariantCategories::class, 'variant_categories_id');
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }
}
