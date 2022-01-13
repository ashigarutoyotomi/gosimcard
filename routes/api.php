<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SimCard\SimCardActivationController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SimCard\SimCardController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::post("/login", [AuthController::class, "login"]);
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, "me"]);
    Route::get('/logout', [AuthController::class, 'logout']);    

    

    Route::group(['prefix'=>'/users'],function (){
        Route::get('/', [UsersController::class, 'index']);
        Route::post('/store', [UsersController::class, 'store']);
        Route::get('/{id}/show', [UsersController::class, 'show']);
        Route::get('/{id}/edit', [UsersController::class, 'edit']);
        Route::post('/{id}/update', [UsersController::class, "update"]);
        Route::delete('/{id}/delete', [UsersController::class, 'delete']);
    });

    Route::group(['prefix'=>'/simcards'],function(){
        Route::get('/',[SimCardController::class,'index']);
        Route::post('/store',[SimCardController::class,'store']);
        Route::get('/{id}/show',[SimCardController::class,'show']);
        Route::delete('/{id}/delete',[SimCardController::class,'delete']);
    });    
});

Route::group(['prefix'=>'simcardactivation'],
    function(){
       Route::get('/',[SimCardActivationController::class,'index']);
        Route::get('/{id}/show',[SimCardActivationController::class,'show']);
        Route::post('/store',[SimCardActivationController::class,'store']);
        Route::post('/{id}/activate',[SimCardActivationController::class,'activate']);
    });