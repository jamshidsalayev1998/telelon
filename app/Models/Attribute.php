<?php

namespace App\Models;

use App\Traits\ModelScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static notDeleted()
 * @method static findOrFail(mixed $attribute_id)
 * @method static find(mixed $attribute_id)
 * @property mixed $brand_id
 * @property mixed $category_id
 * @property mixed $type
 * @property mixed $static
 * @property mixed $access_filter
 * @property mixed $access_translate
 * @property false|mixed|string $limit
 * @property mixed $order
 */
class Attribute extends Model
{
    use HasFactory;
    use ModelScopeTrait;

    public $tableName = 'attributes';

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

    public function translates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Translate::class, 'model_id', 'id')->where('table_name', $this->tableName);
    }
    public function attribute_temporary_values(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AttributeTemporaryValue::class, 'attribute_id', 'id')->where('is_deleted' , 0);
    }
}
