<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBrandRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:25'],
            'slug' => ['required', Rule::unique('brands', 'slug')->where('is_deleted', 0)],
            'image' => ['image', 'mimes:jpeg,png,jpg,svg,webp'],
            'category_id' => ['required', Rule::exists('categories', 'id')->where('is_deleted', 0)]
        ];
    }
}
