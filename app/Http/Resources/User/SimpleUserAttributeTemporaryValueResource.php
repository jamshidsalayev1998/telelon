<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleUserAttributeTemporaryValueResource extends JsonResource
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
            'label' => $this->translate?$this->translate->value:null,
        ];

        return $result;
    }
}
