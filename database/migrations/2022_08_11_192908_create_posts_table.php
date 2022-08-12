<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->string('headline')->nullable();
            $table->longText('content')->nullable();
            $table->string('status')->default('Publicado'); //Publicado, Rascunho, Lixo
            $table->string('cover', 100)->nullable();
            $table->bigInteger('views')->default(0);
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
        Schema::dropIfExists('posts');
    }
}
