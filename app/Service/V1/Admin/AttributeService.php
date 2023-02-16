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
        $newAttribute = new Attribute();
        $newAttribute->access_filter = $data['access_filter'];
        $newAttribute->access_translate = $data['access_translate'];
        $newAttribute->type = $data['type'];
        $newAttribute->static = $data['static'];
        if (key_exists('limit' , $data))
        $newAttribute->limit = json_encode($data['limit']);
        $newAttribute->save();
        (new TranslateService())->storeTranslate($newAttribute, $data['name'], 'name');
        return $newAttribute;
    }

    public static function updateAttribute($data)
    {

    }
}
