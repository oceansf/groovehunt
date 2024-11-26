<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Illuminate\Http\Request;

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
                ->simplePaginate(24)
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
        return Inertia::render('CreateListing');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'artist' => 'required|string|max:255',
        'format' => 'required|string|in:LP,45,78,EP,Single',
        'media_condition' => 'required|string|in:Mint,Near Mint,Very Good Plus,Very Good,Good Plus,Good,Fair,Poor',
        'sleeve_condition' => 'nullable|string|in:Mint,Near Mint,Very Good Plus,Very Good,Good Plus,Good,Fair,Poor',
        'description' => 'nullable|string|max:5000',
        'images' => 'required|array|min:1|max:12',
        'images.*' => 'required|image|mimes:jpeg,png,jpg|max:10240', // 10MB limit
        'price' => 'required|numeric|min:0',
        'allow_offers' => 'boolean',
        'min_offer' => 'required_if:allow_offers,true|nullable|numeric|min:0|lt:price',
        'shipping' => 'required|numeric|min:0',
        'genre' => 'nullable|string|max:255',
        'speed' => 'nullable|string|in:33,45,78',
        'color' => 'nullable|string|max:255',
        'release_country' => 'nullable|string|max:255',
        'release_year' => 'nullable|string|max:4',
        'release_label' => 'nullable|string|max:255',
        'release_cat_no' => 'nullable|string|max:255',
        'release_matrix_no' => 'nullable|string|max:255',
        'release_upc' => 'nullable|string|max:255',
        'location' => 'nullable|string|max:255',
        'local_pickup' => 'boolean',
        'shipping_restrictions' => 'nullable|array',
        'weight' => 'nullable|numeric|min:0',
        'notes' => 'nullable|string',
    ]);

    try {
        // Process and upload images
        $processedImages = $this->imageHandler->handleMultipleUploads($request->file('images'));
        
        // Create the listing
        $listing = auth()->user()->listings()->create([
            ...$validated,
            'images' => $processedImages, // This will store the array of image data
            'seller_id' => auth()->id(),
            'status' => 'available',
            'is_active' => true,
            'views_count' => 0,
            'shipping_restrictions' => $request->shipping_restrictions ?? [],
            'last_price_update' => now(),
        ]);

        return to_route('listings.show', $listing)
            ->with('success', 'Listing created successfully!');
            
    } catch (\Exception $e) {
        \Log::error('Error creating listing: ' . $e->getMessage());
        
        return back()
            ->withInput()
            ->with('error', 'There was an error creating your listing. Please try again.');
        }
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
