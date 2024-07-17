<?php

use Illuminate\Support\Facades\Route;
use App\Modules\Consommateurs\Http\Controllers\ConsommateursController;

Route::prefix('api/consommateurs')->group(function () {
    Route::get('/', [ConsommateursController::class, 'index']);
    Route::post('/create', [ConsommateursController::class, 'create']);
    Route::get('/{id}', [ConsommateursController::class, 'get']);
    Route::put('/{id}', [ConsommateursController::class, 'update']);
    Route::delete('/{id}', [ConsommateursController::class, 'delete']);
});
