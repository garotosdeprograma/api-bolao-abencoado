<?php

use Illuminate\Database\Seeder;
use App\Campeonato;
use App\Equipe;
use Carbon\Carbon;

class EquipesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        // Equipe serie A

        factory(App\Equipe::class)->create([
            'nome' => 'CEARA'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'SPORT CLUB'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'GRÊMIO'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'SANTOS'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'PALMEIRAS'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'SAO PAULO'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Corinthias'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Cruzeiro'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Vasco'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Flamengo'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Botafogo'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Bahia'
        ]);
        
        $campeonato = Campeonato::find(1);

        $equipes = Equipe::select('id')->where('id', '<=', 12)->get();

        foreach ($equipes as $key => $equipe) {
            $campeonato->equipes()->attach($equipe, ['created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        }

        // Equipe serie B


        factory(App\Equipe::class)->create([
            'nome' => 'Fortaleza'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Internacional'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Vila Nova'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'CRB'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Juventude'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Londrina'
        ]);
        
        factory(App\Equipe::class)->create([
            'nome' => 'Oeste'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Náutico'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Luverdense'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'ABC'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Paraná'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Fortaleza'
        ]);

        $campeonato = Campeonato::find(2);
        
        $equipes = Equipe::select('id')->where('id', '>=', 13)->where('id', '<=', 24)->get();

        foreach ($equipes as $key => $equipe) {
            $campeonato->equipes()->attach($equipe, ['created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        }

        // Equipes serie C

        factory(App\Equipe::class)->create([
            'nome' => 'Sampaio Corrêa'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'CSA'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Confiança'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Salgueiro'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Guiabá'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Remo'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'ASA'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'SAO Bento'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Tombense'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Joinville'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Macaê'
        ]);

        factory(App\Equipe::class)->create([
            'nome' => 'Mogi Mirim'
        ]);

        $campeonato = Campeonato::find(3);
        
        $equipes = Equipe::select('id')->where('id', '>=', 25)->where('id', '<=', 36)->get();

        foreach ($equipes as $key => $equipe) {
            $campeonato->equipes()->attach($equipe, ['created_at' => Carbon::now()->format('Y-m-d H:i:s'), 'updated_at' => Carbon::now()->format('Y-m-d H:i:s')]);
        }
    }
}
