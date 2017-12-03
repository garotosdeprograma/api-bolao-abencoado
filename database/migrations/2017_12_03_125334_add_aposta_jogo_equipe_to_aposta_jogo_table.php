<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddApostaJogoEquipeToApostaJogoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jogo_aposta', function (Blueprint $table) {
            $table->integer('aposta_id')->unsigned()->after('id');
            $table->foreign('aposta_id')->references('id')->on('apostas');
            $table->integer('jogo_id')->unsigned()->after('aposta_id');
            $table->foreign('jogo_id')->references('id')->on('jogos');
            $table->integer('equipe_id')->unsigned()->after('jogo_id');
            $table->foreign('equipe_id')->references('id')->on('equipes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jogo_aposta', function (Blueprint $table) {
            //
        });
    }
}
