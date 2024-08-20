<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "NovoShop Backend";
});

Route::get('/reset-password/{token}', function () {
    return "NovoShop Backend";
})->name('password.reset');
