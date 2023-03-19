<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property mixed $attribute_temporary_values
 */
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
        ];
        $translates = [];
        foreach ($this->translates as $translate) {
            $translates[$translate->field_name][$translate->language] = $translate->value;
        }
        $result['translates'] = $translates;

        if (key_exists('relations', $dataRequest)) {
            $searchable = array_filter($dataRequest['relations'], function ($value) {
                return strpos($value, 'attribute_temporary_values') !== false;
            });
            if (count($searchable)) {
                $result['attribute_temporary_values'] = AttributeTemporaryValueResource::collection($this->attribute_temporary_values);
            }
        }

        return $result;
    }
}
