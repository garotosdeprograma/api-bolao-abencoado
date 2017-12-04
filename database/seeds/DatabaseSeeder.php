<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call([
            UsersTableSeeder::class,
            CampeonatosTableSeeder::class,
            EquipesTableSeeder::class,
            RodadasTableSeeder::class,
            JogosTableSeeder::class
        ]);
        
        // $this->call(UsersTableSeeder::class);
        // $this->call(CampeonatosTableSeeder::class);
        // $this->call(EquipesTableSeeder::class);

        Model::reguard();
    }
}
