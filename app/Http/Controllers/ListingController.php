<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Listing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ListingController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Services\ImageHandlerService;
use App\Http\Resources\ListingResource;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Storage;

class ListingController extends Controller
{
    private $imageHandler;

    public function __construct(ImageHandlerService $imageHandler)
    {
        $this->imageHandler = $imageHandler;
    }

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
        return Inertia::render('Listing/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            // Validate the request
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'artist' => 'required|string|max:255',
                'format' => 'required|string|in:LP,45,78,EP,Single',
                'media_condition' => 'required|string|in:Mint,Near Mint,Very Good Plus,Very Good,Good Plus,Good,Fair,Poor',
                'sleeve_condition' => 'nullable|string|in:Mint,Near Mint,Very Good Plus,Very Good,Good Plus,Good,Fair,Poor',
                'description' => 'nullable|string|max:5000',
                'images' => 'required|array|min:1|max:12',
                'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:10240',
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

            // Process and upload images
            $processedImages = $this->imageHandler->handleMultipleUploads($request->file('images'));
            
            // Get authenticated user
            $user = auth()->user();

            // Create the listing
            $listing = $user->listings()->create([
                ...$validated,
                'images' => $processedImages,
                'seller_id' => $user->id,
                'status' => 'available',
                'is_active' => true,
                'views_count' => 0,
                'shipping_restrictions' => $request->shipping_restrictions ?? [],
                'last_price_update' => now(),
            ]);            

            // Use redirect() instead of to_route() for more explicit control
            return redirect()
                ->route('listings.show', ['listing' => $listing->id])
                ->with('success', 'Listing created successfully!');
                
        } catch (\Exception $e) {
            \Log::error('Error in ListingController@store: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            \Log::error('Previous exception: ' . ($e->getPrevious() ? $e->getPrevious()->getMessage() : 'None'));
            
            return back()
                ->withInput()
                ->withErrors(['error' => 'There was an error creating your listing: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Listing $listing)
    {
        $listing->load('seller');
        
        $sellerListings = $listing->seller
            ->listings()
            ->where('id', '!=', $listing->id)
            ->latest()
            ->take(4)
            ->get();

        return Inertia::render('Listing/Show', [
            'listing' => new ListingResource($listing),
            'seller' => new UserResource($listing->seller),
            'sellerListings' => ListingResource::collection($sellerListings),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Listing $listing)
    {
        return Inertia::render('Listing/Edit', [
            'listing' => new ListingResource($listing),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Listing $listing)
    {
        try {
            // Only validate fields that were actually sent
            $rules = [];
            $data = $request->all();
            
            // Build validation rules only for submitted fields
            if (isset($data['title'])) {
                $rules['title'] = 'string|max:255';
            }
            if (isset($data['artist'])) {
                $rules['artist'] = 'string|max:255';
            }
            if (isset($data['format'])) {
                $rules['format'] = 'string|in:LP,45,78,EP,Single';
            }
            if (isset($data['media_condition'])) {
                $rules['media_condition'] = 'string|in:Mint,Near Mint,Very Good Plus,Very Good,Good Plus,Good,Fair,Poor';
            }
            if (isset($data['price'])) {
                $rules['price'] = 'numeric|min:0';
            }
            // Add other fields as needed...
    
            $validated = $request->validate($rules);
    
            // Update only the changed fields
            $listing->update($validated);
    
            return redirect()
                ->route('listings.show', ['listing' => $listing->id])
                ->with('success', 'Listing updated successfully!');
    
        } catch (\Exception $e) {
            \Log::error('Error in ListingController@update: ' . $e->getMessage());
            return back()
                ->withInput()
                ->withErrors(['error' => 'There was an error updating your listing: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        try {
            

            // Delete associated images from storage
            if (!empty($listing->images)) {
                foreach ($listing->images as $image) {
                    Storage::delete($image);
                }
            }

            

            // Delete the listing
            $listing->delete();

            

            return redirect()
                ->route('home')
                ->with('success', 'Listing deleted successfully!');

        } catch (\Exception $e) {
            \Log::error('Error in ListingController@destroy: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return back()->withErrors(['error' => 'There was an error deleting your listing: ' . $e->getMessage()]);
        }
    }
}
