<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateDealershipReadingView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE VIEW dealership_readings_view AS
        SELECT dr.id, dr.complex_id, c.alias_name, dr.month_ref, dr.year_ref, DATE_FORMAT(dr.reading_date, '%d/%m/%Y') as reading_date , DATE_FORMAT(dr.reading_date_next, '%d/%m/%Y') as reading_date_next
        FROM dealership_readings as dr
        LEFT JOIN complexes as c ON c.id = dr.complex_id
        WHERE dr.deleted_at IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW dealership_readings_view");
    }
}
