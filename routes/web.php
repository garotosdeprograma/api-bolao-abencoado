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

$router->group(['prefix' => 'aposta'], function () use ($router) {
            
    $router->post('', 'ApostaController@cadastro');
    
    $router->get('', 'ApostaController@buscar');
    
    $router->get('ranking/{rodada_id}', 'ApostaController@ranking');
});

$router->group(['middleware' => 'auth'], function () use ($router) {

        $router->group(['prefix' => 'campeonato'], function () use ($router) {

            $router->post('', 'CampeonatoController@cadastro');
            
            $router->put('{id}', 'CampeonatoController@edit');
            
            $router->get('', 'CampeonatoController@buscar');

            $router->get('todos', 'CampeonatoController@buscarTodos');
            
            $router->get('{id}', 'CampeonatoController@buscarPorId');

        });

        $router->group(['prefix' => 'equipe'], function () use ($router) {
            
            $router->post('', 'EquipeController@cadastro');
            
            $router->put('{id}', 'EquipeController@edit');
            
            $router->get('', 'EquipeController@buscar');
            
            $router->get('{id}', 'EquipeController@buscarPorId');

        });

        $router->group(['prefix' => 'rodada'], function () use ($router) {
            
            $router->post('', 'RodadaController@cadastro');
            
            $router->put('{id}', 'RodadaController@edit');
            
            $router->get('', 'RodadaController@buscar');
            
            $router->get('{id}', 'RodadaController@buscarPorId');

            $router->get('jogos/{id}', 'RodadaController@buscarJogosPorRodadaAuth');
            
        });

        $router->group(['prefix' => 'jogo'], function () use ($router) {
            
            $router->post('', 'JogoController@cadastro');
            
            $router->put('{id}', 'JogoController@edit');
            
            $router->get('', 'JogoController@buscar');
            
            $router->get('{id}', 'JogoController@buscarPorId');
        });
    
    $router->put('/usuario/{id}', 'UsuarioController@edit');

});

$router->group(['prefix' => 'externo'], function () use ($router) {
    $router->get('campeonato/equipes', 'CampeonatoController@buscarEquipePorCampeonato');
    $router->get('rodada/jogos', 'RodadaController@buscarJogosPorRodada');
    $router->get('rodada/ranking', 'RodadaController@ranking');
});

$router->post('/auth/login', 'AuthController@login');
$router->post('/auth/register', 'UsuarioController@cadastro');  

// $router->get('/', function () use ($router) {
//     return $router->app->version();
// });