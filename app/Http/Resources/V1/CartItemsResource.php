<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\IncludeParser;
use App\Models\CartItem;

class CartItemsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $includes = new IncludeParser($request, CartItem::ALLOWED_INCLUDES);

        return array_filter([
            'type' => 'cart_items',
            'id' => $this->id,
            'attributes' => [
                'skuId' => $this->sku_id,
                'quantity' => $this->quantity,
            ],
            'relationships' => array_filter([
                'sku' => $this->sku ? [
                    'data' => [
                        'type' => 'product_sku',
                        'id' => $this->sku->id,
                    ],
                    'links' => [
                        'self' => route('product-sku.show', $this->sku->id)
                    ]
                ] : null,
                'product' => $this->sku->product ? [
                    'data' => [
                        'type' => 'product',
                        'id' => $this->sku->product->id,
                    ],
                    'links' => [
                        'self' => route('product.show', $this->sku->product->id)
                    ]
                ] : null,
            ]),
            'includes' => array_filter([
                'sku' =>
                $includes->has('sku') && $this->relationLoaded('sku')
                    ? new ProductSkuResource($this->sku)
                    : null,
                'product' => $includes->has('product') && $this->relationLoaded('sku') && $this->sku->relationLoaded('product')
                    ? new ProductResource($this->sku->product)
                    : null,
            ]),
            'links' => [
                'self' => route('cart-items.show', $this->id)
            ]
        ]);
    }
}
