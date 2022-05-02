<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveColumnMonthlyConsumptionDealershipTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dealership_readings', function ($table) {
            $table->dropColumn('monthly_consumption');
            $table->dropColumn('water_value_consumption');
            $table->dropColumn('sewage_value_consumption');
            $table->dropColumn('regulation_tax');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('dealership_readings', function ($table) {
            $table->decimal('monthly_consumption', 13, 3)->default(0);
            $table->decimal('water_value_consumption', 12, 2)->default(0); //valor da água (dados da fatura da concessionária)
            $table->decimal('sewage_value_consumption', 12, 2)->default(0); //valor do esgoto (dados da fatura da concessionária)
            $table->decimal('regulation_tax', 12, 2)->default(0); //taxa de regulação (dados da fatura da concessionária caso exista)
        });
    }
}
