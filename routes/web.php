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
    return "Welcome to this wonderfull api";//$router->app->version();
});

$router->group(['prefix' => 'api'], function () use ($router)
{
    //match /api/register
    $router->post('register', 'AuthController@register');

    //match /api/login
    $router->post('login', 'AuthController@login');

    //match /api/profile
    $router->get('profile', 'UserController@profile');

    //match /api/users
    $router->get('users', 'UserController@allUsers');

    //match /api/user
    $router->get('users/{id}', 'UserController@singleUser');



});

