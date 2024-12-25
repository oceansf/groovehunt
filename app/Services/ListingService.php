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
        // Genre filter
        if ($request->has('genre') && is_array($request->genre)) {
            $query->whereIn('genre', $request->genre);
        }

        // Format filter
        if ($request->has('format') && is_array($request->format)) {
            $query->whereIn('format', $request->format);
        }

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
