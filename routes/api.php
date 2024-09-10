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


Route::middleware('auth:sanctum', 'verified')->get('/payment/new', function (Request $request) {
    $controller = new PaymentController();
    return $controller->pay($request);
});

Route::middleware('auth:sanctum', 'verified')->get('/payment/status', function (Request $request) {
    $controller = new PaymentController();
    return $controller->status($request);
});

Route::middleware('auth:sanctum', 'verified')->get('/payment/info', function (Request $request) {
    $controller = new PaymentController();
    return $controller->info($request);
});

Route::middleware('auth:sanctum', 'verified')->get('/payment/refund', function (Request $request) {
    $controller = new PaymentController();
    return $controller->refund($request);
});

Route::middleware('auth:sanctum', 'verified')->get('/payment/history', function (Request $request) {
    $controller = new PaymentController();
    return $controller->history($request);
});

Route::middleware('auth:sanctum', 'verified', 'role:master,admin')->get('/payment/all', function (Request $request) {
    $controller = new PaymentController();
    return $controller->show($request);
});