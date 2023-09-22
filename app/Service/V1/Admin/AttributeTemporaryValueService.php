<?php

namespace App\Service\V1\Admin;

use App\Models\AttributeTemporaryValue;
use App\Service\TranslateService;

class AttributeTemporaryValueService
{
    public static function storeAttributeTemporaryValues($data, $attribute): AttributeTemporaryValue
    {
        $newAttributeTempValue = new AttributeTemporaryValue();
        $newAttributeTempValue->attribute_id = $attribute->id;
        $newAttributeTempValue->value = $data['value'];
        $newAttributeTempValue->save();
        (new TranslateService())->storeTranslate($newAttributeTempValue, $data['label'], 'label');
        return $newAttributeTempValue;
    }

    public static function updateAttributeTemporaryValues($data , $attributeTemporaryValue)
    {
        $attributeTemporaryValue->value = $data['value'];
        $attributeTemporaryValue->update();
        (new TranslateService())->updateTranslate($attributeTemporaryValue, $data['label'], 'label');
        return $attributeTemporaryValue;
    }

    public static function deleteAttributeTemporaryValue($attributeTemporaryValue)
    {
        $attributeTemporaryValue->is_deleted = 1;
        $attributeTemporaryValue->update();
        return $attributeTemporaryValue;
    }
}
