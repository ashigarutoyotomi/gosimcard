<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SimCard\SimcardController;
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
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, "me"]);
    Route::get('/logout', [AuthController::class, 'logout']);    

    Route::group(['prefix'=>'/simcards'],function(){
        Route::get('/',[SimcardController::class,'index']);
        Route::post('/store',[SimCardController::class,'store']);
        Route::get('/{id}/show',[SimcardController::class,'show']);
        Route::delete('/{id}/delete',[SimcardController::class,'delete']);
    });

    Route::group(['prefix'=>'/users'],function (){
        Route::get('/', [UsersController::class, 'index']);
        Route::post('/store', [UsersController::class, 'store']);
        Route::get('/{id}/show', [UsersController::class, 'show']);
        Route::get('/{id}/edit', [UsersController::class, 'edit']);
        Route::post('/{id}/update', [UsersController::class, "update"]);
        Route::delete('/{id}/delete', [UsersController::class, 'delete']);
    });
});

Route::post("/login", [AuthController::class, "login"]);