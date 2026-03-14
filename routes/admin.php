<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminWebsiteController;
use App\Http\Controllers\Admin\AdminTestimonialController;
use Illuminate\Support\Facades\Route;

Route::prefix('admin')->name('admin.')->group(function () {
    Route::middleware('guest:admin')->group(function () {
        Route::get('/login', [AdminController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminController::class, 'login']);
    });
    Route::middleware('auth:admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

            Route::get('/users', [AdminUserController::class, 'index'])->name('users');
            Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
            Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->name('users.edit');
            Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('users.update');
            Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
            Route::get('/users/{user}/email', [AdminUserController::class, 'emailForm'])->name('users.email');
            Route::post('/users/{user}/email', [AdminUserController::class, 'sendEmail'])->name('users.email.send');

        Route::get('/websites',                    [AdminWebsiteController::class, 'index'])->name('websites');
        Route::post('/websites/{website}/approve', [AdminWebsiteController::class, 'approve'])->name('websites.approve');
        Route::post('/websites/{website}/reject',  [AdminWebsiteController::class, 'reject'])->name('websites.reject');

        Route::get('/testimonials', [AdminTestimonialController::class, 'index'])->name('testimonials');

        Route::get('/settings/payment',  [AdminSettingsController::class, 'paymentIndex'])->name('settings.payment');
        Route::put('/settings/payment',  [AdminSettingsController::class, 'paymentUpdate'])->name('settings.payment.update');

        Route::post('/logout', [AdminController::class, 'logout'])->name('logout');
    });
});
