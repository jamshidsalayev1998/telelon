<?php

namespace App\Service\V1\Admin;

use App\Models\Category;
use App\Models\ModelProduct;
use App\Service\FileSave;
use App\Service\PaginationService;
use App\Service\TranslateService;
use Illuminate\Support\Facades\File;

class ModelProductService
{
    public static function indexModelProduct($request): array
    {
        $modelProductEloquent = ModelProduct::notDeleted()
            ->with('translates:id,model_id,language,value,field_name')
            ->relations($request->relations)
            ->filter($request->filters)->order($request->desc);
        return PaginationService::makePagination($modelProductEloquent, $request->limit);
    }

    public static function storeModelProduct($data): ModelProduct
    {
        $lastModelProduct = ModelProduct::notDeleted()->orderBy('id', 'DESC')->first();
        $order = 1;
        if ($lastModelProduct) {
            $order = $lastModelProduct->order + 1;
        }
        $modelProduct = new ModelProduct();
        $modelProduct->category_id = $data['category_id'];
        $modelProduct->brand_id = $data['brand_id'];
        $modelProduct->order = $order;
        if (key_exists('parent_id', $data))
            $modelProduct->parent_id = $data['parent_id'];
        $modelProduct->save();
        (new TranslateService())->storeTranslate($modelProduct, $data['name'], 'name');
        ModelProductAttributeService::storeModelProductAttributes($modelProduct,$data['attributes']);
        return $modelProduct;
    }

    public static function updateModelProduct($modelProduct, $data)
    {
        if (key_exists('name', $data)) (new TranslateService)->updateTranslate($modelProduct, $data['name'], 'name');
        if (key_exists('status', $data)) {
            $modelProduct->status = $data['status'];
        }
        if (key_exists('brand_id', $data)) $modelProduct->brand_id = $data['brand_id'];
        if (key_exists('category_id', $data)) $modelProduct->category_id = $data['category_id'];
        if (key_exists('order', $data)) $modelProduct->order = $data['order'];
        if (key_exists('parent_id', $data)) $modelProduct->parent_id = $data['parent_id'];
        ModelProductAttributeService::updateModelProductAttributes($modelProduct,$data['attributes']);
        $modelProduct->update();
        return $modelProduct;
    }

//
    public static function deleteModelProduct($modelProduct)
    {
        $modelProduct->is_deleted = 1;
        $modelProduct->update();
        return $modelProduct;
    }
}
