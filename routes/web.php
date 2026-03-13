<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Dashboard\AnalyticsController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\SettingsController;
use App\Http\Controllers\Dashboard\TestimonialController;
use App\Http\Controllers\Dashboard\WebsiteController;
use App\Http\Controllers\Dashboard\WidgetController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\SearchController;
use Illuminate\Support\Facades\Route;

// --- Public pages ---
Route::get('/',          fn () => view('home.homepage'))->name('home');
Route::get('/search',    [SearchController::class, 'search'])->name('search');
Route::get('/features',  fn () => view('pages.features'))->name('features');
Route::get('/pricing',   fn () => view('pages.pricing'))->name('pricing');
Route::get('/about',     fn () => view('pages.about'))->name('about');





// --- Dashboard (auth only) ---
Route::prefix('dashboard')->name('dashboard.')->middleware('auth')->group(function () {
    Route::get('/',  [DashboardController::class, 'index'])->name('index');

    Route::resource('websites',     WebsiteController::class)->except(['show']);
    Route::resource('testimonials', TestimonialController::class)->except(['show']);
    Route::post('testimonials/{testimonial}/approve', [TestimonialController::class, 'approve'])->name('testimonials.approve');
    Route::post('testimonials/{testimonial}/reject',  [TestimonialController::class, 'reject'])->name('testimonials.reject');

    Route::get('widget',    [WidgetController::class,    'index'])->name('widget');
    Route::get('analytics', [AnalyticsController::class, 'index'])->name('analytics');

    Route::get('settings',          [SettingsController::class, 'index'])->name('settings');
    Route::post('settings',         [SettingsController::class, 'update'])->name('settings.update');
    Route::post('settings/password',[SettingsController::class, 'updatePassword'])->name('settings.password');
});

// --- Auth (guest only) ---
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class,    'create'])->name('login');
    Route::post('/login',   [LoginController::class,    'store']);

    Route::get('/register', [RegisterController::class, 'create'])->name('register');
    Route::post('/register',[RegisterController::class, 'store']);
});

// --- Logout (auth only) ---
Route::post('/logout', [LoginController::class, 'destroy'])->name('logout')->middleware('auth');

// --- Public business profiles (must remain last — catch-all) ---
Route::get('/{slug}', [PublicProfileController::class, 'show'])
    ->name('public.profile')
    ->where('slug', '[a-z0-9]+(?:-[a-z0-9]+)*');
