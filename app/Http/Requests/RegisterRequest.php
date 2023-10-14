<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * @property mixed login
 */
class RegisterRequest extends FormRequest
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
            'name' => ['required', 'min:3', 'max:60'],
            'login' => ['required', Rule::unique('users', 'login')->where('register_code_status' , 1)],
            'captcha' => ['array', 'required'],
            'captcha.code' => ['required', 'string'],
            'captcha.temp_key' => ['required', 'string']
        ];
    }
}
