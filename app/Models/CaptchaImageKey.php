<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CaptchaImageKey extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function captcha_image()
    {
        return $this->belongsTo(CaptchaImage::class,'captcha_image_key' , 'key');
    }

}
