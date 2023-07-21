<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static inRandomOrder()
 */
class CaptchaImage extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $guarded = [];
}
