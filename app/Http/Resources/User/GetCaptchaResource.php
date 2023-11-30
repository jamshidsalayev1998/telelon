<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\File;

class GetCaptchaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $file = File::get($this->captcha_image->image);
        return [
            'image' => base64_encode($file),
            'temp_key' => $this->temp_key,
            'code' => $this->captcha_image->code
        ];
    }
}
