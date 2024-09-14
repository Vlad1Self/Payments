<?php
use Illuminate\Support\Facades\Route;

Route::prefix('stripe')->group(function() {
    Route::post('callback', [\App\UI\API\Controllers\StripeController::class, 'callback']);
});

