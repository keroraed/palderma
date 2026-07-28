<?php

use App\Http\Controllers\AllServicesController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LegalPageController;
use Illuminate\Support\Facades\Route;

Route::get('/', LandingController::class)->name('landing');
Route::get('/services', AllServicesController::class)->name('services.all');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/privacy-policy', [LegalPageController::class, 'privacy'])->name('legal.privacy');
Route::get('/terms', [LegalPageController::class, 'terms'])->name('legal.terms');
