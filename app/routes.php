<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

// GET ROUTES
Route::get('/', function()
{
	return View::make('hello');
});

Route::get('/games', function()
{
    return 'Hello World';
});

Route::get('/games/{id}', function($id)
{
    return 'Game '.$id;
});

// POST ROUTES

Route::post('/games', function()
{
    return 'POST GAMES';
});

Route::post('/games/{id}', function($id)
{
    return 'POST GAMES';
});