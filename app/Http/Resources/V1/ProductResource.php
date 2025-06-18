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
        return [
            'type' => 'product',
            'id' => $this->id,
            'attributes' => array_merge([
                'name' => $this->name,
                'description' => $this->description,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ], $request->boolean('include_meta') ? [
                    'metaTitle' => $this->meta_title,
                    'metaDescription' => $this->meta_description,
                    'metaKeywords' => $this->meta_keywords,
                ] : []),
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
                'categories' => $this->categories_id ? [
                    'data' => [
                        'type' => 'categories',
                        'id' => $this->categories_id
                    ],
                    'links' => [
                        'self' => route('category.show', $this->categories_id)
                    ]
                ] : null,
            ]),
            'includes' => [
                'categories' => new CategoryResource($this->whenLoaded('categories')),
                'galleries' => new GalleryResource($this->whenLoaded('galleries')),
            ],
            'links' => [
                'self' => route('product.show', ($this->id))
            ]
        ];
    }
}
