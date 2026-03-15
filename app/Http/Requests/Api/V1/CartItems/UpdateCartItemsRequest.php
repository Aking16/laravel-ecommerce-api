<?php

namespace App\Http\Requests\Api\V1\CartItems;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartItemsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => ['required', 'integer', 'min:1'],
        ];
    }
}
