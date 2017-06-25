<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group([
    'namespace' => 'Api',
], function (){
    // Handle on passed down request
    header('Access-Control-Allow-Origin: '.'http://localhost:8080');
    header('Access-Control-Allow-Methods: '.'GET, POST, PATCH, PUT, DELETE, OPTIONS, HEAD');
    header('Access-Control-Allow-Headers: '.'Content-Type, Accept, Cookie, X-Requested-With');
    header('Access-Control-Allow-Credentials: '.'true');

    Route::group([
        'namespace' => 'Auth',
    ], function(){
        Route::post('login', 'LoginController@login');
    });

    Route::group([
        'middleware' => ['auth.api']
    ], function() {
        Route::resource('users', 'UserController');
    });
});
