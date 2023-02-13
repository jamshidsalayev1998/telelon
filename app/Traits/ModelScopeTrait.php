<?php

namespace App\Traits;

use App\Models\Translate;
use Illuminate\Support\Facades\Schema;

trait ModelScopeTrait
{
    public function scopeFilter($query, $filterArray)
    {
        $ifParam = is_array($filterArray) && count($filterArray);
        if ($ifParam) {
            foreach ($filterArray as $filter) {
                if (array_key_exists('fieldValue', $filter)) {
                    if ($filter['fieldOperator'] == 'LIKE') {
                        if (Schema::hasColumn($this->tableName, $filter['fieldKey'])) {
                            $query->where($filter['fieldKey'], $filter['fieldOperator'], '%' . $filter['fieldValue'] . '%');
                            $query->orWhereHas('translates', function ($queryRelation) use ($filter) {
                                $queryRelation->where('value', 'LIKE', '%' . $filter['fieldValue'] . '%');
                            });
                        } else {
                            $query->whereHas('translates', function ($queryRelation) use ($filter) {
                                $queryRelation->where('value', 'LIKE', '%' . $filter['fieldValue'] . '%');
                            });
                        }

                    } else {
                        $query->where($filter['fieldKey'], $filter['fieldOperator'], $filter['fieldValue']);
                    }

                }
            }
        }
    }

    public function scopeRelations($query, $relationsArray)
    {
        $ifParam = is_array($relationsArray) && count($relationsArray);
        if ($ifParam) {
            foreach ($relationsArray as $relation) {
//                if ($query->relation($relation)->exists())
                    $query->with($relation);
            }
        }
    }

    public function scopeOrder($query, $order)
    {
        if (!is_null($order)) {
            if ($order) {
                $query->orderBy('id', 'DESC');
            }
        }

    }

    public function scopeNotDeleted($query)
    {
        $query->where('is_deleted', 0);
    }

    public function scopeTranslates($query): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Translate::class, 'model_id', 'id')->where('table_name', $this->tableName);
    }

    public function scopeTranslate($query): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(Translate::class, 'model_id', 'id')->where('table_name', $this->tableName)->where('language', app()->getLocale());
    }

}
