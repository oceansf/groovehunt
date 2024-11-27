<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'avatar_url' => $this->avatar_url,
            // TODO: Add rating and review count
            // 'rating' => round($this->average_rating, 1),
            // 'review_count' => $this->reviews()->count(),
            'joined_date' => $this->created_at,
        ];
    }
}
