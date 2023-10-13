<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleUserAreaResource extends JsonResource
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
            'region_id' => $this['region_id'],
            'name' => $this->translate?$this->translate->value:null
        ];
        return $result;
    }
}
