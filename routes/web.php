<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Public routes
Route::get('/', [ListingController::class, 'index'])->name('home');

Route::get('/about', function () {
    return Inertia::render('About');
});

// Show a single listing
Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');


// Protected routes
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Listing creation routes
    Route::get('/sell', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/sell', [ListingController::class, 'store'])->name('listings.store');
});

require __DIR__.'/auth.php';
