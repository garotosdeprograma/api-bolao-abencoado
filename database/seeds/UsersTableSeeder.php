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
    }
}
