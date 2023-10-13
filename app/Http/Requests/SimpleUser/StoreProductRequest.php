<?php

namespace App\Http\Requests\SimpleUser;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreProductRequest extends FormRequest
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
    public function rules()
    {
        return [
            'model_product_id' => ['required', Rule::exists('model_products', 'id')->where('is_deleted', 0)],
            'price' => ['required','integer'],
            'box_doc' => ['required','integer', Rule::in([0, 1, 2])],
            'exchange' => ['required','boolean'],
            'currency_key' => ['required' , Rule::in(['sum' , 'dollar'])],
            'is_new' => ['required' , 'boolean'],
            'area_id' => ['required' , Rule::exists('areas' , 'id')],
            'images' => ['required' , 'array' , 'min:1'],
            'images.*' => ['required' , 'array'],
            'images.*.is_main' => ['required' , Rule::in([0,1])],
            'images.*.file_image' => ['required' , 'file' , 'mimes:jpg,jpeg,png'],
            'attribute' => ['required' , 'array'],
            'attribute.*' => ['required' , 'array'],
            'attribute.*.attribute_id' => ['required' , Rule::exists('attributes' , 'id')->where('is_deleted' , 0)],
            'attribute.*.attribute_temporary_value_id' => ['required' , Rule::exists('attribute_temporary_values' , 'id')->where('is_deleted' , 0)]
        ];
    }
}
