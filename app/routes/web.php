<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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

$router->group(['middleware' => 'app\Http\Middleware\AuthenticateAccess'], function() use ($router) {
    $router->post('/estabelecimento', 'EstabelecimentoController@create');
    $router->get('/estabelecimento', 'EstabelecimentoController@get');
    $router->put('/estabelecimento/{id}', 'EstabelecimentoController@update');
    $router->delete('/estabelecimento/{id}', 'EstabelecimentoController@delete');
    $router->get('/estabelecimento/buscaCep/{cep}', 'EstabelecimentoController@buscaCep');
});
