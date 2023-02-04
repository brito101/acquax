<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateReadingsView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE VIEW readings_view AS
        SELECT r.id, m.id as meter_id, tm.name as meter_type, ap.id as apartment_id, CONCAT('Condomínio ', cp.alias_name, ' - Bl. ', bl.name, ' - Ap. ', ap.name) as property, m.register, m.location, r.month_ref, r.year_ref, DATE_FORMAT(r.reading_date, '%d/%m/%Y') as reading_date
        FROM readings as r
        LEFT JOIN meters m ON m.id = r.meter_id
        LEFT JOIN apartments ap ON ap.id = m.apartment_id
        LEFT JOIN blocks bl ON bl.id = ap.block_id
        LEFT JOIN complexes as cp ON bl.complex_id = cp.id
        LEFT JOIN type_meters as tm ON tm.id = m.type_meter_id
        WHERE r.deleted_at IS NULL AND m.deleted_at IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW readings_view");
    }
}
