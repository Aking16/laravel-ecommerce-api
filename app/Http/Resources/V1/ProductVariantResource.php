<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\IncludeParser;
use App\Models\ProductVariant;

class ProductVariantResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $includes = new IncludeParser($request, ProductVariant::ALLOWED_INCLUDES);

        return array_filter([
            'type' => 'product-variants',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
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
                'productAttributes' => $this->attributes->isNotEmpty() ? [
                    'data' => $this->attributes->map(fn($attribute) => [
                        'type' => 'product-attributes',
                        'id' => $attribute->id,
                    ])
                ] : null,
            ]),
            'includes' => array_filter([
                'product' => $includes->has('product') && $this->relationLoaded('product') ?
                    new ProductResource($this->product) :
                    null,
                // 'attributes' => $includes->has('attributes') && $this->relationLoaded('attributes')
                //     ? ProductAttributes::collection($this->attributes)
                //     : null,
            ]),
            'links' => [
                'self' => route('product-variants.show', $this->id)
            ]
        ]);
    }
}
