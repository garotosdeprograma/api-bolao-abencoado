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
        factory(App\Usuario::class, 1)->create([
            'tipo_usuario' => 'ADMIN',
            'celular' => 999998888
        ]);

        // factory(App\Usuario::class, 20)->create([
        //     'tipo_usuario' => 'USUARIO'
        // ]);
    }
}
