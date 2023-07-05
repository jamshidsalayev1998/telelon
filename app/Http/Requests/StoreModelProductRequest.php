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
        $rules = [
            'name' => ['required', 'array'],
            'name.uz' => ['required', 'string'],
            'name.ru' => ['required', 'string'],
//            'brand_id' => [Rule::exists('brands', 'id')->where('is_deleted', 0)],
//            'category_id' => [Rule::exists('categories', 'id')->where('is_deleted', 0)],
            'parent_id' => [Rule::exists('model_products', 'id')->where('is_deleted', 0)],
            'attributes' => ['array'],
            'attributes.*.attribute_id' => ['required', Rule::exists('attributes', 'id')->where('is_deleted', 0)],
            'attributes.*' => ['required', new ModelProductAttributeStoreRule],

        ];
        if (!$this->has('parent_id')) {
            $rules['brand_id'] = ['required', Rule::exists('brands', 'id')->where('is_deleted', 0)];
            $rules['category_id'] = ['required', Rule::exists('categories', 'id')->where('is_deleted', 0)];
        }
        return $rules;
    }
}
