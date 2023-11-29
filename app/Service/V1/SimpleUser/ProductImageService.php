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
            $newProductImage->media_file_id = $item['media_file_id'];
            $newProductImage->save();
        }
    }

    public static function updateProductImage($dataArray , $productId , $userId)
    {
        ProductImage::where('product_id' , $productId)->delete();
        foreach ($dataArray as $item) {
            $newProductImage = new ProductImage();
            $newProductImage->is_main = $item['is_main'];
            $newProductImage->user_id = $userId;
            $newProductImage->product_id = $productId;
            $newProductImage->media_file_id = $item['media_file_id'];
            $newProductImage->save();
        }
    }
}
