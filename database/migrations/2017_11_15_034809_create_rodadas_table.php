<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRodadasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rodadas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('numero')->unsigned();
            $table->dateTimeTz('ano');
            $table->dateTimeTz('inicio');
            $table->dateTimeTz('fim');
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
        Schema::dropIfExists('rodadas');
    }
}
