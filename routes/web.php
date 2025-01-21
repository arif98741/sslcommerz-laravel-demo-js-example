<?php

use Illuminate\Support\Facades\Route;

Route::get('/payment', function () {

    return view('payment');
});
Route::post('/payment-status', [\App\Http\Controllers\PaymentController::class, 'paymentStatus']);
Route::post('/process-payment', [\App\Http\Controllers\PaymentController::class, 'processPayment']);
