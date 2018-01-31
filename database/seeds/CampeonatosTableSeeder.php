<?php

use Illuminate\Database\Seeder;

class CampeonatosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Campeonato::class)->create([
            'nome' => 'Seria A',
            'tipo' => 'NACIONAL'
        ]);

        factory(App\Campeonato::class)->create([
            'nome' => 'Seria B',
            'tipo' => 'NACIONAL'
        ]);

        factory(App\Campeonato::class)->create([
            'nome' => 'Seria C',
            'tipo' => 'NACIONAL'
        ]);

        factory(App\Campeonato::class)->create([
            'nome' => 'Champions League',
            'tipo' => 'INTERNACIONAL'
        ]);

        factory(App\Campeonato::class)->create([
            'nome' => 'Premier  League',
            'tipo' => 'INTERNACIONAL'
        ]);

        factory(App\Campeonato::class)->create([
            'nome' => 'Premiere division',
            'tipo' => 'INTERNACIONAL'
        ]);

    }
}
