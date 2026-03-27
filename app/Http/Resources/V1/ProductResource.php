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
                'slug' => $this->slug,
                'highestPrice' => $this->skus_max_price,
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
                'subCategory' => [
                    'data' => [
                        'type' => 'sub-category',
                        'id' => $this->sub_category_id
                    ],
                    'links' => [
                        'self' => route('category.show', $this->sub_category_id)
                    ]
                ],
                'mainImage' => $this->mainImage ? [
                    'data' => [
                        'type' => 'image',
                        'id' => $this->mainImage->id
                    ],
                    'links' => [
                        'self' => route('image.show', $this->mainImage->id)
                    ]
                ] : null,
                'images' => $this->images->isNotEmpty() ? [
                    'data' => $this->images->map(fn($image) => [
                        'type' => 'image',
                        'id' => $image->id,
                    ])
                ] : null,
                'variants' => $this->variants->isNotEmpty() ? [
                    'data' => $this->variants->map(fn($variant) => [
                        'type' => 'variant',
                        'id' => $variant->id,
                    ])
                ] : null,
                'variantValues' => $this->variantValues->isNotEmpty() ? [
                    'data' => $this->variantValues->map(fn($variantValue) => [
                        'type' => 'variantValue',
                        'id' => $variantValue->id,
                    ])
                ] : null,
                'skus' => $this->skus->isNotEmpty() ? [
                    'data' => $this->skus->map(fn($sku) => [
                        'type' => 'product-sku',
                        'id' => $sku->id,
                    ])
                ] : null,
            ]),
            'includes' => array_filter([
                'subCategory' => $includes->has('subCategory') && $this->relationLoaded('subCategory')
                    ? new SubCategoryResource($this->subCategory)
                    : null,
                'mainImage' => $includes->has('mainImage') && $this->relationLoaded('mainImage')
                    ? new ImageResource($this->mainImage)
                    : null,
                'images' => $includes->has('images') && $this->relationLoaded('images')
                    ? ImageResource::collection($this->images)
                    : null,
                'variants' => $includes->has('variants') && $this->relationLoaded('variants')
                    ? ProductVariantResource::collection($this->variants)
                    : null,
                'variantValues' => $includes->has('variantValues') && $this->relationLoaded('variantValues')
                    ? ProductVariantValueResource::collection($this->variantValues)
                    : null,
                'skus' => $includes->has('skus') && $this->relationLoaded('skus')
                    ? ProductSkuResource::collection($this->skus)
                    : null,
                'skuValues' => $includes->has('skuValues') && $this->relationLoaded('skuValues')
                    ? SkuVariantValueResource::collection($this->skuValues)
                    : null,
            ]),
            'links' => [
                'self' => route('product.show', ($this->id))
            ]
        ]);
    }
}
