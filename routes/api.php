<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthApiController;
use App\Http\Controllers\Api\AudioAnalysisController;
use App\Http\Controllers\Api\ExerciceApiController;

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
    Route::post('/analyze', [AudioAnalysisController::class, 'analyze']);
    Route::prefix('exercices')->group(function () {
        Route::get('/', [ExerciceApiController::class, 'index']);
        Route::get('/by-niveau', [ExerciceApiController::class, 'byNiveau']);
        Route::get('/{id}', [ExerciceApiController::class, 'show']);
        Route::post('/', [ExerciceApiController::class, 'store']);
        Route::put('/{id}', [ExerciceApiController::class, 'update']);
        Route::delete('/{id}', [ExerciceApiController::class, 'destroy']);
});
});
