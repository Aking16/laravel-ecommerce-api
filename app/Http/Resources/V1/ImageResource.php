<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ImageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'image',
            'id' => $this->id,
            'attributes' => [
                'path' => Storage::disk('public')->url($this->path),
                'isMain' => $this->is_main,
                'createdAt' => $this->created_at,
            ],
            'relationships' => [
                'imageable' => [
                    'id' => $this->imageable_id,
                    'type' => $this->imageable_type
                ]
            ],
            'links' => [
                'self' => route('image.show', $this->id)
            ]
        ];
    }
}
