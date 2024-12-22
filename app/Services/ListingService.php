<?php

// app/Services/ListingService.php

namespace App\Services;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class ListingService
{
    protected $allowedSortFields = [
        'price' => 'price',
        'date' => 'created_at',
        'title' => 'title',
        // Add other sortable fields
    ];

    protected $allowedFilters = [
        'genre',
        'min_price',
        'max_price',
        'location',
        // Add other filterable fields
    ];

    public function getListings(?string $query, Request $request)
    {
        $queryBuilder = Listing::query()->where('is_active', true);

        if ($query) {
            $queryBuilder = $this->applySearch($queryBuilder, $query);
        }

        $queryBuilder = $this->applyFilters($queryBuilder, $request);
        $queryBuilder = $this->applySorting($queryBuilder, $request);

        return $queryBuilder->paginate(24);
    }

    private function applySearch(Builder $query, string $searchQuery): Builder
    {
        return $query->where(function (Builder $builder) use ($searchQuery) {
            $builder->where('title', 'like', "%{$searchQuery}%")
                ->orWhere('artist', 'like', "%{$searchQuery}%");
        });
    }

    private function applyFilters(Builder $query, Request $request): Builder
    {
        if ($request->filled('genre')) {
            $query->where('genre', $request->input('genre'));
        }

        // if ($request->filled('min_price')) {
        //     $query->where('price', '>=', $request->input('min_price'));
        // }

        // if ($request->filled('max_price')) {
        //     $query->where('price', '<=', $request->input('max_price'));
        // }

        if ($request->filled('location')) {
            $query->where('location', $request->input('location'));
        }

        // Add date range filter if needed
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->input('date_to'));
        }

        return $query;
    }

    private function applySorting(Builder $query, Request $request): Builder
    {
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');

        // Validate sort direction
        $sortDirection = in_array($sortDirection, ['asc', 'desc']) ? $sortDirection : 'desc';

        // Check if the requested sort field is allowed
        if (isset($this->allowedSortFields[$sortField])) {
            $field = $this->allowedSortFields[$sortField];
            $query->orderBy($field, $sortDirection);
        } else {
            // Default sorting
            $query->orderBy('created_at', 'desc');
        }

        return $query;
    }
}
