<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\IncludeParser;
use App\Models\ProductSku;

class ProductSkuResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $includes = new IncludeParser($request, ProductSku::ALLOWED_INCLUDES);

        return array_filter([
            'type' => 'product-sku',
            'id' => $this->id,
            'attributes' => [
                'sku' => $this->sku,
                'price' => $this->price,
                'stock' => $this->stock,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'relationships' => array_filter([
                'product' => [
                    'data' => [
                        'type' => 'product',
                        'id' => $this->product_id
                    ],
                    'links' => [
                        'self' => route('product.show', $this->product_id)
                    ]
                ],
            ]),
            'links' => [
                'self' => route('product-sku.show', $this->id)
            ]
        ]);
    }
}
