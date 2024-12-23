<?php

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
    ];

    public function getListings(?string $query, Request $request)
    {
        \Log::info('Raw request data:', $request->all());

        $queryBuilder = Listing::query()->where('is_active', true);

        if ($query) {
            $queryBuilder = $this->applySearch($queryBuilder, $query);
        }

        $queryBuilder = $this->applyFilters($queryBuilder, $request);
        $queryBuilder = $this->applySorting($queryBuilder, $request);

        // Log the final query
        \Log::info('Final query:', [
            'sql' => $queryBuilder->toSql(),
            'bindings' => $queryBuilder->getBindings()
        ]);

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
        // Genre filter
        if ($request->has('genre') && is_array($request->genre)) {
            \Log::info('Applying genre filter:', ['genres' => $request->genre]);
            $query->whereIn('genre', $request->genre);
        }

        // Location filter
        if ($request->has('location') && is_array($request->location)) {
            \Log::info('Applying location filter:', ['locations' => $request->location]);
            $query->whereIn('location', $request->location);
        }

        // Let's see what the query looks like at this point
        \Log::info('Query after filters:', [
            'sql' => $query->toSql(),
            'bindings' => $query->getBindings(),
            'genre_values' => $request->input('genre'),
            'location_values' => $request->input('location')
        ]);

        return $query;
    }

    private function applySorting(Builder $query, Request $request): Builder
    {
        $sortField = $request->input('sort', 'created_at');
        $sortDirection = $request->input('direction', 'desc');

        $sortDirection = in_array($sortDirection, ['asc', 'desc']) ? $sortDirection : 'desc';

        if (isset($this->allowedSortFields[$sortField])) {
            $field = $this->allowedSortFields[$sortField];
            $query->orderBy($field, $sortDirection);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query;
    }
}