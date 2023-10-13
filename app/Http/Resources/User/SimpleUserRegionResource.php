<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class SimpleUserRegionResource extends JsonResource
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
            'id' => $this->id,
//            'areas' => SimpleUserAreaResource::collection($this->areas),
            'name' => $this->translate?$this->translate->value:null,
        ];
        if (key_exists('relations', $dataRequest)) {
            $searchable = array_filter($dataRequest['relations'], function ($value) {
                return strpos($value, 'areas') !== false;
            });
            if (count($searchable)) {
                $categories = SimpleUserAreaResource::collection($this->areas);
                $result['areas'] = $categories;
            }
        }
        return $result;
    }
}
