<?php

use App\Http\Controllers\API\AuthApiController;
use App\Http\Controllers\API\ProductApiController;
use App\Http\Controllers\API\UserApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::post('register', [UserApiController::class, 'register'])->name('register');
    Route::post('login', [UserApiController::class, 'login'])->name('login');

    Route::middleware('auth:api')->group(function () {

#### user Routes
        Route::prefix('user')->group(function () {
            Route::get('', [UserApiController::class, 'list'])->name('user.list');
        });

#### product Routes
        Route::prefix('product')->group(function () {
            Route::get('', [ProductApiController::class, 'list'])->name('product.list');
            Route::post('store', [ProductApiController::class, 'store'])->name('product.store');
            Route::get('{id}', [ProductApiController::class, 'details'])->name('product.details');
            Route::put('update/{id}', [ProductApiController::class, 'update'])->name('product.update');
            Route::delete('delete/{id}', [ProductApiController::class, 'delete'])->name('product.delete');
        });
    });

});
