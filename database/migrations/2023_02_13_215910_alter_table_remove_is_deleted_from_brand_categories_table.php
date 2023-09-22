<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableRemoveIsDeletedFromBrandCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('brand_categories', function (Blueprint $table) {
            $table->dropColumn('is_deleted');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('brand_categories', function (Blueprint $table) {
            $table->boolean('is_deleted')->default(false);
        });
    }
}
