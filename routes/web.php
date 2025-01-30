<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\StripeConnectController;
use App\Http\Controllers\MessageController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public routes
Route::get('/', [ListingController::class, 'index'])->name('home');

Route::get('/about', function () {
    return Inertia::render('About');
});

// Show a single listing
Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');

//Search
Route::get('/search', [SearchController::class, 'search']);

// Protected routes
Route::middleware('auth')->group(function () {
    // Stripe management routes
    Route::post('/create-account', [StripeConnectController::class, 'createAccount']);
    Route::post('/create-account-link', [StripeConnectController::class, 'createAccountLink']);
    Route::get('/return/{account}', [StripeConnectController::class, 'handleReturn'])
        ->name('stripe.return');
    Route::get('/refresh/{account}', [StripeConnectController::class, 'handleRefresh'])
        ->name('stripe.refresh');

    // Profile management routes
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/messages', [MessageController::class, 'index'])->name('message.index');

    // Listing management routes
    Route::get('/sell', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/sell', [ListingController::class, 'store'])->name('listings.store');
    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->can('update', 'listing')->name('listings.edit');
    Route::put('/listings/{listing}', [ListingController::class, 'update'])->can('update', 'listing')->name('listings.update');
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->can('delete', 'listing')->name('listings.destroy');
});

Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

require __DIR__ . '/auth.php';
