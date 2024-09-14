<?php

use Illuminate\Support\Facades\Route;

Route::prefix('subscriptions')->group(function() {
    Route::get('index/{page}', [\App\UI\API\Controllers\SubscriptionController::class, 'index']);

    Route::get('show/{uuid}', [\App\UI\API\Controllers\SubscriptionController::class, 'show']);

    Route::post('/payment/{uuid}', [\App\UI\API\Controllers\SubscriptionController::class, 'payment']);
});
