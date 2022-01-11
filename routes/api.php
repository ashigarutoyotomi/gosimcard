<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UsersController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('auth:sanctum')->group(function () {
    Route::get('/me', [AuthController::class, "me"]);
    Route::get('/logout', [AuthController::class, 'logout']);
});

Route::post("/login", [AuthController::class, "login"]);

// users crud actions
Route::middleware('IsAdmin')->group(function () {
    Route::get('/users/index', [UsersController::class, 'index']);
    Route::post('/users/store', [UsersController::class, 'store']);
    Route::get('/users/show/{id}', [UsersController::class, 'show']);
    Route::get('/users/edit/{id}', [UsersController::class, 'edit']);
    Route::post('/users/update/{id}', [UsersController::class, "update"]);
    Route::delete('/users/delete/{id}', [UsersController::class, 'delete']);
});
