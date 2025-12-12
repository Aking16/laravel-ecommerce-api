<?php

namespace App\Http\Requests\Api\V1\Carts;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCartsRequest extends FormRequest
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
            'attributes_id' => 'sometimes|integer|exists:attributes,id',
            'discounts_id' => 'sometimes|integer|exists:discounts,id'
        ];
    }
}
