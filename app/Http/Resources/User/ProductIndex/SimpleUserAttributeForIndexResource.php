<?php

namespace App\Http\Resources\User\ProductIndex;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleUserAttributeForIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return  [
            'id' => $this['id'],
            'type' => $this['type'],
            'static' => $this['static'],
            'is_deleted' => $this['is_deleted'],
            'order' => $this['order'],
            'access_filter' => $this['access_filter'],
            'limit' => $this['limit'],
            'access_translate' => $this['access_translate'],
            'name' => $this->translate?$this->translate->value:null,
        ];
    }
}
