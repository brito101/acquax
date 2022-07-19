<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterTableDealershipReadingsAddTaxColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('dealership_readings', function (Blueprint $table) {
            $table->renameColumn('units_above_tax_1', 'units_inside_tax_2');
            $table->integer('units_inside_tax_3');
            $table->integer('units_inside_tax_4');
            $table->integer('units_inside_tax_5');
            $table->integer('units_inside_tax_6');
            $table->unsignedInteger('consumption_ranges')->default(2);
            $table->decimal('dealership_cost_tax_3', 13, 3)->default(0);
            $table->decimal('dealership_consumption_tax_3', 13, 3)->default(0);
            $table->decimal('dealership_cost_tax_4', 13, 3)->default(0);
            $table->decimal('dealership_consumption_tax_4', 13, 3)->default(0);
            $table->decimal('dealership_cost_tax_5', 13, 3)->default(0);
            $table->decimal('dealership_consumption_tax_5', 13, 3)->default(0);
            $table->decimal('dealership_cost_tax_6', 13, 3)->default(0);
            $table->decimal('consumption_tax_3', 13, 3)->default(0);
            $table->decimal('consumption_tax_4', 13, 3)->default(0);
            $table->decimal('consumption_tax_5', 13, 3)->default(0);
            $table->decimal('consumption_tax_6', 13, 3)->default(0);
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
            $table->renameColumn('units_inside_tax_2', 'units_above_tax_1');
            $table->dropColumn(
                [
                    'consumption_ranges',
                    'units_inside_tax_3',
                    'units_inside_tax_4',
                    'units_inside_tax_5',
                    'units_inside_tax_6',
                    'dealership_cost_tax_3', 'dealership_consumption_tax_3',
                    'dealership_cost_tax_4', 'dealership_consumption_tax_4',
                    'dealership_cost_tax_5', 'dealership_consumption_tax_5',
                    'dealership_cost_tax_6',
                    'consumption_tax_3',
                    'consumption_tax_4',
                    'consumption_tax_5',
                    'consumption_tax_6'
                ]
            );
        });
    }
}
