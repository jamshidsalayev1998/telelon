<?php

namespace App\Service\V1\SimpleUser;

use App\Models\ProductImage;
use App\Service\FileSave;

class ProductImageService{
    public static function storeProductImage($dataArray , $productId , $userId)
    {
        foreach ($dataArray as $item) {
            $newProductImage = new ProductImage();
            $newProductImage->is_main = $item['is_main'];
            $newProductImage->user_id = $userId;
            $newProductImage->product_id = $productId;
            $newProductImage->url = FileSave::storeFile('product_images' , $item['file_image']);
            $newProductImage->save();
        }
    }
}
