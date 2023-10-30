<?php

namespace App\Http\Resources\Admin;

use App\Models\Category;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'id' => $this['id'],
            'slug' => $this['slug'],
            'image' => config('file_system_assets.category_images').'/'.$this['image'],
            'status' => $this['status'],
        ];
        if (key_exists('relations', $dataRequest)) {
            $searchable = array_filter($dataRequest['relations'], function ($value) {
                return strpos($value, 'translates') !== false;
            });
            if (count($searchable)) {
                $translates = [];
                if ($this['translates']) {
                    foreach ($this['translates'] as $translate) {
                        $translates[$translate['field_name']][$translate['language']] = $translate['value'];
                    }
                }
                else{
                    $cat = Category::with('translates')->find($this['id']);
                    foreach ($cat->translates as $translate) {
                        $translates[$translate['field_name']][$translate['language']] = $translate['value'];
                    }
                }
                $result['translates'] = $translates;
            }
        }

        return $result;
    }
}
