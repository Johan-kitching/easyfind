<?php

use App\Http\Controllers\UserPaymentController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/user/payments/{id}', [UserPaymentController::class , 'logPayment'])->name('payments');
