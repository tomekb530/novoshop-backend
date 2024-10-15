<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PaymentController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum', 'verified');

Route::get('/users', [UserController::class, 'index'])->middleware('auth:sanctum', 'verified', 'role:master,admin');
Route::post('/users', [UserController::class, 'store'])->middleware('auth:sanctum', 'verified', 'role:master,admin');
Route::get('/users/{user}', [UserController::class, 'show'])->middleware('auth:sanctum', 'verified', 'role:master,admin');
Route::post('/users/{user}', [UserController::class, 'update'])->middleware('auth:sanctum', 'verified', 'role:master,admin');
Route::delete('/users/{user}', [UserController::class, 'destroy'])->middleware('auth:sanctum', 'verified', 'role:master,admin');

Route::get('/payment/all', [PaymentController::class, 'show'])->middleware('auth:sanctum', 'verified', 'role:master,admin');

Route::post('/payment/new', [PaymentController::class, 'pay'])->middleware('auth:sanctum', 'verified');
Route::get('/payment/status', [PaymentController::class, 'status'])->middleware('auth:sanctum', 'verified');
Route::get('/payment/info', [PaymentController::class, 'info'])->middleware('auth:sanctum', 'verified');
Route::get('/payment/refund', [PaymentController::class, 'refund'])->middleware('auth:sanctum', 'verified');
Route::get('/payment/history', [PaymentController::class, 'history'])->middleware('auth:sanctum', 'verified');

Route::get('/invoice', [PaymentController::class, 'invoice'])->middleware('auth:sanctum', 'verified');
Route::get('/invoice/my', [PaymentController::class, 'myInvoice'])->middleware('auth:sanctum', 'verified');
Route::get('/invoice/all', [PaymentController::class, 'allInvoice'])->middleware('auth:sanctum', 'verified', 'role:master,admin');