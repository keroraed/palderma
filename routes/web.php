<?php

use App\Http\Controllers\AllServicesController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LegalPageController;
use App\Http\Controllers\LinkHubController;
use Illuminate\Support\Facades\Route;

// links.palderma.com — a standalone "link in bio" page. Domain-scoped so it
// takes precedence for that host only; must stay registered before the
// generic (no-domain) routes below, which would otherwise match any host.
Route::domain('links.palderma.com')->group(function () {
    Route::get('/', LinkHubController::class)->name('linkhub');
});

Route::get('/', LandingController::class)->name('landing');
Route::get('/services', AllServicesController::class)->name('services.all');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/privacy-policy', [LegalPageController::class, 'privacy'])->name('legal.privacy');
Route::get('/terms', [LegalPageController::class, 'terms'])->name('legal.terms');
Route::get('/__link-hub-preview', LinkHubController::class); // TEMP: for client screenshot before DNS is live, remove after
