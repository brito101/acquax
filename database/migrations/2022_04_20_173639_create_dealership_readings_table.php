<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealershipReadingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealership_readings', function (Blueprint $table) {
            $table->id();
            $table->date('reading_date'); //data da leitura (dados da fatura da concessionária)
            $table->date('reading_date_next'); //data da próxima leitura (dados da fatura da concessionária)
            $table->integer('total_days')->default(0); //total de dias faturados pela concessionária
            $table->decimal('dealership_consumption', 13, 3)->default(0); //consumo em m3 medido pela concessionária
            $table->decimal('dealership_consumption_tax_1', 13, 3)->default(0); //consumo em m3 medido pela concessionária para a primeira faixa
            $table->decimal('dealership_consumption_tax_2', 13, 3)->default(0); //consumo em m3 medido pela concessionária para a segunda faixa
            $table->decimal('monthly_consumption', 13, 3)->default(0); //consumo em m3 medido pela empresa de individualização
            $table->decimal('dealership_cost_tax_1', 13, 3)->default(0); //valor do m3  da concessionária da primeira faixa
            $table->decimal('dealership_cost_tax_2', 13, 3)->default(0); //valor do m3  da concessionária da segunda faixa
            $table->foreignId('dealership_id') //concessionária
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreignId('complex_id') //condomínio
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->string('month_ref'); //mês de referência
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
        Schema::dropIfExists('dealership_readings');
    }
}
