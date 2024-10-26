<?php

use App\Http\Controllers\API\Auth\AuthController;
use App\Http\Controllers\API\Category\CategoryController;
use App\Http\Controllers\API\Order\OrderController;
use App\Http\Controllers\API\Product\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['name' => 'auth.'], function () {
    Route::post('login', [AuthController::class, 'login']);
    Route::post('register', [AuthController::class, 'register']);

    Route::group(['middleware' => ['auth:sanctum', 'admin']], function() {
        // Products Routes
        Route::apiResource('/products', ProductController::class)->except('index');
    });
    Route::group(['middleware' => 'auth:sanctum'], function(){
        // Auth routes
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('user', [AuthController::class, 'user']);

        // Order Routes
        Route::apiResource('/orders', OrderController::class)->except('delete');
    });
});

// Routes Doesn't need Authentication
Route::get('/categories', [CategoryController::class,'index']);

Route::get('/products', [ProductController::class, 'index']);

