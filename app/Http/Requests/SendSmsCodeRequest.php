<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SendSmsCodeRequest extends FormRequest
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
            'login' => ['required', Rule::exists('users', 'login')],
            'captcha' => ['array', 'required'],
            'captcha.code' => ['required', 'string'],
            'captcha.temp_key' => ['required', 'string']
        ];
    }
}
