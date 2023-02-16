<?php

namespace App\Service\V1\Admin;

use App\Models\Attribute;
use App\Service\PaginationService;
use App\Service\TranslateService;

class AttributeService
{
    public static function indexAttributes($request): array
    {
        $attributeEloquent = Attribute::notDeleted()
            ->with('translates:id,model_id,language,value,field_name')
            ->filter($request->filters)->order($request->desc);
        return PaginationService::makePagination($attributeEloquent, $request->limit);
    }

    public static function storeAttribute($data): Attribute
    {
        $order = 1;
        if (count(Attribute::notDeleted()->get())){
            $last = Attribute::notDeleted()->orderBy('order' , 'DESC')->first();
            $order = $last->order+1;
        }
        $newAttribute = new Attribute();
        $newAttribute->access_filter = $data['access_filter'];
        $newAttribute->access_translate = $data['access_translate'];
        $newAttribute->type = $data['type'];
        $newAttribute->order = $order;
        $newAttribute->static = $data['static'];
        if (key_exists('limit' , $data))
        $newAttribute->limit = json_encode($data['limit']);
        $newAttribute->save();
        (new TranslateService())->storeTranslate($newAttribute, $data['name'], 'name');
        return $newAttribute;
    }

    public static function updateAttribute($attribute,$data)
    {
        if (key_exists('name', $data)) (new TranslateService)->updateTranslate($attribute, $data['name'], 'name');
        if (key_exists('type', $data)) $attribute->type = $data['type'];
        if (key_exists('static', $data)) $attribute->static = $data['static'];
        if (key_exists('order', $data)) $attribute->order = $data['order'];
        if (key_exists('access_filter', $data)) $attribute->access_filter = $data['access_filter'];
        if (key_exists('limit', $data)) $attribute->limit = $data['limit'];
        if (key_exists('access_translate', $data)) $attribute->access_translate = $data['access_translate'];
        $attribute->update();
        return $attribute;
    }

    public static function deleteAttribute($attribute)
    {
        $attribute->is_deleted = 1;
        $attribute->update();
        return $attribute;
    }
}
