<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
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
            'name' => ['required', 'array'],
            'name.uz' => ['required', 'string'],
            'name.ru' => ['required', 'string'],
            'slug' => ['required', Rule::unique('categories', 'slug')->where('is_deleted', 0)],
            'image' => ['required' , 'image' , 'mimes:jpeg,png,jpg,svg,webp']
        ];
    }
}
