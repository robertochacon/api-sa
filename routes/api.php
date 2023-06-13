<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductsController;
use App\Http\Controllers\OrdersController;
use Illuminate\Support\Facades\Artisan;

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

Route::get('/run_ws', function(){
    try {
        Artisan::call('websockets:serve');
        return json_encode(["success"=>"success", "msg"=>"Started"]);
    } catch (\Throwable $th) {
        return json_encode(["success"=>"false", "msg"=>$th ]);
    }
});

Route::get('/stop_ws', function(){
    try {
        Artisan::call('websockets:serve --stop');
        return json_encode(["success"=>"success", "msg"=>"Started"]);
    } catch (\Throwable $th) {
        return json_encode(["success"=>"false", "msg"=>$th ]);
    }
});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'api',
], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::post('refresh', [AuthController::class, 'refresh']);
    Route::post('me', [AuthController::class, 'me']);
    Route::post('register', [AuthController::class, 'register']);

    //categories
    Route::get('/categories/', [CategoriesController::class, 'index']);
    Route::get('/categories/{id}', [CategoriesController::class, 'watch']);
    Route::post('/categories', [CategoriesController::class, 'register']);
    Route::put('/categories/{id}', [CategoriesController::class, 'update']);
    Route::delete('/categories/{id}', [CategoriesController::class, 'delete']);

    //products
    Route::get('/products/', [ProductsController::class, 'index']);
    Route::get('/products/{id}', [ProductsController::class, 'watch']);
    Route::post('/products', [ProductsController::class, 'register']);
    Route::put('/products/{id}', [ProductsController::class, 'update']);
    Route::delete('/products/{id}', [ProductsController::class, 'delete']);

    //orders
    Route::get('/orders/', [OrdersController::class, 'index']);
    Route::get('/orders/{id}', [OrdersController::class, 'watch']);
    Route::post('/orders', [OrdersController::class, 'register']);
    Route::put('/orders/{id}', [OrdersController::class, 'update']);
    Route::delete('/orders/{id}', [OrdersController::class, 'delete']);

});
