<?php

namespace App\Service\V1\Admin;

use App\Models\Category;
use App\Service\FileSave;
use App\Service\PaginationService;
use App\Service\TranslateService;
use Illuminate\Support\Facades\File;

class CategoryService
{
    public static function indexCategories($request): array
    {
        $departmentEloquent = Category::notDeleted()
            ->with('translates:id,model_id,language,value,field_name')
            ->filter($request->filters)->order($request->desc);
        return PaginationService::makePagination($departmentEloquent, $request->limit);
    }

    public static function storeCategory($data): Category
    {
        $file = $data['image'];
        $newCategory = new Category();
        $newCategory->slug = $data['slug'];
        $newCategory->image = FileSave::storeFile('categories', $file);
        $newCategory->save();
        (new TranslateService())->storeTranslate($newCategory, $data['name'], 'name');
        return $newCategory;
    }

    public static function updateCategory($category, $data)
    {
        if (key_exists('name', $data)) (new TranslateService)->updateTranslate($category, $data['name'], 'name');
        if (key_exists('status', $data)) {
                $category->status = $data['status'];
        }
        if (key_exists('image', $data)) {
            if ($data['image']) {
                if (is_file($data['image'])) {
                    if (File::exists($category->image)) {
                        File::delete($category->image);
                    }
                    $category->image = FileSave::storeFile('categories', $data['image']);
                }
            }
        }
        if (key_exists('slug', $data)) $category->slug = $data['slug'];
        $category->update();
        return $category;
    }

//
    public static function deleteCategory($category)
    {
        $category->is_deleted = 1;
        $category->update();
        return $category;
    }
}
