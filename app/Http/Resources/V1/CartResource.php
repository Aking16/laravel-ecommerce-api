<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_filter([
            'type' => 'carts',
            'id' => $this->id,
            'cart' => [
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'relationships' => array_filter([
                'items' => $this->items ? [
                    'data' => $this->items->map(function ($item) {
                        return [
                            'type' => 'cart_items',
                            'id' => $item->id,
                        ];
                    }),
                ] : null,
            ]),
            'includes' => array_filter([
                'items' =>
                $this->relationLoaded('items')
                    && request()->query('include')
                    ? CartItemsResource::collection($this->items)
                    : null,
            ]),
            'links' => [
                'self' => route('cart.show', $this->id)
            ]
        ]);
    }
}
