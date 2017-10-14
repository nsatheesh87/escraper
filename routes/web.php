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
    'as' => 'scrapLinks', 'uses' => 'JobController@scrapLinks'
]);

$router->post('job', [
    'as' => 'job_create', 'uses' => 'JobController@create'
]);

$router->get('foo', function () {
    return 'Hello World';
});

//Route::post('/job', 'JobController@create');
