<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StoreAttributeRequest extends FormRequest
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
            'type' => ['required', Rule::in(['select', 'string', 'range'])],
            'static' => ['required', Rule::in([1, 0])],
            'access_translate' => ['required', Rule::in([1, 0])],
            'access_filter' => ['required', Rule::in([1, 0])],
        ];
    }
}
