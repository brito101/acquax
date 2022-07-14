<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDealershipReadingsAddKiteTotalConsumed extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dealership_readings', function (Blueprint $table) {
            $table->decimal('kite_car_consumed_units', 13, 3)->default(0);
            $table->decimal('kite_car_cost_units', 13, 3)->default(0);
            $table->decimal('consumption_tax_1', 13, 3)->default(0);
            $table->decimal('consumption_tax_2', 13, 3)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dealerships_reading', function (Blueprint $table) {
            $table->dropColumn(['kite_car_consumed_units', 'kite_car_cost_units', 'consumption_tax_1', 'consumption_tax_2']);
        });
    }
}
