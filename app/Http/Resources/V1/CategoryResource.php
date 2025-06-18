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
            'type' => 'categories',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'description' => $this->description,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'relationships' => array_filter([
                'galleries_id' => $this->galleries_id ? [
                    'data' => [
                        'type' => 'galleries',
                        'id' => $this->galleries_id
                    ],
                    'links' => [
                        'self' => route('gallery.show', $this->galleries_id)
                    ]
                ] : null
            ]),
            'includes' => new GalleryResource($this->whenLoaded('gallery')),
            'links' => [
                'self' => route('category.show', ($this->id))
            ]
        ];
    }
}
