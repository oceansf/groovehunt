<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\SearchController;
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

Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');

// Protected routes
Route::middleware('auth')->group(function () {
    // Profile management routes
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Listing management routes
    Route::get('/sell', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/sell', [ListingController::class, 'store'])->name('listings.store');
    Route::get('/listings/{listing}/edit', [ListingController::class, 'edit'])->can('update', 'listing')->name('listings.edit');
    Route::put('/listings/{listing}', [ListingController::class, 'update'])->can('update', 'listing')->name('listings.update');
    Route::delete('/listings/{listing}', [ListingController::class, 'destroy'])->can('delete', 'listing')->name('listings.destroy');
});

require __DIR__.'/auth.php';
