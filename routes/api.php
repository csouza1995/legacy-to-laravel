<?php

use App\Http\Controllers\ProvidersController;
use Illuminate\Support\Facades\Route;

Route::get('/providers', [ProvidersController::class, 'index'])
    ->name('providers.index');

Route::get('/providers/{provider}', [ProvidersController::class, 'show'])
    ->name('providers.show');

Route::post('/providers', [ProvidersController::class, 'store'])
    ->name('providers.store');

// Route::match(['put', 'patch'], '/providers/{provider}', [ProvidersController::class, 'update'])
//     ->name('providers.update');