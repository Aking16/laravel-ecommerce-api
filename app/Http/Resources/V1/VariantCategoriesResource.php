<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VariantCategoriesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return array_filter([
            'type' => 'variantCategories',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'links' => [
                'self' => route('variant-categories.show', $this->id)
            ]
        ]);
    }
}
