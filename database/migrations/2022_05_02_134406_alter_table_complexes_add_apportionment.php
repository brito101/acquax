<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableComplexesAddApportionment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('complexes', function (Blueprint $table) {
            $table->string('apportionment')->default('Simples');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('complexes', function (Blueprint $table) {
            $table->dropColumn('apportionment');
        });
    }
}
