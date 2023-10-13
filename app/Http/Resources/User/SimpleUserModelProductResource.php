<?php

namespace App\Http\Resources\User;

use App\Http\Controllers\Api\V1\SimpleUser\SimpleUserBrandController;
use App\Http\Resources\Admin\BrandResource;
use App\Http\Resources\Admin\ModelProductAttributeResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpleUserModelProductResource extends JsonResource
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
            'id' => $this->id,
            'children' => SimpleUserModelProductResource::collection($this['children']),
            'name' => $this->translate?$this->translate->value:null
        ];
        if (key_exists('relations', $dataRequest)) {
            $searchable = array_filter($dataRequest['relations'], function ($value) {
                return strpos($value, 'translates') !== false;
            });
            $searchable = array_filter($dataRequest['relations'], function ($value) {
                return strpos($value, 'attributes') !== false;
            });
            if (count($searchable)) {
                $result['attributes'] = SimpleUserModelProductAttributeResource::collection($this['attributes']);
            }
            $searchable = array_filter($dataRequest['relations'], function ($value) {
                return strpos($value, 'category') !== false;
            });
            if (count($searchable)) {
                $result['category'] = new SimpleUserCategoryResource($this['category']);
            }
            $searchable = array_filter($dataRequest['relations'], function ($value) {
                return strpos($value, 'brand') !== false;
            });
            if (count($searchable)) {
                $result['brand'] = new BrandResource($this['brand']);
            }
        }
        return $result;
    }
}
