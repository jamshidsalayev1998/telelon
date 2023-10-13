<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->text('description')->nullable();
            $table->unsignedBigInteger('model_product_id');
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id');
            $table->unsignedBigInteger('user_id');
            $table->integer('status')->default(0);
            $table->integer('box_doc')->default(0);
            $table->boolean('exchange')->default(false);
            $table->integer('price');
            $table->string('currency_key');
            $table->boolean('is_new')->default(false);
            $table->unsignedBigInteger('region_id');
            $table->unsignedBigInteger('area_id');
            $table->string('lat',255)->nullable();
            $table->string('long',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('products');
    }
}
