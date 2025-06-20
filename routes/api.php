<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Ce fichier contient les routes pour les appels API de votre application.
| Toutes les routes ici sont automatiquement protégées par le middleware "api".
|
*/

// ✅ Route pour tester l'utilisateur authentifié (optionnel)
// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/test', function () {
    return response()->json(['message' => 'Test successful'], 200);
});
// ✅ Authentification API
Route::post('/register', [AuthApiController::class, 'register']);
Route::post('/login', [AuthApiController::class, 'login']);
Route::get('/niveaux', [AuthApiController::class, 'niveaux']);

// ✅ Routes protégées par token
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthApiController::class, 'logout']);
});
