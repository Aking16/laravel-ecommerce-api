<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'category',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'description' => $this->description,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'relationships' => array_filter([
                'thumbnail' => $this->thumbnail ? [
                    'data' => [
                        'type' => 'gallery',
                        'id' => $this->thumbnail
                    ],
                    'links' => [
                        'self' => route('gallery.show', $this->thumbnail)
                    ]
                ] : null
            ]),
            'links' => [
                'self' => route('category.show', ($this->id))
            ]
        ];
    }
}
