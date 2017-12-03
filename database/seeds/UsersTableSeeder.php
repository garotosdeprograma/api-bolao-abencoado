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
        factory(App\Usuario::class)->create([
            'email' => 'user1@example.com',
            'password' => app('hash')->make('1234'),
            'tipo_usuario' => 'ADMIN'
        ]);

        factory(App\Usuario::class)->create([
            'email' => 'user2@example.com',
            'password' => app('hash')->make('1234'),
            'tipo_usuario' => 'USUARIO'
        ]);

        factory(App\Usuario::class)->create([
            'email' => 'user3@example.com',
            'password' => app('hash')->make('1234'),
            'tipo_usuario' => 'USUARIO'
        ]);

        // factory(App\Campeonato::class)->create([
        //     'nome' => 'Seria A'
        // ]);

        // factory(App\Campeonato::class)->create([
        //     'nome' => 'Seria B'
        // ]);

        // factory(App\Campeonato::class)->create([
        //     'nome' => 'Seria C'
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'CEARA',
        //     'campeoanto_id' => 1
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'SPORT CLUB',
        //     'campeoanto_id' => 1
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'GRÊMIO',
        //     'campeoanto_id' => 1
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'SANTOS',
        //     'campeoanto_id' => 1
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'PALMEIRAS',
        //     'campeoanto_id' => 1
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'SAO PAULO',
        //     'campeoanto_id' => 1
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Corinthias',
        //     'campeoanto_id' => 1
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Cruzeiro',
        //     'campeoanto_id' => 1
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Vasco',
        //     'campeoanto_id' => 1
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Flamengo',
        //     'campeoanto_id' => 1
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Botafogo',
        //     'campeoanto_id' => 1
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Bahia',
        //     'campeoanto_id' => 1
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Fortaleza',
        //     'campeoanto_id' => 2
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Internacional',
        //     'campeoanto_id' => 2
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Vila Nova',
        //     'campeoanto_id' => 2
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'CRB',
        //     'campeoanto_id' => 2
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Juventude',
        //     'campeoanto_id' => 2
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Londrina',
        //     'campeoanto_id' => 2
        // ]);
        
        // factory(App\Equipe::class)->create([
        //     'nome' => 'Oeste',
        //     'campeoanto_id' => 2
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Náutico',
        //     'campeoanto_id' => 2
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Luverdense',
        //     'campeoanto_id' => 2
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'ABC',
        //     'campeoanto_id' => 2
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Paraná',
        //     'campeoanto_id' => 2
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Fortaleza',
        //     'campeoanto_id' => 2
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Sampaio Corrêa',
        //     'campeoanto_id' => 3
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'CSA',
        //     'campeoanto_id' => 3
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Confiança',
        //     'campeoanto_id' => 3
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Salgueiro',
        //     'campeoanto_id' => 3
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Guiabá',
        //     'campeoanto_id' => 3
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Remo',
        //     'campeoanto_id' => 3
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'ASA',
        //     'campeoanto_id' => 3
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'SAO Bento',
        //     'campeoanto_id' => 3
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Tombense',
        //     'campeoanto_id' => 3
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Joinville',
        //     'campeoanto_id' => 3
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Macaê',
        //     'campeoanto_id' => 3
        // ]);

        // factory(App\Equipe::class)->create([
        //     'nome' => 'Mogi Mirim',
        //     'campeoanto_id' => 3
        // ]);

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
