<?php

namespace App\Services;

use App\Models\Listing;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ListingService
{
  private const PER_PAGE = 24;

  public function getListings(string $query, Request $request)
  {
    return $query
      ? $this->getSearchResults($query, $request)
      : $this->getPaginatedListings();
  }

  private function getSearchResults(string $query, Request $request): LengthAwarePaginator
  {
    $searchResults = Listing::search($query)->get();

    return $this->createPaginatorFromCollection(
      collect($searchResults),
      $request->input('page', 1),
      $request
    );
  }

  private function getPaginatedListings()
  {
    return Listing::query()
      ->select(['id', 'title', 'artist', 'price', 'images', 'media_condition'])
      ->latest()
      ->simplePaginate(self::PER_PAGE)
      ->through(fn($listing) => $this->transformListing($listing));
  }

  private function createPaginatorFromCollection(Collection $items, int $page, Request $request): LengthAwarePaginator
  {
    $paginatedItems = $items->forPage($page, self::PER_PAGE);

    return (new LengthAwarePaginator(
      $paginatedItems,
      $items->count(),
      self::PER_PAGE,
      $page,
      [
        'path' => $request->url(),
        'query' => $request->query()
      ]
    ))->through(fn($listing) => $this->transformListing($listing));
  }

  private function transformListing($listing): array
  {
    return [
      'id' => $listing->id,
      'title' => $listing->title,
      'artist' => $listing->artist,
      'price' => $listing->price,
      'images' => $listing->images,
      'media_condition' => $listing->media_condition,
    ];
  }
}
