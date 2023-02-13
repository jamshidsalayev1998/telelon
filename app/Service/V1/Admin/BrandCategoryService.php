<?php

namespace App\Service\V1\Admin;

use App\Models\BrandCategory;

class BrandCategoryService
{
    public static function storeBrandCategory($data, $brand)
    {
        foreach ($data as $item) {
            BrandCategory::create([
                'brand_id' => $brand->id,
                'category_id' => $item
            ]);
        }
    }

    public static function updateBrandCategory($data, $brand)
    {
        $oldData = BrandCategory::where('brand_id','=', $brand->id)->pluck('category_id')->toArray();
        $needAdd = array_diff($data, $oldData);
        foreach ($needAdd as $item) {
            BrandCategory::create([
                'brand_id' => $brand->id,
                'category_id' => $item
            ]);
        }
        $needRemove = array_diff($oldData, $data);
        BrandCategory::whereIn('category_id', $needRemove)->where('brand_id', $brand->id)->delete();
    }
}
