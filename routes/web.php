<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ToolController;
use App\Http\Controllers\BusinessController;

Route::get('/', function () {
    return view('auth.login');
})->name('login');

Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/settings', function () {
    return view('settings.index');
})->name('settings');

// Sidebar Routes
Route::get('/landing-page-generator', [ToolController::class, 'landingPage'])->name('landing-page-generator');
Route::post('/landing-page-generator', [ToolController::class, 'storeLandingPage'])->name('landing-page-generator.store');

Route::get('/video-prompter', [ToolController::class, 'videoPrompter'])->name('video-prompter');
Route::post('/video-prompter', [ToolController::class, 'storeVideoScript'])->name('video-prompter.store');

Route::get('/wa-testimonial-generator', [ToolController::class, 'waTestimonial'])->name('wa-testimonial-generator');
Route::post('/wa-testimonial-generator', [ToolController::class, 'storeTestimonial'])->name('wa-testimonial-generator.store');

Route::get('/affiliate-script-generator', [ToolController::class, 'affiliateScript'])->name('affiliate-script-generator');
Route::post('/affiliate-script-generator', [ToolController::class, 'storeAffiliateScript'])->name('affiliate-script-generator.store');

Route::get('/ads-image-generator', [ToolController::class, 'adsImage'])->name('ads-image-generator');
Route::post('/ads-image-generator', [ToolController::class, 'storeAdsImage'])->name('ads-image-generator.store');

Route::get('/pos', [BusinessController::class, 'pos'])->name('pos');
Route::post('/pos/checkout', [BusinessController::class, 'processCheckout'])->name('pos.checkout');
Route::get('/sales-recap', [BusinessController::class, 'salesRecap'])->name('sales-recap');
Route::get('/stock-management', [BusinessController::class, 'stock'])->name('stock-management');
Route::post('/stock-management', [BusinessController::class, 'storeProduct'])->name('stock-management.store');
Route::put('/stock-management/{id}', [BusinessController::class, 'updateProduct'])->name('stock-management.update');
Route::delete('/stock-management/{id}', [BusinessController::class, 'destroyProduct'])->name('stock-management.destroy');
Route::get('/cashflow', [BusinessController::class, 'cashflow'])->name('cashflow');
Route::post('/cashflow', [BusinessController::class, 'storeTransaction'])->name('cashflow.store');
Route::get('/location-profit', [BusinessController::class, 'locationProfit'])->name('location-profit');
Route::get('/hpp-calculator', [BusinessController::class, 'hppCalculator'])->name('hpp-calculator');
Route::post('/hpp-calculator', [BusinessController::class, 'storeHpp'])->name('hpp-calculator.store');
Route::get('/team-management', [BusinessController::class, 'team'])->name('team-management');
Route::post('/team-management', [BusinessController::class, 'storeTeamMember'])->name('team-management.store');
