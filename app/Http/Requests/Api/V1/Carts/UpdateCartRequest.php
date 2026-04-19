<?php

namespace App\Http\Requests\Api\V1\Carts;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sku_id' => ['sometimes', 'exists:product_skus,id'],
            'quantity' => ['nullable', 'integer', 'min:1']
        ];
    }
}
