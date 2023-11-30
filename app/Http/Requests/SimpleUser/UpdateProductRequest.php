<?php

namespace App\Http\Requests\SimpleUser;

use App\Models\Attribute;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateProductRequest extends FormRequest
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
            'model_product_id' => ['required', Rule::exists('model_products', 'id')->where('is_deleted', 0)],
            'price' => ['required', 'integer'],
            'box_doc' => ['required', 'integer', Rule::in([0, 1, 2])],
            'exchange' => ['required', 'boolean'],
            'currency_key' => ['required', Rule::in(['sum', 'dollar'])],
            'is_new' => ['required', 'boolean'],
            'area_id' => ['required', Rule::exists('areas', 'id')],
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['required', 'array'],
            'images.*.media_file_id' => ['required', Rule::exists('media_files', 'id')],
            'images.*.is_main' => ['required', Rule::in([1, 0])],
            'attribute' => ['required', 'array'],
            'attribute.*' => ['required', 'array'],
            'attribute.*.value' => ['nullable'],
            'attribute.*.attribute_temporary_value_id' => ['nullable'],
        ];
        foreach ($this->input('attribute') as $index => $attribute) {
            $attributeId = $attribute['attribute_id'];
            $attributeType = $this->getAttributeType($attributeId);
            $rules["attribute.$index.attribute_id"] = 'required|integer|exists:attributes,id';
            if ($attributeType == 'string') {
                $rules["attribute.$index.value"] = 'required';
                $rules["attribute.$index.attribute_temporary_value_id"] = 'nullable';
            } elseif ($attributeType == 'select') {
                $rules["attribute.$index.value"] = 'nullable';
                $rules["attribute.$index.attribute_temporary_value_id"] = 'required';
            }
        }
        return $rules;
    }

    protected function getAttributeType($attributeId)
    {
        $attribute = Attribute::findOrFail($attributeId);
        return $attribute->type;
    }
}
