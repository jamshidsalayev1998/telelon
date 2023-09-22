<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableChangeColumnsToCodeBugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('code_bugs', function (Blueprint $table) {
            $table->text('error')->nullable()->change();
            $table->text('code')->nullable()->change();
            $table->text('type')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('code_bugs', function (Blueprint $table) {
            //
        });
    }
}
