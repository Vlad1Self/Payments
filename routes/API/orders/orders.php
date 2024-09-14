<?php

use Illuminate\Support\Facades\Route;

Route::prefix('orders')->group(function() {
    Route::get('/index/{page}', [\App\UI\API\Controllers\OrderController::class, 'index']);

    Route::get('show/{uuid}', [\App\UI\API\Controllers\OrderController::class, 'show']);

    Route::post('/store', [\App\UI\API\Controllers\OrderController::class, 'store']);

    Route::post('/find', [\App\UI\API\Controllers\OrderController::class, 'find']);

    Route::post('/payment/{uuid}', [\App\UI\API\Controllers\OrderController::class, 'payment']);
});
