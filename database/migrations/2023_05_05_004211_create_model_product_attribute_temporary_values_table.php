<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateModelProductAttributeTemporaryValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('model_product_attribute_temporary_values', function (Blueprint $table) {
            $table->unsignedBigInteger('model_product_id');
            $table->unsignedBigInteger('attribute_id');
            $table->unsignedBigInteger('attribute_temporary_value_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('model_product_attribute_temporary_values');
    }
}
