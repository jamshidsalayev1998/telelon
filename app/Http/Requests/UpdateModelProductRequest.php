<?php

namespace App\Http\Requests;

use App\Rules\ModelProductAttributeStoreRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateModelProductRequest extends FormRequest
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
            'name' => ['required', 'array'],
            'name.uz' => ['required', 'string'],
            'name.ru' => ['required', 'string'],
            'brand_id' => ['nullable', Rule::exists('brands', 'id')->where('is_deleted', 0)],
            'category_id' => ['nullable', Rule::exists('categories', 'id')->where('is_deleted', 0)],
            'parent_id' => ['nullable',Rule::exists('model_products', 'id')->where('is_deleted', 0)],
            'attributes' => ['required', 'array'],
            'attributes.*.attribute_id' => ['required', Rule::exists('attributes', 'id')->where('is_deleted', 0)],
            'attributes.*' => ['required', new ModelProductAttributeStoreRule()]
        ];
    }
}
