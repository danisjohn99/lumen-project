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
    echo "<center> Lumen Task </center>";
});

$router->get('/version', function () use ($router) {
    return $router->app->version();
});





Route::group([

    'prefix' => 'api'

], function ($router) {
    
    // AUTHENTICATION //
    Route::post('signup', 'AuthController@signup');
    Route::post('login', 'AuthController@login');
    Route::post('logout', 'AuthController@logout');
    Route::post('refresh', 'AuthController@refresh');
    Route::post('user-profile', 'AuthController@userProfile');

    // TODO //
    Route::post('create-note', 'ToDoController@createNote');
    Route::delete('delete-note/{id}', 'ToDoController@deleteNote');
    Route::post('mark-note-status', 'ToDoController@markNoteStatus');
    Route::get('user-note-list', 'ToDoController@userNoteList');
    Route::get('all-user-notes', 'ToDoController@allNotes');

});

