<?php

use Illuminate\Support\Facades\Route;
use App\Models\Settings; // Ajoutez cette ligne
use App\Http\Controllers\Api\SyncController;

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/sync', [SyncController::class, 'sync']);
    
    Route::get('/essential-data', function () {
        return response()->json([
            'user' => auth()->user(),
            'classes' => auth()->user()->classes,
            'settings' => Settings::all() // Assurez-vous que le modèle Settings existe
        ]);
    });
});