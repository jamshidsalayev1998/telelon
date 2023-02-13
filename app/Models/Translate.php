<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translate extends Model
{
    use HasFactory;

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
