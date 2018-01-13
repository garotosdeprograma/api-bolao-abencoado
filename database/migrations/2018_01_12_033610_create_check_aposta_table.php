<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCheckApostaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('check_aposta', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('rodada_id')->unsigned();
            $table->foreign('rodada_id')->references('id')->on('rodadas');
            $table->string('chave_aposta');
            $table->unique(['rodada_id', 'chave_aposta']);
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
        Schema::dropIfExists('check_aposta');
    }
}
