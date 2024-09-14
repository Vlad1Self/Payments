<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::group(['namespace' => 'App\UI\API\Controllers'], function () {
    require __DIR__ . '/../routes/API/orders/orders.php';
    require __DIR__ . '/../routes/API/users/users.php';
    require __DIR__ . '/../routes/API/payments_methods/payment_methods.php';
    require __DIR__ . '/../routes/API/currency/currencies.php';
    require __DIR__ . '/../routes/API/payments/payments.php';
    require __DIR__ . '/../routes/API/subscriptions/subscriptions.php';
    require __DIR__ . '/../routes/API/stripe/stripe.php';
});
