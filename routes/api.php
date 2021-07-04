<?php

use Illuminate\Http\Request;
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

Route::post('register', [\App\Http\Controllers\AuthController::class, 'register']);
Route::post('login', [\App\Http\Controllers\AuthController::class, 'login']);



// Route::middleware('auth:sanctum')->group(function () {
//     Route::get('user', [\App\Http\Controllers\AuthController::class, 'user']);
//     Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
// });

Route::group(['middleware' => 'auth:sanctum'], function()
{
    Route::get('user', [\App\Http\Controllers\AuthController::class, 'user']);
    Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);

    Route::group(['prefix' => 'admin', 'middleware' => 'admin'], function(){

        Route::get('users20', [\App\Http\Controllers\AuthController::class, 'users20']);
        Route::get('users40', [\App\Http\Controllers\AuthController::class, 'users40']);
        Route::get('users60', [\App\Http\Controllers\AuthController::class, 'users60']);
        Route::get('nbOfRegisteredUsers', [\App\Http\Controllers\AuthController::class, 'nbOfRegisteredUsers']);

    });
});

// Route::middleware('AdminMiddleware')->group(funtion() {
//     Route::middleware('auth:sanctum')->group(function () {
//         Route::get('user', [\App\Http\Controllers\AuthController::class, 'user']);
//         Route::post('logout', [\App\Http\Controllers\AuthController::class, 'logout']);
//     })
// });