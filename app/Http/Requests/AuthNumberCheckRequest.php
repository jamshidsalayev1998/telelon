<?php

namespace App\Http\Requests;

use App\Models\CaptchaImageKey;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $login
 */
class AuthNumberCheckRequest extends FormRequest
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
            'login' => ['required', 'max:9', 'min:9'],
//            'captcha' => ['array', 'required'],
//            'captcha.code' => ['required', 'string'],
//            'captcha.temp_key' => ['required', 'string']
        ];
    }

    public function withValidator($validator)
    {
//        $validator->after(function ($validator) {
//            $temp_key = $this->captcha['temp_key'];
//            $timeEnd = date('Y-m-d H:i:s', strtotime('- 5 minutes'));
//            $captchaImageKey = CaptchaImageKey::where('temp_key', $temp_key)->whereDate('created_at', '>=', $timeEnd)->first();
//            if (!$captchaImageKey) {
//                $validator->errors()->add('captcha.temp_key', 'key noto`g`ri');
//            } else {
//                $captchaImage = $captchaImageKey->captcha_image;
//                if ($captchaImage->code != $this->captcha['code']) {
//                    $validator->errors()->add('captcha', 'Captcha kodi noto`g`ri');
//                }
//            }
//        });
    }
}
