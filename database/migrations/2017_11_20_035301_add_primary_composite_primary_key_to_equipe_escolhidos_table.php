<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrimaryCompositePrimaryKeyToEquipeEscolhidosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('equipe_escolhidos', function (Blueprint $table) {
            $table->integer('usuario_id')->unsigned()->default(1);
            $table->foreign('usuario_id')->references('id')->on('usuarios');
            $table->unique(['jogo_id', 'usuario_id']);
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
