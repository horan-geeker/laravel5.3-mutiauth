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
], function () {
    // Handle on passed down request
    header('Access-Control-Allow-Origin: ' . config('app.domain'));
    header('Access-Control-Allow-Methods: ' . 'GET, POST, PATCH, PUT, DELETE, OPTIONS, HEAD');
    header('Access-Control-Allow-Headers: ' . 'Content-Type, Accept, Cookie, X-Requested-With');
    header('Access-Control-Allow-Credentials: ' . 'true');

    Route::group([
        'namespace' => 'Auth',
    ], function () {
        Route::post('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout');
        Route::post('register','RegisterController@register');
    });

    Route::resource('coder','CoderController');


    Route::group([
        'middleware' => 'auth.api'
    ], function () {
        Route::resource('users', 'UserController');
        Route::get('userinfo', function () {
            $user = Auth::user();
            if (!$user) {
                return response()->json([
                    'status' => 4,
                    'msg' => 'user not login'
                ]);
            }
            return response()->json([
                'status' => 0,
                'msg' => 'already login',
                'data' => $user
            ]);
        });
    });


});
