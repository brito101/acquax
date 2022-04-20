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
            $table->date('date_reading');                               //data da leitura (dados da fatura da concessionária)
            $table->date('date_next_reading');                          //data da próxima leitura (dados da fatura da concessionária)
            $table->integer('total_days');                              //total de dias faturados pela concessionária
            $table->decimal('dealership_consumption', 13, 3);           //consumo em m3 medido pela concessionária
            $table->decimal('dealership_consumption_tax_1', 13, 3);     //consumo em m3 medido pela concessionária para a primeira faixa
            $table->decimal('dealership_consumption_tax_2', 13, 3);     //consumo em m3 medido pela concessionária para a segunda faixa
            $table->decimal('monthly_consumption', 13, 3);              //consumo em m3 medido pela empresa de individualização
            $table->decimal('water_value_consumption', 12, 2);          //valor da água (dados da fatura da concessionária)
            $table->decimal('sewage_value_consumption', 12, 2);         //valor do esgoto (dados da fatura da concessionária)
            $table->decimal('regulation_tax', 12, 2);                   //taxa de regulação (dados da fatura da concessionária caso exista)
            $table->decimal('dealership_cost_tax_1', 13, 3);            //valor do m3  da concessionária da primeira faixa
            $table->decimal('dealership_cost_tax_2', 13, 3);            //valor do m3  da concessionária da segunda faixa
            $table->foreignId('dealership_id')                          //concessionária
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
