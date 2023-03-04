<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateViewAdminReadings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE VIEW admin_readings_view AS
        SELECT r.id,
        CASE
        WHEN cp.deleted_at IS NULL AND bl.deleted_at IS NULL AND ap.deleted_at IS NULL
        THEN CONCAT('Condomínio ', cp.alias_name, ' - Bl. ', bl.name, ' - Ap. ', ap.name)
        ELSE 'Unidade inexistente'
        END
        as property, r.reading, r.month_ref, r.year_ref, r.reading_date,
        CASE
        WHEN m.deleted_at IS NULL THEN m.register
        ELSE 'Medidor inexistente'
        END as meter,
        CASE
        WHEN r.cover_base64 IS NOT NULL THEN  'Capturada pelo sistema'
        WHEN r.cover IS NOT NULL THEN 'Através de upload no sistema'
        WHEN r.url_cover IS NOT NULL THEN 'URL externa'
        ELSE 'Sem Foto'
        END
        as image
        FROM readings as r
        LEFT JOIN meters m ON m.id = r.meter_id
        LEFT JOIN apartments ap ON ap.id = m.apartment_id
        LEFT JOIN blocks bl ON bl.id = ap.block_id
        LEFT JOIN complexes as cp ON bl.complex_id = cp.id
        WHERE r.deleted_at IS NULL");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW admin_readings_view");
    }
}
