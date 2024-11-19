<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// Homepage
Route::get('/', [ListingController::class, 'index'])->name('home');

// About page
Route::get('/about', function () {
    return Inertia::render('About');
});

// Listings
Route::get('/listings/{listing}', [ListingController::class, 'show'])->name('listings.show');
Route::get('/sell', [ListingController::class, 'create'])->name('listings.create');
Route::post('/sell', [ListingController::class, 'store'])->name('listings.store');


Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/sell', function () {
        return Inertia::render('CreateListing');
    });
});

require __DIR__.'/auth.php';
