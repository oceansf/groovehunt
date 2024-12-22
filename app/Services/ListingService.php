<?php

namespace App\Services;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ListingService
{
    public function getListings(?string $query, Request $request)
    {
        if ($query) {
            return $this->searchListings($query);
        }
        
        return $this->getAllListings();
    }

    private function getAllListings()
    {
        return Listing::query()
            ->where('is_active', true)  // Assuming you have this field
            ->orderBy('created_at', 'desc')
            ->paginate(24);
    }

    private function searchListings(string $query)
    {
        return Listing::query()
            ->where('is_active', true)
            ->where(function (Builder $builder) use ($query) {
                $builder->where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%")
                    ->orWhere('location', 'like', "%{$query}%"); // Add any other fields you want to search
            })
            ->orderBy('created_at', 'desc')
            ->paginate(24);
    }
}