<?php

namespace App\Http\Resources\User;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class SimpleUserCategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $result = [
            'id' => $this->id,
            'slug' => $this->slug,
            'image' => $this->image,
            'status' => $this->status,
            'name' => $this->translate?$this->translate->value:null,
        ];

        return $result;
    }
}
