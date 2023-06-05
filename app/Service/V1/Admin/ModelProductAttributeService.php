<?php

namespace App\Service\V1\Admin;

use App\Models\Attribute;
use App\Models\CodeBug;
use App\Models\ModelProductAttribute;

class ModelProductAttributeService
{
    public static function storeModelProductAttributes($modelProduct, $data)
    {
        foreach ($data as $item) {
            $attribute = Attribute::find($item['attribute_id']);
            $value = [
                'model_product_id' => $modelProduct->id,
                'attribute_id' => $item['attribute_id'],
            ];
            if ($attribute->type == 'string' && $attribute->static) {
                $value['value'] = json_encode($item['value']);
            }
            if ($attribute->type == 'select') {
                ModelProductAttributeTemporaryValuesService::storeModelProductAttributeTemporaryValues($modelProduct,$attribute,$item['temporary_values']);
            }
            ModelProductAttribute::create($value);
        }
    }

    public static function updateModelProductAttributes($modelProduct, $data)
    {
        foreach ($data as $attribute) {
            $attributeId = $attribute['attribute_id'];
            $value = $attribute['value'];

            // Check if the attribute already exists in the pivot table
            if ($modelProduct->attributes()->where('id', $attributeId)->exists()) {
                // Update the attribute's value
                try {

                    $modelProduct->attributes()->updateExistingPivot($attributeId, [
                        'value' => json_encode($value)
                    ]);
                } catch (\Exception $exception) {
                    CodeBug::create([
                        'error' => $exception->getMessage(),
                        'code' => $exception->getCode(),
                        'type' => 'Update the attribute`s value'
                    ]);
                }
            } else {
                // Add the new attribute to the pivot table
                try {

                    $modelProduct->attributes()->attach($attributeId, [
                        'value' => json_encode($value)
                    ]);
                } catch (\Exception $exception) {
                    CodeBug::create([
                        'error' => $exception->getMessage(),
                        'code' => $exception->getCode(),
                        'type' => 'Add the new attribute to the pivot table'
                    ]);
                }
            }
        }

        $newAttributeIds = collect($data)->pluck('attribute_id')->toArray();
        // Remove any attributes that were not sent by the frontend
        $modelProduct->attributes()->sync($newAttributeIds);
//        return $modelProduct;
    }
}
