<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateComplexesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('complexes', function (Blueprint $table) {
            $table->id();
            $table->string('social_name');
            $table->string('alias_name')->nullable();
            $table->string('document_company')->nullable();
            $table->string('document_company_secondary')->nullable();
            /** contact */
            $table->string('email')->nullable();
            $table->string('telephone')->nullable();
            $table->string('cell')->nullable();
            /** address */
            $table->string('zipcode')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();
            /** logo */
            $table->string('photo', 100)->nullable();
            /** social networks */
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            /*pattern*/
            $table->foreignId('user_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade')
                ->comment('último editor');
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
        Schema::dropIfExists('complexes');
    }
}
