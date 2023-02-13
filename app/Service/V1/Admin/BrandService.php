<?php

namespace App\Service\V1\Admin;

use App\Models\Brand;
use App\Models\BrandCategory;
use App\Service\FileSave;
use App\Service\PaginationService;
use Illuminate\Support\Facades\File;

class BrandService
{
    public static function indexBrands($request): array
    {
        $departmentEloquent = Brand::notDeleted()
            ->filter($request->filters)->relations($request->relations)->order($request->desc);
        return PaginationService::makePagination($departmentEloquent, $request->limit);
    }

    public static function storeBrand($data): Brand
    {
        $newBrand = new Brand();
        $newBrand->name = $data['name'];
        $newBrand->slug = $data['slug'];
        if (key_exists('image', $data)) {
            if ($data['image']) {
                if (is_file($data['image'])) {
                    $newBrand->image = FileSave::storeFile('brands', $data['image']);
                }
            }
        }
        $newBrand->save();
        BrandCategoryService::storeBrandCategory($data['category_id'], $newBrand);
        return $newBrand;
    }

    public static function updateBrand($brand, $data)
    {
        if (key_exists('status', $data)) {
            $brand->status = $data['status'];
        }
        if (key_exists('image', $data)) {
            if ($data['image']) {
                if (is_file($data['image'])) {
                    if (File::exists($brand->image)) {
                        File::delete($brand->image);
                    }
                    $brand->image = FileSave::storeFile('brands', $data['image']);
                }
            }
        }
        if (key_exists('category_id', $data)) {
            BrandCategoryService::updateBrandCategory($data['category_id'], $brand);
        }
        if (key_exists('name', $data)) $brand->name = $data['name'];
        if (key_exists('slug', $data)) $brand->slug = $data['slug'];
        $brand->update();
        return $brand;
    }

    public static function deleteBrand($brand)
    {
        $brand->is_deleted = 1;
        $brand->update();
        return $brand;
    }
}
