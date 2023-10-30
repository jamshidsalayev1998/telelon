<?php

namespace App\Http\Resources\User\ProductIndex;

use App\Http\Resources\User\SimpleUserAttributeTemporaryValueResource;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpleUserProductAttributeForIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'attribute' => new SimpleUserAttributeForIndexResource($this->attribute),
            'attribute_temporary_value' => new SimpleUserAttributeTemporaryValueResource($this->attribute_temporary_value)
        ];
    }
}
