<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateJogoApostaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jogo_aposta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('aposta_id')->unsigned();
            $table->foreign('aposta_id')->references('id')->on('apostas');
            $table->integer('jogo_id')->unsigned();
            $table->foreign('jogo_id')->references('id')->on('jogos');
            $table->integer('equipe_id')->unsigned();
            $table->foreign('equipe_id')->references('id')->on('equipes');
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
        Schema::dropIfExists('jogo_aposta');
    }
}
