<?php

namespace App\Service\V1\SimpleUser;

use App\Models\Area;
use App\Models\ModelProduct;
use App\Models\Product;
use App\Service\PaginationService;

class SimpleUserProductService
{
    public static function indexProduct($request)
    {
        $brandEloquent = Product::filter($request->filters)
            ->with('region.translate')
            ->with('area.translate')
            ->with('category.translate')
            ->with('product_status')
            ->with('product_attributes.attribute.translate')
            ->with('product_attributes.attribute_temporary_value.translate')
            ->with('model_product.translate')
            ->with('images.media_file')
            ->order($request->desc);
        return PaginationService::makePagination($brandEloquent, $request->limit);
    }
    public static function storeProduct($request)
    {
        $user = auth()->user();
        $area = Area::find($request->area_id);
        $modelProduct = ModelProduct::find($request->model_product_id);
        $newProduct = new Product();
        $newProduct->model_product_id = $request->model_product_id;
        $newProduct->user_id = $user->id;
        $newProduct->box_doc = $request->box_doc;
        $newProduct->exchange = $request->exchange;
        $newProduct->currency_key = $request->currency_key;
        $newProduct->price = $request->price;
        $newProduct->is_new = $request->is_new;
        $newProduct->area_id = $request->area_id;
        $newProduct->region_id = $area->region_id;
        $newProduct->category_id = $modelProduct->category_id;
        $newProduct->brand_id = $modelProduct->brand_id;
        $newProduct->price = $request->price;
        $newProduct->save();
        return $newProduct;
    }

    public static function updateProduct($request , $newProduct)
    {
        $user = auth()->user();
        $area = Area::find($request->area_id);
        $modelProduct = ModelProduct::find($request->model_product_id);
        $newProduct->model_product_id = $request->model_product_id;
        $newProduct->user_id = $user->id;
        $newProduct->box_doc = $request->box_doc;
        $newProduct->exchange = $request->exchange;
        $newProduct->currency_key = $request->currency_key;
        $newProduct->price = $request->price;
        $newProduct->is_new = $request->is_new;
        $newProduct->area_id = $request->area_id;
        $newProduct->region_id = $area->region_id;
        $newProduct->category_id = $modelProduct->category_id;
        $newProduct->brand_id = $modelProduct->brand_id;
        $newProduct->price = $request->price;
        $newProduct->update();
        return $newProduct;
    }
}
