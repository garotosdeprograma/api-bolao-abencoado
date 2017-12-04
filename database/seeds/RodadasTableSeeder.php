<?php

use Illuminate\Database\Seeder;
use App\Campeonato;

class RodadasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Rodadas serie A

        factory(App\Rodada::class, 5)->make()->each(function($rodada)
        {
            $campeonato = Campeonato::find(1);
            $campeonato->rodadas()->save($rodada);
        });

        // Rodadas serie B

        factory(App\Rodada::class, 5)->make()->each(function($rodada)
        {
            $campeonato = Campeonato::find(2);
            $campeonato->rodadas()->save($rodada);
        });

        // Rodadas serie C

        factory(App\Rodada::class, 5)->make()->each(function($rodada)
        {
            $campeonato = Campeonato::find(3);
            $campeonato->rodadas()->save($rodada);
        });

    }
}
