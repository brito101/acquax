<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateMetersView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE VIEW meters_view AS
        SELECT m.id, m.register, CONCAT('Condomínio ', cp.alias_name, ' - Bl. ', bl.name, ' - Ap. ', ap.name) as property, m.location, tm.name as type, m.year_manufacture,
        CASE
            WHEN m.main = 1 THEN 'Sim'
            ELSE 'Não'
        END as main,
        m.status
        FROM meters as m
        LEFT JOIN apartments as ap ON m.apartment_id = ap.id
        LEFT JOIN blocks as bl ON ap.block_id = bl.id
        LEFT JOIN complexes as cp ON bl.complex_id = cp.id
        LEFT JOIN type_meters as tm ON m.type_meter_id = tm.id
        WHERE m.deleted_at IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW meters_view");
    }
}
