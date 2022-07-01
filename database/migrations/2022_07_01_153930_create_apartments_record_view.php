<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateApartmentsRecordView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE VIEW apartments_record_view AS
        SELECT ap.id, ap.name, ap.status, ap.fraction, bl.id as block_id, bl.name as block_name, cp.id as complex_id, cp.alias_name as complex_name
        FROM apartments as ap
        LEFT JOIN blocks as bl ON ap.block_id = bl.id
        LEFT JOIN complexes as cp ON bl.complex_id = cp.id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW apartments_record_view");
    }
}
