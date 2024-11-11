<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class ListingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('Index', [
            'listings' => Listing::query()
                ->select('id', 'title', 'artist', 'price', 'images', 'media_condition')
                ->latest()
                ->simplePaginate(25)
                ->through(fn($listing) => [
                    'id' => $listing->id,
                    'title' => $listing->title,
                    'artist' => $listing->artist,
                    'price' => $listing->price,
                    'images' => $listing->images,
                    'media_condition' => $listing->media_condition,
                ]),
            'canRegister' => Route::has('register'),
            'canLogin' => Route::has('login'),
            'phpVersion' => PHP_VERSION,
            'laravelVersion' => Application::VERSION,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        return Inertia::render('ViewListing', [
            'listing' => $listing
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        //
    }
}
