<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEquipeAndApostaForeignKeyToEquipeEscolhidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipe_escolhidos', function (Blueprint $table) {
            $table->integer('equipe_id')->unsigned();
            $table->foreign('equipe_id')->references('id')->on('equipes');
            $table->integer('aposta_id')->unsigned();
            $table->foreign('aposta_id')->references('id')->on('apostas');
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
