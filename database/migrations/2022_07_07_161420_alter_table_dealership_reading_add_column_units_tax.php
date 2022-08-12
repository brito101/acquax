<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDealershipReadingAddColumnUnitsTax extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dealership_readings', function (Blueprint $table) {
            $table->integer('units_inside_tax_1')->default(0);
            $table->integer('units_above_tax_1')->default(0);
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
            $table->dropColumn('units_inside_tax_1');
            $table->dropColumn('units_above_tax_1');
        });
    }
}
