<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAttribute extends Model
{
    use HasFactory;
    public $timestamps = false;

    public function attribute()
    {
        return $this->belongsTo(Attribute::class,'attribute_id' , 'id');
    }

    public function attribute_temporary_value()
    {
        return $this->belongsTo(AttributeTemporaryValue::class,'attribute_temporary_value_id' , 'id');
    }
}
