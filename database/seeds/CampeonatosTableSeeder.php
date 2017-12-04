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
        $seriaA = factory(App\Campeonato::class)->create([
            'nome' => 'Seria A'
        ]);

        $seriaB = factory(App\Campeonato::class)->create([
            'nome' => 'Seria B'
        ]);

        $seriaC = factory(App\Campeonato::class)->create([
            'nome' => 'Seria C'
        ]);
    }
}
