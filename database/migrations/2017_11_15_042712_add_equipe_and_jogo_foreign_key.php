<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEquipeAndJogoForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('apostas', function (Blueprint $table) {
            // $table->integer('equipe_escolhida')->unsigned();
            // $table->foreign('equipe_escolhida')->references('id')->on('equipes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('apostas', function (Blueprint $table) {
            // $table->dropForeign(['equipe_escolhida, jogo_id']);
        });
    }
}
