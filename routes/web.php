<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

// Route::group([
    
//         'middleware' => 'api',
//         'namespace' => 'App\Http\Controllers',
//         'prefix' => 'auth'
    
//     ], function ($router) {
    
//         Route::post('login', 'AuthController@login');
//         Route::post('logout', 'AuthController@logout');
//         Route::post('refresh', 'AuthController@refresh');
//         Route::post('me', 'AuthController@me');
    
//     });

$router->post('/auth/login', 'AuthController@login');

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->post('/campeonato', 'CampeonatoController@cadastro');

$router->put('/campeonato/{id}', 'CampeonatoController@edit');

$router->get('/campeonato', 'CampeonatoController@buscar');

$router->get('/campeonato/{id}', 'CampeonatoController@buscarPorId');
