<?php

namespace App\Models;

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
        return $this->belongsTo(Gallery::class, 'galleries_id');
    }
}
