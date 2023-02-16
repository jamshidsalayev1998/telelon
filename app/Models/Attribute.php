<?php

namespace App\Models;

use App\Traits\ModelScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static notDeleted()
 * @property mixed $brand_id
 * @property mixed $category_id
 * @property mixed $type
 * @property mixed $static
 * @property mixed $access_filter
 * @property mixed $access_translate
 * @property false|mixed|string $limit
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
}
