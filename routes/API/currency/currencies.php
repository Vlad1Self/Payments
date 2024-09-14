<?php

use Illuminate\Support\Facades\Route;

Route::prefix('currencies')->group(function() {
    Route::get('/index', [\App\UI\API\Controllers\CurrencyController::class, 'index']);
});
