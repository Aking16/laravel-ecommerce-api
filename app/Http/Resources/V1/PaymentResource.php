<?php

namespace App\Http\Resources\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'type' => 'payments',
            'id' => $this->id,
            'attributes' => [
                'status' => $this->status,
                'method' => $this->method,
                'amount' => $this->amount,
                'transactionId' => $this->transaction_id,
                'meta' => $this->meta,
                'createdAt' => $this->created_at,
                'updatedAt' => $this->updated_at,
            ],
            'relationships' => [
                'cart' => [
                    'data' => [
                        'type' => 'carts',
                        'id' => $this->cart_id
                    ]
                ]
            ],
            'includes' => [
                'cart' => new CartsResource($this->whenLoaded('cart')),
            ],
            'links' => [
                'self' => route('payments.show', ($this->id))
            ]
        ];
    }
}
