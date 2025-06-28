<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_filter([
            'type' => 'attributes',
            'id' => $this->id,
            'attributes' => [
                'price' => $this->price,
                'stock' => $this->stock,
                'discountNumber' => $this->discount_number,
                'discountPercentage' => $this->discount_percentage,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'relationships' => array_filter([
                'galleries' => $this->galleries_id ? [
                    'data' => [
                        'type' => 'galleries',
                        'id' => $this->galleries_id
                    ],
                    'links' => [
                        'self' => route('gallery.show', $this->galleries_id)
                    ]
                ] : null,
                'variants' => $this->variants_id ? [
                    'data' => [
                        'type' => 'variants',
                        'id' => $this->variants_id
                    ],
                    'links' => [
                        'self' => route('variants.show', $this->variants_id)
                    ]
                ] : null,
            ]),
            'includes' => array_filter([
                'galleries' => $this->relationLoaded('galleries') ? new GalleryResource($this->galleries) : null,
                'variants' => $this->relationLoaded('variants') ? new VariantsResource($this->variants) : null,
            ]),
            'links' => [
                'self' => route('attributes.show', $this->id)
            ]
        ]);
    }
}
