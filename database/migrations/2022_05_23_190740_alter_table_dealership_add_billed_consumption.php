<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDealershipAddBilledConsumption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dealership_readings', function (Blueprint $table) {
            $table->decimal('billed_consumption', 13, 3)->default(0); //consumo faturado em m3
            $table->string('consumption_calculation')->default('Consumo Real');
            $table->string('type_minimum_value')->default('Pré Estabelecido');
            $table->decimal('minimum_value', 13, 3)->default(0);
            $table->string('fare_type')->default('Metro Cúbico Médio');
            $table->string('common_area')->default('Sem Rateio');
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
            $table->dropColumn('billed_consumption');
            $table->dropColumn('consumption_calculation');
        });
    }
}
