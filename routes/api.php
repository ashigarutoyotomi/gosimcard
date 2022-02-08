<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\SimCard\SimCardActivationController;
use App\Http\Controllers\User\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SimCard\SimCardController;
use App\Http\Controllers\SimCard\SimCardRechargeController;

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

//login api
Route::post("/login", [AuthController::class, "login"]);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, "me"]);
    Route::get('/logout', [AuthController::class, 'logout']);



    //users crud
    Route::group(['prefix' => '/users'], function () {
        Route::get('/', [UsersController::class, 'index']);
        Route::post('/store', [UsersController::class, 'store']);
        Route::get('/{id}/show', [UsersController::class, 'show']);
        Route::get('/{id}/edit', [UsersController::class, 'edit']);
        Route::post('/{id}/update', [UsersController::class, "update"]);
        Route::delete('/{id}/delete', [UsersController::class, 'delete']);
    });
});

//sim activations
Route::group(['prefix' => 'sim-card-activations'], function () {
    Route::post('/store', [SimCardActivationController::class, 'store']);
});

//sim rechargea
Route::group(['prefix' => 'sim-card-recharges'], function () {
    Route::post('/store', [SimCardRechargeController::class, 'store']);
});

Route::post('/simrecharges/store', [SimCardRechargeController::class, 'store']);

//sim recharge cruds
Route::group(['prefix' => 'simrecharges'], function () {
    Route::get('/', [SimCardRechargeController::class, 'index']);
    Route::post('/{id}/recharge', [SimCardRechargeController::class, 'recharge']);
    Route::get('/{id}/show', [SimCardRechargeController::class, 'show']);
});


//simcards crud
Route::group(['prefix' => '/simcards'], function () {
    Route::get('/', [SimCardController::class, 'index']);
    Route::get('/{id}/show', [SimCardController::class, 'show']);
    Route::delete('/{id}/delete', [SimCardController::class, 'delete']);
    Route::post('/createfromcsv',[SimCardController::class, 'createfromcsv']);
});
