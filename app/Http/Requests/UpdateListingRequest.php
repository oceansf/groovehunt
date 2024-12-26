<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateListingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        // Extra layer of security to ensure the user is authorized to update the listing
        return $this->user()->can('update', $this->listing);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        // Only include rules for fields that were actually submitted
        $baseRules = [
            'title' => 'string|max:255',
            'artist' => 'string|max:255',
            'format' => 'required|string|in:Vinyl,CD,Cassette,DVD,Box Set',
            'media_condition' => 'string|in:Mint,Near Mint,Very Good Plus,Very Good,Good Plus,Good,Fair,Poor',
            'sleeve_condition' => 'nullable|string|in:Mint,Near Mint,Very Good Plus,Very Good,Good Plus,Good,Fair,Poor',
            'description' => 'nullable|string|max:5000',
            'price' => 'numeric|min:0',
            'allow_offers' => 'boolean',
            'min_offer' => 'nullable|numeric|min:0|lt:price',
            'shipping' => 'numeric|min:0',
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
        ];

        return array_intersect_key($baseRules, $this->all());
    }

    public function messages()
    {
        return [
            'images.required' => 'At least one image is required for the listing.',
            'images.*.max' => 'Each image must not exceed 10MB.',
            'min_offer.lt' => 'The minimum offer must be less than the listing price.',
            'media_condition.in' => 'The media condition must be one of: Mint, Near Mint, Very Good Plus, Very Good, Good Plus, Good, Fair, Poor',
            'sleeve_condition.in' => 'The sleeve condition must be one of: Mint, Near Mint, Very Good Plus, Very Good, Good Plus, Good, Fair, Poor',
            'format.in' => 'The format must be one of: LP, 45, 78, EP, Single',
            'speed.in' => 'The speed must be one of: 33, 45, 78',
        ];
    }
}
