<?php

use Illuminate\Support\Facades\Route;

Route::prefix('payment_methods')->group(function() {
    Route::get('/index', [\App\UI\API\Controllers\PaymentMethodController::class, 'index']);

    Route::get('{payment_uuid}/redirectPayment', [\App\UI\API\Controllers\PaymentMethodController::class, 'redirectPayment']);
});
