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

//authorized users
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, "me"]);
    Route::get('/logout', [AuthController::class, 'logout']);

    //sim recharge cruds

});

//create a new simcard
Route::post('/simcards/store', [SimCardController::class, 'store']);

//activation crud
Route::group(
    ['prefix' => 'simcardactivation'],
    function () {
        Route::post('/store', [SimCardActivationController::class, 'store']);
        Route::get('/', [SimCardActivationController::class, 'index']);
        Route::get('/{id}/show', [SimCardActivationController::class, 'show']);
        Route::post('/{id}/activate', [SimCardActivationController::class, 'activate']);
    }
);

Route::post('/simrecharge/store', [SimCardRechargeController::class, 'store']);


Route::group(['prefix' => 'simrecharge'], function () {
    Route::get('/', [SimCardRechargeController::class, 'index']);
    Route::post('/{id}/recharge', [SimCardRechargeController::class, 'recharge']);
    Route::get('/{id}/show', [SimCardRechargeController::class, 'show']);
});

//simcards crud
Route::group(['prefix' => '/simcards'], function () {
    Route::get('/', [SimCardController::class, 'index']);
    Route::get('/{id}/show', [SimCardController::class, 'show']);
    Route::delete('/{id}/delete', [SimCardController::class, 'delete']);
});

//users crud
Route::group(['prefix' => '/users'], function () {
    Route::get('/', [UsersController::class, 'index']);
    Route::post('/store', [UsersController::class, 'store']);
    Route::get('/{id}/show', [UsersController::class, 'show']);
    Route::get('/{id}/edit', [UsersController::class, 'edit']);
    Route::post('/{id}/update', [UsersController::class, "update"]);
    Route::delete('/{id}/delete', [UsersController::class, 'delete']);
});
