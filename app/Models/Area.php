<?php

namespace App\Models;

use App\Traits\ModelScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;
    use ModelScopeTrait;

    public $tableName = 'areas';

    protected $guarded = [];
    public $timestamps = false;

    public function translates(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Translate::class, 'model_id', 'id')->where('table_name', $this->tableName);
    }
}
