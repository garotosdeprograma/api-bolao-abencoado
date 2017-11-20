<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddJogoIdToEquipeEscolhidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipe_escolhidos', function (Blueprint $table) {
            $table->integer('jogo_id')->unsigned();
            $table->foreign('jogo_id')->references('id')->on('jogos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('equipe_escolhidos', function (Blueprint $table) {
            //
        });
    }
}
