<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Support\IncludeParser;
use App\Models\SubCategory;

class SubCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $includes = new IncludeParser($request, SubCategory::ALLOWED_INCLUDES);

        return array_filter([
            'type' => 'sub-category',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'slug' => $this->slug,
                'description' => $this->description,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'relationships' => array_filter([
                'image' => $this->image ? [
                    'data' => [
                        'type' => 'image',
                        'id' => $this->image->id
                    ],
                    'links' => [
                        'self' => route('image.show', $this->image)
                    ]
                ] : null,
                'products' => $this->products->isNotEmpty() ? [
                    'data' => $this->products->map(fn($product) => [
                        'type' => 'product',
                        'id' => $product->id,
                    ])
                ] : null,
            ]),
            'includes' => array_filter([
                'products' => $includes->has('products') && $this->relationLoaded('products')
                    ? ProductResource::collection($this->products)
                    : null,
                'image' => $includes->has('image') && $this->relationLoaded('image')
                    ? new ImageResource($this->image)
                    : null,
            ]),
            'links' => [
                'self' => route('sub-category.show', ($this->id))
            ]
        ]);
    }
}
