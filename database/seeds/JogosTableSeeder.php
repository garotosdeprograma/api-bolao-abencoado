<?php

use Illuminate\Database\Seeder;
use App\Rodada;

class JogosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Jogo::class, 5)->make()->each(function($jogo){
            $rodada = Rodada::find(1);
            $rodada->jogos()->save($jogo);
        });
    }
}
