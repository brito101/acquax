<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableApartmentReportAddKiteCalc extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apartment_reports', function (Blueprint $table) {
            $table->decimal('kite_car_consumed', 13, 3)->default(0);
            $table->decimal('kite_car_cost', 13, 3)->default(0);
            $table->decimal('total_consumed', 13, 3)->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apartment_reports', function (Blueprint $table) {
            $table->dropColumn(['kite_car_consumed', 'kite_car_cost', 'total_consumed']);
        });
    }
}
