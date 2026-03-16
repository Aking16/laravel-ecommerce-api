<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_filter([
            'type' => 'product',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'description' => $this->description,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'meta' => array_filter(
                $request->boolean('include_meta') ? [
                    'metaTitle' => $this->meta_title,
                    'metaDescription' => $this->meta_description,
                    'metaKeywords' => $this->meta_keywords,
                ] : []
            ),
            'relationships' => array_filter([
                'category' => [
                    'data' => [
                        'type' => 'category',
                        'id' => $this->category->id
                    ],
                    'links' => [
                        'self' => route('category.show', $this->category->id)
                    ]
                ],
                'images' => $this->when(
                    $this->relationLoaded('images'),
                    fn() => [
                        'data' => $this->images->map(fn($image) => [
                            'type' => 'image',
                            'id' => $image->id,
                        ]),
                    ]
                ),

            ]),
            'includes' => array_filter([
                'category' => $this->relationLoaded('category') ? new CategoryResource($this->category) : null,
                // 'images' => $this->relationLoaded('images')
                //     ? ImageResource::collection($this->images)
                //     : null,
            ]),
            'links' => [
                'self' => route('product.show', ($this->id))
            ]
        ]);
    }
}
