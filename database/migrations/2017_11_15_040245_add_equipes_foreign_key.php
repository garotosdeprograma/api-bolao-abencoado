<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddEquipesForeignKey extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('jogos', function (Blueprint $table) {
            $table->integer('equipe_casa')->unsigned()->after('id');
            $table->integer('equipe_visitante')->unsigned()->after('equipe_casa');
            $table->foreign('equipe_casa')->references('id')->on('equipes');
            $table->foreign('equipe_visitante')->references('id')->on('equipes');
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
            // $table->dropForeign(['equipe_visitante, equipe_casa']);
        });
    }
}
