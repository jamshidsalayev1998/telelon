<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static whereIn(string $string, array $needRemove)
 * @method static create(array $array)
 * @method static where(string $string, string $string1, $id)
 */
class BrandCategory extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;
}
