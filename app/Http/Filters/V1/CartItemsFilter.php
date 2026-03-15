<?php

namespace App\Http\Filters\V1;

class CartItemsFilter extends QueryFilter
{
    protected $sortable = [
        'id',
        'quantity',
        'createdAt' => 'created_at'
    ];

    public function include($value)
    {
        $relationships = array_map('trim', explode(',', $value));

        $allowed = [
            'cart',
            'attribute',
            'attribute.variant',
            'attribute.variant.product'
        ];

        $valid = array_filter(
            $relationships,
            fn($rel) =>
            in_array($rel, $allowed)
        );

        return $this->builder->with($valid);
    }

    public function cart($value)
    {
        return $this->builder->where('cart_id', $value);
    }
}
