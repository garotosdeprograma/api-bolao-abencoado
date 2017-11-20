<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRodadaAndCampeonatoForeignKeyToJogo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jogos', function (Blueprint $table) {
            $table->integer('rodada_id')->unsigned();
            $table->foreign('rodada_id')->references('id')->on('rodadas');
            $table->integer('campeonato_id')->unsigned();
            $table->foreign('campeonato_id')->references('id')->on('campeonatos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jogos', function (Blueprint $table) {
            //
        });
    }
}
