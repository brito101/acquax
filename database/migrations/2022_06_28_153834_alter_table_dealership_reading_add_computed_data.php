<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDealershipReadingAddComputedData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dealership_readings', function (Blueprint $table) {
            $table->decimal('diff_consumption', 13, 3)->default(0);
            $table->decimal('previous_monthly_consumption', 13, 3)->default(0);
            $table->decimal('previous_billed_consumption', 13, 3)->default(0);
            $table->decimal('consumption_value', 13, 3)->default(0);
            $table->decimal('sewage_value', 13, 3)->default(0);
            $table->decimal('total_value', 13, 3)->default(0);
            $table->decimal('diff_cost', 13, 3)->default(0);
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
            $table->dropColumn('monthly_consumption');
            $table->dropColumn('diff_consumption');
            $table->dropColumn('previous_monthly_consumption');
            $table->dropColumn('previous_billed_consumption');
            $table->dropColumn('consumption_value');
            $table->dropColumn('sewage_value');
            $table->dropColumn('total_value');
            $table->dropColumn('diff_cost');
        });
    }
}
