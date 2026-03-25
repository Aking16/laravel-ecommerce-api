<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\IncludeParser;
use App\Models\ProductSku;

class SkuVariantValueResource extends JsonResource
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
            'type' => 'sku-variant-value',
            'id' => $this->id,
            'attributes' => [
                'sku_id' => $this->sku_id,
                'variant_value_id' => $this->variant_value_id,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'relationships' => array_filter([
                'variantValues' => [
                    'data' => [
                        'type' => 'product-variant-values',
                        'id' => $this->variant_value_id
                    ],
                    'links' => [
                        'self' => route('product-variant-values.show', $this->variant_value_id)
                    ]
                ],
                'sku' => [
                    'data' => [
                        'type' => 'product-sku',
                        'id' => $this->sku_id
                    ],
                    'links' => [
                        'self' => route('product-sku.show', $this->sku_id)
                    ]
                ],
            ]),
            'links' => [
                'self' => route('sku-variant-value.show', $this->id)
            ]
        ]);
    }
}
