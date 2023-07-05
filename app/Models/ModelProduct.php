<?php

namespace App\Models;

use App\Traits\ModelScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static notDeleted()
 * @property mixed $category_id
 * @property mixed $brand_id
 * @property int|mixed $order
 * @property mixed $parent_id
 */
class ModelProduct extends Model
{
    use HasFactory;
    use ModelScopeTrait;

    public $tableName = 'model_products';

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $user = auth()->user();
            if (isset($user->id)) {
                $model->created_by = $user->id;
                $model->updated_by = $user->id;
            }
        });
        self::updating(function ($model) {
            $user = auth()->user();
            if (isset($user->id)) {
                $model->updated_by = $user->id;
            }
        });
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'model_product_attributes');
    }

//    public function attributes()
//    {
//        return $this->belongsToMany(Attribute::class, 'model_product_attribute_temporary_values', 'model_product_id', 'attribute_id')
//                    ->withPivot('attribute_temporary_value_id');
//    }
    public function translates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Translate::class, 'model_id', 'id')->where('table_name', $this->tableName);
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ModelProduct::class,'parent_id')->with('children');
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(ModelProduct::class,'parent_id');
    }
}
