<?php
namespace App\Service\V1\SimpleUser;


use App\Models\ProductAttribute;

class ProductAttributeService{
    public static function storeProductAttributes($attributes , $productId)
    {
        foreach ($attributes as $attribute) {
            $newProductAttribute = new ProductAttribute();
            $newProductAttribute->attribute_id = $attribute['attribute_id'];
            $newProductAttribute->attribute_temporary_value_id = $attribute['attribute_temporary_value_id'];
            $newProductAttribute->product_id = $productId;
            $newProductAttribute->save();
        }
    }
}
