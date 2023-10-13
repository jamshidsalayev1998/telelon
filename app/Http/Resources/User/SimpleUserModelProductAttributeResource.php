<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Admin\ModelProductAttributeTemporaryValueResource;
use App\Models\Attribute;
use App\Models\ModelProductAttributeTemporaryValue;
use App\Models\Translate;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpleUserModelProductAttributeResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $temporaryValues = ModelProductAttributeTemporaryValue::where('model_product_id', $this['pivot']['model_product_id'])->where('attribute_id', $this['pivot']['attribute_id'])->with('attribute_temporary_value.translate')->get();
        $result = [
            'id' => $this['id'],
            'type' => $this['type'],
            'static' => $this['static'],
            'is_deleted' => $this['is_deleted'],
            'order' => $this['order'],
            'access_filter' => $this['access_filter'],
            'limit' => $this['limit'],
            'access_translate' => $this['access_translate'],
            'name' => $this->translate?$this->translate->value:null,
            'values' => SimpleUserModelProductAttributeTemporaryValueResource::collection($temporaryValues),
        ];
        return $result;
    }
}
