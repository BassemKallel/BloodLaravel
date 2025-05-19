<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CentreController;
use App\Http\Controllers\Api\RendezVousController;
use App\Http\Controllers\Api\UserController;

// Routes publiques (authentification)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Routes protégées avec Sanctum (authentification obligatoire)
Route::middleware('auth:sanctum')->group(function () {

    // User info connecté
    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    // Logout
    Route::post('/logout', [AuthController::class, 'logout']);

    // Routes ressources protégées
    Route::apiResource('centres', CentreController::class);
    Route::apiResource('rendezvous', RendezVousController::class);
    Route::apiResource('users', UserController::class);

    // Routes personnalisées protégées
    Route::get('rendezvous/centre/{id_centre}', [RendezVousController::class, 'getRendezVousByCentre']);
    Route::get('rendezvous/donneur/{id_donneur}', [RendezVousController::class, 'getRendezVousByDonneur']);
});
