<?php

namespace App\Http\Resources\Admin;

use App\Models\Attribute;
use App\Models\ModelProductAttributeTemporaryValue;
use App\Models\Translate;
use Illuminate\Http\Resources\Json\JsonResource;

class ModelProductAttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $temporaryValues = ModelProductAttributeTemporaryValue::where('model_product_id' , $this['pivot']['model_product_id'])->where('attribute_id' , $this['pivot']['attribute_id'])->with('attribute_temporary_value.translates')->get();
        $result = [
            'id' => $this['id'],
            'type' => $this['type'],
            'static' => $this['static'],
            'is_deleted' => $this['is_deleted'],
            'order' => $this['order'],
            'access_filter' => $this['access_filter'],
            'limit' => $this['limit'],
            'access_translate' => $this['access_translate'],
            'values' => ModelProductAttributeTemporaryValueResource::collection($temporaryValues),
        ];
        $translates = [];
        $dataRequest = $request->all();
        if (key_exists('relations', $dataRequest)) {
            $searchable = array_filter($dataRequest['relations'], function ($value) {
                return strpos($value, 'attributes.translates') !== false;
            });
            if (count($searchable)) {
                $attribute = Attribute::find($this['id']);
                $attributeTranslates = Translate::where('table_name', $attribute->tableName)->where('model_id', $attribute->id)->get();
                foreach ($attributeTranslates as $translate) {
                    $translates[$translate->field_name][$translate->language] = $translate->value;
                }
                $result['translates'] = $translates;
            }
        }


        return $result;
//        return $this;
    }
}
