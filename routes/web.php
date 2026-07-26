<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\LandingController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class)->name('landing');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
