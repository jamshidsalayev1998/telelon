<?php

namespace Database\Seeders;

use App\Models\CaptchaImage;
use App\Service\V1\Auth\GenerateKeyService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class CaptchaImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
     public function run()
    {
        $captchaDir = public_path('files/captcha');
        $captchaFiles = File::files($captchaDir);
        foreach ($captchaFiles as $file) {
            $filename = $file->getFilenameWithoutExtension();
            $ext = $file->getExtension();
            $key = GenerateKeyService::generate(30,'alpha' , 'upper');
            while (CaptchaImage::where('key', $key)->exists()) {
                $key = GenerateKeyService::generate(30,'alpha' , 'upper');
            }
            if (!CaptchaImage::where('code', $filename)->exists()) {
                CaptchaImage::create([
                    'image' => "files/captcha/{$filename}.".$ext,
                    'code' => $filename,
                    'key' => $key
                ]);
            }
        }
    }
}
