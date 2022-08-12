<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApartmentReportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apartment_reports', function (Blueprint $table) {
            $table->id();
            $table->decimal('consumed', 13, 3)->default(0);
            $table->decimal('consumed_cost', 13, 3)->default(0);
            $table->decimal('sewage_cost', 13, 3)->default(0);
            $table->decimal('partial', 13, 3)->default(0);
            $table->decimal('total_unit', 13, 3)->default(0);
            $table->string('month_ref');
            $table->string('year_ref');
            $table->json('readings');
            $table->foreignId('dealership_reading_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('apartment_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apartment_reports');
    }
}
