<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $conditions = ['Mint', 'Near Mint', 'Very Good Plus', 'Very Good', 'Good Plus', 'Good', 'Fair', 'Poor'];
        $genres = ['Rock', 'Pop', 'Jazz', 'Classical', 'Folk', 'World', 'Country', 'Blues', 'Soul', 'Reggae', 'Hip Hop', 'Electronic', 'Latin', 'Funk / Soul', 'Non-Music', 'Children\'s', 'Brass & Military', 'Stage & Screen'];
        $speeds = ['33', '45', '16', '78'];
        $colors = ['Black', 'Blue', 'Brown', 'Clear', 'Gold', 'Green', 'Grey', 'Orange', 'Pink', 'Purple', 'Red', 'Silver', 'White', 'Yellow'];
        
        $allowoffers = $this->faker->boolean();

        return [
            'title' => $this->faker->sentence(),
            'artist' => $this->faker->name(),
            'format' => $this->faker->word(),
            'media_condition' => $this->faker->randomElement($conditions),
            'sleeve_condition' => $this->faker->randomElement($conditions),
            'description' => $this->faker->sentence(),
            'images' => [
                'https://placehold.co/400x400/1E90FF/FFFFFF?text=Listing\nCover',
                'https://placehold.co/400x400/1E90FF/FFFFFF?text=Image\n2',
                'https://placehold.co/400x400/1E90FF/FFFFFF?text=Image\n3',
            ],
            'price' => $this->faker->randomFloat(2, 0, 100),
            'allow_offers' => $allowoffers,
            'min_offer' => $allowoffers ? $this->faker->randomFloat(2, 0, 100) : null,
            'shipping' => $this->faker->randomFloat(2, 0, 100),
            'genre' => $this->faker->randomElement($genres),
            'speed' => $this->faker->word(),
            'color' => $this->faker->randomElement($colors),
            'release_country' => $this->faker->country(),
            'release_year' => $this->faker->year(),
            'release_label' => $this->faker->word(),
            'release_cat_no' => $this->faker->word(),
            'release_matrix_no' => $this->faker->word(),
            'release_upc' => $this->faker->word(),
        ];
    }
}
