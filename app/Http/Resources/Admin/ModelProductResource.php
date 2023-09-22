<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class ModelProductResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $dataRequest = $request->all();

        $result = [
            'id' => $this['id'],
            'children' => ModelProductResource::collection($this['children']),
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
                $result['attributes'] = ModelProductAttributeResource::collection($this['attributes']);
//                $result['attributes'] =$this['attributes'];
            }
            $searchable = array_filter($dataRequest['relations'], function ($value) {
                return strpos($value, 'category') !== false;
            });
            if (count($searchable)) {
                $result['category'] = new CategoryResource($this['category']);
//                $result['attributes'] =$this['attributes'];
            }
            $searchable = array_filter($dataRequest['relations'], function ($value) {
                return strpos($value, 'brand') !== false;
            });
            if (count($searchable)) {
                $result['brand'] = new BrandResource($this['brand']);
//                $result['attributes'] =$this['attributes'];
            }
            $searchable = array_filter($dataRequest['relations'], function ($value) {
                return strpos($value, 'children') !== false;
            });
//            if (count($searchable)) {
//                if (count($this['children']))
//                    $result['children'] = ModelProductResource::collection($this['children']);
//                $result['attributes'] =$this['attributes'];
//            }
        }

        return $result;
    }
}
