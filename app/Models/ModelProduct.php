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
}
