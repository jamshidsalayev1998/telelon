<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class AttributeTemporaryValueResource extends JsonResource
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
            'value' => $this['value'],
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
        }

        return $result;
    }
}
