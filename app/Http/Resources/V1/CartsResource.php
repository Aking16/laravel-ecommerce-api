<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return array_filter([
            'type' => 'carts',
            'id' => $this->id,
            'carts' => [
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'relationships' => array_filter([
                'attributes' => $this->attributes ? [
                    'data' => $this->attributes->map(function ($attribute) {
                        return [
                            'type' => 'attributes',
                            'id'   => $attribute->id,
                        ];
                    }),
                    'links' => [
                        'related' => route('attributes.index'),
                    ]
                ] : null,
            ]),
            'includes' => array_filter([
                'attributes' =>
                $this->relationLoaded('attributes')
                    &&  request()->query('include')
                    ? AttributesResource::collection($this->attributes)
                    : null,
            ]),
            'links' => [
                'self' => route('carts.show', $this->id)
            ]
        ]);
    }
}
