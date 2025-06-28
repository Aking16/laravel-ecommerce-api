<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariantsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_filter([
            'type' => 'variants',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'color' => $this->color,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'relationships' => array_filter([
                'variant_categories' => $this->variant_categories_id ? [
                    'data' => [
                        'type' => 'variantCategories',
                        'id' => $this->variant_categories_id
                    ],
                    'links' => [
                        'self' => route('variant-categories.show', $this->variant_categories_id)
                    ]
                ] : null,
            ]),
            'includes' => array_filter([
                'variant_categories' => $this->relationLoaded('variant_categories') ?
                    new VariantCategoriesResource($this->variant_categories_id) :
                    null,
            ]),
            'links' => [
                'self' => route('variants.show', $this->id)
            ]
        ]);
    }
}
