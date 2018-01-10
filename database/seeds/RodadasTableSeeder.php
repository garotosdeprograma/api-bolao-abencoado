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

        factory(App\Rodada::class, 5)->create();

    }
}
