<?php

use Carbon\Carbon;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

$factory->define(App\Usuario::class, function (Faker\Generator $faker) {
    static $password;
    return [
        'nome' => $faker->firstName,
        'password' => $password ?: $password = app('hash')->make('secret'),
        'email' => $faker->email,
    ];
});

// $factory->define(App\Campeonato::class, function (Faker\Generator $faker) {
//     return [
//         'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//         'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
//     ];
// });

// $factory->define(App\Equipe::class, function (Faker\Generator $faker) {
//     return [
//         'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//         'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
//     ];
// });

// $factory->define(App\Rodada::class, function (Faker\Generator $faker) {
//     return [
//         'nome' => $faker->company,
//         'inicio' => Carbon::now()->format('Y-m-d H:i'),
//         'fim' => Carbon::now()->format('Y-m-d H:i'),
//         'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//         'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
//     ];
// });

// $factory->define(App\Jogo::class, function (Faker\Generator $faker) {
//     return [
//         'inicio' => Carbon::now()->format('Y-m-d H:i:s'),
//         'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
//         'updated_at' => Carbon::now()->format('Y-m-d H:i:s')
//     ];
// });

