<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Usuario::class, 2)->create([
            'tipo_usuario' => 'ADMIN'
        ]);

        factory(App\Usuario::class, 20)->create([
            'tipo_usuario' => 'USUARIO'
        ]);

        // factory(App\Rodada::class)->create([
        //     'numero' => 1,
        //     'campeoanto_id' => 1
        // ]);

        // factory(App\Rodada::class)->create([
        //     'numero' => 2,
        //     'campeoanto_id' => 1
        // ]);

        // factory(App\Rodada::class)->create([
        //     'numero' => 1,
        //     'campeoanto_id' => 2
        // ]);

        // factory(App\Rodada::class)->create([
        //     'numero' => 2,
        //     'campeoanto_id' => 2
        // ]);

        // factory(App\Rodada::class)->create([
        //     'numero' => 1,
        //     'campeoanto_id' => 3
        // ]);

        // factory(App\Rodada::class)->create([
        //     'numero' => 2,
        //     'campeoanto_id' => 3
        // ]);

        // factory(App\jogo::class)->create([
        //     'estadio' => 'Maracana',
        //     'campeoanto_id' => 1,
        //     'rodada_id' => 1,
        //     'equipe_casa' => 1,
        //     'equipe_visitante' => 2
        // ]);

        // factory(App\jogo::class)->create([
        //     'estadio' => 'Castelão',
        //     'campeoanto_id' => 1,
        //     'rodada_id' => 1,
        //     'equipe_casa' => 3,
        //     'equipe_visitante' => 3
        // ]);


    }
}
