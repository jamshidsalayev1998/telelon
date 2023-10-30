<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProductImagesIndexResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
//        return $this->media_file;
        return [
            'id' => $this->id,
            'is_main' => $this->is_main,
            'media_file_id' => $this->media_file_id,
            'url' => $this->media_file->url,
            'type' => $this->media_file->type,
//            'media_file' => $this->media_file,
        ];
    }
}
