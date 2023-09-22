<?php

namespace App\Models;

use App\Traits\ModelScopeTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static create(array $array)
 */
class ModelProductAttribute extends Model
{
    use HasFactory;
    use ModelScopeTrait;
    public $timestamps = false;
    protected $guarded = [];
}
