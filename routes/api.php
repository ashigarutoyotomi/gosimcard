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

    //sim cards
    Route::group(['prefix' => '/sim-cards'], function () {
        Route::get('/', [SimCardController::class, 'index']);
        Route::get('/{id}/show', [SimCardController::class, 'show']);

        Route::post('/store', [SimCardController::class, 'store']);
        Route::post('/create-from-csv',[SimCardController::class, 'createFromCsv']);

        Route::delete('/{id}/delete', [SimCardController::class, 'delete']);
    });

    //sim recharge
    Route::group(['prefix' => 'sim-card-recharges'], function () {
        Route::get('/', [SimCardRechargeController::class, 'index']);
        Route::post('/{id}/recharge', [SimCardRechargeController::class, 'recharge']);
        Route::get('/{id}/show', [SimCardRechargeController::class, 'show']);
    });

    //sim activations
    Route::group(['prefix' => 'sim-card-activations'], function () {
        Route::get('/', [SimCardActivationController::class, 'index']);
        Route::get('/{id}/show', [SimCardActivationController::class, 'show']);

        Route::post('/{id}/activate', [SimCardActivationController::class, 'activate']);

        Route::delete('/{id}/delete', [SimCardActivationController::class, 'delete']);
    });

    //users
    Route::group(['prefix' => '/users'], function () {
        Route::get('/', [UsersController::class, 'index']);
        Route::get('/{id}/show', [UsersController::class, 'show']);
        Route::get('/{id}/edit', [UsersController::class, 'edit']);
        Route::get('/charts/line/customers-data', [UsersController::class, 'getChartLineCustomersData']);

        Route::post('/store', [UsersController::class, 'store']);
        Route::post('/{id}/update', [UsersController::class, "update"]);

        Route::delete('/{id}/delete', [UsersController::class, 'delete']);
    });
});

//sim cards
Route::group(['prefix' => '/sim-cards'], function () {
    Route::get('/{iccid}/check-by-iccid', [SimCardController::class, 'checkByIccid']);
});

//sim activations
Route::group(['prefix' => 'sim-card-activations'], function () {
    Route::post('/store', [SimCardActivationController::class, 'store']);
    Route::put('/{id}/process', [SimCardActivationController::class, 'process']);
});

//sim recharge
Route::group(['prefix' => 'sim-card-recharges'], function () {
    Route::post('/store', [SimCardRechargeController::class, 'store']);
});

