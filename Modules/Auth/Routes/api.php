<?php

use Illuminate\Support\Facades\Route;

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
    'prefix' => 'admin',
], function () {
    Route::group([
        'middleware' => 'guest:api',
        'prefix' => 'auth',
    ], function () {
        Route::post('login', [\Modules\Auth\Http\Controllers\LoginController::class, 'login']);
        Route::post('refresh', [\Modules\Auth\Http\Controllers\LoginController::class, 'refreshToken']);

        Route::post('oauth/{driver}', [\Modules\Auth\Http\Controllers\OAuthController::class, 'redirect']);
        Route::get('oauth/{driver}/callback', [\Modules\Auth\Http\Controllers\OAuthController::class, 'handleCallback'])->name('oauth.callback');
    });

    Route::group([
        'middleware' => 'auth:api',
        'prefix' => 'auth',
    ], function () {
        Route::post('logout', [\Modules\Auth\Http\Controllers\LoginController::class, 'logout']);
        Route::get('user', [\Modules\Auth\Http\Controllers\UserController::class, 'user']);
    });
});
