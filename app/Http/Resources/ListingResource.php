<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class ListingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $images = $this->images;
        
        // Handle images whether they're a Collection, array, or string
        $formattedImages = match(true) {
            $images instanceof Collection => $images->map(fn($image) => [
                'url' => $image->url
            ]),
            is_array($images) => collect($images)->map(fn($image) => [
                'url' => is_array($image) ? $image['url'] : $image
            ]),
            default => []
        };

        return [
            'id' => $this->id,
            'title' => $this->title,
            'artist' => $this->artist,
            'price' => $this->price,
            'shipping' => $this->shipping,
            'media_condition' => $this->media_condition,
            'allow_offers' => $this->allow_offers,
            'description' => $this->description,
            'format' => $this->format,
            'sleeve_condition' => $this->sleeve_condition,
            'genre' => $this->genre,
            'speed' => $this->speed,
            'color' => $this->color,
            'release_country' => $this->release_country,
            'release_year' => $this->release_year,
            'release_label' => $this->release_label,
            'release_cat_no' => $this->release_cat_no,
            'release_matrix_no' => $this->release_matrix_no,
            'release_upc' => $this->release_upc,
            'created_at' => $this->created_at,
            'images' => $formattedImages,
            'seller' => new UserResource($this->whenLoaded('seller')),
        ];
    }
}