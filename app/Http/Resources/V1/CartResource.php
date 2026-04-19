<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\IncludeParser;
use App\Models\Cart;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $includes = new IncludeParser($request, Cart::ALLOWED_INCLUDES);

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
                $includes->has('items') && $this->relationLoaded('items')
                    ? CartItemsResource::collection($this->items)
                    : null,
            ]),
            'links' => [
                'self' => route('cart.show', $this->id)
            ]
        ]);
    }
}
