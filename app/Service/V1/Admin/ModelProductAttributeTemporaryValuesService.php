<?php

namespace App\Service\V1\Admin;

use App\Models\ModelProductAttributeTemporaryValue;

class ModelProductAttributeTemporaryValuesService {
    public static function storeModelProductAttributeTemporaryValues($modelProduct,$attribute,$data): bool
    {
        ModelProductAttributeTemporaryValue::where('model_product_id' , $modelProduct->id)->where('attribute_id' , $attribute->id)->delete();
        foreach ($data as $item) {
            ModelProductAttributeTemporaryValue::create([
                'model_product_id' => $modelProduct->id,
                'attribute_id' => $attribute->id,
                'attribute_temporary_value_id' => $item
            ]);
        }
        return true;
    }
}
