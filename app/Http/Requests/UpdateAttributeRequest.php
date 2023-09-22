<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAttributeRequest extends FormRequest
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
            'name' => ['array'],
            'name.uz' => ['string'],
            'name.ru' => ['string'],
            'type' => [Rule::in(['select', 'string', 'range'])],
            'static' => [Rule::in([1, 0])],
            'access_translate' => [Rule::in([1, 0])],
            'access_filter' => [Rule::in([1, 0])],
        ];
    }
}
