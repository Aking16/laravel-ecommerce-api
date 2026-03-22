<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\IncludeParser;
use App\Models\ProductAttribute;

class AttributesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $includes = new IncludeParser($request, ProductAttribute::ALLOWED_INCLUDES);

        return array_filter([
            'type' => 'product-attributes',
            'id' => $this->id,
            'attributes' => [
                'price' => $this->price,
                'stock' => $this->stock,
                'sku' => $this->sku,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'relationships' => array_filter([
                'variant' => [
                    'data' => [
                        'type' => 'product-variants',
                        'id' => $this->variant_id
                    ],
                    'links' => [
                        'self' => route('product-variants.show', $this->variant_id)
                    ]
                ],
            ]),
            'includes' => array_filter([
                'variant' => $includes->has('variant') && $this->relationLoaded('variant') ?
                    new ProductVariantResource($this->variant) :
                    null,
            ]),
            'links' => [
                'self' => route('product-attributes.show', $this->id)
            ]
        ]);
    }
}
