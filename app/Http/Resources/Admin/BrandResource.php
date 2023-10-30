<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * //     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $dataRequest = $request->all();
        $result = [
            'id' => $this['id'],
            'slug' => $this['slug'],
            'image' => config('file_system_assets.brand_images').'/'.$this['image'],
            'status' => $this['status'],
            'name' => $this['name'],
        ];
        if (key_exists('relations', $dataRequest)) {
            $searchable = array_filter($dataRequest['relations'], function ($value) {
                return strpos($value, 'categories') !== false;
            });
            if (count($searchable)) {
                $categories = CategoryResource::collection($this['categories']);
                $result['categories'] = $categories;
            }
        }
        return $result;
    }
}
