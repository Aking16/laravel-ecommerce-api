<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_filter([
            'type' => 'cart_items',
            'id' => $this->id,
            'attributes' => [
                'quantity' => $this->quantity,
            ],
            'relationships' => array_filter([
                'attribute' => $this->attribute ? [
                    'data' => [
                        'type' => 'product_attributes',
                        'id' => $this->attribute->id,
                    ]
                ] : null,
            ]),
            // 'includes' => array_filter([
            //     'attribute' =>
            //     $this->relationLoaded('attribute')
            //         && request()->query('include')
            //         ? new ProductAttributesResource($this->attribute)
            //         : null,
            // ]),
            'links' => [
                'self' => route('cart-items.show', $this->id)
            ]
        ]);
    }
}
