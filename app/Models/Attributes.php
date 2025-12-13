<?php

namespace App\Models;

use App\Http\Filters\V1\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Attributes extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'stock',
        'discount_number',
        'discount_percentage',
        'galleries_id',
        'variants_id',
    ];

    public function galleries(): BelongsTo
    {
        return $this->belongsTo(Gallery::class, 'galleries_id');
    }

    public function variants(): BelongsTo
    {
        return $this->belongsTo(Variants::class, 'variants_id');
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }
}
