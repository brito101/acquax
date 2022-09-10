<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateResidentsRecordView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE VIEW residents_view AS
        SELECT r.id,
        CONCAT(u.name, ' - ', u.document_person, ' - ', u.email) as resident,
        CONCAT('Condomínio ', cp.alias_name, ' - Bl. ', bl.name, ' - Ap. ', ap.name) as property,
        r.status
        FROM residents as r
        LEFT JOIN users as u ON r.user_id = u.id
        LEFT JOIN apartments as ap ON r.apartment_id = ap.id
        LEFT JOIN blocks as bl ON ap.block_id = bl.id
        LEFT JOIN complexes as cp ON bl.complex_id = cp.id
        WHERE r.deleted_at IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW residents_view");
    }
}
