<?php

namespace App\Http\Requests\Api\V1\CartItems;

use Illuminate\Foundation\Http\FormRequest;

class StoreCartItemsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'cart_id' => ['required', 'exists:carts,id'],
            'attribute_id' => ['required', 'exists:product_attributes,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
