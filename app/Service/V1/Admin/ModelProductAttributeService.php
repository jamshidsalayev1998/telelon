<?php
namespace App\Service\V1\Admin;

use App\Models\Attribute;
use App\Models\ModelProductAttribute;

class ModelProductAttributeService{
    public static function storeModelProductAttributes($modelProduct , $data)
    {
        foreach ($data as $item) {
            $attribute = Attribute::find($item['attribute_id']);
            $value = [
                'model_product_id' => $modelProduct->id,
                'attribute_id' => $item['attribute_id'],
            ];
            if ($attribute->type == 'select' || ($attribute->type == 'string' && $attribute->static)){
                $value['value'] = json_encode($item['value']);
            }
            ModelProductAttribute::create($value);
        }
    }
}
