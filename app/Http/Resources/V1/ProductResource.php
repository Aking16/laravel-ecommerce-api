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
                    'meta_title' => $this->meta_title,
                    'meta_description' => $this->meta_description,
                    'meta_keywords' => $this->meta_keywords,
                ] : []),
            'relationships' => array_filter([
                'thumbnail' => $this->thumbnail ? [
                    'data' => [
                        'type' => 'thumbnail',
                        'id' => $this->thumbnail
                    ],
                    'links' => [
                        'self' => route('gallery.show', $this->thumbnail)
                    ]
                ] : null,

                'category' => $this->category ? [
                    'data' => [
                        'type' => 'category',
                        'id' => $this->category
                    ],
                    'links' => [
                        'self' => route('category.show', $this->category)
                    ]
                ] : null,
            ]),
            'includes' => new CategoryResource($this->whenLoaded('category')),
            'links' => [
                'self' => route('product.show', ($this->id))
            ]
        ];
    }
}
