<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModelProductAttributeTemporaryValue extends Model
{
    use HasFactory;

    protected $guarded = [];
    public $timestamps = false;

    public function attribute_temporary_value()
    {
        return $this->belongsTo(AttributeTemporaryValue::class,'attribute_temporary_value_id' , 'id');
    }
}
