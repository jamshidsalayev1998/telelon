<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributeShowResource extends JsonResource
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
            'type' => $this->type,
            'access_filter' => $this->access_filter,
            'access_translate' => $this->access_translate,
            'limit' => $this->limit,
            'static' => $this->static,
            'order' => $this->order,
            'attribute_temporary_values' => AttributeTemporaryValueResource::collection($this->attribute_temporary_values)
        ];
        $translates = [];
        foreach ($this->translates as $translate) {
            $translates[$translate->field_name][$translate->language] = $translate->value;
        }
        $result['translates'] = $translates;
        return $result;
    }
}
