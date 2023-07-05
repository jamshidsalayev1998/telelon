<?php

namespace App\Http\Resources\Admin;

use App\Models\ModelProductAttributeTemporaryValue;
use Illuminate\Http\Resources\Json\JsonResource;

class ModelProductShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $dataRequest = $request->all();

        $result = [
            'id' => $this['id'],
        ];
        if (key_exists('relations', $dataRequest)) {
            $searchable = array_filter($dataRequest['relations'], function ($value) {
                return strpos($value, 'translates') !== false;
            });
            if (count($searchable)) {
                $translates = [];
                foreach ($this['translates'] as $translate) {
                    $translates[$translate['field_name']][$translate['language']] = $translate['value'];
                }
                $result['translates'] = $translates;
            }
            $searchable = array_filter($dataRequest['relations'], function ($value) {
                return strpos($value, 'attributes') !== false;
            });
            if (count($searchable)) {
                $attributes = $this['attributes'];
                foreach ($attributes as $attribute) {
                    $attribute['temporary_values'] = ModelProductAttributeTemporaryValue::where('model_product_id' , $this['id'])->where('attribute_id' , $attribute['id'])->with('attribute_temporary_value')->get();
//                $modelProductAttributeTemporaryValues = ModelProductAttributeTemporaryValue::where()
                }
                $result['attributes'] =ModelProductAttributeResource::collection($this['attributes']);
//                $result['attributes'] =$attributes;
//                $result['attributes'] =$this['attributes'];
            }
        }

        return $result;
    }
}
