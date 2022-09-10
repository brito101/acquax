<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateBlocksView extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("
        CREATE OR REPLACE VIEW blocks_view AS
        SELECT bl.id, bl.name, bl.status, bl.complex_id, c.alias_name as complex
        FROM blocks as bl
        LEFT JOIN complexes c ON c.id = bl.complex_id
        WHERE bl.deleted_at IS NULL
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("DROP VIEW blocks_view");
    }
}
