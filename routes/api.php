<?php
use App\Http\Controllers\AuthController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/tokens/create', function (Request $request) {
        $validated = $request->validate([
            'token_name' => "required|string|max:50",
        ]);
        $token = $request->user()->create_token($request->token_name);
        return ['token' => $token->plainTextToken];
    });
    Route::get('/me', [AuthController::class, "me"]);
});

Route::post("/login", [AuthController::class, "login"]);
