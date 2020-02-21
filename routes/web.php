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

$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router) {
    $router->get('feriados/{ano}',  ['uses' => 'FeriadosController@getNacionais']);

    $router->get('feriados/{ano}/{sigla}',  ['uses' => 'FeriadosController@getEstaduais']);

    $router->get('feriados/{ano}/{sigla}/{cidade}',  ['uses' => 'FeriadosController@getMunicipais']);

    $router->post('feriados/{ano}/municipiosEspecificos',  ['uses' => 'FeriadosController@getMunicipiosEspecificos']);

    $router->post('feriados/{ano}/estadosEspecificos',  ['uses' => 'FeriadosController@getEstadosEspecificos']);
  
    $router->get('teste',  ['uses' => 'FeriadosController@setarNacionais']);
});
