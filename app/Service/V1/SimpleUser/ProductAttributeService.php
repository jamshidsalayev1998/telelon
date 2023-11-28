<?php


namespace App\Service\V1\SimpleUser;


use App\Models\AttributeTemporaryValue;
use App\Models\ProductAttribute;

class ProductAttributeService
{
    public static function storeProductAttributes($attributes, $productId)
    {
        foreach ($attributes as $attribute) {
            $value = null;
            $newProductAttribute = new ProductAttribute();
            if (key_exists('attribute_temporary_value_id', $attribute)) {
                $attributeTemporaryValue = AttributeTemporaryValue::find($attribute['attribute_temporary_value_id']);
                $newProductAttribute->attribute_temporary_value_id = $attribute['attribute_temporary_value_id'];
                $value = $attributeTemporaryValue->value;
            }
            elseif (key_exists('value', $attribute)){
                $value = $attribute['value'];
            }
            $newProductAttribute->value = $value;
            $newProductAttribute->attribute_id = $attribute['attribute_id'];
            $newProductAttribute->product_id = $productId;
            $newProductAttribute->save();
        }
    }
}
