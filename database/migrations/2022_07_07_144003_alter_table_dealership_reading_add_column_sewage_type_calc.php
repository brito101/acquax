<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDealershipReadingAddColumnSewageTypeCalc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dealership_readings', function (Blueprint $table) {
            $table->string('sewage_calc')->default('Igual ao consumo de água')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dealership_readings', function (Blueprint $table) {
            $table->dropColumn('sewage_type_calc');
        });
    }
}
