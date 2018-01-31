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
        $id = 0;
        factory(App\Jogo::class, 12)->make([
            'campeonato_id' => 1,
            'equipe_casa' => ++$id,
            'equipe_visitante' => ++$id,
        ])->each(function($jogo){
            $rodada = Rodada::find(1);
            $rodada->jogos()->save($jogo);
        });

        factory(App\Jogo::class, 12)->make([
            'campeonato_id' => 2,
            'equipe_casa' => ++$id,
            'equipe_visitante' => ++$id,
        ])->each(function($jogo){
            $rodada = Rodada::find(2);
            $rodada->jogos()->save($jogo);
        });

        factory(App\Jogo::class, 12)->make([
            'campeonato_id' => 3,
            'equipe_casa' => ++$id,
            'equipe_visitante' => ++$id,
        ])->each(function($jogo){
            $rodada = Rodada::find(3);
            $rodada->jogos()->save($jogo);
        });

        factory(App\Jogo::class, 12)->make([
            'campeonato_id' => 4,
            'equipe_casa' => ++$id,
            'equipe_visitante' => ++$id,
        ])->each(function($jogo){
            $rodada = Rodada::find(4);
            $rodada->jogos()->save($jogo);
        });

        factory(App\Jogo::class, 12)->make([
            'campeonato_id' => 5,
            'equipe_casa' => ++$id,
            'equipe_visitante' => ++$id,
        ])->each(function($jogo){
            $rodada = Rodada::find(5);
            $rodada->jogos()->save($jogo);
        });
    }
}
