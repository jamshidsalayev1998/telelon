<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDropForeignsFromModelProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
         Schema::table('model_products', function (Blueprint $table) {
            $table->dropForeign(['brand_id']);
        });

        // Remove the foreign key for category_id
        Schema::table('model_products', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('model_products', function (Blueprint $table) {
            //
        });
    }
}
