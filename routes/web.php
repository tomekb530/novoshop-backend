<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\VerifyEmailController;
Route::get('/', function () {
    return "NovoShop Backend";
});

Route::get('/reset-password/{token}', function () {
    return "NovoShop Backend";
})->name('password.reset');

Route::get('/email/verify/{id}/{hash}', VerifyEmailController::class)->name('verification.verify');
