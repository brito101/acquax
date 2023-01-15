<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateViewCondominiumManagementReports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement(
            "
        CREATE OR REPLACE VIEW condominium_management_reports_view AS
        SELECT cp.alias_name as complex_name, bl.name as block_name, ap.name as apartment_name
        FROM complexes as cp
        RIGHT JOIN blocks bl ON bl.complex_id = cp.id
        RIGHT JOIN apartments as ap ON ap.block_id = bl.id
        WHERE cp.deleted_at IS NULL AND bl.deleted_at IS NULL AND ap.deleted_at IS NULL
        ORDER BY complex_name, block_name, apartment_name"
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW condominium_management_reports_view");
    }
}
