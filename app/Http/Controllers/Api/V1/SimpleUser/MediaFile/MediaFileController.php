<?php

namespace App\Http\Controllers\Api\V1\SimpleUser\MediaFile;

use App\Http\Controllers\Controller;
use App\Http\Requests\SimpleUser\MediaFile\StoreMediaFileRequest;
use App\Http\Requests\SimpleUser\MediaFile\StoreProductImageRequest;
use App\Models\MediaFile;
use App\Service\FileSave;
use App\Traits\ApiResponser;
use Illuminate\Http\Request;

class MediaFileController extends Controller
{
    use ApiResponser;

    public function store_product_image(StoreProductImageRequest $request): \Illuminate\Http\JsonResponse
    {
        $url = FileSave::storeFile('product_images', $request->file('image'));
        $newMediaFile = new MediaFile();
        $newMediaFile->url = $url;
        $newMediaFile->type = 'image';
        $newMediaFile->save();
        return $this->success($newMediaFile, 'Success', 201);
    }
}
