<?php

namespace App\Http\Requests;

use App\Models\Attribute;
use App\Rules\ModelProductAttributeStoreRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreModelProductRequest extends FormRequest
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
    public function rules()
    {
        return [
            'name' => ['required', 'array'],
            'name.uz' => ['required', 'string'],
            'name.ru' => ['required', 'string'],
            'brand_id' => ['required', Rule::exists('brands', 'id')->where('is_deleted', 0)],
            'category_id' => ['required', Rule::exists('categories', 'id')->where('is_deleted', 0)],
            'parent_id' => [Rule::exists('model_products', 'id')->where('is_deleted', 0)],
            'attributes' => ['required', 'array'],
            'attributes.*.attribute_id' => ['required', Rule::exists('attributes', 'id')->where('is_deleted', 0)],
            'attributes.*' => ['required', new ModelProductAttributeStoreRule]
        ];
    }
}