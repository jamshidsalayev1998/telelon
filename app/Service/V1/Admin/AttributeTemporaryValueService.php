<?php

namespace App\Service\V1\Admin;

use App\Models\AttributeTemporaryValue;
use App\Service\TranslateService;

class AttributeTemporaryValueService
{
    public static function storeAttributeTemporaryValues($data, $attribute)
    {
        $newAttributeTempValue = new AttributeTemporaryValue();
        $newAttributeTempValue->attribute_id = $attribute->id;
        $newAttributeTempValue->value = $data['value'];
        $newAttributeTempValue->save();
        (new TranslateService())->storeTranslate($newAttributeTempValue, $data['label'], 'label');
        return $newAttributeTempValue;
    }
}
