<?php

use App\Http\Controllers\PageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PropertyController;
use App\Http\Controllers\PropertySearchController;
use App\Http\Controllers\SubscriptionController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'landing'])->name('landing');

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/password/reset', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
    Route::post('/password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// Property Search Routes (should be before the show route)
Route::get('/properties/search', [PropertySearchController::class, 'search'])->name('properties.search');

Route::get('/payment/callback', [SubscriptionController::class, 'callback'])->name('payment.callback');
// Dashboard Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // Redirect old admin dashboard path to new one
    Route::get('/admin/dashboard', function () {
        return redirect()->route('dashboard');
    });

    Route::middleware(['agent.subscription'])->group(function () {
        Route::get('/properties/create', [PropertyController::class, 'create'])
            ->name('properties.create');

        Route::post('/properties', [PropertyController::class, 'store'])
            ->name('properties.store');

        Route::get('/properties/{property}/edit', [PropertyController::class, 'edit'])
            ->name('properties.edit');

        Route::put('/properties/{property}', [PropertyController::class, 'update'])
            ->name('properties.update');

        Route::delete('/properties/{property}', [PropertyController::class, 'destroy'])
            ->name('properties.destroy');
    });
    
    // Property Inquiry - needs to be before the show route as well
    Route::post('/properties/{property}/inquiry', [PropertyController::class, 'inquiry'])->name('properties.inquiry');
    
    // Property Show route - MUST be LAST
    Route::get('/properties/{property}', [PropertyController::class, 'show'])->name('properties.show');

    Route::get('/agent/subscription', [SubscriptionController::class, 'index'])
        ->name('agent.subscription');

    Route::post('/agent/subscription', [SubscriptionController::class, 'subscribe'])
        ->name('agent.subscription.subscribe');
});
