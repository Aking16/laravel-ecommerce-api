<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\IncludeParser;
use App\Models\ProductVariantValue;

class ProductVariantValueResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $includes = new IncludeParser($request, ProductVariantValue::ALLOWED_INCLUDES);

        return array_filter([
            'type' => 'product-variant-values',
            'id' => $this->id,
            'attributes' => [
                'value' => $this->value,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'relationships' => array_filter([
                'variant' => [
                    'data' => [
                        'type' => 'variant',
                        'id' => $this->variant_id
                    ],
                    'links' => [
                        'self' => route('product-variants.show', $this->variant_id)
                    ]
                ],
            ]),
            // 'includes' => array_filter([
            //     'product' => $includes->has('product') && $this->relationLoaded('product') ?
            //         new ProductResource($this->product) :
            //         null,
            // ]),
            'links' => [
                'self' => route('product-variant-values.show', $this->id)
            ]
        ]);
    }
}
