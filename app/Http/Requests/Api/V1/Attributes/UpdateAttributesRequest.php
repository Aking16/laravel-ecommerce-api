<?php

namespace App\Http\Requests\Api\V1\Attributes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateAttributesRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::user()->is_admin;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'price' => 'sometimes|numeric',
            'stock' => 'sometimes|integer',
            'discount_number' => 'sometimes|integer',
            'discount_percentage' => 'sometimes|numeric',
            'galleries_id' => 'sometimes|exists:galleries,id',
            'variants_id' => 'sometimes|exists:variants,id',
        ];
    }
}
