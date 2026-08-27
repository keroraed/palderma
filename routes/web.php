<?php

use App\Http\Controllers\AllServicesController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\LandingController;
use App\Http\Controllers\LegalPageController;
use App\Http\Controllers\LinkHubController;
use App\Http\Controllers\SitemapController;
use Illuminate\Support\Facades\Route;

// links.palderma.com — a standalone "link in bio" page. Domain-scoped so it
// takes precedence for that host only; must stay registered before the
// generic (no-domain) routes below, which would otherwise match any host.
Route::domain('links.palderma.com')->group(function () {
    Route::get('/', LinkHubController::class)->name('linkhub');
});

// The main site moved from services.palderma.com to the root domain
// palderma.com. Old links/bookmarks to the old host (and any www traffic)
// get a permanent redirect to the same path on the new canonical domain,
// preserving query strings. Must stay registered before the generic routes.
$redirectToPrimaryDomain = function (\Illuminate\Http\Request $request) {
    return redirect('https://palderma.com' . $request->getRequestUri(), 301);
};
Route::domain('services.palderma.com')->any('/{any?}', $redirectToPrimaryDomain)->where('any', '.*');
Route::domain('www.palderma.com')->any('/{any?}', $redirectToPrimaryDomain)->where('any', '.*');

Route::get('/', LandingController::class)->name('landing');
Route::get('/services', AllServicesController::class)->name('services.all');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
Route::get('/privacy-policy', [LegalPageController::class, 'privacy'])->name('legal.privacy');
Route::get('/terms', [LegalPageController::class, 'terms'])->name('legal.terms');
Route::get('/sitemap.xml', SitemapController::class)->name('sitemap');

Route::prefix('blog')->name('blog.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/category/{category:slug}', [BlogController::class, 'category'])->name('category');
    Route::get('/tag/{tag:slug}', [BlogController::class, 'tag'])->name('tag');
    Route::get('/{slug}', [BlogController::class, 'show'])->name('show');
});
