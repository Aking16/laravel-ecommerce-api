<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\IncludeParser;
use App\Models\Product;

class ProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $includes = new IncludeParser($request, Product::ALLOWED_INCLUDES);

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
                        'id' => $this->category_id
                    ],
                    'links' => [
                        'self' => route('category.show', $this->category_id)
                    ]
                ],
                'images' => $this->images->isNotEmpty() ? [
                    'data' => $this->images->map(fn($image) => [
                        'type' => 'image',
                        'id' => $image->id,
                    ])
                ] : null,
            ]),
            'includes' => array_filter([
                'category' => $includes->has('category') && $this->relationLoaded('category')
                    ? new CategoryResource($this->category)
                    : null,
                'mainImage' => $includes->has('mainImage') && $this->relationLoaded('mainImage')
                    ? new ImageResource($this->mainImage)
                    : null,
                'images' => $includes->has('images') && $this->relationLoaded('images')
                    ? ImageResource::collection($this->images)
                    : null,
            ]),
            'links' => [
                'self' => route('product.show', ($this->id))
            ]
        ]);
    }
}
