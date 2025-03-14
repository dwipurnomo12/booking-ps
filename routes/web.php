<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\RiwayatBookingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/booking', [BookingController::class, 'index']);
Route::post('/booking', [BookingController::class, 'store']);
Route::post('/booking/pay', [BookingController::class, 'paymentProccess']);

Route::get('/riwayat-booking', [RiwayatBookingController::class, 'index']);
Route::get('/riwayat-booking/search', [RiwayatBookingController::class, 'searchData']);