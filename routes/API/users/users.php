<?php

use Illuminate\Support\Facades\Route;

Route::prefix('users')->group(function() {
   Route::get('/index/{page}', [\App\UI\API\Controllers\UserController::class, 'index']);

   Route::get('show/{id}', [\App\UI\API\Controllers\UserController::class, 'show']);
});
