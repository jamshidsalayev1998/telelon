<?php

namespace App\Http\Resources\User;

use App\Http\Resources\Admin\BrandResource;
use App\Http\Resources\User\ProductIndex\SimpleUserProductAttributeForIndexResource;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProductIndexResource extends JsonResource
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
            'description' => $this->description,
            'model_product' => new SimpleUserModelProductResource($this->model_product),
            'category' => new SimpleUserCategoryResource($this->category),
            'brand' => new BrandResource($this->brand),
            'status' => $this->status,
            'box_doc' => $this->box_doc,
            'exchange' => $this->exchange,
            'price' => $this->price,
            'currency' => $this->currency,
            'is_new' => $this->is_new,
            'region' => new SimpleUserRegionResource($this->region),
            'area' => new SimpleUserAreaResource($this->area),
            'images' => UserProductImagesIndexResource::collection($this->images),
            'created_at' => $this->created_at,
            'product_attributes' => SimpleUserProductAttributeForIndexResource::collection($this->product_attributes)
        ];
    }
}
