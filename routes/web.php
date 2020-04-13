<?php

/** @var Router $router */

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

use Laravel\Lumen\Routing\Router;

$router->get('/', function () use ($router) {
    return "Build 4 SDG Covid-19 API Up and Running !!!";
});


$router->group(["prefix" => "api/v1/on-covid-19"], function () use ($router) {

    $router->post('/', "ApiController@json");
    $router->post('/json', "ApiController@json");
    $router->post('/xml', "ApiController@xml");

    $router->get('/logs', "ApiController@logs");
});
