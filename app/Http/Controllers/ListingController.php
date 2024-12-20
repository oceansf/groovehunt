<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use App\Http\Resources\ListingResource;
use App\Http\Resources\UserResource;
use App\Http\Requests\StoreListingRequest;
use App\Http\Requests\UpdateListingRequest;
use App\Services\ImageHandlerService;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Illuminate\Http\Request;

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
    public function index(Request $request)
    {
        $query = $request->input('search');

        if ($query && trim($query) !== '') {
            \Log::info('Search query:', ['query' => $query]);
            // Get raw Typesense results
            $searchResults = Listing::search($query)->get();
            \Log::info('Search results count:', ['count' => count($searchResults)]);
            // Convert to a paginator instance
            $page = $request->input('page', 1);
            $perPage = 24;

            $items = collect($searchResults)->forPage($page, $perPage);

            // Create a new LengthAwarePaginator
            $listings = new \Illuminate\Pagination\LengthAwarePaginator(
                $items,
                count($searchResults),
                $perPage,
                $page,
                ['path' => $request->url(), 'query' => $request->query()]
            );

            // Transform the items
            $listings->through(fn($listing) => [
                'id' => $listing->id,
                'title' => $listing->title,
                'artist' => $listing->artist,
                'price' => $listing->price,
                'images' => $listing->images,
                'media_condition' => $listing->media_condition,
            ]);
        } else {
            $listings = Listing::query()
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
                ]);
        }

        return Inertia::render('Index', [
            'listings' => $listings,
            'filters' => [
                'search' => $query ?? ''
            ]
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
    public function store(StoreListingRequest $request)
    {
        try {
            // Process and upload images
            $processedImages = $this->imageHandler->handleMultipleUploads($request->file('images'));

            // Create the listing
            $listing = auth()->user()->listings()->create([
                ...$request->validated(),
                'images' => $processedImages,
                'seller_id' => auth()->id(),
                'status' => 'available',
                'is_active' => true,
                'views_count' => 0,
                'shipping_restrictions' => $request->shipping_restrictions ?? [],
                'last_price_update' => now(),
            ]);

            return redirect()
                ->route('listings.show', ['listing' => $listing->id])
                ->with('success', 'Listing created successfully!');
        } catch (\Exception $e) {
            report($e); // Uses Laravel's error reporting system

            return back()
                ->withInput()
                ->withErrors(['error' => 'There was an error creating your listing. Please try again.']);
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
    public function update(UpdateListingRequest $request, Listing $listing)
    {
        try {
            $listing->update($request->validated());

            return redirect()
                ->route('listings.show', ['listing' => $listing->id])
                ->with('success', 'Listing updated successfully!');
        } catch (\Exception $e) {
            report($e); // This is preferred over Log::error() as it includes stack trace

            return back()
                ->withInput()
                ->withErrors(['error' => 'There was an error updating your listing. Please try again.']);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Listing $listing)
    {
        try {
            // Delete associated images from S3
            if (!empty($listing->images)) {
                foreach ($listing->images as $image) {
                    // Delete from S3 using the path
                    Storage::disk('s3')->delete($image['path']);
                }
            }

            // Delete the listing
            $listing->delete();

            return redirect()
                ->route('home')
                ->with('success', 'Listing deleted successfully!');
        } catch (\Exception $e) {
            //            \Log::error('Error in ListingController@destroy: ' . $e->getMessage());
            //            \Log::error('Stack trace: ' . $e->getTraceAsString());

            return back()->withErrors(['error' => 'There was an error deleting your listing: ' . $e->getMessage()]);
        }
    }
}
