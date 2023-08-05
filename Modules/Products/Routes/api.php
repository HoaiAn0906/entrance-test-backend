<?php

use Illuminate\Support\Facades\Route;
use Modules\Products\Http\Controllers\ProductCategoriesController;
use Modules\Products\Http\Controllers\ProductsController;

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
    'middleware' => 'auth:api',
], function () {
    Route::group([
        'prefix' => 'admin',
    ], function () {
        Route::apiResource('products',ProductsController::class);

        Route::group([
            'prefix' => 'product-categories',
        ], function () {
            Route::get('no-tree', [ProductCategoriesController::class, 'getProductCategoriesNoTree']);
        });
        Route::apiResource('product-categories',ProductCategoriesController::class);
    });
});
