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

$router->get('test', [
    'as' => 'scrapLinks', 'uses' => 'TaskController@test'
]);

$router->post('job', [
    'as' => 'taskCreate', 'uses' => 'TaskController@create'
]);

$router->get('jobs', [
    'as' => 'taskShow', 'uses' => 'TaskController@list'
]);

$router->get('job/{id}/show', [
    'as' => 'taskShow', 'uses' => 'TaskController@show'
]);

$router->get('foo', function () {
    return 'Hello World';
});

//Route::post('/job', 'JobController@create');
