<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsReportView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE VIEW apartment_reports_view AS
        SELECT ar.id, bl.name as block, ap.name as apartment, ar.consumed, ar.consumed_cost, ar.sewage_cost, ar.kite_car_consumed, ar.kite_car_cost, ar.partial, ar.total_unit, ar.dealership_reading_id, ar.apartment_id, dr.month_ref, dr.year_ref
        FROM apartment_reports as ar
        LEFT JOIN apartments ap ON ap.id = ar.apartment_id
        LEFT JOIN blocks bl ON bl.id = ap.block_id
        LEFT JOIN dealership_readings dr ON dr.id = ar.dealership_reading_id
        WHERE ar.deleted_at IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW apartment_reports_view");
    }
}
