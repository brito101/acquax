<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealershipReadingGasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealership_readings_gas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('complex_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('month_ref');
            $table->string('year_ref')->nullable();
            $table->foreignId('dealership_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->date('reading_date');
            $table->date('reading_date_next');
            $table->integer('total_days')->default(0);
            $table->decimal('billed_consumption', 13, 3)->default(0);
            $table->decimal('dealership_consumption', 13, 3)->default(0);
            $table->decimal('dealership_cost', 12, 2)->default(0);
            $table->decimal('monthly_consumption', 13, 3)->default(0);
            $table->decimal('total_value', 13, 3)->default(0);
            $table->decimal('consumption_value', 13, 3)->default(0);

            /** Pattern */
            $table->unsignedBigInteger('editor');
            $table->foreign('editor')
                ->references('id')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->comment('Último editor');
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
        Schema::dropIfExists('dealership_reading_gases');
    }
}
