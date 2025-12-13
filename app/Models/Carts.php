<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Http\Filters\V1\QueryFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Facades\Auth;

class Carts extends Model
{
    use HasFactory;

    protected static function booted(): void
    {
        static::addGlobalScope('owner', function ($query) {
            if (!Auth::check() || !Auth::user()->is_admin) {
                $query->where('user_id', Auth::id());
            }
        });
    }

    protected $fillable = ['user_id'];

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

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function scopeFilter(Builder $builder, QueryFilter $filters)
    {
        return $filters->apply($builder);
    }
}
