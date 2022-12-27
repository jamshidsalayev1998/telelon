<?php

namespace App\Service;

use App\Models\Translate;

class TranslateService
{
    public function storeTranslate($model, $dataArray, $fieldName)
    {
        foreach ($dataArray as $key => $item) {
            $newTranslate = new Translate();
            $newTranslate->language = $key;
            $newTranslate->model_id = $model->id;
            $newTranslate->value = $item;
            $newTranslate->table_name = $model->tableName;
            $newTranslate->field_name = $fieldName;
            $newTranslate->save();
        }
    }

    public function updateTranslate($model, $dataArray, $fieldName)
    {
        foreach ($dataArray as $key => $item) {
            if (Translate::where('language', $key)->where('model_id', $model->id)->where('table_name', $model->tableName)->where('field_name', $fieldName)->exists()) {
                $newTranslate = Translate::where('language', $key)->where('model_id', $model->id)->where('table_name', $model->tableName)->where('field_name', $fieldName)->first();
            } else {
                $newTranslate = new Translate();
            }
            $newTranslate->language = $key;
            $newTranslate->model_id = $model->id;
            $newTranslate->value = $item;
            $newTranslate->table_name = $model->tableName;
            $newTranslate->field_name = $fieldName;
            $newTranslate->save();
        }
    }

}
