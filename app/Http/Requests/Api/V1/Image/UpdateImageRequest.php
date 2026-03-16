<?php

namespace App\Http\Requests\Api\V1\Image;

use Illuminate\Foundation\Http\FormRequest;

class UpdateImageRequest extends FormRequest
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
            'file' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
            'is_main' => 'sometimes|boolean',
            'imageable_id' => 'sometimes|integer',
            'imageable_type' => 'sometimes|string'
        ];
    }
}
