<?php

namespace App\Http\Requests\Api\V1\Attributes;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreAttributesRequest extends FormRequest
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
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'discount_number' => 'nullable|integer',
            'discount_percentage' => 'nullable|numeric',
            'galleries_id' => 'required|exists:galleries,id',
            'variants_id' => 'required|exists:variants,id',
        ];
    }
}
