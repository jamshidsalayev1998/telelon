<?php

namespace App\Models;

use App\Traits\ModelScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 * @property mixed $value
 * @property mixed $attribute_id
 */
class AttributeTemporaryValue extends Model
{
    use HasFactory;
    use ModelScopeTrait;

    protected $guarded = [];
    public $tableName = 'attribute_temporary_values';


    public function translates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Translate::class, 'model_id', 'id')->where('table_name', $this->tableName);
    }
}
