<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreListingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Check if user is authorized to create listings
        return $this->user()->can('create', 'App\Models\Listing');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'artist' => 'required|string|max:255',
            'format' => 'required|string|in:LP,45,78,EP,Single',
            'media_condition' => 'required|string|in:Mint,Near Mint,Very Good Plus,Very Good,Good Plus,Good,Fair,Poor',
            'sleeve_condition' => 'nullable|string|in:Mint,Near Mint,Very Good Plus,Very Good,Good Plus,Good,Fair,Poor',
            'description' => 'nullable|string|max:5000',
            'price' => 'required|numeric|min:0',
            'allow_offers' => 'required|boolean',
            'min_offer' => 'nullable|numeric|min:0|lt:price',
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
            'local_pickup' => 'required|boolean',
            'shipping_restrictions' => 'nullable|array',
            'weight' => 'nullable|numeric|min:0',
            'notes' => 'nullable|string',
            'images' => 'required|array|min:1',
            'images.*' => 'image|max:10240', // 10MB max per image
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages()
    {
        return [
            'title.required' => 'A title is required for the listing.',
            'artist.required' => 'An artist name is required for the listing.',
            'format.required' => 'The format is required for the listing.',
            'media_condition.required' => 'The media condition is required for the listing.',
            'price.required' => 'A price is required for the listing.',
            'shipping.required' => 'A shipping cost is required for the listing.',
            'images.required' => 'At least one image is required for the listing.',
            'images.min' => 'At least one image is required for the listing.',
            'images.*.max' => 'Each image must not exceed 10MB.',
            'images.*.image' => 'The uploaded file must be an image.',
            'min_offer.lt' => 'The minimum offer must be less than the listing price.',
            'media_condition.in' => 'The media condition must be one of: Mint, Near Mint, Very Good Plus, Very Good, Good Plus, Good, Fair, Poor',
            'sleeve_condition.in' => 'The sleeve condition must be one of: Mint, Near Mint, Very Good Plus, Very Good, Good Plus, Good, Fair, Poor',
            'format.in' => 'The format must be one of: LP, 45, 78, EP, Single',
            'speed.in' => 'The speed must be one of: 33, 45, 78',
        ];
    }
}
