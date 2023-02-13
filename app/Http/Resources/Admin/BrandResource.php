<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
//     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $result = [
            'id' => $this['id'],
            'slug' => $this['slug'],
            'image' => $this['image'],
            'status' => $this['status'],
            'name' => $this['name'],
        ];
//        if (property_exists($this,'category')) {
            $category = CategoryResource::collection(array($this['category']));
            $result['category'] = $category;
//        }
        return $result;
    }
}
