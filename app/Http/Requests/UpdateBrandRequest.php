<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateBrandRequest extends FormRequest
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
            'name' => ['string', 'min:2', 'max:25'],
            'slug' => [ Rule::unique('brands', 'slug')->where('is_deleted', 0)->ignore($this->route('brand') , 'id')],
            'image' => [ 'mimes:jpeg,png,jpg,svg,webp'],
            'category_id' => [ Rule::exists('categories', 'id')->where('is_deleted', 0)]
        ];
    }
}
