<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\User\GetCaptchaResource;
use App\Models\CaptchaImage;
use App\Models\CaptchaImageKey;
use App\Service\V1\Auth\GenerateKeyService;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class CaptchaImageController extends Controller
{
    use ApiResponser;
    public function get_captcha(Request $request): \Illuminate\Http\JsonResponse
    {
        $captcha = CaptchaImage::inRandomOrder()->first();
        $generatedKey = GenerateKeyService::generate(30,'alpha' , 'upper');
        $captchaKey = CaptchaImageKey::create([
            'captcha_image_key' => $captcha->key,
            'temp_key' => $generatedKey,
            'ip' => $request->getClientIp()
        ]);
        return $this->success(new GetCaptchaResource($captchaKey),'Success');
    }
}
