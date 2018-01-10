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
    }
}
