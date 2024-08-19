<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return "NovoShop Backend";
});

Route::get('/reset-password/{token}', function () {
    return "NovoShop Backend";
})->name('password.reset');

Route::get('/images/logos/{filename}', function ($filename) {
    $path = storage_path('app/logos/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->file($path);
});
