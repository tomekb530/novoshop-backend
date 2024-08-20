<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum', 'verified');

Route::get('/users', [UserController::class, 'index'])->middleware('auth:sanctum', 'verified', 'role:superadmin,admin');
Route::post('/users', [UserController::class, 'store'])->middleware('auth:sanctum', 'verified', 'role:superadmin,admin');
Route::get('/users/{user}', [UserController::class, 'show'])->middleware('auth:sanctum', 'verified', 'role:superadmin,admin');
Route::post('/users/{user}', [UserController::class, 'update'])->middleware('auth:sanctum', 'verified', 'role:superadmin,admin');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('auth:sanctum', 'verified', 'role:superadmin,admin');


