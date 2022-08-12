<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDealershipsReadingAddKiteColumnsCalc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dealership_readings', function (Blueprint $table) {
            $table->boolean('kite_car')->default(false);
            $table->decimal('kite_car_consumption', 13, 3)->default(0);
            $table->decimal('kite_car_tax', 13, 3)->default(0);
            $table->decimal('kite_car_total', 13, 3)->default(0);
            $table->integer('kite_car_qtd', false, true)->default(0);
            $table->decimal('value_per_kite_car', 13, 3)->default(0);
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
            $table->dropColumn(['kite_car', 'kite_car_consumption', 'kite_car_tax', 'kite_car_total', 'kite_car_qtd', 'value_per_kite_car']);
        });
    }
}
