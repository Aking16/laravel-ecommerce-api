<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GalleryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'gallery',
            'id' => $this->id,
            'attributes' => [
                'name' => $this->name,
                'file' => $this->file,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            // 'relationships' => array_filter([
            //     'thumbnail' => $this->thumbnail ? [
            //         'data' => [
            //             'type' => 'gallery',
            //             'id' => $this->thumbnail
            //         ],
            //         'links' => [
            //             'self' => route('gallery.show', $this->thumbnail)
            //         ]
            //     ] : null
            // ]),
            // 'includes' => $this->gallery,
            'links' => [
                'self' => route('gallery.show', ($this->id))
            ]
        ];
    }
}
